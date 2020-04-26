<?php
// session_start();
// // delete($_SESSION['idUser']);
// 
// if (!isset($_SESSION['idUser'])){
//   // header('Location:identification.php');
//   echo json_encode(array('strErreur' => 'NoSession'));
//   throw new Exception('NoSession');
//   // die(401);
// } else if ($_SESSION['idProfil'] != 1 AND $_SESSION['idProfil'] != 2){
//   // Droits administrateurs nécessaire
//   // echo json_encode(array('strErreur' => 'NoAdmin'));
//   // throw new Exception('NoAdmin');
//   header('Location:identification.php');
//   die;
// }

// --------------------------------------------------------------------------------------------------- //
// ajax-recherche.php                                                                                  //
//                                                                                                     //
// page d'accueil pour les requêtes ajax de la recherche                                               //
//                                                                                                     //
// iCmd=1 : (Affichage du formulaire de recherche simple)                                              //
//      2 : Affichage du formulaire de recherche avancée                                               //
//      3 : Requête pour autocomplétion des désignations                                               //
//      4 : Requête pour autocomplétion des auteurs comparés                                           //
//      5 : Requête pour autocomplétion des langues                                                    //
//      6 : Requête pour autocomplétion des adaptations                                                //
//      7 : Requête pour autocomplétion des cadres spatiaux                                            //
//      8 : Requête pour autocomplétion des références intertextuelles (titres des oeuvres et auteurs) //
//      9 : Requête pour autocomplétion des disciplines scientifiques des personnages                  //
//     10 : Requête pour autocomplétion des professions des personnages                                //
//     11 : Requête pour autocomplétion des caractéristiques des personnages                           //
//     12 : Requête pour autocomplétion des références au réel (Théorie ou invention)                  //
//     13 : Requête pour autocomplétion des références à des éléments scientifiques imaginaires        //
//     14 : Requête pour autocomplétion des inventions techniques imaginaires                          //
//     15 : Requête pour autocomplétion des voyages imaginaires                                        //
//     16 : Requête pour autocomplétion des supports de publication                                    //
//     17 : Requête pour autocomplétion des auteurs de fiche                                           //
//     18 : Requête pour autocomplétion des noms d'illustrateurs                                       //
//     19 : Requête pour autocomplétion des références au réel (personnage scien.)                     //
//     20 : Affichage du résultat de recherche simple                                                  //
//     21 : Affichage du résultat de recherche avancée                                                 //
//     22 : Affichage des Fiches en cours de rédaction                                                 //
//     23 : Affichage des Fiches incomplètes                                                           //
//     24 : Affichage des Fiches complètes, à relire                                                   //
//     25 : Affichage des Fiches relues, corrections à effectuer                                       //
//     26 : Affichage des Fiches prêtes pour la publication                                            //
//     27 : liste des tableaux "Société imaginaire" des fiches (onglet 5)                              //
//     28 : liste des mots clés (onglet 5)                                                             //
//     29 : Détail des critères trouvés d'une oeuvre pour une recherche simple                         //
//     30 : Détail des critères trouvés d'une oeuvre pour une recherche avancée                        //
//     31 : Affichage des Fiches sans aucune information sur l'avancement de la saisie                 //
//     32 : (voir lib/statistiques.php) Statistiques / Présence des disciplines dans les oeuvres       //
//     33 : (voir lib/statistiques.php) Statistiques / Personnalités scientifiques réelles             //
//     34 : Détail des critères trouvés pour toutes les oeuvres d'une recherche simple                 //
//     35 : Détail des critères trouvés pour toutes les oeuvres d'une recherche avancée                //
//     36 :                                                                                            //
//     37 :                                                                                            //
//     38 :                                                                                            //
//     39 :                                                                                            //
//     40 : Affichage de l'interface de gestion des utilisateurs (droits admin nécessaire)             //
//          interface définie dans ajax-gestutil.php                                                   //
//     41 : Modification d'un utilisateur (droits admin nécessaire)                                    //
//     42 :                                                                                            //
//                                                                                                     //
// --------------------------------------------------------------------------------------------------- //

include_once('lib/divers.php');
include_once('lib/anticipation-inc.php');
include_once 'lib/connexion.php';
include_once 'lib/recherche-inc.php';

