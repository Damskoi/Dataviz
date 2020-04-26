<?php
/***********************************************************************************
 *
 *  uneoeuvre.php : contient les fonctions pour gérer l'affichage d'une oeuvre
 *
 *
 ***********************************************************************************/

// Récupération des informations d'une oeuvre en fonction de son id
//   on retourne un tableau
function aGetOeuvre($_OConnexion, $_idOeuvre) {
  $aOeuvre = array();
  $strDBG = '';

  // Information générale sur l'oeuvre (table oeuvres)
  $strRPGetOeuvre = 'SELECT * FROM oeuvres WHERE idOeuvre=? AND deleted=0';
  // Préparation de la requête
  $ORPGetOeuvre = $_OConnexion->prepare($strRPGetOeuvre);
  if ($ORPGetOeuvre != FALSE) {
    // Association du paramètre
    $ORPGetOeuvre->bind_param('i', $_idOeuvre);
    // Éxécution de la requête
    if ($ORPGetOeuvre->execute() === TRUE) {
      // Récupération du résultat
      $OResult = $ORPGetOeuvre->get_result();
      // ... et parcours de l'enregistrement retourné
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['oeuvre'][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Récupération de l'idOeuvre précédente
  $strRPGetOeuvrePrec = 'SELECT idOeuvre FROM oeuvres WHERE idOeuvre < ? AND deleted=0 ORDER BY idOeuvre DESC LIMIT 1';
  $ORPGetOeuvrePrec = $_OConnexion->prepare($strRPGetOeuvrePrec);
  if ($ORPGetOeuvrePrec != FALSE) {
    $ORPGetOeuvrePrec->bind_param('i', $_idOeuvre);
    if ($ORPGetOeuvrePrec->execute() === TRUE) {
      $OResult = $ORPGetOeuvrePrec->get_result();
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['navigation']['idOeuvrePrec'][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Récupération de l'idOeuvre suivante
  $strRPGetOeuvreSuiv = 'SELECT idOeuvre FROM oeuvres WHERE idOeuvre > ? AND deleted=0 ORDER BY idOeuvre ASC LIMIT 1';
  $ORPGetOeuvreSuiv = $_OConnexion->prepare($strRPGetOeuvreSuiv);
  if ($ORPGetOeuvreSuiv != FALSE) {
    $ORPGetOeuvreSuiv->bind_param('i', $_idOeuvre);
    if ($ORPGetOeuvreSuiv->execute() === TRUE) {
      $OResult = $ORPGetOeuvreSuiv->get_result();
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['navigation']['idOeuvreSuiv'][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les supports de publications
  $strRPGetEditions = 'SELECT editions.* FROM editions'."\n".
                      ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = editions.idOeuvre'."\n".
                      ' WHERE editions.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                      ' ORDER BY anneeParution, idEdition';
  $ORPGetEditions = $_OConnexion->prepare($strRPGetEditions);
  if ($ORPGetEditions != FALSE) {
    $ORPGetEditions->bind_param('i', $_idOeuvre);
    if ($ORPGetEditions->execute() === TRUE) {
      $OResult = $ORPGetEditions->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['editions'][$ligne['idEdition']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Récupération des Catégorie / Collection spécialisée
  $strRPGetCatColSpec = 'SELECT editions.idEdition, GROUP_CONCAT(`tableref`.`libelle` SEPARATOR \'; \') \'strCategories\''."\n".
                        'FROM editions'."\n".
                        'LEFT JOIN liste_catedit ON editions.idEdition = liste_catedit.idEdition'."\n".
                        'LEFT JOIN tableref ON tableref.idRef = liste_catedit.idRef'."\n".
                        'WHERE editions.idOeuvre = ?'."\n".
                        'group by editions.idEdition'."\n";
  $ORPGetCatColSpec = $_OConnexion->prepare($strRPGetCatColSpec);
  if ($ORPGetCatColSpec != FALSE) {
    $ORPGetCatColSpec->bind_param('i', $_idOeuvre);
    if ($ORPGetCatColSpec->execute() === TRUE) {
      $OResult = $ORPGetCatColSpec->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        // foreach ($ligne as $strNomChamp => $strValeurChamp) {
          //$aOeuvre['editions'][$ligne['idEdition']]['CatColSpec'][$strNomChamp] = $strValeurChamp;
        // }
        $aOeuvre['editions'][$ligne['idEdition']]['strCategories'] = $ligne['strCategories'];
      }
    }
  }


  // Récupération des paratextes (onglet3) à trier par ordre chronologique:
  //   - date dans class="date_citation" -> aOeuvre['editions'][idEdition]['date']
  //   - texte de la citation dans class="text_citation"
  //     | à récupérer dans aOeuvre['editions'][idEdition]['paraDedicace'|'paraEpigraphe'|'paraCouv4']
  //  ou | à récupérer dans aOeuvre['editions'][idEdition]['paratexte'][idParatexte]['texte']
  //   - dans class="source_citation":
  //     | Dédicace, Épigraphe, Quatrième de couverture -> suivant le cas
  //  ou | Auteur dans aOeuvre['editions'][idEdition]['paratexte'][idParatexte]['auteur']
  //      +Type (Allographe, autohraphe) dans aOeuvre['editions'][idEdition]['paratexte'][idParatexte]['auteurType']
  //      +Nature dans aOeuvre['editions'][idEdition]['paratexte'][idParatexte]['nature']
  $strRPGetParatextes = 'SELECT paratexte.* FROM paratexte'."\n".
                        ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = paratexte.idOeuvre'."\n".
                        ' WHERE paratexte.idOeuvre = ? AND oeuvres.deleted = 0';
  $ORPGetParatextes = $_OConnexion->prepare($strRPGetParatextes);
  if ($ORPGetParatextes != FALSE) {
    $ORPGetParatextes->bind_param('i', $_idOeuvre);
    if ($ORPGetParatextes->execute() === TRUE) {
      $OResult = $ORPGetParatextes->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['editions'][$ligne['idEdition']]['paratexte'][$ligne['idParatexte']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les genres - Discours auctorial
  $strRPGetGenresDA = 'SELECT * FROM discoursauctorial'."\n".
                      ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = discoursauctorial.idOeuvre'."\n".
                      ' WHERE discoursauctorial.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                      ' ORDER BY discoursauctorial.dDate';
  $ORPGetGenresDA = $_OConnexion->prepare($strRPGetGenresDA);
  if ($ORPGetGenresDA != FALSE) {
    $ORPGetGenresDA->bind_param('i', $_idOeuvre);
    if ($ORPGetGenresDA->execute() === TRUE) {
      $OResult = $ORPGetGenresDA->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          // $aOeuvre['genres'][$ligne['idDiscoursAuctorial'].'DA'][$strNomChamp] = $strValeurChamp;
          $aGenre[$ligne['dDate'].'-'.$ligne['idDiscoursAuctorial'].'-DA'][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les genres - Dispositif Éditorial
  $strRPGetGenresDE = 'SELECT * FROM dispositifeditorial'."\n".
                      ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = discoursauctorial.idOeuvre'."\n".
                      ' WHERE discoursauctorial.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                      ' ORDER BY discoursauctorial.dDate';
  $ORPGetGenresDE = $_OConnexion->prepare($strRPGetGenresDE);
  if ($ORPGetGenresDE != FALSE) {
    $ORPGetGenresDE->bind_param('i', $_idOeuvre);
    if ($ORPGetGenresDE->execute() === TRUE) {
      $OResult = $ORPGetGenresDE->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          // $aOeuvre['genres'][$ligne['idDispositifEditorial'].'DE'][$strNomChamp] = $strValeurChamp;
          $aGenre[$ligne['dDate'].'-'.$ligne['idDispositifEditorial'].'-DE'][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les genres - Réception Critique
  $strRPGetGenresRC = 'SELECT * FROM receptioncritique'."\n".
                      ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = receptioncritique.idOeuvre'."\n".
                      ' WHERE receptioncritique.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                      ' ORDER BY receptioncritique.dDate';
  $ORPGetGenresRC = $_OConnexion->prepare($strRPGetGenresRC);
  if ($ORPGetGenresRC != FALSE) {
    $ORPGetGenresRC->bind_param('i', $_idOeuvre);
    if ($ORPGetGenresRC->execute() === TRUE) {
      $OResult = $ORPGetGenresRC->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          // $aOeuvre['genres'][$ligne['idReceptionCritique'].'RC'][$strNomChamp] = $strValeurChamp;
          $aGenre[$ligne['dDate'].'-'.$ligne['idReceptionCritique'].'-RC'][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Trie du tableau aGenre (ordonne les dates)
  if (!empty($aGenre)) ksort($aGenre);
  $aOeuvre['genres'] = $aGenre;

  // Information sur les liens avec d'autres auteurs
  $strRPGetLiensAuteurs = 'SELECT * FROM liensautresauteurs'."\n".
                          ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = liensautresauteurs.idOeuvre'."\n".
                          ' WHERE liensautresauteurs.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                          ' ORDER BY liensautresauteurs.dDate';
  $ORPGetLiensAuteurs = $_OConnexion->prepare($strRPGetLiensAuteurs);
  if ($ORPGetLiensAuteurs != FALSE) {
    $ORPGetLiensAuteurs->bind_param('i', $_idOeuvre);
    if ($ORPGetLiensAuteurs->execute() === TRUE) {
      $OResult = $ORPGetLiensAuteurs->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['liensauteurs'][$ligne['idLienAutreAuteur']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les traductions
  $strRPGetTraductions = 'SELECT * FROM traductions'."\n".
                         ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = traductions.idOeuvre'."\n".
                         ' WHERE traductions.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                         ' ORDER BY traductions.dDate';
  $ORPGetTraductions = $_OConnexion->prepare($strRPGetTraductions);
  if ($ORPGetTraductions != FALSE) {
    $ORPGetTraductions->bind_param('i', $_idOeuvre);
    if ($ORPGetTraductions->execute() === TRUE) {
      $OResult = $ORPGetTraductions->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['traductions'][$ligne['idTraduction']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les adaptations
  $strRPGetAdaptations = 'SELECT * FROM adaptations'."\n".
                         ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = adaptations.idOeuvre'."\n".
                         ' WHERE adaptations.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                         ' ORDER BY adaptations.dDate';
  $ORPGetAdaptations = $_OConnexion->prepare($strRPGetAdaptations);
  if ($ORPGetAdaptations != FALSE) {
    $ORPGetAdaptations->bind_param('i', $_idOeuvre);
    if ($ORPGetAdaptations->execute() === TRUE) {
      $OResult = $ORPGetAdaptations->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['adaptations'][$ligne['idAdaptation']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les registres (onglet6 - Esthétique)
  $strRPGetRegistres = 'SELECT idMot, libelle FROM esthetique'."\n".
                       ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = esthetique.idOeuvre'."\n".
                       ' LEFT JOIN tableref ON tableref.idRef = esthetique.idMot'."\n".
                       ' WHERE esthetique.idMot = tableref.idRef AND esthetique.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                       ' ORDER BY tableref.Libelle';
  $ORPGetRegistres = $_OConnexion->prepare($strRPGetRegistres);
  if ($ORPGetRegistres != FALSE) {
    $ORPGetRegistres->bind_param('i', $_idOeuvre);
    if ($ORPGetRegistres->execute() === TRUE) {
      $OResult = $ORPGetRegistres->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['registres'][$ligne['idMot']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Récupération de tous les personnages
  $strRPGetPersonnages = 'SELECT * FROM personnages'."\n".
                         ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = personnages.idOeuvre'."\n".
                         ' WHERE personnages.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                         ' ORDER BY personnages.rang, personnages.type, personnages.nom';
  $ORPGetPersonnages = $_OConnexion->prepare($strRPGetPersonnages);
  if ($ORPGetPersonnages != FALSE) {
    $ORPGetPersonnages->bind_param('i', $_idOeuvre);
    if ($ORPGetPersonnages->execute() === TRUE) {
      $OResult = $ORPGetPersonnages->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          if ($ligne['type'] == 'F') {
            $aOeuvre['personnages']['F'][$ligne['idPersonnage']][$strNomChamp] = $strValeurChamp;
          } else {
            $aOeuvre['personnages']['autres'][$ligne['idPersonnage']][$strNomChamp] = $strValeurChamp;
          }
        }
      }
    }
  }

  // Récupération des références intertextuelles
  $strRPGetReferences = 'SELECT refintertextuelles.* FROM refintertextuelles'."\n".
                        ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = refintertextuelles.idOeuvre'."\n".
                        ' WHERE refintertextuelles.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                        ' ORDER BY refintertextuelles.auteur';
  $ORPGetReferences = $_OConnexion->prepare($strRPGetReferences);
  if ($ORPGetReferences != FALSE) {
    $ORPGetReferences->bind_param('i', $_idOeuvre);
    if ($ORPGetReferences->execute() === TRUE) {
      $OResult = $ORPGetReferences->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['references'][$ligne['idRefIntertxt']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Récupération des lieux
  $strRPGetLieux = 'SELECT * FROM lieux'."\n".
                   ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = lieux.idOeuvre'."\n".
                   ' WHERE lieux.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                   ' ORDER BY lieux.libelle';
  $ORPGetLieux = $_OConnexion->prepare($strRPGetLieux);
  if ($ORPGetLieux != FALSE) {
    $ORPGetLieux->bind_param('i', $_idOeuvre);
    if ($ORPGetLieux->execute() === TRUE) {
      $OResult = $ORPGetLieux->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['lieux'][$ligne['idLieu']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Récupération des écarts temporels
  $strRPGetLieux = 'SELECT * FROM spaciotemporel'."\n".
                   ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = spaciotemporel.idOeuvre'."\n".
                   ' WHERE spaciotemporel.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                   ' ORDER BY spaciotemporel.idCSP';
  $ORPGetLieux = $_OConnexion->prepare($strRPGetLieux);
  if ($ORPGetLieux != FALSE) {
    $ORPGetLieux->bind_param('i', $_idOeuvre);
    if ($ORPGetLieux->execute() === TRUE) {
      $OResult = $ORPGetLieux->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['ecartstempos'][$ligne['idCSP']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur le rapport au temps (onglet 4.3)
  $strRPGetRapportTempo = 'SELECT tableref.idRef, tableref.libelle FROM poetiquekw'."\n".
                          ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = poetiquekw.idOeuvre'."\n".
                          ' LEFT JOIN tableref ON tableref.idRef = poetiquekw.idMot'."\n".
                          ' WHERE poetiquekw.section = 43 AND poetiquekw.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                          ' ORDER BY tableref.Libelle'."\n";
  $ORPGetRapportTempo = $_OConnexion->prepare($strRPGetRapportTempo);
  if ($ORPGetRapportTempo != FALSE) {
    $ORPGetRapportTempo->bind_param('i', $_idOeuvre);
    if ($ORPGetRapportTempo->execute() === TRUE) {
      $OResult = $ORPGetRapportTempo->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['rapporttempo'][$ligne['idRef']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les voyages (onglet 5.2)
  $strRPGetVoyages = 'SELECT idMot, libelle FROM representations'."\n".
                     ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = representations.idOeuvre'."\n".
                     ' LEFT JOIN tableref ON tableref.idRef = representations.idMot'."\n".
                     ' WHERE representations.section = 52 AND representations.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                     ' ORDER BY tableref.Libelle';
  $ORPGetVoyages = $_OConnexion->prepare($strRPGetVoyages);
  if ($ORPGetVoyages != FALSE) {
    $ORPGetVoyages->bind_param('i', $_idOeuvre);
    if ($ORPGetVoyages->execute() === TRUE) {
      $OResult = $ORPGetVoyages->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['voyages'][$ligne['idMot']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les disciplines (onglet 5.1)
  $strRPGetDisciplines = 'SELECT representations.idMot, tableref.top, tableref.groupe, libelle FROM representations'."\n".
                         ' LEFT JOIN oeuvres ON oeuvres.idOeuvre = representations.idOeuvre'."\n".
                         ' LEFT JOIN tableref ON tableref.idRef = representations.idMot'."\n".
                         ' WHERE representations.section = 511 AND representations.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                         ' ORDER BY tableref.groupe, tableref.top DESC, tableref.Libelle';
  $ORPGetDisciplines = $_OConnexion->prepare($strRPGetDisciplines);
  if ($ORPGetDisciplines != FALSE) {
    $ORPGetDisciplines->bind_param('i', $_idOeuvre);
    if ($ORPGetDisciplines->execute() === TRUE) {
      $OResult = $ORPGetDisciplines->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['disciplines'][$ligne['idMot']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les éléments scientifiques réels (onglet 5)
  $strRPGetEltsSciReels = 'SELECT * FROM refaureel WHERE idOeuvre = ? ORDER BY citation'."\n";
  $ORPGetEltsSciReels = $_OConnexion->prepare($strRPGetEltsSciReels);
  if ($ORPGetEltsSciReels != FALSE) {
    $ORPGetEltsSciReels->bind_param('i', $_idOeuvre);
    if ($ORPGetEltsSciReels->execute() === TRUE) {
      $OResult = $ORPGetEltsSciReels->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['eltsSciReels'][$ligne['idRefAuReel']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les éléments scientifiques imaginaires (onglet 5)
  $strRPGetEltsSciImg = 'SELECT'."\n".
                        '`eltscientifiques`.*,'."\n".
                        'GROUP_CONCAT(`tableref`.`libelle` SEPARATOR \'; \') \'strCategories\','."\n".
                        'GROUP_CONCAT(`tableref`.`idRef` SEPARATOR \'; \') \'strIdRef\''."\n".
                        'FROM `eltscientifiques`'."\n".
                        'LEFT JOIN `liste_catelts` ON `liste_catelts`.`idEltScientifique` = `eltscientifiques`.`idEltScientifique`'."\n".
                        'LEFT JOIN `tableref` ON `tableref`.`idRef` = `liste_catelts`.`idRef`'."\n".
                        'WHERE `eltscientifiques`.`idOeuvre` = ?'."\n".
                        'GROUP BY `eltscientifiques`.`idEltScientifique`'."\n".
                        'ORDER BY `eltscientifiques`.`nom`'."\n";
  $ORPGetEltsSciImg = $_OConnexion->prepare($strRPGetEltsSciImg);
  if ($ORPGetEltsSciImg != FALSE) {
    $ORPGetEltsSciImg->bind_param('i', $_idOeuvre);
    if ($ORPGetEltsSciImg->execute() === TRUE) {
      $OResult = $ORPGetEltsSciImg->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['eltsSciImg'][$ligne['idEltScientifique']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur la bibliographie (onglet 2)
  $strRPGetBiblio = 'SELECT * FROM bibliocritique WHERE idOeuvre = ? ORDER BY dDate';
  $ORPGetBiblio = $_OConnexion->prepare($strRPGetBiblio);
  if ($ORPGetBiblio != FALSE) {
    $ORPGetBiblio->bind_param('i', $_idOeuvre);
    if ($ORPGetBiblio->execute() === TRUE) {
      $OResult = $ORPGetBiblio->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['bibliographies'][$ligne['idBibliCritique']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Information sur les sociétés imaginaires (onglet 5.3)
  // SELECT societesimg.*,
  // GROUP_CONCAT(`tableref`.`libelle` SEPARATOR '; ') 'strTraitSpec',
  // GROUP_CONCAT(`tableref`.`idRef` SEPARATOR '; ') 'strIdRef'
  // FROM societesimg
  // LEFT JOIN `liste_traitspec` ON `liste_traitspec`.`idSociete` = `societesimg`.`idSociete`
  // LEFT JOIN `tableref` ON `tableref`.`idRef` = `liste_traitspec`.`idRef`
  // WHERE idOeuvre = ?
  // GROUP BY `societesimg`.`idSociete`
  // ORDER BY nom
  $strRPGetSocieteImagine = 'SELECT societesimg.*,'."\n".
                            'GROUP_CONCAT(`tableref`.`libelle` SEPARATOR \'; \') \'strTraitSpec\','."\n".
                            'GROUP_CONCAT(`tableref`.`idRef` SEPARATOR \'; \') \'strIdRef\''."\n".
                            'FROM societesimg'."\n".
                            'LEFT JOIN `liste_traitspec` ON `liste_traitspec`.`idSociete` = `societesimg`.`idSociete`'."\n".
                            'LEFT JOIN `tableref` ON `tableref`.`idRef` = `liste_traitspec`.`idRef`'."\n".
                            'WHERE idOeuvre = ?'."\n".
                            'GROUP BY `societesimg`.`idSociete`'."\n".
                            'ORDER BY nom';
  $ORPGetSocieteImagine = $_OConnexion->prepare($strRPGetSocieteImagine);
  if ($ORPGetSocieteImagine != FALSE) {
    $ORPGetSocieteImagine->bind_param('i', $_idOeuvre);
    if ($ORPGetSocieteImagine->execute() === TRUE) {
      $OResult = $ORPGetSocieteImagine->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['societeImg'][$ligne['idSociete']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  // Récupération des divers tags
  // Ordre des tags
  // 01- Nature du texte
  // 02- Année de première édition
  // 03- Esthétique
  // 04- Rapport au temps
  // 05- Voyages
  // 06- Disciplines et thématiques
  // 07- Catégories des élément scientifiques imaginaires
  // 08- Société imaginaire

// UNION SELECT tableref.idRef, 'Group', 'Top', CONCAT('07-Catégorie élément scientifique imaginaire%%: ', tableref.libelle) 'libelle' FROM eltscientifiques
// LEFT JOIN liste_catelts ON liste_catelts.idEltScientifique = eltscientifiques.idEltScientifique
// LEFT JOIN tableref ON tableref.idRef = liste_catelts.idRef
// LEFT JOIN oeuvres ON oeuvres.idOeuvre = eltscientifiques.idOeuvre
// WHERE oeuvres.idOeuvre = ? AND oeuvres.deleted = 0
// GROUP BY eltscientifiques.idEltScientifique
// UNION SELECT societesimg.idSociete, 'Group', 'Top', CONCAT('08-Société%%: ', societesimg.nom) 'libelle' FROM societesimg
// LEFT JOIN oeuvres ON oeuvres.idOeuvre = societesimg.idOeuvre
// WHERE oeuvres.idOeuvre = ? AND oeuvres.deleted = 0
// ORDER BY 'Group', 'Top' DESC, libelle

// 'UNION SELECT tableref.idRef, \'Group\', \'Top\', CONCAT(\'04-Rapport au temps%%: \', tableref.libelle) \'libelle\' FROM poetiquekw'."\n".
// 'LEFT JOIN oeuvres ON oeuvres.idOeuvre = poetiquekw.idOeuvre'."\n".
// 'LEFT JOIN tableref ON tableref.idRef = poetiquekw.idMot'."\n".
// 'WHERE (tableref.section=\'4.3\') AND oeuvres.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
// 'GROUP BY tableref.idRef'."\n".

  $strRPGetTags = 'SELECT tableref.idRef, \'Group\', \'Top\', CONCAT(\'01-Nature du texte%%: \', tableref.libelle) \'libelle\' FROM oeuvres'."\n".
                  'LEFT JOIN tableref ON tableref.idRef = oeuvres.natureTxt'."\n".
                  'WHERE (section=\'1.4\') AND oeuvres.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                  'GROUP BY tableref.idRef'."\n".
                  'UNION SELECT oeuvres.idOeuvre, \'Group\', \'Top\', CONCAT(\'02-Année première édition%%: \', oeuvres.anneePE) \'libelle\' FROM oeuvres'."\n".
                  'WHERE oeuvres.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                  'UNION SELECT tableref.idRef, \'Group\', \'Top\', CONCAT(\'03-Esthétique%%: \', tableref.libelle) \'libelle\' FROM esthetique'."\n".
                  'LEFT JOIN oeuvres ON oeuvres.idOeuvre = esthetique.idOeuvre'."\n".
                  'LEFT JOIN tableref ON tableref.idRef = esthetique.idMot'."\n".
                  'WHERE tableref.section=\'6\' AND oeuvres.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                  'GROUP BY tableref.idRef'."\n".
                  'UNION SELECT spaciotemporel.idCSP, \'Group\', \'Top\', CONCAT(\'04-Écart temporel%%: \', spaciotemporel.ecart) \'libelle\' FROM spaciotemporel'."\n".
                  'LEFT JOIN oeuvres ON oeuvres.idOeuvre = spaciotemporel.idOeuvre'."\n".
                  'WHERE spaciotemporel.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                  'UNION SELECT tableref.idRef, \'Group\', \'Top\', CONCAT(\'05-Voyage%%: \', tableref.libelle) \'libelle\' FROM representations'."\n".
                  'LEFT JOIN oeuvres ON oeuvres.idOeuvre = representations.idOeuvre'."\n".
                  'LEFT JOIN tableref ON tableref.idRef = representations.idMot'."\n".
                  'WHERE tableref.section=\'5.2\' AND oeuvres.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                  'GROUP BY tableref.idRef'."\n".
                  'UNION SELECT tableref.idRef, tableref.groupe \'Group\', tableref.top \'Top\', CONCAT(\'06-Disciplines%%: \', tableref.libelle) \'libelle\' FROM representations'."\n".
                  'LEFT JOIN oeuvres ON oeuvres.idOeuvre = representations.idOeuvre'."\n".
                  'LEFT JOIN tableref ON tableref.idRef = representations.idMot'."\n".
                  'WHERE tableref.section=\'5.1.1\' AND tableref.top=1 AND oeuvres.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                  'UNION SELECT tableref.idRef, \'Group\', \'Top\', CONCAT(\'07-Catégorie élément scientifique imaginaire%%: \', tableref.libelle) \'libelle\' FROM eltscientifiques'."\n".
                  'LEFT JOIN liste_catelts ON liste_catelts.idEltScientifique = eltscientifiques.idEltScientifique'."\n".
                  'LEFT JOIN tableref ON tableref.idRef = liste_catelts.idRef'."\n".
                  'LEFT JOIN oeuvres ON oeuvres.idOeuvre = eltscientifiques.idOeuvre'."\n".
                  'WHERE oeuvres.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                  'GROUP BY eltscientifiques.idEltScientifique'."\n".
                  'UNION SELECT societesimg.idSociete, \'Group\', \'Top\', CONCAT(\'08-Société%%: \', societesimg.nom) \'libelle\' FROM societesimg'."\n".
                  'LEFT JOIN oeuvres ON oeuvres.idOeuvre = societesimg.idOeuvre'."\n".
                  'WHERE oeuvres.idOeuvre = ? AND oeuvres.deleted = 0'."\n".
                  'ORDER BY \'Group\', \'Top\' DESC, libelle'."\n";
  $ORPGetTags = $_OConnexion->prepare($strRPGetTags);
  if ($ORPGetTags != FALSE) {
    $ORPGetTags->bind_param('iiiiiiii', $_idOeuvre, $_idOeuvre, $_idOeuvre, $_idOeuvre, $_idOeuvre, $_idOeuvre, $_idOeuvre, $_idOeuvre);
    if ($ORPGetTags->execute() === TRUE) {
      $OResult = $ORPGetTags->get_result();
      // Sans doute qu'il y a plus simple pour charger le résultat dans un tableau...
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          $aOeuvre['tags'][$ligne['idRef']][$strNomChamp] = $strValeurChamp;
        }
      }
    }
  }

  $aOeuvre['strDBG'] = $strDBG;
  return $aOeuvre;
}

?>