try {

  $strRetour = '';
  $tab=array();

  // On se connecte tout de suite pour béféficier des fonctions MySQLi
  $OConnexion = new Connexion();
  // $mySQLi = CnxMySQL::getBD();
  $iCmd = $OConnexion->real_escape_string($_POST['iCmd']);

  if ($iCmd == 32 OR $iCmd == 33) {
    require_once('lib/statistiques.php');
  }

  if ($iCmd == 1 OR $iCmd == 2) {
    // Récupération de la liste des disciplines et thématiques mobilisées (getListeRepresentation dans lib/lib.php)
    $aListeDTHierarchie = getListeRef('5.1.1');
    // Classement des disciplines et thèmes par groupes
    foreach ($aListeDTHierarchie as $mot){
      if ($mot['top'] == 1){
        // Mémorisation des noms de groupe
        if ($mot['groupe'] != 255)
          $aListeDTGroupes[$mot['groupe']] = array('id'=>$mot['idRef'], 'lib'=>$mot['libelle']);
        else
          $aListeDTGroupes[$mot['groupe']+$mot['idRef']] = array('id'=>$mot['idRef'], 'lib'=>$mot['libelle']);
      } else {
        // Mémorisation des noms de disciplines et thématiques
        $aListeDTIdLib[$mot['groupe']][] = array('id'=>$mot['idRef'], 'lib'=>$mot['libelle']);
      }
    }
    $aListeDiscThem = getListeRepresentation(null, 511);
  }

  switch ($iCmd) {

    case 1: // Affichage du formulaire de recherche simple
    case 2: // Affichage du formulaire de recherche avancée
      // $strRetour .= '<br />iCmd = '.$_POST['iCmd']."\n";
      if ($iCmd == 2) {
        // Récupération de la liste des natures de texte (tableref where idRef in [1, 2, 3])
        $aListeNatureTexte = getListeNatureText();
        // Récupération de la liste des traits spécifiques à la société imaginaire (getListeRepresentation dans lib/lib.php)
        $aListeTraitsSpec = getListeRepresentation(null, 534);
        // Récupération de la liste des caractéristiques esthétiques
        $aListeEstethique = getListeEsthetique(null);
        // Récupération de la liste des natures d'adaptation
        $aListeNatureAdapt = getListeAdaptations(null);
        // Récupération de la liste des rapports au temps
        $aListeRapportTemps = getListePoetique(null, 43);
        // Récupération de la liste des catégories et collections spécialisées
        $aListeSPCatColSpe = getListeRef('3.1.2');
        // Récupération de la liste des type de voyage
        $aListeVoyages = getListeRef('5.2');
        // Récupération de la liste des domaines d'invention technique
        $aListeDomaines = getListeRef('5.1.3.2');
      }
      require_once('lib/recherche-form.php');
      break;

    case 3: // Requête pour autocomplétion des désignations
      // Initialisation des variables
      // $strDesignation = (isset($_POST['strDesignation'])) ? $mySQLi->real_escape_string(strtolower(trim($_POST['strDesignation']))) : '';
      $strDesignation = (isset($_POST['strDesignation'])) ? $OConnexion->real_escape_string(trim($_POST['strDesignation'])) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strDesignation, '%') !== false) $strDesignation = rawurldecode($strDesignation);

      // Pour chaque requête, préciser dans 'category' la table requêtée (discoursauctorial: Discours auctorial; dispositifeditorial: Dispositif éditorial; bibliocritique: Réception critique)
      // Renvoie les désignations auctoriales filtrées
      // $req = "SELECT designation FROM discoursauctorial WHERE LOWER(designation) LIKE '%$strDesignation%' GROUP BY designation ORDER BY designation LIMIT 0, $iMaxLignes";
      $req = "SELECT designation FROM discoursauctorial WHERE designation LIKE '%$strDesignation%' GROUP BY designation ORDER BY designation LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'designation' => $row['designation'],
                   'category' => 'Discours auctorial'];
      }
      // Renvoie les désignations éditoriale filtrées
      // $req = "SELECT designation FROM dispositifeditorial WHERE LOWER(designation) LIKE '%$strDesignation%' GROUP BY designation ORDER BY designation LIMIT 0, $iMaxLignes";
      $req = "SELECT designation FROM dispositifeditorial WHERE designation LIKE '%$strDesignation%' GROUP BY designation ORDER BY designation LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'designation' => $row['designation'],
                   'category' => 'Dispositif éditorial'];
      }
      // Renvoie des réceptions critique filtrées
      // $req = "SELECT designation FROM receptioncritique WHERE LOWER(designation) LIKE '%$strDesignation%' GROUP BY designation ORDER BY designation LIMIT 0, $iMaxLignes";
      $req = "SELECT designation FROM receptioncritique WHERE designation LIKE '%$strDesignation%' GROUP BY designation ORDER BY designation LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'designation' => $row['designation'],
                   'category' => 'Réception critique'];
      }
      echo json_encode($tab);
      break;

    case 4: // Requête pour autocomplétion des auteurs comparés
      // Initialisation des variables
      $strAuteur = (isset($_POST['strAuteur'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strAuteur']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';
      $iCpt = 0;

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strAuteur, '%') !== false) $strAuteur = rawurldecode($strAuteur);

      // Renvoie les auteurs trouvés dans 
      // $req = "SELECT auteurCompare FROM liensautresauteurs WHERE auteurCompare LIKE '%$strAuteur%' GROUP BY auteurCompare ORDER BY auteurCompare LIMIT 0, $iMaxLignes";
      $req = "SELECT auteurCompare FROM liensautresauteurs WHERE LOWER(auteurCompare) LIKE '%$strAuteur%' GROUP BY auteurCompare ORDER BY auteurCompare LIMIT 0, 100";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        if (strrchr($row['auteurCompare'], ',')) {
          // Dans le cas où il y a plusieurs auteurs séparés par des virgules, on les met dans un enregistrement différent... ce qui donnera plus de résultat que maxLignes (on fait donc autrement)
          $aAuteurs = explode(',', $row['auteurCompare']);
          foreach ($aAuteurs as $value) {
            // Si c'est un autre auteur on ne le met pas
            if (empty($strAuteur) OR !stristr(trim($value), $strAuteur)) continue;
            // Si l'auteur est déjà dans le tableau... pas la peine de le rajouter
            $bTrouve = false;
            foreach ($tab as $aValue) {
              if (strstr($aValue['auteurCompare'], trim($value))) {
                $bTrouve = true;
                break;
              }
            }
            if ($bTrouve) continue;
            $iCpt++;
            $tab[] = [ 'auteurCompare' => trim($value)];
            if ($iCpt > $iMaxLignes) break;
          }
        } else {
          // Si l'auteur est déjà dans le tableau... pas la peine de le rajouter
          $bTrouve = false;
          foreach ($tab as $aValue) {
            if (strstr($aValue['auteurCompare'], trim($row['auteurCompare']))) {
              $bTrouve = true;
              break;
            }
          }
          if ($bTrouve) continue;
          $iCpt++;
          // $tab[] = $row;
          $tab[] = [ 'auteurCompare' => trim($row['auteurCompare'])];
          if ($iCpt > $iMaxLignes) break;
        }
        if ($iCpt > $iMaxLignes) break;
      }
      echo json_encode($tab);
      break;

    case 5: // Requête pour autocomplétion des langues
      // Initialisation des variables
      $strLangueTrad = (isset($_POST['strLangueTrad'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strLangueTrad']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strLangueTrad, '%') !== false) $strLangueTrad = rawurldecode($strLangueTrad);

      $req = "SELECT langue FROM traductions WHERE LOWER(langue) LIKE '%$strLangueTrad%' GROUP BY langue ORDER BY langue LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $tab[] = $row;
      }
      echo json_encode($tab);
      break;

    case 6: // Requête pour autocomplétion des adaptations
      // Initialisation des variables
      $strNatureAdapt = (isset($_POST['strNatureAdapt'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strNatureAdapt']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strNatureAdapt, '%') !== false) $strNatureAdapt = rawurldecode($strNatureAdapt);

      $req = "SELECT nature FROM adaptations WHERE LOWER(nature) LIKE '%$strNatureAdapt%' GROUP BY nature ORDER BY nature LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $tab[] = $row;
      }
      echo json_encode($tab);
      break;

    case 7: // Requête pour autocomplétion des cadres spatiaux
      // Initialisation des variables
      $strCadreSpat = (isset($_POST['strCadreSpat'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strCadreSpat']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strCadreSpat, '%') !== false) $strCadreSpat = rawurldecode($strCadreSpat);

      $req = "SELECT libelle FROM lieux WHERE LOWER(libelle) LIKE '%$strCadreSpat%' GROUP BY libelle ORDER BY libelle LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $tab[] = $row;
      }
      echo json_encode($tab);
      break;

    case 8: // Requête pour autocomplétion des références intertextuelles (titres des oeuvres et auteurs)
      // Initialisation des variables
      $strRefInterTxt = (isset($_POST['strRefInterTxt'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strRefInterTxt']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strRefInterTxt, '%') !== false) $strRefInterTxt = rawurldecode($strRefInterTxt);

      // Récupération des titres des oeuvres
      $req = "SELECT titre FROM refintertextuelles WHERE LOWER(titre) LIKE '%$strRefInterTxt%' GROUP BY titre ORDER BY titre LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'reference' => $row['titre'],
                   'category' => 'Titre de l\'oeuvre'];
      }

      // Récupération des auteurs
      $req = "SELECT auteur FROM refintertextuelles WHERE LOWER(auteur) LIKE '%$strRefInterTxt%' GROUP BY auteur ORDER BY auteur LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'reference' => $row['auteur'],
                   'category' => 'Auteur de l\'oeuvre'];
      }

      // Dédoublonnage des titi et [titi] (et suppression des [])
      $tabReferences = array();
      $tabDedoublonne = array();
      foreach ($tab as $key => $value) {
        if (preg_match('/\[(.*)\]/', $value['reference'], $aCapture) == 1) {
          if (!in_array($aCapture[1], $tabReferences)) {
            // La valeur n'est pas déjà présente dans le tableau: on l'ajoute (sans les [])
            $tabDedoublonne[] = $tab[$key];
          }
        } else {
          $tabReferences[] = $value['reference'];
          $tabDedoublonne[] = $tab[$key];
        }
      }
      $tab = $tabDedoublonne;

      echo json_encode($tab);
      break;

    case 9: // Requête pour autocomplétion des disciplines scientifiques des personnages
      // Initialisation des variables
      $strPersDiscip = (isset($_POST['strPersDiscip'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strPersDiscip']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strPersDiscip, '%') !== false) $strPersDiscip = rawurldecode($strPersDiscip);

      // Récupération des disciplines scientifiques des personnages
      $req = "SELECT discipline FROM personnages WHERE type='F' AND LOWER(discipline) LIKE '%$strPersDiscip%' GROUP BY discipline ORDER BY discipline LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $tab[] = $row;
        // $tab[] = [ 'reference' => $row['titre'],
        //            'category' => 'Titre de l\'oeuvre'];
      }
      echo json_encode($tab);
      break;

    case 10: // Requête pour autocomplétion des professions des personnages
      // Initialisation des variables
      $strPersProf = (isset($_POST['strPersProf'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strPersProf']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strPersProf, '%') !== false) $strPersProf = rawurldecode($strPersProf);

      // Récupération des disciplines scientifiques des personnages
      $req = "SELECT profession FROM personnages WHERE LOWER(profession) LIKE '%$strPersProf%' GROUP BY profession ORDER BY profession LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $tab[] = $row;
        // $tab[] = [ 'reference' => $row['titre'],
        //            'category' => 'Titre de l\'oeuvre'];
      }

      echo json_encode($tab);
      break;

    case 11: // Requête pour autocomplétion des caractéristiques des personnages
      // Initialisation des variables
      $strPersCaract = (isset($_POST['strPersCaract'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strPersCaract']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strPersCaract, '%') !== false) $strPersCaract = rawurldecode($strPersCaract);

      // Récupération des disciplines scientifiques des personnages
      $req = "SELECT caracteristique FROM personnages WHERE LOWER(caracteristique) LIKE '%$strPersCaract%' GROUP BY caracteristique ORDER BY caracteristique LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $tab[] = $row;
        // $tab[] = [ 'reference' => $row['titre'],
        //            'category' => 'Titre de l\'oeuvre'];
      }

      echo json_encode($tab);
      break;

    case 12: // Requête pour autocomplétion des références au réel (Théorie ou invention)
      // Initialisation des variables
      $strReelThInv = (isset($_POST['strReelThInv'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strReelThInv']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strReelThInv, '%') !== false) $strReelThInv = rawurldecode($strReelThInv);

      // Récupération des théories et invention
      $req = "SELECT theorie FROM refaureel WHERE LOWER(theorie) LIKE '%$strReelThInv%' GROUP BY theorie ORDER BY theorie LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'reference' => $row['theorie'],
                   'category' => 'Théorie ou invention'];
      }

      echo json_encode($tab);
      break;

    case 19: // Requête pour autocomplétion des références au réel (Personnage scientifique)
      // Initialisation des variables
      $strReelPersSci = (isset($_POST['strReelPersSci'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strReelPersSci']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strReelPersSci, '%') !== false) $strReelPersSci = rawurldecode($strReelPersSci);

      // Récupération des personnalités scientifiques
      $req = "SELECT personnalite FROM refaureel WHERE LOWER(personnalite) LIKE '%$strReelPersSci%' GROUP BY personnalite ORDER BY personnalite LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'reference' => $row['personnalite'],
                   'category' => 'Personnalité'];
      }

      echo json_encode($tab);
      break;

    case 13: // Requête pour autocomplétion des références à des éléments scientifiques imaginaires
      // Initialisation des variables
      $strImaginDesc = (isset($_POST['strImaginDesc'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strImaginDesc']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strImaginDesc, '%') !== false) $strImaginDesc = rawurldecode($strImaginDesc);

      // Récupération des théories et invention
      $req = "SELECT description FROM eltscientifiques WHERE LOWER(description) LIKE '%$strImaginDesc%' GROUP BY description ORDER BY description LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $tab[] = $row;
        // $tab[] = [ 'reference' => $row['theorie'],
        //            'category' => 'Théorie ou invention'];
      }

      echo json_encode($tab);
      break;

    case 14: // Requête pour autocomplétion des inventions techniques imaginaires
      // Initialisation des variables
      $strImaginDomaine = (isset($_POST['strImaginDomaine'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strImaginDomaine']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strImaginDomaine, '%') !== false) $strImaginDomaine = rawurldecode($strImaginDomaine);

      // Récupération des théories et invention
      $req = "SELECT libelle FROM representations R, tableref T WHERE LOWER(libelle) LIKE '%$strImaginDomaine%' AND (R.idMot=T.idRef) AND (R.section='5132') GROUP BY libelle ORDER BY libelle LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $tab[] = $row;
        // $tab[] = [ 'reference' => $row['theorie'],
        //            'category' => 'Théorie ou invention'];
      }

      echo json_encode($tab);
      break;

    case 15: // Requête pour autocomplétion des voyages imaginaires
      // Initialisation des variables
      $strImaginVoyage = (isset($_POST['strImaginVoyage'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strImaginVoyage']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strImaginVoyage, '%') !== false) $strImaginVoyage = rawurldecode($strImaginVoyage);

      // Récupération des théories et invention
      $req = "SELECT libelle FROM representations R, tableref T WHERE LOWER(libelle) LIKE '%$strImaginVoyage%' AND (R.idMot=T.idRef) AND (R.section='52') GROUP BY libelle ORDER BY libelle LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $tab[] = $row;
        // $tab[] = [ 'reference' => $row['theorie'],
        //            'category' => 'Théorie ou invention'];
      }

      echo json_encode($tab);
      break;

    case 16: // Requête pour autocomplétion des supports de publication
      // Initialisation des variables
      $strSupportPub = (isset($_POST['strSupportPub'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strSupportPub']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strSupportPub, '%') !== false) $strSupportPub = rawurldecode($strSupportPub);

      // Récupération du nom des périodiques
      $req = "SELECT perNom FROM editions WHERE LOWER(perNom) LIKE '%$strSupportPub%' GROUP BY perNom ORDER BY perNom LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'support' => $row['perNom'],
                   'category' => 'Périodique'];
      }

      // Récupération du nom de l'éditeur (édition en volume)
      $req = "SELECT volEditeur FROM editions WHERE LOWER(volEditeur) LIKE '%$strSupportPub%' GROUP BY volEditeur ORDER BY volEditeur LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'support' => $row['volEditeur'],
                   'category' => 'Éditeur (édition en volume)'];
      }

      // Récupération du nom de l'éditeur (édition en livraison)
      $req = "SELECT livEditeur FROM editions WHERE LOWER(livEditeur) LIKE '%$strSupportPub%' GROUP BY livEditeur ORDER BY livEditeur LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'support' => $row['livEditeur'],
                   'category' => 'Éditeur (édition en volume)'];
      }

      // Récupération du titre de la collection
      $req = "SELECT livCollecNom FROM editions WHERE LOWER(livCollecNom) LIKE '%$strSupportPub%' GROUP BY livCollecNom ORDER BY livCollecNom LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'support' => $row['livCollecNom'],
                   'category' => 'Titre de la collection'];
      }

      echo json_encode($tab);
      break;

    case 17: // Requête pour autocomplétion des auteurs de fiches
      // Initialisation des variables
      $strAuteur = (isset($_POST['strAuteur'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strAuteur']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';
      $iCpt = 0;

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strAuteur, '%') !== false) $strAuteur = rawurldecode($strAuteur);

      // Renvoie les auteurs trouvés dans 
      $req = "SELECT auteurFiche FROM oeuvres WHERE auteurFiche LIKE '%$strAuteur%' GROUP BY auteurFiche ORDER BY auteurFiche LIMIT 0, 100";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // Si l'auteur est déjà dans le tableau... pas la peine de le rajouter
        $bTrouve = false;
        foreach ($tab as $aValue) {
          if (strstr($aValue['auteurFiche'], trim($row['auteurFiche']))) {
            $bTrouve = true;
            break;
          }
        }
        if ($bTrouve) continue;
        $iCpt++;
        $tab[] = [ 'auteurFiche' => trim($row['auteurFiche'])];
        if ($iCpt > $iMaxLignes) break;
      }
      echo json_encode($tab);
      break;

    case 18: // Requête pour autocomplétion des auteurs d'illustrations
      // Initialisation des variables
      $strIllustrAuteur = (isset($_POST['strIllustrAuteur'])) ? $OConnexion->real_escape_string(strtolower(trim($_POST['strIllustrAuteur']))) : '';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';

      // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
      if (strstr($strIllustrAuteur, '%') !== false) $strIllustrAuteur = rawurldecode($strIllustrAuteur);

      // Récupération des auteurs d'illustrations d'éditions en volumes
      $req = "SELECT volIllustrAuteur FROM editions WHERE volIllustrAuteur LIKE '%$strIllustrAuteur%' GROUP BY volIllustrAuteur ORDER BY volIllustrAuteur LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'illustrateur' => $row['volIllustrAuteur'],
                   'category' => 'Éditions en volume'];
      }

      // Récupération des auteurs d'illustrations d'éditions en livraison
      $req = "SELECT livIllustrAuteur FROM editions WHERE livIllustrAuteur LIKE '%$strIllustrAuteur%' GROUP BY livIllustrAuteur ORDER BY livIllustrAuteur LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'illustrateur' => $row['livIllustrAuteur'],
                   'category' => 'Éditions en livraison'];
      }

      // Récupération des auteurs d'illustrations d'éditions en périodiques
      $req = "SELECT perIllustrAuteur FROM editions WHERE perIllustrAuteur LIKE '%$strIllustrAuteur%' GROUP BY perIllustrAuteur ORDER BY perIllustrAuteur LIMIT 0, $iMaxLignes";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        // $tab[] = $row;
        $tab[] = [ 'illustrateur' => $row['perIllustrAuteur'],
                   'category' => 'Périodique'];
      }

      echo json_encode($tab);
      break;

    case 20: // Affichage du résultat de recherche simple
    case 21: // Affichage du résultat de recherche avancée
    case 29: // Détail des critères trouvés d'une oeuvre pour une recherche simple
    case 30: // Détail des critères trouvés d'une oeuvre pour une recherche avancée
    case 34: // Détail des critères trouvés pour toutes les oeuvres d'une recherche simple
    case 35: // Détail des critères trouvés pour toutes les oeuvres d'une recherche avancée
      // Initialisation des variables
      $strTitreRecherche = ($iCmd == 20) ? 'Recherche simple' : 'Recherche avancée';
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';
      $iLigneDeb = (isset($_POST['ligneDeb'])) ? $OConnexion->real_escape_string($_POST['ligneDeb']) : '1';

      $bPremsS = $bPremsW = true;
      $strPlusCritere = ' AND ';
      $strSelect = $strWhere = $strPlus = $strPlusS = $strLeftJoin = $strGroupBy = $strRecapRecherche = $strPlusRR = '';
      $aCriteres = array();
      // $strPlusW = ' ( ';

      if ($iCmd == 20 OR $iCmd == 29 OR $iCmd == 34) {
        // Recherche simple
        $strPlusW = ' ( ';
        // $strPlusW = '';
        $strLowRechSimple = (isset($_POST['txtRechSimple'])) ? $OConnexion->real_escape_string(strSupprimeAccents(trim($_POST['txtRechSimple']))) : '';

        // Cas où les caractères spéciaux sont passés de façon incorrecte: "%C3%A9" à la place de "é" par exemple
        if (strstr($strLowRechSimple, '%') !== false) $strLowRechSimple = rawurldecode($strLowRechSimple);

        // aRechSimpleAffichage définit dans lib/recherche-inc.php
        // foreach ($aRechSimpleAffichage as $value) {
        //   $strSelect .= $strPlus.$value['table'].'.'.$value['champ'].' AS \''.str_replace("'", "''", $value['titre']).'\'';
        //   if ($bPremsS) {
        //     $bPremsS = false;
        //     $strPlus = ', '."\n";
        //   }
        // }
        // Les champs à sélectionner sont dans aRechSimpleFiltrage
        foreach ($aRechSimpleFiltrage as $value) {
          $strSelect .= $strPlusS.$value['table'].'.'.$value['champ'].' AS \''.str_replace("'", "''", $value['titre']).'\'';
          // $strWhere .= $strPlusW.'LOWER('.$value['table'].'.'.$value['champ'].') LIKE \'%'.$strLowRechSimple.'%\'';
          $strWhere .= $strPlusW.$value['table'].'.'.$value['champ'].' LIKE \'%'.$strLowRechSimple.'%\'';
          $strRecapRecherche .= '<dt>'.$value['titre'].'</dt><dd>*'.$strLowRechSimple.'*</dd>';
          if ($bPremsS) {
            $bPremsS = false;
            $strPlusS = ', '."\n";
          }
          if ($bPremsW) {
            $bPremsW = false;
            $strPlusW = "\n".' OR ';
          }
        }
      } else {
        $strPlusW = '';
        // Recherche avancée
        // Construction du select
        foreach ($aRechAvanceeAffichage as $value) {
          $strSelect .= $strPlusS.$value['table'].'.'.$value['champ'].' AS \''.str_replace("'", "''", $value['titre']).'\'';
          if ($bPremsS) {
            $bPremsS = false;
            $strPlusS = ', '."\n";
          }
        }

        $strPlus = '';
        $bLJEditions = $bLJSpacioTemp = $bLJPersonnages = $bLJRepresentations = $bLJRefaureel = $bLJSocietesimg = $bLJListe_categorie = $bLJEltscientifiques = false;
        // Champs de l'onglet Présentation
        if (isset($_POST['txtTitrePE']) AND !empty($_POST['txtTitrePE'])) {
          // Titre première édition
          $strSelect .= ",\n".' oeuvres.titrePE AS \'Titre de l\'\'oeuvre\'';
          $aCriteres['Titre de l\'oeuvre'] = $_POST['txtTitrePE'];
          if (isset($_POST['rdTitrePE']) AND $_POST['rdTitrePE'] == 'contient') {
            $strPlus = '%';
            $strPlusRR = '*';
          }
          // Contient ou commence
          $strWhere .= $strPlusW.' oeuvres.titrePE LIKE \''.$strPlus.$OConnexion->real_escape_string($_POST['txtTitrePE']).'%\'';
          $strRecapRecherche .= '<dt>Titre de l\'oeuvre</dt><dd>'.$strPlusRR.$_POST['txtTitrePE'].'*</dd>';
          if ($bPremsW) {
            $bPremsW = false;
            $strPlusW = "\n".$strPlusCritere;
          }
        }

        if (isset($_POST['txtAuteur']) AND !empty($_POST['txtAuteur'])) {
          // Auteur
          $strFiltre = $OConnexion->real_escape_string($_POST['txtAuteur']);
          $strSelect .= ",\n".' oeuvres.auteurNom AS \'Nom(1)\''.
                        ",\n".' oeuvres.auteurNomReel AS \'Nom(1) réel\''.
                        ",\n".' oeuvres.auteurNom2 AS \'Nom(2)\''.
                        ",\n".' oeuvres.auteurNomReel2 AS \'Nom(2) réel\''.
                        ",\n".' oeuvres.auteurNom3 AS \'Nom(3)\''.
                        ",\n".' oeuvres.auteurNomReel3 AS \'Nom(3) réel\'';
          $aCriteres['Nom(1)'] = $_POST['txtAuteur'];
          $aCriteres['Nom(1) réel'] = $_POST['txtAuteur'];
          $aCriteres['Nom(2)'] = $_POST['txtAuteur'];
          $aCriteres['Nom(2) réel'] = $_POST['txtAuteur'];
          $aCriteres['Nom(3)'] = $_POST['txtAuteur'];
          $aCriteres['Nom(3) réel'] = $_POST['txtAuteur'];
          $strWhere .= $strPlusW.'( oeuvres.auteurNom LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurNomReel LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurNom2 LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurNomReel2 LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurNom3 LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurNomReel3 LIKE \'%'.$strFiltre.'%\'';
          $strRecapRecherche .= '<dt>Nom(s)</dt><dd>*'.$_POST['txtAuteur'].'*</dd>';

          if (isset($_POST['rdAuteur']) AND $_POST['rdAuteur'] == 'NomPrenom') {
            // Filtrage aussi sur les prénoms
            $strSelect .= ",\n".' oeuvres.auteurPrenom AS \'Prénom(1)\''.
                          ",\n".' oeuvres.auteurPrenomReel AS \'Prénom(1) réel\''.
                          ",\n".' oeuvres.auteurPrenom2 AS \'Prénom(2)\''.
                          ",\n".' oeuvres.auteurPrenomReel2 AS \'Prénom(2) réel\''.
                          ",\n".' oeuvres.auteurPrenom3 AS \'Prénom(3)\''.
                          ",\n".' oeuvres.auteurPrenomReel3 AS \'Prénom(3) réel\'';
            $aCriteres['Prénom(1)'] = $_POST['txtAuteur'];
            $aCriteres['Prénom(1) réel'] = $_POST['txtAuteur'];
            $aCriteres['Prénom(2)'] = $_POST['txtAuteur'];
            $aCriteres['Prénom(2) réel'] = $_POST['txtAuteur'];
            $aCriteres['Prénom(3)'] = $_POST['txtAuteur'];
            $aCriteres['Prénom(3) réel'] = $_POST['txtAuteur'];
            $strWhere .= "\n".' OR oeuvres.auteurPrenom LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurPrenomReel LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurPrenom2 LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurPrenomReel2 LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurPrenom3 LIKE \'%'.$strFiltre.'%\''."\n".
                              ' OR oeuvres.auteurPrenomReel3 LIKE \'%'.$strFiltre.'%\')';
            $strRecapRecherche .= '<dt>Prenom(s)</dt><dd>*'.$_POST['txtAuteur'].'*</dd>';
          } else {
            $strWhere .= ')';
          }
          if ($bPremsW) {
            $bPremsW = false;
            $strPlusW = "\n".$strPlusCritere;
          }
        }

        if (isset($_POST['txtAnneePEDeb']) AND !empty($_POST['txtAnneePEDeb']) OR isset($_POST['txtAnneePEFin']) AND !empty($_POST['txtAnneePEFin'])) {
          // Date de première édition
          $strSelect .= ",\n".' oeuvres.anneePE AS \'Date de 1ère édition\'';
          $strPlus = $strPlusW;
          if (isset($_POST['txtAnneePEDeb']) AND !empty($_POST['txtAnneePEDeb'])) {
            $aCriteres['Date de 1ère édition']['>='] = $_POST['txtAnneePEDeb'];
            $strWhere .= $strPlusW.' oeuvres.anneePE >= \''.$OConnexion->real_escape_string($_POST['txtAnneePEDeb'])."'";
            $strRecapRecherche .= '<dt>Date de 1ère édition</dt><dd>>= '.$_POST['txtAnneePEDeb'].'</dd>';
            // $bPremsW = false;
            $strPlus = ' AND ';
          }
          if (isset($_POST['txtAnneePEFin']) AND !empty($_POST['txtAnneePEFin'])) {
            $strWhere .= $strPlus.' oeuvres.anneePE <= \''.$OConnexion->real_escape_string($_POST['txtAnneePEFin'])."'";
            $aCriteres['Date de 1ère édition']['<='] = $_POST['txtAnneePEFin'];
            $strRecapRecherche .= '<dt>Date de 1ère édition</dt><dd><= '.$_POST['txtAnneePEFin'].'</dd>';
            // $bPremsW = false;
          }
          if ($bPremsW) {
            $bPremsW = false;
            $strPlusW = "\n".$strPlusCritere;
          }
        }

        if (isset($_POST['chkNatureTxt']) AND !empty($_POST['chkNatureTxt'])) {
          // Nature du texte
          $strSelect .= ",\n".' oeuvres.natureTxt AS \'Nature du texte\' ';
          $bPremsBis = true;
          $strPlusBis = '( ';
          $strWhere .= $strPlusW;
          foreach ($_POST['chkNatureTxt'] as $value) {
            // $strWhere .= $strPlusBis.' oeuvres.natureTxt = '.$OConnexion->real_escape_string($value);
            // value est de la forme id|libelle
            $aValeur = explode('|', $value);
            if ($bPremsBis) $aCriteres['Nature du texte'] = array();
            $aCriteres['Nature du texte'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            $strWhere .= $strPlusBis.' oeuvres.natureTxt = '.$OConnexion->real_escape_string($aValeur[0]);
            $strRecapRecherche .= '<dt>Nature du texte</dt><dd>= '.$aValeur[1].'</dd>';
            if ($bPremsBis) {
              $bPremsBis = false;
              $strPlusBis = ' OR ';
            }
          }
          $strWhere .= ' ) ';
          if ($bPremsW) {
            $bPremsW = false;
            $strPlusW = "\n".$strPlusCritere;
          }
          $aChampsSelect[] = array('oeuvres.natureTxt' => '');
        }

        if (isset($_POST['iNbAutFic']) AND $_POST['iNbAutFic'] != 0) {
          // Auteurs de la fiche
          $strWhereAAuteur = $strPlus = '';
          $bUnElt = false;
          for ($iCpt = 1; $iCpt <= $_POST['iNbAutFic']; $iCpt++) {
            if (!isset($_POST['txtListeAutFic-'.$iCpt]) OR empty($_POST['txtListeAutFic-'.$iCpt])) continue;
            if (!$bUnElt) {
              $aCriteres['Auteur de la fiche'] = array();
              $strSelect .= ",\n".' oeuvres.auteurFiche AS \'Auteur de la fiche\'';
            }
            // Ici, clé = valeur
            $aCriteres['Auteur de la fiche'][] = array('multi' => '', 'cle' => $_POST['txtListeAutFic-'.$iCpt], 'val' => $_POST['txtListeAutFic-'.$iCpt]);
            $strWhereAAuteur .= $strPlus.' oeuvres.auteurFiche LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeAutFic-'.$iCpt]).'%\'';
            $strRecapRecherche .= '<dt>Auteur de la fiche</dt><dd>= *'.$_POST['txtListeAutFic-'.$iCpt].'*</dd>';
            // $strPlus = $strPlusCritere;
            $strPlus = ' OR ';
            $bUnElt = true;
          }

          // (!empty($strWhereAAuteur) OR !empty($strWhereAAuteurDate))
          if ($bUnElt) {
            $strWhere .= $strPlusW.' ('.$strWhereAAuteur.')';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
        }

        // Champs de l'onglet Étude du genre
        if ((isset($_POST['iNbDescription']) AND $_POST['iNbDescription'] != 0 OR isset($_POST['chkDesGeneriqueTous']) AND $_POST['chkDesGeneriqueTous'] == 'tous') AND isset($_POST['chkTypeDes'])) {
          // Désignations génériques
          $strWhereTypeDes = $strPlusWTypeDes = '';
          $strPlusAucto = $strPlusEdito = $strPlusRecep = '(';
          $strWhereDescAucto = $strWhereDescEdito = $strWhereDescRecep = '';
          $bDateAucto = $bDateEdito = $bDateRecep = $bUnElt = false;
          $bPremsTypDes = true;
          // Ajout des désignations
          if (isset($_POST['chkDesGeneriqueTous']) AND $_POST['chkDesGeneriqueTous'] == 'tous') {
            // On filtre sur toutes les désignations non nulles
            $bUnElt = true;
            foreach ($_POST['chkTypeDes'] as $value) {
              switch ($value) {
                case 'discAuctorial':
                  // Ici, clé = valeur
                  // $aCriteres['Discours auctorial'] = array();
                  $aCriteres['Discours auctorial'][] = array('multi' => '', 'cle' => '', 'val' => '');
                  $strWhereDescAucto .= ' (discoursauctorial.designation IS NOT NULL';
                  $strRecapRecherche .= '<dt>Discours auctorial</dt><dd>= *</dd>';
                  break;
                case 'dispEditorial':
                  // Ici, clé = valeur
                  // $aCriteres['Dispositif éditorial'] = array();
                  $aCriteres['Dispositif éditorial'][] = array('multi' => '', 'cle' => '', 'val' => '');
                  $strWhereDescEdito .= ' (dispositifeditorial.designation IS NOT NULL';
                  $strRecapRecherche .= '<dt>Dispositif éditorial</dt><dd>= *</dd>';
                  break;
                case 'recepCritique':
                  // Ici, clé = valeur
                  // $aCriteres['Réception critique'] = array();
                  $aCriteres['Réception critique'][] = array('multi' => '', 'cle' => '', 'val' => '');
                  $strWhereDescRecep .= ' (receptioncritique.designation IS NOT NULL';
                  $strRecapRecherche .= '<dt>Réception critique</dt><dd>= *</dd>';
                  break;
              }
            }
          } else {
            $bPremsDA = $bPremsDE = $bPremsRC = true;
            for ($iCpt = 1; $iCpt <= $_POST['iNbDescription']; $iCpt++) {
              if (!isset($_POST['txtListeDescription-'.$iCpt]) OR empty($_POST['txtListeDescription-'.$iCpt])) continue;
              $bUnElt = true;
              foreach ($_POST['chkTypeDes'] as $value) {
                $strFiltre = $OConnexion->real_escape_string($_POST['txtListeDescription-'.$iCpt]);
                switch ($value) {
                  case 'discAuctorial':
                    if ($bPremsDA) {
                      $aCriteres['Discours auctorial'] = array();
                      $bPremsDA = false;
                    }
                    // Ici, clé = valeur
                    $aCriteres['Discours auctorial'][] = array('multi' => '', 'cle' => $_POST['txtListeDescription-'.$iCpt], 'val' => $_POST['txtListeDescription-'.$iCpt]);
                    $strWhereDescAucto .= $strPlusAucto.' discoursauctorial.designation LIKE \'%'.$strFiltre.'%\'';
                    $strPlusAucto = ' OR ';
                    $strRecapRecherche .= '<dt>Discours auctorial</dt><dd>= *'.$_POST['txtListeDescription-'.$iCpt].'*</dd>';
                    break;
                  case 'dispEditorial':
                    if ($bPremsDE) {
                      $aCriteres['Dispositif éditorial'] = array();
                      $bPremsDE = false;
                    }
                    // Ici, clé = valeur
                    $aCriteres['Dispositif éditorial'][] = array('multi' => '', 'cle' => $_POST['txtListeDescription-'.$iCpt], 'val' => $_POST['txtListeDescription-'.$iCpt]);
                    $strWhereDescEdito .= $strPlusEdito.' dispositifeditorial.designation LIKE \'%'.$strFiltre.'%\'';
                    $strPlusEdito = ' OR ';
                    $strRecapRecherche .= '<dt>Dispositif éditorial</dt><dd>= *'.$_POST['txtListeDescription-'.$iCpt].'*</dd>';
                    break;
                  case 'recepCritique':
                    if ($bPremsRC) {
                      $aCriteres['Réception critique'] = array();
                      $bPremsRC = false;
                    }
                    // Ici, clé = valeur
                    $aCriteres['Réception critique'][] = array('multi' => '', 'cle' => $_POST['txtListeDescription-'.$iCpt], 'val' => $_POST['txtListeDescription-'.$iCpt]);
                    $strWhereDescRecep .= $strPlusRecep.' receptioncritique.designation LIKE \'%'.$strFiltre.'%\'';
                    $strRecapRecherche .= '<dt>Réception critique</dt><dd>= *'.$_POST['txtListeDescription-'.$iCpt].'*</dd>';
                    $strPlusRecep = ' OR ';
                    break;
                }
              }
            }
          }

          if ($bUnElt) {
            // Il y a bien eu la saisie d'une description
            if (isset($_POST['txtAnneeDesignationDateDeb']) AND !empty($_POST['txtAnneeDesignationDateDeb']) OR isset($_POST['txtAnneeDesignationDateFin']) AND !empty($_POST['txtAnneeDesignationDateFin'])) {
              // Filtrage sur la date de la désignation
              $strPlusAucto = $strPlusEdito = $strPlusRecep = $strWhereDateAucto = $strWhereDateEdito = $strWhereDateRecep = '';
              if (isset($_POST['txtAnneeDesignationDateDeb']) AND !empty($_POST['txtAnneeDesignationDateDeb'])) {
                foreach ($_POST['chkTypeDes'] as $value) {
                  $strFiltre = $OConnexion->real_escape_string($_POST['txtAnneeDesignationDateDeb']);
                  switch ($value) {
                    case 'discAuctorial':
                      $aCriteres['Date du disc. auctorial']['>='] = $_POST['txtAnneeDesignationDateDeb'];
                      // $strSelect .= ",\n".'discoursauctorial.dDate AS \'Date du disc. auctorial\'';
                      $strWhereDateAucto .= 'discoursauctorial.dDate >= \''.$strFiltre."'";
                      $strPlusAucto = ' AND ';
                      $strRecapRecherche .= '<dt>Date du disc. auctorial</dt><dd>>= '.$_POST['txtAnneeDesignationDateDeb'].'</dd>';
                      $bDateAucto = true;
                      break;
                    case 'dispEditorial':
                      $aCriteres['Date du disp. éditorial']['>='] = $_POST['txtAnneeDesignationDateDeb'];
                      // $strSelect .= ",\n".'dispositifeditorial.dDate AS \'Date du disp. éditorial\'';
                      $strWhereDateEdito .= 'dispositifeditorial.dDate >= \''.$strFiltre."'";
                      $strPlusEdito = ' AND ';
                      $strRecapRecherche .= '<dt>Date du disp. éditorial</dt><dd>>= '.$_POST['txtAnneeDesignationDateDeb'].'</dd>';
                      $bDateEdito = true;
                      break;
                    case 'recepCritique':
                      $aCriteres['Date de la récep. crit.']['>='] = $_POST['txtAnneeDesignationDateDeb'];
                      // $strSelect .= ",\n".'receptioncritique.dDate AS \'Date de la récep. crit.\'';
                      $strWhereDateRecep .= 'receptioncritique.dDate >= \''.$strFiltre."'";
                      $strPlusRecep = ' AND ';
                      $strRecapRecherche .= '<dt>Date de la récep. crit.</dt><dd>>= '.$_POST['txtAnneeDesignationDateDeb'].'</dd>';
                      $bDateRecep = true;
                      break;
                  }
                }
              }
              // NOTA: il est possible d'avoir le cas de trouver dans le SELECT deux fois le même champ... tant pis, ce n'est pas un souci pour SQL et ça simplifie le code
              if (isset($_POST['txtAnneeDesignationDateFin']) AND !empty($_POST['txtAnneeDesignationDateFin'])) {
                foreach ($_POST['chkTypeDes'] as $value) {
                  $strFiltre = $OConnexion->real_escape_string($_POST['txtAnneeDesignationDateFin']);
                  switch ($value) {
                    case 'discAuctorial':
                      $aCriteres['Date du disc. auctorial']['<='] = $_POST['txtAnneeDesignationDateFin'];
                      // $strSelect .= ",\n".'discoursauctorial.dDate AS \'Date du disc. auctorial\'';
                      $strWhereDateAucto .= $strPlusAucto.'discoursauctorial.dDate <= '.$strFiltre;
                      $strRecapRecherche .= '<dt>Date du disc. auctorial</dt><dd><= '.$_POST['txtAnneeDesignationDateFin'].'</dd>';
                      $bDateAucto = true;
                      break;
                    case 'dispEditorial':
                      $aCriteres['Date du disp. éditorial']['<='] = $_POST['txtAnneeDesignationDateFin'];
                      // $strSelect .= ",\n".'dispositifeditorial.dDate AS \'Date du disp. éditorial\'';
                      $strWhereDateEdito .= $strPlusEdito.'dispositifeditorial.dDate <= '.$strFiltre;
                      $strRecapRecherche .= '<dt>Date du disp. éditorial</dt><dd><= '.$_POST['txtAnneeDesignationDateFin'].'</dd>';
                      $bDateEdito = true;
                      break;
                    case 'recepCritique':
                      $aCriteres['Date de la récep. crit.']['<='] = $_POST['txtAnneeDesignationDateFin'];
                      // $strSelect .= ",\n".'receptioncritique.dDate AS \'Date de la récep. crit.\'';
                      $strWhereDateRecep .= $strPlusRecep.'receptioncritique.dDate <= '.$strFiltre;
                      $strRecapRecherche .= '<dt>Date de la récep. crit.</dt><dd><= '.$_POST['txtAnneeDesignationDateFin'].'</dd>';
                      $bDateRecep = true;
                      break;
                  }
                }
              }
            }
            foreach ($_POST['chkTypeDes'] as $value) {
              switch ($value) {
                case 'discAuctorial':
                  if ($bDateAucto) {
                    $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT IF('.$strWhereDateAucto.', CONCAT(\'(\', discoursauctorial.dDate, \') \', discoursauctorial.designation), \'\') SEPARATOR \',\n \') AS \'Discours auctorial\'';
                  } else {
                    $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', discoursauctorial.dDate, \') \', discoursauctorial.designation) SEPARATOR \',\n \') AS \'Discours auctorial\'';
                  }
                  $strWhereDescAucto .= ')';
                  $strLeftJoin .= "\n".'LEFT JOIN discoursauctorial ON discoursauctorial.idOeuvre = oeuvres.idOeuvre';
                  break;
                case 'dispEditorial':
                  if ($bDateEdito) {
                    $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT IF('.$strWhereDateEdito.', CONCAT(\'(\', dispositifeditorial.dDate, \') \', dispositifeditorial.designation), \'\') SEPARATOR \',\n \') AS \'Dispositif éditorial\'';
                  } else {
                    $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', dispositifeditorial.dDate, \') \', dispositifeditorial.designation) SEPARATOR \',\n \') AS \'Dispositif éditorial\'';
                  }
                  $strWhereDescEdito .= ')';
                  $strLeftJoin .= "\n".'LEFT JOIN dispositifeditorial ON dispositifeditorial.idOeuvre = oeuvres.idOeuvre';
                  break;
                case 'recepCritique':
                  if ($bDateRecep) {
                    $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT IF('.$strWhereDateRecep.', CONCAT(\'(\', receptioncritique.dDate, \') \', receptioncritique.designation), \'\') SEPARATOR \',\n \') AS \'Réception critique\'';
                  } else {
                    $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', receptioncritique.dDate, \') \', receptioncritique.designation) SEPARATOR \',\n \') AS \'Réception critique\'';
                  }
                  $strWhereDescRecep .= ')';
                  $strLeftJoin .= "\n".'LEFT JOIN receptioncritique ON receptioncritique.idOeuvre = oeuvres.idOeuvre';
                  break;
              }
            }

            // Regroupement des filtres par type de description (Discours auctorial, Dispositif Éditorial et Réception critique)
            if (!empty($strWhereDescAucto)) {
              if (!empty($strWhereDateAucto)) {
                // Avec filtre sur la date
                $strWhereTypeDes .= $strPlusWTypeDes.$strWhereDateAucto.' AND ('.$strWhereDescAucto.')';
              } else {
                $strWhereTypeDes .= $strPlusWTypeDes.$strWhereDescAucto;
              }
              if ($bPremsTypDes) {
                $bPremsTypDes = false;
                $strPlusWTypeDes = "\n OR ";
              }
            }
            if (!empty($strWhereDescEdito)) {
              if (!empty($strWhereDateEdito)) {
                // Avec filtre sur la date
                $strWhereTypeDes .= $strPlusWTypeDes.$strWhereDateEdito.' AND ('.$strWhereDescEdito.')';
              } else {
                $strWhereTypeDes .= $strPlusWTypeDes.$strWhereDescEdito;
              }
              if ($bPremsTypDes) {
                $bPremsTypDes = false;
                $strPlusWTypeDes = "\n OR ";
              }
            }
            if (!empty($strWhereDescRecep)) {
              if (!empty($strWhereDateRecep)) {
                // Avec filtre sur la date
                $strWhereTypeDes .= $strPlusWTypeDes.$strWhereDateRecep.' AND ('.$strWhereDescRecep.')';
              } else {
                $strWhereTypeDes .= $strPlusWTypeDes.$strWhereDescRecep;
              }
              if ($bPremsTypDes) {
                $bPremsTypDes = false;
                $strPlusWTypeDes = "\n OR ";
              }
            }
            $strWhere .= $strPlusW.' ( '.$strWhereTypeDes.' )';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
        }

        if (isset($_POST['iNbLien']) AND $_POST['iNbLien'] != 0 OR isset($_POST['chkAutCompTous']) AND $_POST['chkAutCompTous'] == 'tous') {
          // Auteurs comparés
          $strLeftJoinLienAuteur = $strWhereAAuteur = $strWhereAAuteurDate = $strPlus = '';
          $bUnElt = false;
          if (isset($_POST['chkAutCompTous']) AND $_POST['chkAutCompTous'] == 'tous') {
            // $aCriteres['Auteur comparé'] = array();
            $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', liensautresauteurs.dDate, \') \', liensautresauteurs.auteurCompare) SEPARATOR \',\n \') AS \'Auteur comparé\'';
            // Ici, clé = valeur
            $aCriteres['Auteur comparé'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereAAuteur .= ' liensautresauteurs.auteurCompare IS NOT NULL';
            $strRecapRecherche .= '<dt>Auteur comparé</dt><dd>= *</dd>';
            $bUnElt = true;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbLien']; $iCpt++) {
              if (!isset($_POST['txtListeLien-'.$iCpt]) OR empty($_POST['txtListeLien-'.$iCpt])) continue;
              // PYJ - pour faire un AND à la place d'un OR
              // $strWhereAAuteur .= $strPlus.' liensautresauteurs.auteurCompare LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeLien-'.$iCpt]).'%\'';
              $strWhereAAuteur .= $strPlus.' liensautresauteurs'.$iCpt.'.auteurCompare LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeLien-'.$iCpt]).'%\'';
              $strLeftJoinLienAuteur .= "\n".'LEFT JOIN liensautresauteurs AS liensautresauteurs'.$iCpt.' ON liensautresauteurs'.$iCpt.'.idOeuvre = oeuvres.idOeuvre';
              $strRecapRecherche .= '<dt>Auteur comparé</dt><dd>= *'.$_POST['txtListeLien-'.$iCpt].'*</dd>';
              if (!$bUnElt) {
                $aCriteres['Auteur comparé'] = array();
                // $strSelect .= ",\n".' liensautresauteurs.auteurCompare AS \'Auteur comparé\'';
                $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', liensautresauteurs.dDate, \') \', liensautresauteurs.auteurCompare) SEPARATOR \',\n \') AS \'Auteur comparé\'';
                // $strPlus = ' OR ';
                $strPlus = ' AND ';
                $bUnElt = true;
              }
              // Ici, clé = valeur
              $aCriteres['Auteur comparé'][] = array('multi' => '', 'cle' => $_POST['txtListeLien-'.$iCpt], 'val' => $_POST['txtListeLien-'.$iCpt]);
              // $strPlus = $strPlusCritere;
            }
          }

          if ($bUnElt AND (isset($_POST['txtAnneeLienAAuteurDateDeb']) AND !empty($_POST['txtAnneeLienAAuteurDateDeb']) OR isset($_POST['txtAnneeLienAAuteurDateFin']) AND !empty($_POST['txtAnneeLienAAuteurDateFin']))) {
            // Date du lien avec l'auteur
            $strPlus = '';
            if (isset($_POST['txtAnneeLienAAuteurDateDeb']) AND !empty($_POST['txtAnneeLienAAuteurDateDeb'])) {
              $aCriteres['Date de comp. auteur']['>='] = $_POST['txtAnneeLienAAuteurDateDeb'];
              $strSelect .= ",\n".' liensautresauteurs.dDate AS \'Date de comp. auteur\'';
              $strWhereAAuteurDate .= ' liensautresauteurs.dDate >= \''.$OConnexion->real_escape_string($_POST['txtAnneeLienAAuteurDateDeb'])."'";
              $strRecapRecherche .= '<dt>Date de comp. auteur</dt><dd>>= '.$_POST['txtAnneeLienAAuteurDateDeb'].'</dd>';
              $strPlus = ' AND ';
            }
            if (isset($_POST['txtAnneeLienAAuteurDateFin']) AND !empty($_POST['txtAnneeLienAAuteurDateFin'])) {
              $aCriteres['Date de comp. auteur']['<='] = $_POST['txtAnneeLienAAuteurDateFin'];
              $strSelect .= ",\n".' liensautresauteurs.dDate AS \'Date de comp. auteur\'';
              $strWhereAAuteurDate .= $strPlus.' liensautresauteurs.dDate <= \''.$OConnexion->real_escape_string($_POST['txtAnneeLienAAuteurDateFin'])."'";
              $strRecapRecherche .= '<dt>Date de comp. auteur</dt><dd><= '.$_POST['txtAnneeLienAAuteurDateFin'].'</dd>';
            }
          }

          // (!empty($strWhereAAuteur) OR !empty($strWhereAAuteurDate))
          if ($bUnElt) {
            if (!empty($strWhereAAuteurDate)) {
              $strWhere .= $strPlusW.$strWhereAAuteurDate.' AND ('.$strWhereAAuteur.')';
            } else {
              $strWhere .= $strPlusW.' ('.$strWhereAAuteur.')';
            }
            $strLeftJoin .= "\n".'LEFT JOIN liensautresauteurs ON liensautresauteurs.idOeuvre = oeuvres.idOeuvre';
            if (!empty($strLeftJoinLienAuteur)) {
              $strLeftJoin .= $strLeftJoinLienAuteur;
            }
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
        }

        // Champs de l'onglet Description matérielle
        // (isset($_POST['iNbSupportPub']) AND $_POST['iNbSupportPub'] != 0 AND isset($_POST['chkTypeSupportPub']))
        // (isset($_POST['iNbSupportPub']) AND $_POST['iNbSupportPub'] != 0 OR !empty($_POST['txtSPAPAnneeDeb']) OR !empty($_POST['txtSPAPAnneeFin']))
        if (isset($_POST['iNbSupportPub']) AND $_POST['iNbSupportPub'] != 0 OR isset($_POST['chkSupportPubTous']) AND $_POST['chkSupportPubTous'] == 'tous' OR
            !empty($_POST['txtSPAPAnneeDeb']) OR !empty($_POST['txtSPAPAnneeFin'])) {
          // Supports de publication
          $strLeftJoinSupportPub = $strWhereSupportPub = $strWhereSupportPubDate = '';
          $strPlus = ' ';
          $bUnElt = $bPremsEditVolLiv = $bPremsEditColl = $bPremsEditPeriod = false;
          if (isset($_POST['chkSupportPubTous']) AND $_POST['chkSupportPubTous'] == 'tous') {
            // $aCriteres['Édition en volume'] = array();
            // $aCriteres['Édition en livraisons'] = array();
            // $aCriteres['Collection'] = array();
            // $aCriteres['Périodique'] = array();
            // Ici, clé = valeur
            $aCriteres['Édition en volume'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $aCriteres['Édition en livraisons'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $aCriteres['Collection'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $aCriteres['Périodique'][] = array('multi' => '', 'cle' => '', 'val' => '');

            $strWhereSupportPub .= $strPlus.' (editions.volEditeur IS NOT NULL OR editions.livEditeur IS NOT NULL OR editions.livCollecNom IS NOT NULL OR editions.perNom IS NOT NULL)';
            $strRecapRecherche .= '<dt>Éditeur, collection ou périodique</dt><dd>= *</dd>';
            $bUnElt = true;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbSupportPub']; $iCpt++) {
              if (!isset($_POST['txtListeSupportPub-'.$iCpt]) OR empty($_POST['txtListeSupportPub-'.$iCpt])) continue;
                if ($bPremsEditVolLiv) {
                  $aCriteres['Édition en volume'] = array();
                  $aCriteres['Édition en livraisons'] = array();
                  $bPremsEditVolLiv = false;
                }
                // Ici, clé = valeur
                $aCriteres['Édition en volume'][] = array('multi' => '', 'cle' => $_POST['txtListeSupportPub-'.$iCpt], 'val' => $_POST['txtListeSupportPub-'.$iCpt]);
                $aCriteres['Édition en livraisons'][] = array('multi' => '', 'cle' => $_POST['txtListeSupportPub-'.$iCpt], 'val' => $_POST['txtListeSupportPub-'.$iCpt]);
                if ($bPremsEditColl) {
                  $aCriteres['Collection'] = array();
                  $bPremsEditColl = false;
                }
                // Ici, clé = valeur
                $aCriteres['Collection'][] = array('multi' => '', 'cle' => $_POST['txtListeSupportPub-'.$iCpt], 'val' => $_POST['txtListeSupportPub-'.$iCpt]);
                if ($bPremsEditPeriod) {
                  $aCriteres['Périodique'] = array();
                  $bPremsEditPeriod = false;
                }
                // Ici, clé = valeur
                $aCriteres['Périodique'][] = array('multi' => '', 'cle' => $_POST['txtListeSupportPub-'.$iCpt], 'val' => $_POST['txtListeSupportPub-'.$iCpt]);

                // PYJ - pour faire un AND à la place d'un OR
                // $strWhereSupportPub .= $strPlus.' (editions.volEditeur LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeSupportPub-'.$iCpt]).'%\''."\n".
                //                                  '     OR editions.livEditeur LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeSupportPub-'.$iCpt]).'%\''.
                //                                 '     OR editions.livCollecNom LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeSupportPub-'.$iCpt]).'%\''.
                //                                 '     OR editions.perNom LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeSupportPub-'.$iCpt]).'%\')';
                $strWhereSupportPub .= $strPlus.' (editions'.$iCpt.'.volEditeur LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeSupportPub-'.$iCpt]).'%\''."\n".
                                                 '     OR editions'.$iCpt.'.livEditeur LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeSupportPub-'.$iCpt]).'%\''.
                                                '     OR editions'.$iCpt.'.livCollecNom LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeSupportPub-'.$iCpt]).'%\''.
                                                '     OR editions'.$iCpt.'.perNom LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeSupportPub-'.$iCpt]).'%\')';
                $strRecapRecherche .= '<dt>Éditeur, collection ou périodique</dt><dd>= *'.$_POST['txtListeSupportPub-'.$iCpt].'*</dd>';
                $strLeftJoinSupportPub .= "\n".'LEFT JOIN editions AS editions'.$iCpt.' ON editions'.$iCpt.'.idOeuvre = oeuvres.idOeuvre';
                if (!$bUnElt) {
                  $bUnElt = true;
                  // $strPlus = ' OR ';
                  $strPlus = ' AND ';
                }
                // if ($bPremsW) {
                //   $bPremsW = false;
                //   $strPlusW = "\n".$strPlusCritere;
                // }
            }
          }
          if ((isset($_POST['txtSPAPAnneeDeb']) AND !empty($_POST['txtSPAPAnneeDeb']) OR isset($_POST['txtSPAPAnneeFin']) AND !empty($_POST['txtSPAPAnneeFin']))) {
            // Date de la publication
            if (isset($_POST['txtSPAPAnneeDeb']) AND !empty($_POST['txtSPAPAnneeDeb'])) {
              $strSelect .= ",\n".' editions.anneeParution AS \'Année de parution\'';
              $aCriteres['Année de parution']['>='] = $_POST['txtSPAPAnneeDeb'];
              $strWhereSupportPubDate .= $strPlusW.' editions.anneeParution >= '.$OConnexion->real_escape_string($_POST['txtSPAPAnneeDeb']);
              $strRecapRecherche .= '<dt>Année de parution</dt><dd>>= '.$_POST['txtSPAPAnneeDeb'].'</dd>';
              if ($bPremsW) {
                $bPremsW = false;
                $strPlusW = "\n".$strPlusCritere;
              }
            }
            if (isset($_POST['txtSPAPAnneeFin']) AND !empty($_POST['txtSPAPAnneeFin'])) {
              $strSelect .= ",\n".' editions.anneeParution AS \'Année de parution\'';
              $aCriteres['Année de parution']['<='] = $_POST['txtSPAPAnneeFin'];
              $strWhereSupportPubDate .= $strPlusW.' editions.anneeParution <= '.$OConnexion->real_escape_string($_POST['txtSPAPAnneeFin']);
              $strRecapRecherche .= '<dt>Année de parution</dt><dd><= '.$_POST['txtSPAPAnneeFin'].'</dd>';
              if ($bPremsW) {
                $bPremsW = false;
                $strPlusW = "\n".$strPlusCritere;
              }
            }
          }

          if (!empty($strWhereSupportPubDate)) {
            // $strWhere .= $strPlusW.$strWhereSupportPubDate;
            $strWhere .= $strWhereSupportPubDate;
            if (!$bLJEditions) {
              $strLeftJoin .= "\n".'LEFT JOIN editions ON editions.idOeuvre = oeuvres.idOeuvre';
              $bLJEditions = true;
            }
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if (!empty($strWhereSupportPub)) {
            // $strWhere .= $strWhereSupportPub;
            $strWhere .= $strPlusW.' ( '.$strWhereSupportPub.' )';
            if (!$bLJEditions) {
              $strLeftJoin .= "\n".'LEFT JOIN editions ON editions.idOeuvre = oeuvres.idOeuvre';
              $bLJEditions = true;
            }
            if (!empty($strLeftJoinSupportPub)) {
              $strLeftJoin .= $strLeftJoinSupportPub;
            }
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bLJEditions) {
            // if (isset($_POST['chkTypeSupportPub'])) {
            //   foreach ($_POST['chkTypeSupportPub'] as $value) {
            //     switch ($value) {
            //       case 'Editeur'   : $strSelect .= ",\n".' editions.volEditeur AS \'Édition en volume\', editions.livEditeur AS \'Édition en livraisons\''; break;
            //       case 'Collection': $strSelect .= ",\n".' editions.livCollecNom AS \'Collection\''; break;
            //       case 'Periodique': $strSelect .= ",\n".' editions.perNom AS \'Périodique\''; break;
            //     }
            //   }
            // } else {
              // Si aucun type de support de publication n'a été coché on les prend tous
              $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', editions.anneeParution, \') \', editions.volEditeur) SEPARATOR \',\n \') AS \'Édition en volume\''.
                            ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', editions.anneeParution, \') \', editions.livEditeur) SEPARATOR \',\n \') AS \'Édition en livraisons\''.
                            ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', editions.anneeParution, \') \', editions.livCollecNom) SEPARATOR \',\n \') AS \'Collection\''.
                            ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', editions.anneeParution, \') \', editions.perNom) SEPARATOR \',\n \') AS \'Périodique\'';
            // }
          }
        }

        // TODO: pour ce genre de champs (chk*), s'arranger pour afficher les champs avec accent. Ex: Périodique au lieu de Periodique
        if (isset($_POST['chkSPTypeEdition'])) {
          // Types d'éditions
          $strLeftJoinTypeEdit = $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkSPTypeEdition'] as $value) {
            switch ($value) {
              case 'Volume':
                // PYJ - pour faire un AND à la place d'un OR
                // $strWhereBis .= $strPlusWBis.' editions.typeEdit = \'V\'';
                $strWhereBis .= $strPlusWBis.' editionsV.typeEdit = \'V\'';
                $aCriteres['Type d\'édition'][] = array('multi' => '', 'cle' => 'V', 'val' => 'Volume');
                $strLeftJoinTypeEdit .= "\n".'LEFT JOIN editions AS editionsV ON editionsV.idOeuvre = oeuvres.idOeuvre';
                break;
              case 'Periodique':
                // PYJ - pour faire un AND à la place d'un OR
                // $strWhereBis .= $strPlusWBis.' editions.typeEdit = \'P\'';
                $strWhereBis .= $strPlusWBis.' editionsP.typeEdit = \'P\'';
                $aCriteres['Type d\'édition'][] = array('multi' => '', 'cle' => 'P', 'val' => 'Periodique');
                $strLeftJoinTypeEdit .= "\n".'LEFT JOIN editions AS editionsP ON editionsP.idOeuvre = oeuvres.idOeuvre';
                break;
              case 'Livraison':
                // PYJ - pour faire un AND à la place d'un OR
                // $strWhereBis .= $strPlusWBis.' editions.typeEdit = \'L\'';
                $strWhereBis .= $strPlusWBis.' editionsL.typeEdit = \'L\'';
                $aCriteres['Type d\'édition'][] = array('multi' => '', 'cle' => 'L', 'val' => 'Livraison');
                $strLeftJoinTypeEdit .= "\n".'LEFT JOIN editions AS editionsL ON editionsL.idOeuvre = oeuvres.idOeuvre';
                break;
            }
            $strRecapRecherche .= '<dt>Type d\'édition</dt><dd>= '.$value.'</dd>';
            if ($bPremsWBis) {
              $strSelect .= ",\n".' GROUP_CONCAT(DISTINCT CONCAT(\'(\', editions.anneeParution, \') \', editions.typeEdit) SEPARATOR \',\n \') AS \'Type d\'\'édition\''; 
              $bPremsWBis = false;
              // $strPlusWBis = ' OR ';
              $strPlusWBis = ' AND ';
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if (!$bLJEditions) {
            $strLeftJoin .= "\n".'LEFT JOIN editions ON editions.idOeuvre = oeuvres.idOeuvre';
            $bLJEditions = true;
          }
          if (!empty($strLeftJoinTypeEdit)) {
            $strLeftJoin .= $strLeftJoinTypeEdit;
          }
        }

        // if (isset($_POST['chkSPCatEditeur'])) {
        //   // Catégories d'éditeur
        //   $strPlusWBis = $strWhereBis = '';
        //   $bPremsWBis = true;
        //   foreach ($_POST['chkSPCatEditeur'] as $value) {
        //     switch ($value) {
        //       case 'Jeunesse':         $strWhereBis .= $strPlusWBis.' editions.volCollecCat = \'J\''; $aCriteres['Catégorie d\'éditeur'][] = array('multi' => '', 'cle' => 'J', 'val' => 'Jeunesse'); break;
        //       case 'Populaire':        $strWhereBis .= $strPlusWBis.' editions.volCollecCat = \'P\''; $aCriteres['Catégorie d\'éditeur'][] = array('multi' => '', 'cle' => 'P', 'val' => 'Populaire'); break;
        //       case 'LuxeBibliophilie': $strWhereBis .= $strPlusWBis.' editions.volCollecCat = \'L\''; $aCriteres['Catégorie d\'éditeur'][] = array('multi' => '', 'cle' => 'L', 'val' => 'LuxeBibliophilie'); break;
        //       case 'Generale':         $strWhereBis .= $strPlusWBis.' editions.volCollecCat = \'G\''; $aCriteres['Catégorie d\'éditeur'][] = array('multi' => '', 'cle' => 'G', 'val' => 'Generale'); break;
        //     }
        //     $strRecapRecherche .= '<dt>Catégorie d\'éditeur</dt><dd>= '.$value.'</dd>';
        //     $strSelect .= "\n".', CONCAT(\'(\', editions.anneeParution, \') \', editions.volCollecCat) AS \'Catégorie d\'\'éditeur\''; 
        //     if ($bPremsWBis) {
        //       $bPremsWBis = false;
        //       $strPlusWBis = ' OR ';
        //     }
        //     if (!$bLJEditions) {
        //       $strLeftJoin .= "\n".'LEFT JOIN editions ON editions.idOeuvre = oeuvres.idOeuvre';
        //       $bLJEditions = true;
        //     }
        //   }
        //   if (!$bPremsWBis) {
        //     $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
        //     if ($bPremsW) {
        //       $bPremsW = false;
        //       $strPlusW = "\n".$strPlusCritere;
        //     }
        //   }
        // }

        // if (isset($_POST['chkSPCollSp'])) {
        //   // Collections spécialisées
        //   $strPlusWBis = $strWhereBis = '';
        //   $bPremsWBis = true;
        //   foreach ($_POST['chkSPCollSp'] as $value) {
        //     switch ($value) {
        //       case 'Anticipation': $strWhereBis .= $strPlusWBis.' editions.volCollecSpec = \'ANT\''; $aCriteres['Col. spécialisées'][] = array('multi' => '', 'cle' => 'ANT', 'val' => 'Anticipation'); break;
        //       case 'SF':           $strWhereBis .= $strPlusWBis.' editions.volCollecSpec = \'SFI\''; $aCriteres['Col. spécialisées'][] = array('multi' => '', 'cle' => 'SFI', 'val' => 'SF'); break;
        //       case 'Aventure':     $strWhereBis .= $strPlusWBis.' editions.volCollecSpec = \'AVE\''; $aCriteres['Col. spécialisées'][] = array('multi' => '', 'cle' => 'AVE', 'val' => 'Aventure'); break;
        //       case 'Policier':     $strWhereBis .= $strPlusWBis.' editions.volCollecSpec = \'POL\''; $aCriteres['Col. spécialisées'][] = array('multi' => '', 'cle' => 'POL', 'val' => 'Policier'); break;
        //       case 'Fantastique':  $strWhereBis .= $strPlusWBis.' editions.volCollecSpec = \'FAN\''; $aCriteres['Col. spécialisées'][] = array('multi' => '', 'cle' => 'FAN', 'val' => 'Fantastique'); break;
        //       case 'Sentimental':  $strWhereBis .= $strPlusWBis.' editions.volCollecSpec = \'SEN\''; $aCriteres['Col. spécialisées'][] = array('multi' => '', 'cle' => 'SEN', 'val' => 'Sentimental'); break;
        //     }
        //     $strRecapRecherche .= '<dt>Col. spécialisées</dt><dd>= '.$value.'</dd>';
        //     $strSelect .= "\n".', CONCAT(\'(\', editions.anneeParution, \') \', editions.volCollecSpec) AS \'Col. spécialisées\''; 
        //     if ($bPremsWBis) {
        //       $bPremsWBis = false;
        //       $strPlusWBis = ' OR ';
        //     }
        //     if (!$bLJEditions) {
        //       $strLeftJoin .= "\n".'LEFT JOIN editions ON editions.idOeuvre = oeuvres.idOeuvre';
        //       $bLJEditions = true;
        //     }
        //   }
        //   if (!$bPremsWBis) {
        //     $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
        //     if ($bPremsW) {
        //       $bPremsW = false;
        //       $strPlusW = "\n".$strPlusCritere;
        //     }
        //   }
        // }

        if (isset($_POST['chkSPCatColSpe'])) {
          // Catégories et collections spécialisées
          $strLeftJoinCatColl = $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkSPCatColSpe'] as $value) {
            $aValeur = explode('|', $value);
            $aCriteres['Catégories et collec. spécialisées'][] = array('multi' => '', 'cle' => $aValeur[1], 'val' => $aValeur[1]);
            // $strWhereBis .= $strPlusWBis.' liste_catedit.idRef = \''.$aValeur[0]."'";
            $strWhereBis .= $strPlusWBis.' liste_catedit'.$aValeur[0].'.idRef = \''.$aValeur[0]."'";
            $strRecapRecherche .= '<dt>Catégories et collec. spécialisées</dt><dd>= '.$aValeur[1].'</dd>';

            // PYJ - pour faire un AND à la place d'un OR
            $strLeftJoinCatColl .= "\n".'LEFT JOIN liste_catedit AS liste_catedit'.$aValeur[0].' ON liste_catedit'.$aValeur[0].'.idEdition = editions.idEdition'.
                                   "\n".'LEFT JOIN tableref AS TRCatEdit'.$aValeur[0].' ON TRCatEdit'.$aValeur[0].'.idRef = liste_catedit'.$aValeur[0].'.idRef';

            if ($bPremsWBis) {
              $bPremsWBis = false;
              // $strPlusWBis = ' OR ';
              $strPlusWBis = ' AND ';
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', GROUP_CONCAT(DISTINCT TRCatEdit.libelle SEPARATOR \'; \') AS \'Catégories et collec. spécialisées\''; 
            // $strSelect .= "\n".', TRCatEdit.libelle AS \'Catégories et collec. spécialisées\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
            if (!$bLJEditions) {
              $strLeftJoin .= "\n".'LEFT JOIN editions ON editions.idOeuvre = oeuvres.idOeuvre';
              $bLJEditions = true;
            }
            if (!$bLJListeCatedit) {
              $strLeftJoin .= "\n".'LEFT JOIN liste_catedit ON liste_catedit.idEdition = editions.idEdition'.
                              "\n".'LEFT JOIN tableref AS TRCatEdit ON TRCatEdit.idRef = liste_catedit.idRef';
              $bLJListeCatedit = true;
            }
            if (!empty($strLeftJoinCatColl)) {
              $strLeftJoin .= $strLeftJoinCatColl;
            }
          }
        }

        if (isset($_POST['iNbIllustrAuteur']) AND $_POST['iNbIllustrAuteur'] != 0 OR isset($_POST['chkIllustrAuteurTous']) AND $_POST['chkIllustrAuteurTous'] == 'tous') {
          // Nom de l'illustrateur
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkIllustrAuteurTous']) AND $_POST['chkIllustrAuteurTous'] == 'tous') {
            $aCriteres['Nom de l\'illustrateur (ed. en volume)'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $aCriteres['Nom de l\'illustrateur (ed. en livraison)'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $aCriteres['Nom de l\'illustrateur (ed. en périodique)'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= ' editions.volIllustrAuteur IS NOT NULL OR editions.livIllustrAuteur IS NOT NULL OR editions.perIllustrAuteur IS NOT NULL';
            $strRecapRecherche .= '<dt>Nom de l\'illustrateur (ed. en volume)</dt><dd>= *</dd>'.
                                  '<dt>Nom de l\'illustrateur (ed. en livraison)</dt><dd>= *</dd>'.
                                  '<dt>Nom de l\'illustrateur (ed. en périodique)</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbIllustrAuteur']; $iCpt++) {
              if (!isset($_POST['txtListeIllustrAuteur-'.$iCpt]) OR empty($_POST['txtListeIllustrAuteur-'.$iCpt])) continue;
              $aCriteres['Nom de l\'illustrateur (ed. en volume)'][] = array('multi' => '', 'cle' => $_POST['txtListeIllustrAuteur-'.$iCpt], 'val' => $_POST['txtListeIllustrAuteur-'.$iCpt]);
              $aCriteres['Nom de l\'illustrateur (ed. en livraison)'][] = array('multi' => '', 'cle' => $_POST['txtListeIllustrAuteur-'.$iCpt], 'val' => $_POST['txtListeIllustrAuteur-'.$iCpt]);
              $aCriteres['Nom de l\'illustrateur (ed. en périodique)'][] = array('multi' => '', 'cle' => $_POST['txtListeIllustrAuteur-'.$iCpt], 'val' => $_POST['txtListeIllustrAuteur-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' editions.volIllustrAuteur LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeIllustrAuteur-'.$iCpt]).'%\''.
                                        ' OR editions.livIllustrAuteur LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeIllustrAuteur-'.$iCpt]).'%\''.
                                        ' OR editions.perIllustrAuteur LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeIllustrAuteur-'.$iCpt]).'%\'';
              $strRecapRecherche .= '<dt>Nom de l\'illustrateur (ed. en volume)</dt><dd>= *'.$_POST['txtListeIllustrAuteur-'.$iCpt].'*</dd>'.
                                    '<dt>Nom de l\'illustrateur (ed. en livraison)</dt><dd>= *'.$_POST['txtListeIllustrAuteur-'.$iCpt].'*</dd>'.
                                    '<dt>Nom de l\'illustrateur (ed. en périodique)</dt><dd>= *'.$_POST['txtListeIllustrAuteur-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', editions.volIllustrAuteur AS \'Nom de l\'\'illustrateur (ed. en volume)\''.
                          "\n".', editions.livIllustrAuteur AS \'Nom de l\'\'illustrateur (ed. en livraison)\''.
                          "\n".', editions.perIllustrAuteur AS \'Nom de l\'\'illustrateur (ed. en périodique)\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJEditions) {
            $strLeftJoin .= "\n".'LEFT JOIN editions ON editions.idOeuvre = oeuvres.idOeuvre';
            $bLJEditions = true;
          }
        }

        if (isset($_POST['iNbLangueTrad']) AND $_POST['iNbLangueTrad'] != 0 OR isset($_POST['chkLangueTradTous']) AND $_POST['chkLangueTradTous'] == 'tous') {
          // Langue de la traduction
          $bUnElt = false;
          $strLeftJoinTraduction = $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkLangueTradTous']) AND $_POST['chkLangueTradTous'] == 'tous') {
            $aCriteres['Langue de traduction'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= ' traductions.langue IS NOT NULL';
            $strRecapRecherche .= '<dt>Langue de traduction</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbLangueTrad']; $iCpt++) {
              if (!isset($_POST['txtListeLangue-'.$iCpt]) OR empty($_POST['txtListeLangue-'.$iCpt])) continue;
              $aCriteres['Langue de traduction'][] = array('multi' => '', 'cle' => $_POST['txtListeLangue-'.$iCpt], 'val' => $_POST['txtListeLangue-'.$iCpt]);
              // $strWhere .= $strPlusW.' traductions.langue LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeLangue-'.$iCpt]).'%\'';
              // PYJ - pour faire un AND à la place d'un OR
              // $strWhereBis .= $strPlusWBis.' traductions.langue LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeLangue-'.$iCpt]).'%\'';
              $strWhereBis .= $strPlusWBis.' traductions'.$iCpt.'.langue LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeLangue-'.$iCpt]).'%\'';
              $strLeftJoinTraduction .= "\n".'LEFT JOIN traductions AS traductions'.$iCpt.' ON traductions'.$iCpt.'.idOeuvre = oeuvres.idOeuvre';
              $strRecapRecherche .= '<dt>Langue de traduction</dt><dd>= *'.$_POST['txtListeLangue-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                // $strPlusWBis = ' OR ';
                $strPlusWBis = ' AND ';
              }
            }
          }
          if (!$bPremsWBis) {
            // $strSelect .= "\n".', CONCAT(\'(\', traductions.dDate, \') \', traductions.langue) AS \'Langue de traduction\''; 
            $strSelect .= "\n".', GROUP_CONCAT(DISTINCT CONCAT(\'(\', traductions.dDate, \') \', traductions.langue) SEPARATOR \',\n \') AS \'Langue de traduction\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt) {
            $strLeftJoin .= "\n".'LEFT JOIN traductions ON traductions.idOeuvre = oeuvres.idOeuvre';
          }
          if (!empty($strLeftJoinTraduction)) {
            $strLeftJoin .= $strLeftJoinTraduction;
          }
        }

        if (isset($_POST['iNbNatureAdapt']) AND $_POST['iNbNatureAdapt'] != 0) {
          // Nature d'adaptation
          $bUnElt = false;
          $strLeftJoinAdapt = $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          for ($iCpt = 1; $iCpt <= $_POST['iNbNatureAdapt']; $iCpt++) {
            if (!isset($_POST['txtListeNatureAdapt-'.$iCpt]) OR empty($_POST['txtListeNatureAdapt-'.$iCpt])) continue;
            $strSelect .= "\n".', CONCAT(\'(\', adaptations.dDate, \') \', adaptations.nature) AS \'Nature d\'\'adaptation\''; 
            $aCriteres['Nature d\'adaptation'][] = array('multi' => '', 'cle' => $_POST['txtListeNatureAdapt-'.$iCpt], 'val' => $_POST['txtListeNatureAdapt-'.$iCpt]);
            // $strWhere .= $strPlusW.' adaptations.nature LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeNatureAdapt-'.$iCpt]).'%\'';
            // $strWhere .= $strPlusW.' adaptations.nature = \''.$OConnexion->real_escape_string($_POST['txtListeNatureAdapt-'.$iCpt]).'\'';
            // PYJ - pour faire un AND à la place d'un OR
            // $strWhereBis .= $strPlusWBis.' adaptations.nature = \''.$OConnexion->real_escape_string($_POST['txtListeNatureAdapt-'.$iCpt]).'\'';
            $strWhereBis .= $strPlusWBis.' adaptations'.$iCpt.'.nature = \''.$OConnexion->real_escape_string($_POST['txtListeNatureAdapt-'.$iCpt]).'\'';
            $strLeftJoinAdapt .= "\n".'LEFT JOIN adaptations AS adaptations'.$iCpt.' ON adaptations'.$iCpt.'.idOeuvre = oeuvres.idOeuvre';
            $strRecapRecherche .= '<dt>Nature d\'adaptation</dt><dd>= '.$_POST['txtListeNatureAdapt-'.$iCpt].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              // $strPlusWBis = ' OR ';
              $strPlusWBis = ' AND ';
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt) {
            $strLeftJoin .= "\n".'LEFT JOIN adaptations ON adaptations.idOeuvre = oeuvres.idOeuvre';
          }
          if (!empty($strLeftJoinAdapt)) {
            $strLeftJoin .= $strLeftJoinAdapt;
          }
        }

        // Champs de l'onglet Poétique, temps, espace, personnage et esthétique
        if (isset($_POST['chkPoetique'])) {
          // Poétique
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkPoetique'] as $value) {
            switch ($value) {
              case 'NarPPers':
                $strSelect .= "\n".', oeuvres.narrationP1 AS \'Narration à la 1ère personne\''; 
                $aCriteres['Narration à la 1ère personne'][] = array('multi' => '', 'cle' => '1', 'val' => 'Narration à la 1ère personne');
                $strWhereBis .= $strPlusWBis.' oeuvres.narrationP1 = 1';
                $strRecapRecherche .= '<dt>Narration</dt><dd>= à la première personne</dd>';
                if ($bPremsWBis) {
                  $bPremsWBis = false;
                  // $strPlusWBis = ' OR ';
                  $strPlusWBis = ' AND ';
                }
                break;
              case 'NarTPers':
                $strSelect .= "\n".', oeuvres.narrationP3 AS \'Narration à la 3ème personne\''; 
                $aCriteres['Narration à la 3ème personne'][] = array('multi' => '', 'cle' => '1', 'val' => 'Narration à la 3ème personne');
                $strWhereBis .= $strPlusWBis.' oeuvres.narrationP3 = 1';
                $strRecapRecherche .= '<dt>Narration</dt><dd>= à la troisième personne</dd>';
                if ($bPremsWBis) {
                  $bPremsWBis = false;
                  // $strPlusWBis = ' OR ';
                  $strPlusWBis = ' AND ';
                }
                break;
              case 'NarMulti':
                $strSelect .= "\n".', oeuvres.narrationMulti AS \'Narrateurs multiples\''; 
                $aCriteres['Narrateurs multiples'][] = array('multi' => '', 'cle' => '1', 'val' => 'Narrateurs multiples');
                $strWhereBis .= $strPlusWBis.' oeuvres.narrationMulti = 1';
                $strRecapRecherche .= '<dt>Narration</dt><dd>= multiple</dd>';
                if ($bPremsWBis) {
                  $bPremsWBis = false;
                  // $strPlusWBis = ' OR ';
                  $strPlusWBis = ' AND ';
                }
                break;
              case 'NarEnchass':
                $strSelect .= "\n".', oeuvres.narrationEnchassee AS \'Narration enchâssée\''; 
                $aCriteres['Narration enchâssée'][] = array('multi' => '', 'cle' => '1', 'val' => 'Narration enchâssée');
                $strWhereBis .= $strPlusWBis.' oeuvres.narrationEnchassee = 1';
                $strRecapRecherche .= '<dt>Narration</dt><dd>= enchâssée</dd>';
                if ($bPremsWBis) {
                  $bPremsWBis = false;
                  // $strPlusWBis = ' OR ';
                  $strPlusWBis = ' AND ';
                }
                break;
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
        }

        if (isset($_POST['iNbCadreSpat']) AND $_POST['iNbCadreSpat'] != 0 OR isset($_POST['chkCadreSpatTous']) AND $_POST['chkCadreSpatTous'] == 'tous') {
          // Cadre spatial
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkCadreSpatTous']) AND $_POST['chkCadreSpatTous'] == 'tous') {
            $aCriteres['Cadre spatial'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= $strPlusWBis.' lieux.libelle IS NOT NULL';
            $strRecapRecherche .= '<dt>Cadre spatial</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbCadreSpat']; $iCpt++) {
              if (!isset($_POST['txtListeCadreSpat-'.$iCpt]) OR empty($_POST['txtListeCadreSpat-'.$iCpt])) continue;
              $aCriteres['Cadre spatial'][] = array('multi' => '', 'cle' => $_POST['txtListeCadreSpat-'.$iCpt], 'val' => $_POST['txtListeCadreSpat-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' lieux.libelle LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeCadreSpat-'.$iCpt]).'%\'';
              $strRecapRecherche .= '<dt>Cadre spatial</dt><dd>= *'.$_POST['txtListeCadreSpat-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', lieux.libelle AS \'Cadre spatial\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt) {
            $strLeftJoin .= "\n".'LEFT JOIN lieux ON lieux.idOeuvre = oeuvres.idOeuvre';
          }
        }

        if (isset($_POST['txtDateHistoireDeb']) AND !empty($_POST['txtDateHistoireDeb']) OR isset($_POST['txtDateHistoireFin']) AND !empty($_POST['txtDateHistoireFin'])
            OR isset($_POST['chkDateHistoireTous']) AND $_POST['chkDateHistoireTous'] == 'tous') {
          // Date de l'histoire
          $strPlus = $strPlusW;
          $bUnElt = false;
          if (isset($_POST['chkDateHistoireTous']) AND $_POST['chkDateHistoireTous'] == 'tous') {
              $strSelect .= ",\n".' spaciotemporel.dateDeb AS \'Date de début de l\'\'histoire\', spaciotemporel.dateFin AS \'Date de fin de l\'\'histoire\'';
              $aCriteres['Date de début de l\'histoire'][] = array('multi' => '', 'cle' => '', 'val' => '');
              $aCriteres['Date de fin de l\'histoire'][] = array('multi' => '', 'cle' => '', 'val' => '');
              $strWhere .= $strPlusW.' (spaciotemporel.dateDeb IS NOT NULL OR spaciotemporel.dateFin IS NOT NULL)';
              $strRecapRecherche .= '<dt>Date de début de l\'histoire</dt><dd>>= *</dd>';
              $strRecapRecherche .= '<dt>Date de fin de l\'histoire</dt><dd><= *</dd>';
              $bPremsW = false;
              $bUnElt = true;
          } else {
            if (isset($_POST['txtDateHistoireDeb']) AND !empty($_POST['txtDateHistoireDeb'])) {
              $strSelect .= ",\n".' spaciotemporel.dateDeb AS \'Date de début de l\'\'histoire\'';
              $aCriteres['Date de début de l\'histoire']['>='] = $_POST['txtDateHistoireDeb'];
              $strWhere .= $strPlusW.' spaciotemporel.dateDeb >= \''.$OConnexion->real_escape_string($_POST['txtDateHistoireDeb'])."'";
              $strRecapRecherche .= '<dt>Date de début de l\'histoire</dt><dd>>= '.$_POST['txtDateHistoireDeb'].'</dd>';
              $bPremsW = false;
              $strPlus = ' AND ';
              $bUnElt = true;
            }
            if (isset($_POST['txtDateHistoireFin']) AND !empty($_POST['txtDateHistoireFin'])) {
              $strSelect .= ",\n".' spaciotemporel.dateFin AS \'Date de fin de l\'\'histoire\'';
              $aCriteres['Date de fin de l\'histoire']['<='] = $_POST['txtDateHistoireFin'];
              $strWhere .= $strPlus.' spaciotemporel.dateFin <= \''.$OConnexion->real_escape_string($_POST['txtDateHistoireFin'])."'";
              $strRecapRecherche .= '<dt>Date de fin de l\'histoire</dt><dd><= '.$_POST['txtDateHistoireFin'].'</dd>';
              $bPremsW = false;
              $bUnElt = true;
            }
          }
          if ($bPremsW) {
            $bPremsW = false;
            $strPlusW = "\n".$strPlusCritere;
          }
          if ($bUnElt AND !$bLJSpacioTemp) {
            $strLeftJoin .= "\n".'LEFT JOIN spaciotemporel ON spaciotemporel.idOeuvre = oeuvres.idOeuvre';
            $bLJSpacioTemp = true;
          }
        }

        if (isset($_POST['chkEcartTemp'])) {
          // Écart temporel
          $bUnElt = false;
          $strLeftJoinEcartTemp = $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkEcartTemp'] as $value) {
            // $strWhere .= $strPlusW.' spaciotemporel.ecart = \''.$value."'";
            $aValeur = explode('|', $value);
            $strSelect .= "\n".', spaciotemporel.ecart AS \'Écart temporel\''; 
            $aCriteres['Écart temporel'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            // PYJ - pour faire un AND à la place d'un OR
            // $strWhereBis .= $strPlusWBis.' spaciotemporel.ecart = \''.$aValeur[0]."'";
            $strWhereBis .= $strPlusWBis.' spaciotemporel'.$aValeur[0].'.ecart = \''.$aValeur[0]."'";
            $strLeftJoinEcartTemp .= "\n".'LEFT JOIN spaciotemporel AS spaciotemporel'.$aValeur[0].' ON spaciotemporel'.$aValeur[0].'.idOeuvre = oeuvres.idOeuvre';
            $strRecapRecherche .= '<dt>Écart temporel</dt><dd>= '.$aValeur[1].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              // $strPlusWBis = ' OR ';
              $strPlusWBis = ' AND ';
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJSpacioTemp) {
            $strLeftJoin .= "\n".'LEFT JOIN spaciotemporel ON spaciotemporel.idOeuvre = oeuvres.idOeuvre';
            $bLJSpacioTemp = true;
          }
          if (!empty($strLeftJoinEcartTemp)) {
            $strLeftJoin .= $strLeftJoinEcartTemp;
          }
        }

        if (isset($_POST['chkRapTemps'])) {
          // Rapport au temps
          $bUnElt = false;
          $strLeftJoinRapTemps = $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkRapTemps'] as $value) {
            // $strWhere .= $strPlusW.' poetiquekw.idMot = '.$value;
            $aValeur = explode('|', $value);
            $strSelect .= "\n".', poetiquekw.idMot AS \'Rapport au temps\''; 
            $aCriteres['Rapport au temps'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            // PYJ - pour faire un AND à la place d'un OR
            // $strWhereBis .= $strPlusWBis.' poetiquekw.idMot = '.$aValeur[0];
            $strWhereBis .= $strPlusWBis.' poetiquekw'.$aValeur[0].'.idMot = '.$aValeur[0];
            $strLeftJoinRapTemps .= "\n".'LEFT JOIN poetiquekw AS poetiquekw'.$aValeur[0].' ON poetiquekw'.$aValeur[0].'.idOeuvre = oeuvres.idOeuvre';
            $strRecapRecherche .= '<dt>Rapport au temps</dt><dd>= '.$aValeur[1].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              // $strPlusWBis = ' OR ';
              $strPlusWBis = ' AND ';
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt) {
            $strLeftJoin .= "\n".'LEFT JOIN poetiquekw ON poetiquekw.idOeuvre = oeuvres.idOeuvre';
          }
          if (!empty($strLeftJoinRapTemps)) {
            $strLeftJoin .= "\n".'LEFT JOIN poetiquekw ON poetiquekw.idOeuvre = oeuvres.idOeuvre';
          }
        }

        if (isset($_POST['iNbRefInterTxt']) AND $_POST['iNbRefInterTxt'] != 0 OR isset($_POST['chkRefInterTxtTous']) AND $_POST['chkRefInterTxtTous'] == 'tous') {
          // Références intertextuelles (oeuvre ou auteur)
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkRefInterTxtTous']) AND $_POST['chkRefInterTxtTous'] == 'tous') {
            $aCriteres['Références intertextuelles (oeuvre)'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $aCriteres['Références intertextuelles (auteur)'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= $strPlusWBis.' (refintertextuelles.titre IS NOT NULL OR refintertextuelles.auteur IS NOT NULL)';
            $strRecapRecherche .= '<dt>Références intertextuelles<br/>(oeuvre ou auteur)</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbRefInterTxt']; $iCpt++) {
              if (!isset($_POST['txtListeRefInterTxt-'.$iCpt]) OR empty($_POST['txtListeRefInterTxt-'.$iCpt])) continue;
              $aCriteres['Références intertextuelles (oeuvre)'][] = array('multi' => '', 'cle' => $_POST['txtListeRefInterTxt-'.$iCpt], 'val' => $_POST['txtListeRefInterTxt-'.$iCpt]);
              $aCriteres['Références intertextuelles (auteur)'][] = array('multi' => '', 'cle' => $_POST['txtListeRefInterTxt-'.$iCpt], 'val' => $_POST['txtListeRefInterTxt-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' (refintertextuelles.titre LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeRefInterTxt-'.$iCpt]).'%\''."\n".
                                           ' OR refintertextuelles.auteur LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeRefInterTxt-'.$iCpt]).'%\')';
              $strRecapRecherche .= '<dt>Références intertextuelles<br/>(oeuvre ou auteur)</dt><dd>= *'.$_POST['txtListeRefInterTxt-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', refintertextuelles.titre AS \'Références intertextuelles (oeuvre)\', refintertextuelles.auteur AS \'Références intertextuelles (auteur)\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt) {
            $strLeftJoin .= "\n".'LEFT JOIN refintertextuelles ON refintertextuelles.idOeuvre = oeuvres.idOeuvre';
          }
        }

        if (isset($_POST['iNbPersDiscip']) AND $_POST['iNbPersDiscip'] != 0 OR isset($_POST['chkPersDiscipTous']) AND $_POST['chkPersDiscipTous'] == 'tous') {
          // Personnage - Discipline scientifique / Personnage scientifique
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkPersDiscipTous']) AND $_POST['chkPersDiscipTous'] == 'tous') {
            // $aCriteres['Discipline scient. (Personnage)'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $aCriteres['Discipline pers. scientifique'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= $strPlusWBis.' personnages.discipline IS NOT NULL';
            // $strRecapRecherche .= '<dt>Discipline scientifique<br/>(Personnage)</dt><dd>= *</dd>';
            $strRecapRecherche .= '<dt>Discipline pers.<br/>scientifique</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbPersDiscip']; $iCpt++) {
              if (!isset($_POST['txtListePersDiscip-'.$iCpt]) OR empty($_POST['txtListePersDiscip-'.$iCpt])) continue;
              // $aCriteres['Discipline scient. (Personnage)'][] = array('multi' => '', 'cle' => $_POST['txtListePersDiscip-'.$iCpt], 'val' => $_POST['txtListePersDiscip-'.$iCpt]);
              $aCriteres['Discipline pers. scientifique'][] = array('multi' => '', 'cle' => $_POST['txtListePersDiscip-'.$iCpt], 'val' => $_POST['txtListePersDiscip-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' personnages.discipline LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListePersDiscip-'.$iCpt]).'%\'';
              // $strRecapRecherche .= '<dt>Discipline scientifique<br/>(Personnage)</dt><dd>= *'.$_POST['txtListePersDiscip-'.$iCpt].'*</dd>';
              $strRecapRecherche .= '<dt>Discipline pers.<br/>scientifique</dt><dd>= *'.$_POST['txtListePersDiscip-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', CONCAT(\'(\', personnages.nom, \') \', personnages.discipline) AS \'Discipline scient. (Personnage)\''; 
            // $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            $strWhere .= $strPlusW.' ('.$strWhereBis.') AND personnages.type = \'F\' ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJPersonnages) {
            $strLeftJoin .= "\n".'LEFT JOIN personnages ON personnages.idOeuvre = oeuvres.idOeuvre';
            $bLJPersonnages = true;
          }
        }

        if (isset($_POST['iNbPersProf']) AND $_POST['iNbPersProf'] != 0 OR isset($_POST['chkPersProfTous']) AND $_POST['chkPersProfTous'] == 'tous') {
          // Personnage - Profession
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkPersProfTous']) AND $_POST['chkPersProfTous'] == 'tous') {
            $aCriteres['Profession (Personnage)'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= $strPlusWBis.' personnages.profession IS NOT NULL';
            $strRecapRecherche .= '<dt>Profession (Personnage)</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbPersProf']; $iCpt++) {
              if (!isset($_POST['txtListePersProf-'.$iCpt]) OR empty($_POST['txtListePersProf-'.$iCpt])) continue;
              $aCriteres['Profession (Personnage)'][] = array('multi' => '', 'cle' => $_POST['txtListePersProf-'.$iCpt], 'val' => $_POST['txtListePersProf-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' personnages.profession LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListePersProf-'.$iCpt]).'%\'';
              $strRecapRecherche .= '<dt>Profession (Personnage)</dt><dd>= *'.$_POST['txtListePersProf-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', CONCAT(\'(\', personnages.nom, \') \', personnages.profession) AS \'Profession (Personnage)\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJPersonnages) {
            $strLeftJoin .= "\n".'LEFT JOIN personnages ON personnages.idOeuvre = oeuvres.idOeuvre';
            $bLJPersonnages = true;
          }
        }

        if (isset($_POST['chkPersGenre'])) {
          // Personnage: genre
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkPersGenre'] as $value) {
            // $strWhere .= $strPlusW.' personnages.genre = \''.$value."'";
            $aValeur = explode('|', $value);
            // $strSelect .= "\n".', CONCAT(\'(\', personnages.nom, \') \', personnages.genre) AS \'Genre (Personnage)\''; 
            // TODO: problème lors du marquage du critère de recherche
            $strSelect .= "\n".', personnages.genre AS \'Genre (Personnage)\''; 
            $aCriteres['Genre (Personnage)'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            $strWhereBis .= $strPlusWBis.' personnages.genre = \''.$aValeur[0]."'";
            $strRecapRecherche .= '<dt>Genre (Personnage)</dt><dd>= '.$aValeur[1].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              $strPlusWBis = ' OR ';
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJPersonnages) {
            $strLeftJoin .= "\n".'LEFT JOIN personnages ON personnages.idOeuvre = oeuvres.idOeuvre';
            $bLJPersonnages = true;
          }
        }
        if (isset($_POST['chkPersValo'])) {
          // Personnage: valorisation
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkPersValo'] as $value) {
            // $strWhere .= $strPlusW.' personnages.valorisation = \''.$value."'";
            $aValeur = explode('|', $value);
            // $strSelect .= "\n".', CONCAT(\'(\', personnages.nom, \') \', personnages.valorisation) AS \'Valorisation (Personnage)\''; 
            // TODO: problème lors du marquage du critère de recherche
            $strSelect .= "\n".', personnages.valorisation AS \'Valorisation (Personnage)\''; 
            $aCriteres['Valorisation (Personnage)'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            $strWhereBis .= $strPlusWBis.' personnages.valorisation = \''.$aValeur[0]."'";
            $strRecapRecherche .= '<dt>Valorisation (Personnage)</dt><dd>= '.$aValeur[1].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              $strPlusWBis = ' OR ';
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJPersonnages) {
            $strLeftJoin .= "\n".'LEFT JOIN personnages ON personnages.idOeuvre = oeuvres.idOeuvre';
            $bLJPersonnages = true;
          }
        }
        if (isset($_POST['iNbPersCaract']) AND $_POST['iNbPersCaract'] != 0 OR isset($_POST['chkPersCaractTous']) AND $_POST['chkPersCaractTous'] == 'tous') {
          // Personnage - Caractéristiques
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkPersCaractTous']) AND $_POST['chkPersCaractTous'] == 'tous') {
            $aCriteres['Caractéristiques (Personnage)'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= $strPlusWBis.' personnages.caracteristique IS NOT NULL';
            $strRecapRecherche .= '<dt>Caractéristiques (Personnage)</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbPersCaract']; $iCpt++) {
              if (!isset($_POST['txtListePersCaract-'.$iCpt]) OR empty($_POST['txtListePersCaract-'.$iCpt])) continue;
              $aCriteres['Caractéristiques (Personnage)'][] = array('multi' => '', 'cle' => $_POST['txtListePersCaract-'.$iCpt], 'val' => $_POST['txtListePersCaract-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' personnages.caracteristique LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListePersCaract-'.$iCpt]).'%\'';
              $strRecapRecherche .= '<dt>Caractéristiques (Personnage)</dt><dd>= *'.$_POST['txtListePersCaract-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', personnages.caracteristique AS \'Caractéristiques (Personnage)\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJPersonnages) {
            $strLeftJoin .= "\n".'LEFT JOIN personnages ON personnages.idOeuvre = oeuvres.idOeuvre';
            $bLJPersonnages = true;
          }
        }
        if (isset($_POST['chkPersFigAlt'])) {
          // Personnage: Figure de l'altérité
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkPersFigAlt'] as $value) {
            // $strWhere .= $strPlusW.' personnages.alterite = \''.$value."'";
            $aValeur = explode('|', $value);
            $strSelect .= "\n".', personnages.alterite AS \'Figure de l\'\'altérité (Personnage)\''; 
            $aCriteres['Figure de l\'altérité (Personnage)'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            $strWhereBis .= $strPlusWBis.' personnages.alterite = \''.$aValeur[0]."'";
            $strRecapRecherche .= '<dt>Figure de l\'altérité (Personnage)</dt><dd>= '.$aValeur[1].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              $strPlusWBis = ' OR ';
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJPersonnages) {
            $strLeftJoin .= "\n".'LEFT JOIN personnages ON personnages.idOeuvre = oeuvres.idOeuvre';
            $bLJPersonnages = true;
          }
        }
        if (isset($_POST['iNbImaginEsthetique']) AND $_POST['iNbImaginEsthetique'] != 0 OR isset($_POST['chkImaginEsthetiqueTous']) AND $_POST['chkImaginEsthetiqueTous'] == 'tous') {
          // Esthétique
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          $bLJBis = false;
          if (isset($_POST['chkImaginEsthetiqueTous']) AND $_POST['chkImaginEsthetiqueTous'] == 'tous') {
            // $strSelect .= "\n".', esthetique.idMot AS \'Esthétique\''; 
            $strSelect .= "\n".', GROUP_CONCAT(DISTINCT TREsthetique.libelle SEPARATOR \',\n \') AS \'Esthétique\''; 
            $aCriteres['Esthétique'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= $strPlusWBis.' esthetique.idMot IS NOT NULL';
            $strRecapRecherche .= '<dt>Esthétique</dt><dd>= */dd>';
            $bPremsWBis = false;
            $bLJBis = true;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbImaginEsthetique']; $iCpt++) {
              // Récupération de l'identifiant dans le hiddentxtListeImaginEsthetique-$iCpt
              if (!isset($_POST['hiddentxtListeImaginEsthetique-'.$iCpt]) OR empty($_POST['hiddentxtListeImaginEsthetique-'.$iCpt])) continue;
              // $strSelect .= "\n".', GROUP_CONCAT(DISTINCT esthetique.idMot SEPARATOR \', \') AS \'Esthétique\''; 
              // TODO: dans l'idéal, n'avoir qu'un seul résultat... mais là aussi, problème lors du marquage du critère
              $aCriteres['Esthétique'][] = array('multi' => '', 'cle' => $_POST['hiddentxtListeImaginEsthetique-'.$iCpt], 'val' => $_POST['txtListeImaginEsthetique-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' esthetique.idMot = '.$OConnexion->real_escape_string($_POST['hiddentxtListeImaginEsthetique-'.$iCpt]);
              $strRecapRecherche .= '<dt>Esthétique</dt><dd>= '.$_POST['txtListeImaginEsthetique-'.$iCpt].'</dd>';
              if ($bPremsWBis) {
                $strSelect .= "\n".', esthetique.idMot AS \'Esthétique\''; 
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
            $strLeftJoin .= "\n".'LEFT JOIN esthetique ON esthetique.idOeuvre = oeuvres.idOeuvre';
            if ($bLJBis) {
              $strLeftJoin .= "\n".'LEFT JOIN tableref AS TREsthetique ON TREsthetique.idRef = esthetique.idMot';
            }
          }
        }

        // Champs de l'onglet Sciences et sociétés
        if (isset($_POST['chkScSoDiscThem']) OR isset($_POST['chkScSoDiscThemTous']) AND $_POST['chkScSoDiscThemTous'] == 'tous') {
          // Disciplines et thématiques
          $bLJBis = $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkScSoDiscThemTous']) AND $_POST['chkScSoDiscThemTous'] == 'tous') {
            $aCriteres['Disciplines et thématiques'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strSelect .= "\n".', GROUP_CONCAT(DISTINCT TRRepresentations.libelle SEPARATOR \',\n \') AS \'Disciplines et thématiques\''; 
            $strWhereBis .= $strPlusWBis.' representations.idMot IS NOT NULL';
            $strRecapRecherche .= '<dt>Disciplines et thématiques</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
            $bLJBis = true;
          } else {
            $bUnElt = false;
            $strPlusWBis = $strWhereBis = '';
            $bPremsWBis = true;
            foreach ($_POST['chkScSoDiscThem'] as $value) {
              // value est de la forme id|libelle
              $aValeur = explode('|', $value);
              $aCriteres['Disciplines et thématiques'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
              $strWhereBis .= $strPlusWBis.' representations.idMot = '.$aValeur[0];
              $strRecapRecherche .= '<dt>Disciplines et thématiques</dt><dd>= '.$aValeur[1].'</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $strSelect .= "\n".', representations.idMot AS \'Disciplines et thématiques\''; 
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJRepresentations) {
            $strLeftJoin .= "\n".'LEFT JOIN representations ON representations.idOeuvre = oeuvres.idOeuvre';
            $bLJRepresentations = true;
          }
          if ($bLJBis) {
            $strLeftJoin .= "\n".'LEFT JOIN tableref AS TRRepresentations ON TRRepresentations.idRef = representations.idMot';
          }
        }

        if (isset($_POST['iNbReelThInv']) AND $_POST['iNbReelThInv'] != 0 OR isset($_POST['chkReelThInvTous']) AND $_POST['chkReelThInvTous'] == 'tous') {
          // Théorie ou invention
          $bSelectTIPS = $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkReelThInvTous']) AND $_POST['chkReelThInvTous'] == 'tous') {
            // $aCriteres['Théorie ou invention'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $aCriteres['TIPS|Théorie ou invention'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= $strPlusWBis.' (refaureel.theorie IS NOT NULL)';
            $strRecapRecherche .= '<dt>Théorie ou invention</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbReelThInv']; $iCpt++) {
              if (!isset($_POST['txtListeReelThInv-'.$iCpt]) OR empty($_POST['txtListeReelThInv-'.$iCpt])) continue;
              // $aCriteres['Théorie ou invention'][] = array('multi' => '', 'cle' => $_POST['txtListeReelThInv-'.$iCpt], 'val' => $_POST['txtListeReelThInv-'.$iCpt]);
              $aCriteres['TIPS|Théorie ou invention'][] = array('multi' => '', 'cle' => $_POST['txtListeReelThInv-'.$iCpt], 'val' => $_POST['txtListeReelThInv-'.$iCpt]);
              // $strWhereBis .= $strPlusWBis.' (refaureel.theorie LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeReelThInv-'.$iCpt]).'%\')';
              $strWhereBis .= $strPlusWBis.' (refaureel.theorie LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeReelThInv-'.$iCpt]).'%\' OR '.
                                           ' refaureel.citation LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeReelThInv-'.$iCpt]).'%\')';
              $strRecapRecherche .= '<dt>Théorie ou invention</dt><dd>= *'.$_POST['txtListeReelThInv-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            // $strSelect .= "\n".', GROUP_CONCAT(DISTINCT refaureel.theorie SEPARATOR \'<br />\') AS \'Théorie ou invention\', '.
            //                      'GROUP_CONCAT(DISTINCT refaureel.personnalite SEPARATOR \'<br />\') AS \'Personnalité scientifique\''; 
            $strSelect .= "\n".', GROUP_CONCAT(DISTINCT CONCAT(refaureel.theorie, \'%,%\', refaureel.personnalite, \'%,%\', refaureel.citation, \'%,%\', refaureel.discipline, \'%,%\', refaureel.modalite) SEPARATOR \'%;%\') AS \'TIPS|Théorie ou invention\'';
            $bSelectTIPS = true;
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJRefaureel) {
            $strLeftJoin .= "\n".'LEFT JOIN refaureel ON refaureel.idOeuvre = oeuvres.idOeuvre';
            $bLJRefaureel = true;
          }
        }
        if (isset($_POST['iNbReelPersSci']) AND $_POST['iNbReelPersSci'] != 0 OR isset($_POST['chkReelPersSciTous']) AND $_POST['chkReelPersSciTous'] == 'tous') {
          // Théorie, invention ou personnalité scientifique
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkReelPersSciTous']) AND $_POST['chkReelPersSciTous'] == 'tous') {
            // $aCriteres['Théorie ou invention'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $aCriteres['TIPS|Personnalité scientifique'][] = array('multi' => '', 'cle' => '', 'val' => '');
            // $aCriteres['Personnalité scientifique'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= $strPlusWBis.' (refaureel.personnalite IS NOT NULL)';
            $strRecapRecherche .= '<dt>Personnalité scientifique</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbReelPersSci']; $iCpt++) {
              if (!isset($_POST['txtListeReelPersSci-'.$iCpt]) OR empty($_POST['txtListeReelPersSci-'.$iCpt])) continue;
              $aCriteres['TIPS|Personnalité scientifique'][] = array('multi' => '', 'cle' => $_POST['txtListeReelPersSci-'.$iCpt], 'val' => $_POST['txtListeReelPersSci-'.$iCpt]);
              // $strWhereBis .= $strPlusWBis.' (refaureel.personnalite LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeReelPersSci-'.$iCpt]).'%\')';
              $strWhereBis .= $strPlusWBis.' (refaureel.personnalite LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeReelPersSci-'.$iCpt]).'%\' OR '.
                                           ' refaureel.citation LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeReelPersSci-'.$iCpt]).'%\')';
              $strRecapRecherche .= '<dt>Personnalité scientifique</dt><dd>= *'.$_POST['txtListeReelPersSci-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis AND !$bSelectTIPS) {
            $strSelect .= "\n".', GROUP_CONCAT(DISTINCT CONCAT(refaureel.theorie, \'%,%\', refaureel.personnalite, \'%,%\', refaureel.citation, \'%,%\', refaureel.discipline, \'%,%\', refaureel.modalite) SEPARATOR \'%;%\') AS \'TIPS|Personnalité scientifique\'';
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJRefaureel) {
            $strLeftJoin .= "\n".'LEFT JOIN refaureel ON refaureel.idOeuvre = oeuvres.idOeuvre';
            $bLJRefaureel = true;
          }
        }

        if (isset($_POST['chkReelDiscipline'])) {
          // Disciplines (des références au réel)
          $bUnElt = false;
          $strLeftJoinReelDiscipline = $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkReelDiscipline'] as $value) {
            // $strWhere .= $strPlusW.' refaureel.discipline = \''.$value."'";
            $aValeur = explode('|', $value);
            $aCriteres['Disciplines (des réf. au réel)'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            // PYJ - pour faire un AND à la place d'un OR
            // $strWhereBis .= $strPlusWBis.' refaureel.discipline = \''.$aValeur[0]."'";
            // $strWhereBis .= $strPlusWBis.' refaureel'.$aValeur[0].'.discipline = \''.$aValeur[0]."'";
            $strWhereBis .= $strPlusWBis.' refaureel.discipline = \''.$aValeur[0]."' AND refaureel".$aValeur[0].'.discipline = \''.$aValeur[0]."'";
            $strLeftJoinReelDiscipline .= "\n".'LEFT JOIN refaureel AS refaureel'.$aValeur[0].' ON refaureel'.$aValeur[0].'.idOeuvre = oeuvres.idOeuvre';
            $strRecapRecherche .= '<dt>Disciplines (des réf. au réel)</dt><dd>= '.$aValeur[1].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              // $strPlusWBis = ' OR ';
              $strPlusWBis = ' AND ';
            }
          }
          if (!$bPremsWBis) {
            // TODO: améliorer la présentation (tester si theorie et personnalite sont vide ou pas)
            $strSelect .= "\n".', CONCAT(\'(\', refaureel.theorie, \', \', refaureel.personnalite, \') \', refaureel.discipline) AS \'Disciplines (des réf. au réel)\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJRefaureel) {
            $strLeftJoin .= "\n".'LEFT JOIN refaureel ON refaureel.idOeuvre = oeuvres.idOeuvre';
            $bLJRefaureel = true;
          }
          if (!empty($strLeftJoinReelDiscipline)) {
            $strLeftJoin .= $strLeftJoinReelDiscipline;
          }
        }

        if (isset($_POST['chkReelModal'])) {
          // Modalité
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkReelModal'] as $value) {
            // $strWhere .= $strPlusW.' refaureel.modalite = \''.$value."'";
            $aValeur = explode('|', $value);
            $aCriteres['Modalité'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            $strWhereBis .= $strPlusWBis.' refaureel.modalite = \''.$aValeur[0]."'";
            $strRecapRecherche .= '<dt>Modalité</dt><dd>= '.$aValeur[1].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              $strPlusWBis = ' OR ';
            }
          }
          if (!$bPremsWBis) {
            // TODO: améliorer la présentation (tester si theorie et personnalite sont vide ou pas)
            $strSelect .= "\n".', CONCAT(\'(\', refaureel.theorie, \', \', refaureel.personnalite, \') \', refaureel.modalite) AS \'Modalité\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJRefaureel) {
            $strLeftJoin .= "\n".'LEFT JOIN refaureel ON refaureel.idOeuvre = oeuvres.idOeuvre';
            $bLJRefaureel = true;
          }
        }

        if (isset($_POST['iNbImaginDesc']) AND $_POST['iNbImaginDesc'] != 0 OR isset($_POST['chkImaginDescTous']) AND $_POST['chkImaginDescTous'] == 'tous') {
          // Termes utilisés dans la description
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkImaginDescTous']) AND $_POST['chkImaginDescTous'] == 'tous') {
            $aCriteres['ESI|Termes utilisés dans la description'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereBis .= $strPlusWBis.' (eltscientifiques.nom IS NOT NULL)';
            $strRecapRecherche .= '<dt>Termes utilisés dans la description</dt><dd>= *</dd>';
            $bUnElt = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbImaginDesc']; $iCpt++) {
              if (!isset($_POST['txtListeImaginDesc-'.$iCpt]) OR empty($_POST['txtListeImaginDesc-'.$iCpt])) continue;
              $aCriteres['ESI|Termes utilisés dans la description'][] = array('multi' => '', 'cle' => $_POST['txtListeImaginDesc-'.$iCpt], 'val' => $_POST['txtListeImaginDesc-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' eltscientifiques.description LIKE \'%'.$OConnexion->real_escape_string($_POST['txtListeImaginDesc-'.$iCpt]).'%\'';
              $strRecapRecherche .= '<dt>Termes utilisés dans la description</dt><dd>= *'.$_POST['txtListeImaginDesc-'.$iCpt].'*</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', GROUP_CONCAT(DISTINCT CONCAT(eltscientifiques.nom, \'%,%\', eltscientifiques.description, \'%,%\', TREltSci.idRef, \'%,%\', TREltSci.libelle, \'%,%\') SEPARATOR \'%;%\') AS \'ESI|Termes utilisés dans la description\'';
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt) {
            if (!$bLJEltscientifiques) {
              $strLeftJoin .= "\n".'LEFT JOIN eltscientifiques ON eltscientifiques.idOeuvre = oeuvres.idOeuvre';
              $bLJEltscientifiques = true;
            }
            $strLeftJoin .= "\n".'LEFT JOIN liste_catelts AS LCEEltSci ON LCEEltSci.idEltScientifique = eltscientifiques.idEltScientifique'."\n".
                                 'LEFT JOIN tableref AS TREltSci ON TREltSci.idRef = LCEEltSci.idRef';
          }
        }

        if (isset($_POST['iNbImaginDomaine']) AND $_POST['iNbImaginDomaine'] != 0 OR isset($_POST['chkImaginDomaineTous']) AND $_POST['chkImaginDomaineTous'] == 'tous') {
          // Domaine des inventions techniques
          $bLJBis = $bUnElt = false;
          $strPlusWInvTech = '(';
          $strWhereInvTech = '';
          if (isset($_POST['chkImaginDomaineTous']) AND $_POST['chkImaginDomaineTous'] == 'tous') {
            $strSelect .= "\n".', CONCAT(\'(\', eltscientifiques.nom, \') \', TRDomaine.libelle) AS \'Domaine des inventions techniques\''; 
            $aCriteres['Domaine des inventions techniques'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strWhereInvTech .= $strPlusWInvTech.' liste_catelts.idRef IS NOT NULL';
            $strRecapRecherche .= '<dt>Domaine des inventions techniques</dt><dd>= '.$_POST['txtListeImaginDomaine-'.$iCpt].'</dd>';
            $bUnElt = true;
            $bLJBis = true;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbImaginDomaine']; $iCpt++) {
              // Récupération de l'identifiant dans le hiddentxtListeImaginDomaine-$iCpt
              if (!isset($_POST['hiddentxtListeImaginDomaine-'.$iCpt]) OR empty($_POST['hiddentxtListeImaginDomaine-'.$iCpt])) continue;
              $aCriteres['Domaine des inventions techniques'][] = array('multi' => '', 'cle' => $_POST['hiddentxtListeImaginDomaine-'.$iCpt], 'val' => $_POST['txtListeImaginDomaine-'.$iCpt]);
              // $strWhere .= $strPlusW.' representations.idMot = '.$OConnexion->real_escape_string($_POST['hiddentxtListeImaginDomaine-'.$iCpt]);
              $strWhereInvTech .= $strPlusWInvTech.' liste_catelts.idRef = '.$OConnexion->real_escape_string($_POST['hiddentxtListeImaginDomaine-'.$iCpt]);
              $strRecapRecherche .= '<dt>Domaine des inventions techniques</dt><dd>= '.$_POST['txtListeImaginDomaine-'.$iCpt].'</dd>';
              if (!$bUnElt) {
                $strSelect .= "\n".', CONCAT(\'(\', eltscientifiques.nom, \') \', liste_catelts.idRef) AS \'Domaine des inventions techniques\''; 
                $bUnElt = true;
                $strPlusWInvTech = ' OR ';
                // $strPlusWInvTech = ' AND ';
              }
            }
          }
            // $strLeftJoin .= "\n".'LEFT JOIN representations ON representations.idOeuvre = oeuvres.idOeuvre';
            // $bLJRepresentations = true;
          if ($bUnElt) {
            $strWhere .= $strPlusW.$strWhereInvTech.')';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
            if (!$bLJEltscientifiques) {
              $strLeftJoin .= "\n".'LEFT JOIN eltscientifiques ON eltscientifiques.idOeuvre = oeuvres.idOeuvre';
              $bLJEltscientifiques = true;
            }
            if (!$bLJListe_categorie) {
              $strLeftJoin .= "\n".'LEFT JOIN liste_catelts ON liste_catelts.idEltScientifique = eltscientifiques.idEltScientifique';
              $bLJListe_categorie = true;
            }
            if ($bLJBis) {
              $strLeftJoin .= "\n".'LEFT JOIN tableref AS TRDomaine ON TRDomaine.idRef = liste_catelts.idRef';
            }
          }
        }

        if (isset($_POST['iNbImaginVoyage']) AND $_POST['iNbImaginVoyage'] != 0 OR isset($_POST['chkImaginVoyageTous']) AND $_POST['chkImaginVoyageTous'] == 'tous') {
          // Voyage(s)
          $bLJBis = $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkImaginVoyageTous']) AND $_POST['chkImaginVoyageTous'] == 'tous') {
            $aCriteres['Voyage(s)'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strSelect .= "\n".', GROUP_CONCAT(DISTINCT TRVoyage.libelle SEPARATOR \',\n\') AS \'Voyage(s)\''; 
            // Besoin de préciser ici la section pour n'avoir que les voyages
            $strWhereBis .= $strPlusWBis.' TRVoyage.idRef IS NOT NULL AND TRVoyage.section = \'5.2\'';
            $strRecapRecherche .= '<dt>Voyage(s)</dt><dd>= *</dd>';
            $bUnElt = true;
            $bLJBis = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbImaginVoyage']; $iCpt++) {
              // Récupération de l'identifiant dans le hiddentxtListeImaginDomaine-$iCpt
              if (!isset($_POST['hiddentxtListeImaginVoyage-'.$iCpt]) OR empty($_POST['hiddentxtListeImaginVoyage-'.$iCpt])) continue;
              $aCriteres['Voyage(s)'][] = array('multi' => '', 'cle' => $_POST['hiddentxtListeImaginVoyage-'.$iCpt], 'val' => $_POST['txtListeImaginVoyage-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' representations.idMot = '.$OConnexion->real_escape_string($_POST['hiddentxtListeImaginVoyage-'.$iCpt]);
              $strRecapRecherche .= '<dt>Voyage(s)</dt><dd>= '.$_POST['txtListeImaginVoyage-'.$iCpt].'</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $strSelect .= "\n".', representations.idMot AS \'Voyage(s)\''; 
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJRepresentations) {
            $strLeftJoin .= "\n".'LEFT JOIN representations ON representations.idOeuvre = oeuvres.idOeuvre';
            $bLJRepresentations = true;
          }
          if ($bLJBis) {
            $strLeftJoin .= "\n".'LEFT JOIN tableref AS TRVoyage ON TRVoyage.idRef = representations.idMot';
          }
        }
        if (isset($_POST['chkImaginSoci'])) {
          // Représentation d'une société imaginaire
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkImaginSoci'] as $value) {
            $aValeur = explode('|', $value);
            $aCriteres['Société imaginaire (représentation)'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            $strWhereBis .= $strPlusWBis.' oeuvres.socRepresentation = \''.$aValeur[0]."'";
            $strRecapRecherche .= '<dt>Société imaginaire (représentation)</dt><dd>= '.$aValeur[1].'</dd>';
            if ($bPremsWBis) {
              $bPremsWBis = false;
              $strPlusWBis = ' OR ';
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', oeuvres.socRepresentation AS \'Société imaginaire (représentation)\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
        }
        if (isset($_POST['chkImaginTechno'])) {
          // Degré de technologie
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkImaginTechno'] as $value) {
            // $strWhere .= $strPlusW.' societesimg.degreTechno = \''.$value."'";
            $aValeur = explode('|', $value);
            $aCriteres['Société imaginaire (degré technologique)'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            $strWhereBis .= $strPlusWBis.' societesimg.degreTechno = \''.$aValeur[0]."'";
            $strRecapRecherche .= '<dt>Société imaginaire (degré technologique)</dt><dd>= '.$aValeur[1].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              $strPlusWBis = ' OR ';
            }
          }
          if (!$bPremsWBis) {
            // TODO: dans l'idéal, n'avoir qu'un seul résultat... mais là aussi, problème lors du marquage du critère
            // $strSelect .= "\n".', CONCAT(\'(\', societesimg.nom, \') \', societesimg.degreTechno) AS \'Société imaginaire (degré technologique)\''; 
            $strSelect .= "\n".', societesimg.degreTechno AS \'Société imaginaire (degré technologique)\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJSocietesimg) {
            $strLeftJoin .= "\n".'LEFT JOIN societesimg ON societesimg.idOeuvre = oeuvres.idOeuvre';
            $bLJSocietesimg = true;
          }
        }

        // if (isset($_POST['chkImaginStatutSci'])) {
        //   // Statut du scientifique
        //   $bUnElt = false;
        //   $strPlusWBis = $strWhereBis = '';
        //   $bPremsWBis = true;
        //   foreach ($_POST['chkImaginStatutSci'] as $value) {
        //     // $strWhere .= $strPlusW.' societesimg.statutScient = \''.$value."'";
        //     $aValeur = explode('|', $value);
        //     $aCriteres['Statut du scientifique'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
        //     $strWhereBis .= $strPlusWBis.' societesimg.statutScient = \''.$aValeur[0]."'";
        //     $strRecapRecherche .= '<dt>Statut du scientifique</dt><dd>= '.$aValeur[1].'</dd>';
        //     $bUnElt = true;
        //     if ($bPremsWBis) {
        //       $bPremsWBis = false;
        //       $strPlusWBis = ' OR ';
        //     }
        //   }
        //   if (!$bPremsWBis) {
        //     // TODO: dans l'idéal, n'avoir qu'un seul résultat... mais là aussi, problème lors du marquage du critère
        //     $strSelect .= "\n".', societesimg.statutScient AS \'Statut du scientifique\''; 
        //     $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
        //     if ($bPremsW) {
        //       $bPremsW = false;
        //       $strPlusW = "\n".$strPlusCritere;
        //     }
        //   }
        //   if ($bUnElt AND !$bLJSocietesimg) {
        //     $strLeftJoin .= "\n".'LEFT JOIN societesimg ON societesimg.idOeuvre = oeuvres.idOeuvre';
        //     $bLJSocietesimg = true;
        //   }
        // }

        // if (isset($_POST['chkImaginHierarchie'])) {
        //   // Hiérarchie
        //   $bUnElt = false;
        //   foreach ($_POST['chkImaginHierarchie'] as $value) {
        //     // $strWhere .= $strPlusW.' societesimg.hierarchie = \''.$value."'";
        //     $aValeur = explode('|', $value);
        //     $strSelect .= "\n".', societesimg.hierarchie AS \'Hiérarchie\''; 
        //     $aCriteres['Hiérarchie'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
        //     $strWhere .= $strPlusW.' societesimg.hierarchie = \''.$aValeur[0]."'";
        //     $strRecapRecherche .= '<dt>Hiérarchie</dt><dd>= '.$aValeur[1].'</dd>';
        //     if ($bPremsW) {
        //       $bPremsW = false;
        //       $strPlusW = "\n".$strPlusCritere;
        //     }
        //     $bUnElt = true;
        //   }
        //   if ($bUnElt AND !$bLJSocietesimg) {
        //     $strLeftJoin .= "\n".'LEFT JOIN societesimg ON societesimg.idOeuvre = oeuvres.idOeuvre';
        //     $bLJSocietesimg = true;
        //   }
        // }

        if (isset($_POST['chkImaginValeur'])) {
          // Valeur
          $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          foreach ($_POST['chkImaginValeur'] as $value) {
            // $strWhere .= $strPlusW.' societesimg.valeur = \''.$value."'";
            $aValeur = explode('|', $value);
            $aCriteres['Société imaginaire (Valeur)'][] = array('multi' => '', 'cle' => $aValeur[0], 'val' => $aValeur[1]);
            $strWhereBis .= $strPlusWBis.' societesimg.valeur = \''.$aValeur[0]."'";
            $strRecapRecherche .= '<dt>Société imaginaire (valeur)</dt><dd>= '.$aValeur[1].'</dd>';
            $bUnElt = true;
            if ($bPremsWBis) {
              $bPremsWBis = false;
              $strPlusWBis = ' OR ';
            }
          }
          if (!$bPremsWBis) {
            $strSelect .= "\n".', societesimg.valeur AS \'Société imaginaire (Valeur)\''; 
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJSocietesimg) {
            $strLeftJoin .= "\n".'LEFT JOIN societesimg ON societesimg.idOeuvre = oeuvres.idOeuvre';
            $bLJSocietesimg = true;
          }
        }

        if (isset($_POST['iNbSocImaginTraitsSpec']) AND $_POST['iNbSocImaginTraitsSpec'] != 0 OR isset($_POST['chkSocImaginTraitsSpecTous']) AND $_POST['chkSocImaginTraitsSpecTous'] == 'tous') {
          // Traits spécifiques de la société imaginaire
          $bLJBis = $bUnElt = false;
          $strPlusWBis = $strWhereBis = '';
          $bPremsWBis = true;
          if (isset($_POST['chkSocImaginTraitsSpecTous']) AND $_POST['chkSocImaginTraitsSpecTous'] == 'tous') {
            $strSelect .= "\n".', GROUP_CONCAT(DISTINCT TRSocImagin.libelle SEPARATOR \',\n\') AS \'Traits spécifiques\''; 
            // Besoin de préciser ici la section pour n'avoir que les voyages
            $strWhereBis .= $strPlusWBis.' TRSocImagin.idRef IS NOT NULL AND TRSocImagin.section = \'5.3.4\'';
            $aCriteres['Traits spécifiques'][] = array('multi' => '', 'cle' => '', 'val' => '');
            $strRecapRecherche .= '<dt>Traits spécifiques</dt><dd>= */dd>';
            $bUnElt = true;
            $bLJBis = true;
            $bPremsWBis = false;
          } else {
            for ($iCpt = 1; $iCpt <= $_POST['iNbSocImaginTraitsSpec']; $iCpt++) {
              // Récupération de l'identifiant dans le hiddentxtListeSocImaginTraitsSpec-$iCpt
              if (!isset($_POST['hiddentxtListeSocImaginTraitsSpec-'.$iCpt]) OR empty($_POST['hiddentxtListeSocImaginTraitsSpec-'.$iCpt])) continue;
              $aCriteres['Traits spécifiques'][] = array('multi' => '', 'cle' => $_POST['hiddentxtListeSocImaginTraitsSpec-'.$iCpt], 'val' => $_POST['txtListeSocImaginTraitsSpec-'.$iCpt]);
              $strWhereBis .= $strPlusWBis.' representations.idMot = '.$OConnexion->real_escape_string($_POST['hiddentxtListeSocImaginTraitsSpec-'.$iCpt]);
              $strRecapRecherche .= '<dt>Traits spécifiques</dt><dd>= '.$_POST['txtListeSocImaginTraitsSpec-'.$iCpt].'</dd>';
              $bUnElt = true;
              if ($bPremsWBis) {
                $strSelect .= "\n".', representations.idMot AS \'Traits spécifiques\''; 
                $bPremsWBis = false;
                $strPlusWBis = ' OR ';
              }
            }
          }
          if (!$bPremsWBis) {
            // $strSelect .= "\n".', GROUP_CONCAT(representations.idMot SEPARATOR \', \') AS \'Traits spécifiques\''; 
            // TODO: dans l'idéal, n'avoir qu'un seul résultat... mais là aussi, problème lors du marquage du critère
            $strWhere .= $strPlusW.' ('.$strWhereBis.') ';
            if ($bPremsW) {
              $bPremsW = false;
              $strPlusW = "\n".$strPlusCritere;
            }
          }
          if ($bUnElt AND !$bLJRepresentations) {
            $strLeftJoin .= "\n".'LEFT JOIN representations ON representations.idOeuvre = oeuvres.idOeuvre';
            $bLJRepresentations = true;
          }
          if ($bLJBis) {
            $strLeftJoin .= "\n".'LEFT JOIN tableref AS TRSocImagin ON TRSocImagin.idRef = representations.idMot';
          }
        }
      }

      if (!empty($strRecapRecherche)) $strRecapRecherche = '<dl class="dl-horizontal">'.$strRecapRecherche.'</dl>';
      // Cloture du WHERE
      // $strWhere .= $bPremsW ? 'oeuvres.deleted = 0' : ' ) AND oeuvres.deleted = 0';
      // $strWhere .= $bPremsW ? 'oeuvres.deleted = 0' : ' AND oeuvres.deleted = 0';
      // $strWhere .= ($bPremsW ? '' : ' AND ').'oeuvres.deleted = 0';
      if ($iCmd == 20) {
        $strWhere .= ($bPremsW ? '' : ' ) AND ').'oeuvres.deleted = 0';
      } else if ($iCmd == 21) {
        $strWhere .= ($bPremsW ? '' : ' AND ').'oeuvres.deleted = 0';
      } else if ($iCmd == 29) {
        $strWhere .= ($bPremsW ? '' : ' ) AND ').'oeuvres.deleted = 0 AND oeuvres.idOeuvre = '.$OConnexion->real_escape_string($_POST['idO']);
      } else if ($iCmd == 30) {
        $strWhere .= ($bPremsW ? '' : ' AND ').'oeuvres.deleted = 0 AND oeuvres.idOeuvre = '.$OConnexion->real_escape_string($_POST['idO']);
      } else if ($iCmd == 34 OR $iCmd == 35) {
        $strWhereIdOs = '(';
        $strPlusWIdOs = '';
        $aIdOs = explode('|', $OConnexion->real_escape_string($_POST['idOs']));
        foreach ($aIdOs as $key => $idO) {
          $strWhereIdOs .= $strPlusWIdOs.'oeuvres.idOeuvre = '.$idO;
          if (empty($strPlusWIdOs)) $strPlusWIdOs = ' OR ';
        }
        $strWhereIdOs .= ')';
        if ($iCmd == 34) {
          $strWhere .= ($bPremsW ? '' : ' ) AND ').'oeuvres.deleted = 0 AND '.$strWhereIdOs;
        } else if ($iCmd == 35) {
          $strWhere .= ($bPremsW ? '' : ' AND ').'oeuvres.deleted = 0 AND '.$strWhereIdOs;
        }
      }
      $strORDER = ' ORDER BY ';
      if (isset($_POST['triChecked']) AND !empty($_POST['triChecked'])) {
        // Tri sélectionné pour site public
        switch($_POST['triChecked']) {
          case 'titre':
            $strORDER .= 'titrePE, anneePE';
            break;
          case 'date':
            $strORDER .= 'anneePE, auteurNom, auteurPrenom, titrePE';
            break;
          case 'auteur':
            $strORDER .= 'auteurNom, auteurPrenom, anneePE, titrePE';
            break;
        }
      } else {
        if (isset($_POST['strTriChamp']) AND !empty($_POST['strTriChamp'])) {
          // Tri sélectionné dans la BDD
          $strORDER .= $OConnexion->real_escape_string($_POST['strTriChamp']).' '.$OConnexion->real_escape_string($_POST['strTriOrdre']).', ';
        }
        $strORDER .= 'anneePE, titrePE';
      }
      // Le GROUP BY est utile quand on fait une recherche avancée
      $req = 'SELECT '.$strSelect.' FROM oeuvres'.$strLeftJoin."\n".'WHERE '.$strWhere.(($iCmd == 29 OR $iCmd == 30) ? (empty($strGroupBy) ? '' : ' GROUP BY '.$strGroupBy) : ' GROUP BY oeuvres.idOeuvre').$strORDER;
      $strDBG .= 'requête = '.$req."\n";
      // if ($iLigneDeb != 1) $req .= ' LIMIT '.$iLigneDeb;
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      // À ne faire que si on n'exporte pas en CSV
      if (!isset($_POST['exportData']) OR ($_POST['exportData'] != 'CSV' AND $_POST['exportData'] != 'JSON')) {
        // Dans la première ligne du tableau on met les informations de pagination (et le titre de la recherche)
        $tab[] = [ 'iLigneDeb' => $iLigneDeb, 'iNbLigneTot' => $SQLResult->num_rows, 'strTitreRecherche' => $strTitreRecherche, 'strRecapRecherche' => $strRecapRecherche, 'strDBG' => 'DBG: '.$strDBG];
        // Dans la seconde ligne du tableau on met les titres des champs (pour l'instant, le nom des champs)
        $tab[] = ($iCmd == 20) ? $aRechSimpleAffichage : $aRechAvanceeAffichage;
      }
      $iCpt = 0;
      if ($iLigneDeb != 1) $SQLResult->data_seek($iLigneDeb - 1);
      while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
        $aRetour = array();
        if (isset($_POST['exportData']) AND ($_POST['exportData'] == 'CSV' OR $_POST['exportData'] == 'JSON')) {
          // Pour tous les exports CSV on retourne tous les champs du SELECT
          $aRetour[] = $row;
        } else {
          $aRetour['aCorrespondances'] = array();
          if ($iCmd == 20 OR $iCmd == 21 OR $iCmd == 29 OR $iCmd == 30 OR $iCmd == 34 OR $iCmd == 35) {
            // Recherche quels ont été les champs qui ont correspondus à la recherche (à mettre dans row[aCorrespondances])
            $aCorrespondances = array();
            foreach ($row as $champ => $valeur) {
              // echo "\n".'valeur = '.$valeur.'; champ = '.$champ;
              // Si la valeur du champ correspond à la recherche on encadre le critère par des <mark>(suppression des caractères accentués pour avoir la même comparaison que MySQL (utf8_general_ci))
              if (($iCmd == 29 OR $iCmd == 34) AND stristr(strSupprimeAccents($valeur), $strLowRechSimple) !== false) {
                $aCorrespondances[] = array('champ' => $champ, 'valeur' => str_ireplace($strLowRechSimple, '<mark>'.$strLowRechSimple.'</mark>', str_replace(array("\r\n", "\r", "\n"), '<br />', strSupprimeAccents($valeur))));
              } else if (($iCmd == 20 OR $iCmd == 21 OR $iCmd == 30 OR $iCmd == 35) AND isset($aCriteres[$champ])) {
                if (!is_array($aCriteres[$champ])) {
                  // TODO: supprimer strSupprimeAccents quand la requête LIKE se fera sur les caractères stricts (é != e)
                  if (stristr(strSupprimeAccents($valeur), strSupprimeAccents($aCriteres[$champ])) !== false)
                    $aCorrespondances[] = array('champ' => $champ, 'valeur' => str_ireplace($aCriteres[$champ], '<mark>'.$aCriteres[$champ].'</mark>', str_replace(array("\r\n", "\r", "\n"), '<br />', $valeur)));
                } else {
                  // if (isset($aCriteres[$champ]['<=']) AND $valeur != null) $aCorrespondances[] = array('champ' => $champ, 'valeur' => '<mark>'.$valeur.'</mark><='.$aCriteres[$champ]['<=']);
                  // if (isset($aCriteres[$champ]['>=']) AND $valeur != null) $aCorrespondances[] = array('champ' => $champ, 'valeur' => '<mark>'.$valeur.'</mark>>='.$aCriteres[$champ]['>=']);
                  if ((isset($aCriteres[$champ]['<=']) OR isset($aCriteres[$champ]['>='])) AND $valeur != null) {
                    // Pour l'instant utilisé que pour les dates...
                    if (isset($aCriteres[$champ]['<=']) AND isset($aCriteres[$champ]['>='])) {
                      // Fourchette de comparaison
                      $aCorrespondances[] = array('champ' => $champ, 'valeur' => $aCriteres[$champ]['>='].' >= <mark>'.$valeur.'</mark> >= '.$aCriteres[$champ]['<=']);
                    } else if (isset($aCriteres[$champ]['<=']) AND $valeur != null) {
                      // Valeur trouvée inférieure au critère
                      $aCorrespondances[] = array('champ' => $champ, 'valeur' => '<mark>'.$valeur.'</mark> <= '.$aCriteres[$champ]['<=']);
                    } else if (isset($aCriteres[$champ]['>=']) AND $valeur != null) {
                      // Valeur trouvée supérieur au critère
                      $aCorrespondances[] = array('champ' => $champ, 'valeur' => $aCriteres[$champ]['>='].' >= <mark>'.$valeur.'</mark>');
                    }
                  }
                  if (isset($aCriteres[$champ][0]['multi'])) {
                    $strValeurChamp = $valeur;
                    // TODO - Cas des ESI: si filtre sur des termes utilisés dans la descrition, marcage dans la description
                    // Cas des TIPS: si filtre sur disciplines et modalités, marcage à l'intérieur du champ (disciplines et modalités)
                    // (refaureel.theorie, \'%,%\', refaureel.personnalite, \'%,%\', refaureel.citation, \'%,%\', refaureel.discipline, \'%,%\', refaureel.modalite) SEPARATOR \'%;%\'
                    if (strstr($champ, 'TIPS') != FALSE AND (array_key_exists('Modalité', $aCriteres) != FALSE OR array_key_exists('Disciplines (des réf. au réel)', $aCriteres) != FALSE OR
                                                             array_key_exists('TIPS|Théorie ou invention', $aCriteres) != FALSE OR array_key_exists('TIPS|Personnalité scientifique', $aCriteres) != FALSE)) {
                      // Comme les codes des modalités et des disciplines sont uniques, utilisation d'expressions régulières pour insérer les <mark>
                      if (empty($aCritModDisc)) {
                        $aCritModDisc = array();
                        if (array_key_exists('Modalité', $aCriteres) != FALSE) {
                          foreach($aCriteres['Modalité'] as $aModalite) {
                            $aCritModDisc[] = $aModalite;
                          }
                        }
                        if (array_key_exists('Disciplines (des réf. au réel)', $aCriteres) != FALSE) {
                          foreach($aCriteres['Disciplines (des réf. au réel)'] as $aDiscipline) {
                            $aCritModDisc[] = $aDiscipline;
                          }
                        }
                      }
                      if (empty($aCritTIPS)) {
                        $aCritTIPS = array();
                        if (array_key_exists('TIPS|Théorie ou invention', $aCriteres) != FALSE) {
                          foreach($aCriteres['TIPS|Théorie ou invention'] as $aTheoInv) {
                            $aCritTIPS[] = $aTheoInv;
                          }
                        }
                        if (array_key_exists('TIPS|Personnalité scientifique', $aCriteres) != FALSE) {
                          foreach($aCriteres['TIPS|Personnalité scientifique'] as $aPersonnal) {
                            $aCritTIPS[] = $aPersonnal;
                          }
                        }
                      }
                      if (!empty($aCritModDisc) OR !empty($aCritTIPS)) {
                        $strValeurChamp = '';
                        foreach($aCritModDisc as $aCritTmp) {
                          if ($strValeurChamp == '') $strValeurChamp = $valeur;
                          // $strValeurChamp = preg_replace('/%,%'.$aCritTmp['cle'].'/i', '%,%<mark>'.$aCritTmp['cle'].'</mark>', $strValeurChamp);
                          $strValeurChamp = preg_replace('/%,%('.$aCritTmp['cle'].')/i', '%,%<mark>\1</mark>', $strValeurChamp);
                        }
                        foreach($aCritTIPS as $aCritTmp) {
                          if ($strValeurChamp == '') $strValeurChamp = $valeur;
                          // Récupération de chaque TIPS
                          $aValeursChamp = explode('%;%', $strValeurChamp);
                          $aValeursChampTmp = array();
                          foreach($aValeursChamp as $strValeurs) {
                            // Récupération des valeurs de chaque champ dans chaque TIPS
                            $aValeurs = explode('%,%', $strValeurs);
                            // Comparaison sur theorie (0), personnalité (1) et citation (2)
                            $aValeurs[0] = preg_replace('/('.$aCritTmp['cle'].')/i', '<mark>\1</mark>', $aValeurs[0]);
                            $aValeurs[1] = preg_replace('/('.$aCritTmp['cle'].')/i', '<mark>\1</mark>', $aValeurs[1]);
                            $aValeurs[2] = preg_replace('/('.$aCritTmp['cle'].')/i', '<mark>\1</mark>', $aValeurs[2]);
                            $aValeursChampTmp[] = implode('%,%', $aValeurs);
                          }
                          // Reconstruction de la chaîne avec les valeur modifiée pour le critère de recherche
                          $strValeurChamp = implode('%;%', $aValeursChampTmp);
                        }
                        // Enregistrement de la correspondance
                        $aCorrespondances[] = array('champ' => $champ, 'valeur' => $strValeurChamp);
                      }
                    } else {
                      $strValeurChamp = '';
                      foreach($aCriteres[$champ] as $aCrt) {
                        // $aCorrespondances[] = array('champ' => $champ, 'valeur' => 'valeur = '.$valeur.'; aCrt[cle] = '.$aCrt['cle'].'; aCrt[val] = '.$aCrt['val']);
                        // echo "\n".'valeur = '.$valeur.'; aCrt[cle] = '.$aCrt['cle'].'; aCrt[val] = '.$aCrt['val'];
                        // if ($aCrt['cle'] == $valeur) $aCorrespondances[] = array('champ' => $champ, 'valeur' => '<mark>'.$aCrt['val'].'</mark>');
                        // if (trim(strSupprimeAccents($aCrt['cle'])) == '' OR stristr(strSupprimeAccents($valeur), strSupprimeAccents($aCrt['cle'])) !== false)
                        //   $aCorrespondances[] = array('champ' => $champ, 'valeur' => str_ireplace($aCrt['cle'], '<mark>'.$aCrt['val'].'</mark>', str_replace(array("\r\n", "\r", "\n"), '<br />', $valeur)));
                        if ($strValeurChamp == '') $strValeurChamp = $valeur;
                        if (trim(strSupprimeAccents($aCrt['cle'])) == '' OR stristr(strSupprimeAccents($valeur), strSupprimeAccents($aCrt['cle'])) !== false)
                          $strValeurChamp = str_ireplace($aCrt['cle'], '<mark>'.$aCrt['val'].'</mark>', str_replace(array("\r\n", "\r", "\n"), '<br />', $strValeurChamp));
                      }
                      $aCorrespondances[] = array('champ' => $champ, 'valeur' => $strValeurChamp);
                    }
                  }
                }
              }
            }
            $aRetour['aCorrespondances'] = $aCorrespondances;
            // On ne retourne que les champs qu'on veut afficher (ceux dans $aRechSimpleAffichage)
            foreach ($aRechSimpleAffichage as $value) {
              // if (empty($value['titre']) OR empty($value['titre'])) continue;
              if (empty($value['titre'])) continue;
              $aRetour[$value['titre']] = $row[$value['titre']];
            }
          }
          if ($iCmd == 20) {
            foreach ($aRechSimpleAffichage as $value) {
              // if (empty($value['titre']) OR empty($value['titre'])) continue;
              if (empty($value['titre'])) continue;
              $aRetour[$value['titre']] = $row[$value['titre']];
            }
          } else if ($iCmd == 21) {
            foreach ($aRechAvanceeAffichage as $value) {
              // if (empty($value['titre']) OR empty($value['titre'])) continue;
               if (empty($value['titre'])) continue;
               $aRetour[$value['titre']] = $row[$value['titre']];
            }
          }
        }
        // $tab[] = $row;
        $tab[] = $aRetour;
        $iCpt++;
        if ($iCpt >= $iMaxLignes) break;
      }
      // DBG
      $tab[0] = [ 'iLigneDeb' => $iLigneDeb, 'iNbLigneTot' => $SQLResult->num_rows, 'strTitreRecherche' => $strTitreRecherche, 'strRecapRecherche' => $strRecapRecherche, 'strDBG' => 'DBG: '.$strDBG];
      // (!isset($_POST['exportData']) OR ($_POST['exportData'] != 'CSV' AND $_POST['exportData'] == 'JSON'))
      if (!isset($_POST['exportData']) OR $_POST['exportData'] != 'CSV') {
        echo json_encode($tab);
      } else if ($_POST['exportData'] == 'CSV') {
        // Pour export en CSV. Nettoyage du $strSelect...
        // remplacement des <br /> par des ' '
        $strSelect = preg_replace('#<br\ */>#', ' ', $strSelect);
        // remplacement des '' par des '
        $strSelect = preg_replace('#\'\'#', '\'', $strSelect);
        // remplacement des ; par des ,
        $strSelect = preg_replace('#;#', ',', $strSelect);

        // Reconstitution des titres - ATTENTION: bien utiliser les AS dans le SELECT pour qu'ils apparaissent dans les titres
        preg_match_all('#.*\ *AS\ *\'(.*)\'[\n\r]*,?#', $strSelect, $aTitres);  
        $strCSV = implode(';', $aTitres[1])."\n";

        // Nettoyage de tab, remplacements:
        // - ';' par ','
        // - retours à la ligne par un espace
        // - remplacement des codes des disciplines et modalité pour les TIPS (Théories, Inventions et Personnalités Scientifiques)
        // pour ESI, pas la peine: le libellé est déjà présent...
        $aADecoder = array();
        // array('TIPS', 'ESI')
        // foreach (array('TIPS') as $strADecoder) {
          // $cle = array_search($strADecoder, $aTitres[1]);
          foreach ($aTitres[1] as $strTitre) {
            if (strstr($strTitre, 'TIPS') != FALSE) {
              $aADecoder[$strTitre] = $strADecoder;
            }
          }
        // }
        foreach ($tab as $ligne) {
          if (!empty($aADecoder)) {
            // Remplacement des codes par leurs valeurs
            foreach ($aADecoder as $cle => $strChamp) {
              // Récupération de la valeur du champ (potentiellement multiple)
              $aTraite  = array();
              $aATraiter = explode('%;%', $ligne[0][$cle]);
              foreach ($aATraiter as $key => $strLigne) {
                $aLigne = explode('%,%', $strLigne);
                // if ($strChamp == 'TIPS') {
                  $aLigne[2] = getValCodeRefAuReelDiscipline($aLigne[2]);
                  $aLigne[3] = getValCodeRefAuReelModalite($aLigne[3]);
                // } else if ($strChamp == 'ESI') {
                // }
                $aTraite[$key] = implode('%,%', $aLigne);
              }
              $ligne[0][$cle] = implode('%%%', $aTraite);
            }
          }

          $aLigneNet = preg_replace(array('/;/', '/[\n\r]/'), array(',', ' '), $ligne[0]);

          $strCSV .= '"'.implode('";"', $aLigneNet).'"'."\n";
        }
        echo $strCSV;
      }
      break;

    case 22 : // Affichage des Fiches en cours de rédaction
    case 23 : // Affichage des Fiches incomplètes
    case 24 : // Affichage des Fiches complètes, à relire
    case 25 : // Affichage des Fiches relues, corrections à effectuer
    case 26 : // Affichage des Fiches prêtes pour la publication
    case 27 : // Liste des Sociétés imaginaires (onglet 5)
    case 28 : // Liste des mots clés (onglet 5)
    case 31 : // Affichage des Fiches sans aucune information sur l'avancement de la saisie
      // Initialisation des variables
      $iMaxLignes = (isset($_POST['maxLignes'])) ? $OConnexion->real_escape_string($_POST['maxLignes']) : '10';
      $iLigneDeb = (isset($_POST['ligneDeb'])) ? $OConnexion->real_escape_string($_POST['ligneDeb']) : '1';

      $bPrems = true;
      $strGROUPBY = $strORDER = $strFROM = $strLEFTJOIN = $strPlus = $strSelect = '';
      if ($iCmd == 27) {
        // aListeSocietesImaginaires définit dans lib/recherche-inc.php
        $aAffichage = $aListeSocietesImaginaires;
      } else if ($iCmd == 28) {
        // aListeMotsCles définit dans lib/recherche-inc.php
        $aAffichage = $aListeMotsCles;
      } else {
        // aRechSimpleAffichage définit dans lib/recherche-inc.php
        $aAffichage = $aRechSimpleAffichage;
      }
      // $strDBG .= '<br />aAffichage: '.print_r($aAffichage, true)."\n";
      foreach ($aAffichage as $key => $value) {
        if (isset($value['table'])) {
          $strSelect .= $strPlus.$value['table'].'.'.$value['champ'].' AS \''.str_replace("'", "''", $value['titre']).'\'';
          if ($bPrems) {
            $bPrems = false;
            $strPlus = ', '."\n";
          }
        } else if (isset($value['tableFrom'])) {
          $strFROM = $value['tableFrom'];
          if (isset($value['groupBy'])) {
            // Il y a un GROUP BY à construire
            $strGROUPBY = 'GROUP BY '.$value['groupBy']."\n";
          }
          if (isset($value['orderBy'])) {
            // Il y a un ORDER BY à construire
            $strORDER = 'ORDER BY '.$value['orderBy']."\n";
          }
          $iCpt = 0;
          while (isset($value['tableLeftJoin'.$iCpt])) {
            // Il y a aussi un LEFT JOIN à construire
            $strLEFTJOIN .= "\n".'LEFT JOIN '.$value['tableLeftJoin'.$iCpt].' ON '.$value['tableLeftJoin'.$iCpt].'.'.$value['tableLeftJoin'.$iCpt.'OnId'].' = '.$strFROM.'.'.$value['tableLeftJoin'.$iCpt.'Id'];
            $iCpt++;
          }
        }
      }
      // Sélection du type de fiche
      switch ($iCmd) {
        case 22: $strTitreRecherche = 'Fiches en cours de rédaction'; $strWhere = 'ficNOkObl = 1'; break;
        case 23: $strTitreRecherche = 'Fiches incomplètes'; $strWhere = 'ficNOkOpt = 1'; break;
        case 24: $strTitreRecherche = 'Fiches complètes, à relire'; $strWhere = 'ficOK = 1'; break;
        case 25: $strTitreRecherche = 'Fiches relues, corrections à effectuer'; $strWhere = 'ficOKRelire = 1'; break;
        case 26: $strTitreRecherche = 'Fiches prêtes pour la publication'; $strWhere = 'ficOKPubli = 1'; break;
        case 27: $strTitreRecherche = 'Liste des sociétés imaginaires'; $strWhere = ''; break;
        case 28: $strTitreRecherche = 'Liste des mots clés scientifiques'; $strWhere = 'oeuvres.motsClesScientifiques != "" AND oeuvres.motsClesScientifiques IS NOT NULL'; break;
        case 31: $strTitreRecherche = 'Fiches sans information sur l\'avancement de la saisie'; $strWhere = 'ficNOkObl = 0 AND ficNOkOpt = 0 AND ficOK = 0 AND ficOKRelire = 0 AND ficOKPubli = 0'; break;
      }
      if (isset($_POST['strTriChamp']) AND !empty($_POST['strTriChamp'])) {
        // Ce tri écrase celui trouvé éventuellement dans aAffichage
        $strORDER = ' ORDER BY '.$OConnexion->real_escape_string($_POST['strTriChamp']).' '.$OConnexion->real_escape_string($_POST['strTriOrdre']);
      }
      $req = 'SELECT '.$strSelect.' FROM '.$strFROM.' '.(trim($strLEFTJOIN) != '' ? $strLEFTJOIN : '').' WHERE '.(trim($strWhere) != '' ? $strWhere.' AND ' : '').' oeuvres.deleted = 0 '.(trim($strGROUPBY) != '' ? $strGROUPBY : '').(trim($strORDER) != '' ? $strORDER : '');
      $strDBG .= '<br />requête: '.$req."\n";
      if (($SQLResult = $OConnexion->query($req)) === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$OConnexion->error."\r\n\n$req</pre>");
      if (!isset($_POST['exportData']) OR ($_POST['exportData'] != 'CSV' AND $_POST['exportData'] != 'JSON')) {
        // Dans la première ligne du tableau on met les informations de pagination (et le titre de la recherche)
        $tab[0] = [ 'iLigneDeb' => $iLigneDeb, 'iNbLigneTot' => $SQLResult->num_rows, 'strTitreRecherche' => $strTitreRecherche, 'strDBG' => 'DBG: '.$strDBG];
      }
      // Dans la seconde ligne du tableau on met les titres des champs (pour l'instant, le nom des champs)
      // ... mais nettoyage de la table aAffichage de valeurs inutiles pour l'affichage en JS
      unset($aAffichage['Plus']);
      $tab[1] = $aAffichage;
      $iCpt = 0;
      // Positionnement à l'index correspondant à la navigation
      if ($iLigneDeb != 1) $SQLResult->data_seek($iLigneDeb - 1);
      if ($iCmd == 27) {
        // liste des tableaux "Société imaginaire" des fiches (onglet 5)
        while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
          // à voir pour récupérer (de manière efficace) les valeurs de la requête en fonction de aAffichage
          $tab[] = [
            'Id' => $row['Id'],
            'titrePE' => $row['Titre de l\'oeuvre'],
            'nom' => $row['Nom de la société'],
            'degreTechno' => getValCodeSociDegreTechno($row['Degré de technologie']),
            'statutScient' => getValCodeSociStatutScient($row['Statut du scientifique']),
            'hierarchie' => getValCodeSociHierarchie($row['Hiérarchie']),
            'valeur' => getValCodeSociValeur($row['Valeur'])
          ];
          $iCpt++;
          if ($iCpt >= $iMaxLignes) break;
        }
      } else {
        while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
          $tab[] = $row;
          $iCpt++;
          if ($iCpt >= $iMaxLignes) break;
        }
      }
      if (!isset($_POST['exportData']) OR ($_POST['exportData'] != 'CSV' AND $_POST['exportData'] != 'JSON')) {
        // echo json_encode($tab, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        echo json_encode($tab);
      } else if ($_POST['exportData'] == 'JSON') {
      // !isset($_POST['exportData']) OR ($_POST['exportData'] != 'CSV' AND $_POST['exportData'] == 'JSON')
        // echo json_encode($tab);
        // echo json_encode($tab, JSON_FORCE_OBJECT);
        // Recréation de tab pour supprimer les indices [Disciplines|année]
        $aTmp = $tab;
        $tab  = array();
        foreach ($aTmp as $value) {
          $tab[] = ['group' => $value['group'], 'x' => $value['x'], 'y' => $value['y']];
        }
        echo json_encode(array($aListeDiscThemTrie, $tab), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      } else if ($_POST['exportData'] == 'CSV') {
        // Pour export en CSV:
        $strCSV = '';
        foreach ($tab as $ligne) {
          if ($strCSV == '') {
            // Le premier élément du tableau contient les titres
            $strPlus = '';
            foreach ($ligne as $aTitre) {
              $strCSV .= $strPlus.$aTitre['titre'];
              $strPlus = ';';
            }
            $strCSV .= "\n";
          } else {
            $strCSV .= implode(';', $ligne)."\n";
          }
        }
        echo $strCSV;
      }
      break;

    case 32 : // Statistiques / Présence des disciplines dans les oeuvres
    case 33 : // Statistiques / Personnalités scientifiques réelles
      echo getStat();
      break;

    default:
      $strRetour .= '<br />Erreur '."\n";
      break;
  }

  // strRendu($strRetour);

} catch (Exception $OException) {
  echo 'Exception reçue : '.$OException->getMessage()."\n";
}

?>
