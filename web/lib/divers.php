<?php
/***********************************************************************************
 *
 *  divers.php : contient des fonctions diverses... et variées
 *
 ***********************************************************************************/

define('VersionJS', '0.12'); // Permet de forcer le chargement des fichiers JS
define('VersionCSS', '0.6'); // Permet de forcer le chargement des fichiers CSS

function aGetIdOeuvres($_OConnexion) {
  $aIds = array();
  $strDBG = '';

  // Récupération des id de toutes les oeuvres (sauf deleted!=0)
  if ($OResult = $_OConnexion->query('SELECT idOeuvre FROM oeuvres WHERE deleted=0')) {
    while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
      foreach ($ligne as $id) {
        $aIds[$id] = $id;
      }
    }
  }
  return $aIds;

}

function aGetListeOeuvres($_OConnexion, $_iType) {
  $aListeOeuvres = array();
  $strDBG = '';

  // Récupération des id de toutes les oeuvres (sauf deleted!=0)
  // $strRPGetListeOeuvres = 'SELECT idOeuvre, titrePE, auteurNom, auteurPrenom, anneePE, urlIllustration FROM oeuvres WHERE titrePE LIKE ? AND deleted=0 ORDER BY datCreaFiche DESC';
  if ($_iType == 1) {
    $strRPGetListeOeuvres = 'SELECT idOeuvre, titrePE, auteurNom, auteurPrenom, anneePE, urlIllustration FROM oeuvres WHERE deleted=0 ORDER BY titrePE';
  } else if ($_iType == 2) {
    $strRPGetListeOeuvres = 'SELECT idOeuvre, titrePE, auteurNom, auteurPrenom, anneePE, urlIllustration FROM oeuvres WHERE deleted=0 ORDER BY auteurNom, auteurPrenom, anneePE, titrePE';
  } else if ($_iType == 3) {
    $strRPGetListeOeuvres = 'SELECT idOeuvre, titrePE, auteurNom, auteurPrenom, anneePE, urlIllustration FROM oeuvres WHERE deleted=0 ORDER BY anneePE, titrePE';
  }
  $ORPGetListeOeuvres = $_OConnexion->prepare($strRPGetListeOeuvres);
  if ($ORPGetListeOeuvres != FALSE) {
    // $ORPGetListeOeuvres->bind_param('s', $_strType);
    if ($ORPGetListeOeuvres->execute() === TRUE) {
      $OResult = $ORPGetListeOeuvres->get_result();
      $iCpt = 0;
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        foreach ($ligne as $strNomChamp => $strValeurChamp) {
          // $aListeOeuvres[$ligne['idOeuvre']][$strNomChamp] = $strValeurChamp;
          $aListeOeuvres[$iCpt][$strNomChamp] = $strValeurChamp;
        }
        $iCpt++;
      }
    }
  }
  return $aListeOeuvres;

}

function aGetListeAlpha($_OConnexion, $_iType) {
  $aListeAlpha = array();
  $strDBG = '';
  $aAlphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

  // Récupération d'un alphabet indiquant pour chaque lettre si une œuvre possède un titre qui commence par cette lettre
  if ($_iType == 1) {
    $strRPGetListeAlpha = 'SELECT idOeuvre FROM oeuvres WHERE titrePE LIKE ? LIMIT 1';
  } else if ($_iType == 2) {
    $strRPGetListeAlpha = 'SELECT idOeuvre FROM oeuvres WHERE auteurNom LIKE ? LIMIT 1';
  }
  $ORPGetListeAlpha = $_OConnexion->prepare($strRPGetListeAlpha);
  if ($ORPGetListeAlpha != FALSE) {
    foreach ($aAlphabet as $strLettre) {
      $strFiltre = $strLettre.'%';
      $ORPGetListeAlpha->bind_param('s', $strFiltre);
      if ($ORPGetListeAlpha->execute() === TRUE) {
        $OResult = $ORPGetListeAlpha->get_result();
        $aListeAlpha[$strLettre] = $OResult->num_rows;
      }
    }
  }
  return $aListeAlpha;

}

function aGetListeAnnePE($_OConnexion) {
  $aListeAnneePE = array();
  $strDBG = '';

  // Initialisation du tableau des dates de 1860 à 1941
  for ($iAnnee = 1860; $iAnnee <= 1939; $iAnnee++) $aListeAnneePE[$iAnnee] = 'faux';

  // Récupération de la liste des années de première édition indiquant pour chaque année si une œuvre a eu sa première édition
  $strRPGetListeAnneePE = 'SELECT anneePE FROM oeuvres WHERE deleted=0 GROUP BY anneePE ORDER BY anneePE ASC';
  $ORPGetListeAnneePE = $_OConnexion->prepare($strRPGetListeAnneePE);
  if ($ORPGetListeAnneePE != FALSE) {
    if ($ORPGetListeAnneePE->execute() === TRUE) {
      $OResult = $ORPGetListeAnneePE->get_result();
      while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
        $aListeAnneePE[$ligne['anneePE']] = 'vrai';
      }
    }
  }
  ksort($aListeAnneePE);
  return $aListeAnneePE;

}

function getValCodePtxtAuteurType($_strCode){
  switch ($_strCode){
    case 'T' : return 'Autographe'; break;
    case 'L' : return 'Allographe'; break;
    default  : return '???'; break;
  }
}

function getValCodeValorisationPers($_strCode){
  switch ($_strCode){
    case 'P' : return 'Positif'; break;
    case 'N' : return 'Négatif'; break;
    case 'M' : return 'Problématique'; break;
    case 'T' : return 'Neutre'; break;
    default  : return '???'; break;
  }
}

function getValCodeAlterite($_strCode){
  switch ($_strCode){
    case 'EU' : return 'Européenne'; break;
    case 'EE' : return 'Extra-européenne'; break;
    case 'ET' : return 'Extra-terrestre'; break;
    case 'CA' : return 'Créature artificielle'; break;
    case 'MU' : return 'Mutante'; break;
    case 'ZZ' : return 'Autre'; break;
    default   : return ''; break;
  }
}

function getValCodeGenrePers($_strCode){
  switch ($_strCode){
    case 'M' : return 'Masculin'; break;
    case 'F' : return 'Féminin'; break;
    case 'I' : return 'Indéterminé'; break;
    default  : return '???'; break;
  }
}

function getValCodeRangPers($_strCode){
  switch ($_strCode){
    case 'P' : return 'Principal'; break;
    case 'S' : return 'Secondaire'; break;
    case 'C' : return 'Collectif'; break;
    case 'F' : return 'Scientifique'; break;
    default  : return '???'; break;
  }
}

function getValCodeTypeDateCSP($_strCode){
  switch ($_strCode){
    case 'I' : return 'Implicite'; break;
    case 'E' : return 'Explicite'; break;
    case 'N' : return 'Indéterminée'; break;
    default  : return '???'; break;
  }
}

function getValCodeEcartCSP($_strCode){
  switch ($_strCode){
    case 'PL' : return 'Passé lointain (+ de 50 ans)'; break;
    case 'PP' : return 'Passé proche (- de 50 ans)'; break;
    case 'PR' : return 'Présent'; break;
    case 'FP' : return 'Futur proche (- de 50 ans)'; break;
    case 'FL' : return 'Futur lointain (+ de 50 ans)'; break;
    default  : return '???'; break;
  }
  return false;
}

function getValCodeNatureTxt($_strCode){
  switch ($_strCode){
    default  :
    case '0' : return 'Inconnu'; break;
    case '1' : return 'Roman'; break;
    case '2' : return 'Récit court'; break;
    case '3' : return 'BD'; break;
  }
}


  // 0 00 Discipline

  // 1  1 Agronomie
  //    1   Agriculture (ex : acclimatation d’espèces nouvelles)
  //    1   Arts vétérinaires (épizooties, maladies)
  //    1   Diététique (alimentation)
  // 1  2 Anthropologie
  // 1  3 Archéologie
  // 1  4 Armement : applications aux arts militaires (explosifs, canons, machines…)
  // 1  5 Art des constructions (génie civil), grands travaux (canaux, isthmes)
  // 1  6 Astronomie / Astrophysique
  // 1  7 Chimie
  //    7   Chimie analytique, classifications des éléments
  //    7   Chimie industrielle, procédés de fabrication (alliages, produits de synthèse)
  //    7   Chimie organique
  // 1  8 Énergie
  //    8   Atomique
  //    8   Électricité
  //    8   Éolienne
  //    8   Éther / solaire
  //    8   Géothermique
  //    8   Hydraulique
  //    8   Magnétisme
  //    8   Thermodynamique
  // 1  9 Inventions / innovations techniques
  //    9   Éclairage
  //    9   Machines à vapeur, moteurs électriques
  //    9   Photographie (galvanoplastie), cinématographe, phonographe
  //    9   Télégraphe, téléphone, radio
  // 1 10 Mathématiques
  // 1 11 Médecine
  //   11   Anatomie
  //   11   Chirurgie
  //   11   Histologie
  //   11   Homéopathie
  //   11   Hygiène publique
  //   11   Pathologies : épidémies, infections…
  //   11   Physiologie
  //   11   Psychologie / psychiatrie (magnétisme, hypnose)
  //   11   Thérapeutiques : électrothérapies, inoculations, vaccinations
  // 1 12 Paléontologie, préhistoire
  // 1 13 Physique
  //   13   Acoustique
  //   13   Électricité, magnétisme
  //   13   Mécanique, hydraulique
  //   13   Optique
  //   13   Physique atomique, rayonnements
  //   13   Thermodynamique (chaleur)
  // 1 14 Sciences biologiques
  //   14   Bactériologie
  //   14   Génétique / héréditarisme
  //   14   Microbiologie / biochimie
  // 1 15 Sciences naturelles
  //   15   Botanique
  //   15   Entomologie
  //   15   Mycologie
  //   15   Zoologie
  // 1 16 Sciences de la terre
  //   16   Catastrophes naturelles
  //   16   Ethnologie
  //   16   Géographie, géodésie (voyages scientifiques d’exploration, expéditions)
  //   16   Géologie / Minéralogie
  //   16   Météorologie (ex : inondations)
  //   16   Océanographie
  // 1 17 Sociabilités scientifiques
  //   17   Monde savant, communauté scientifique (académies, sociétés savantes, université)
  //   17   Spectacles scientifiques (expositions universelles, conférences et démonstrations publiques)
  // 1 17 Transports
  //   18   Aérostats, appareils aériens
  //   18   Transport maritime (bateaux à vapeur, sous-marins…)
  //   18   Transport souterrain (métro…)
  //   18   Transport terrestre (automobiles, chemin de fer…)

function getValSrcImgDiscipline($_idGroupe){
  switch ($_idGroupe){
    case  1 : return 'agronomie.svg';                  break; // Agronomie
    case  2 : return 'anthropologie.svg';              break; // Anthropologie
    case  3 : return 'archeologie.svg';                break; // Archéologie
    case  4 : return 'sword.svg';                      break; // Armement : applications aux arts militaires (explosifs, canons, machines…)
    case  5 : return 'art_des_constructions.svg';      break; // Art des constructions (génie civil), grands travaux (canaux, isthmes)
    case  6 : return 'space.svg';                      break; // Astronomie / Astrophysique
    case  7 : return 'chimie.svg';                     break; // Chimie
    case  8 : return 'power.svg';                      break; // Énergie
    case  9 : return 'invention.svg';                  break; // Inventions / innovations techniques
    case 10 : return 'mathematiques.svg';              break; // Mathématiques
    case 11 : return 'heartbeat.svg';                  break; // Médecine
    case 12 : return 'prehistoire.svg';                break; // Paléontologie, préhistoire
    case 13 : return 'atom.svg';                       break; // Physique
    case 14 : return 'dna.svg';                        break; // Sciences biologiques
    case 15 : return 'sciences_naturelles.svg';        break; // Sciences naturelles
    case 16 : return 'sciences_de_la_terre.svg';       break; // Sciences de la terre
    case 17 : return 'sociabilites_scientifiques.svg'; break; // Sociabilités scientifiques
    case 18 : return 'transport.svg';                  break; // Transports
    default : return 'atom.svg';                       break;
  }
  return false;
}

function getValSrcImgEltSciReel($_strCode){
  switch ($_strCode){
    case 'VIE' : return 'dna.svg';       break; // Sciences de la vie (inclut biologie, botanique, zoologie) 
    case 'MED' : return 'heartbeat.svg'; break; // Sciences médicales
    case 'TER' : return 'space.svg';     break; // Sciences  de la terre et de l’espace  (astronomie, géologie, géographie)
    case 'PCM' : return 'atom.svg';      break; // Physique, chimie et mathématiques
    case 'ING' : return 'gears.svg';     break; // Ingénierie et technique
    case 'AUT' : return 'autre.svg';     break; // Autre';
    default    : return 'autre.svg';     break;
  }
  return false;
}

function getValSrcImgAdaptation($_strCode){
  switch ($_strCode){
    case 'BD':          return 'bd.svg';            break;
    case 'Danse':       return 'dancer.svg';        break;
    case 'Film':        return 'film.svg';          break;
    case 'Livre audio': return 'livreaudio.svg';    break;
    case 'Musique':     return 'musique.svg';       break;
    case 'Radio':       return 'radio.svg';         break;
    case 'Théâtre':     return 'theatre-masks.svg'; break;
    default:            return 'theatre-masks.svg'; break;
  }
  return false;
}

function getValSrcImgEltSciImag($_idCode){
  switch ($_idCode){
    case 258: return 'sword.svg';         break; // Armes
    case 259: return 'communication.svg'; break; // Communications, image/son
    case 250: return 'heartbeat.svg';     break; // Corps humain, pouvoirs psychiques, vie/mort
    case 254: return 'space.svg';         break; // Espace
    case 251: return 'alien.svg';         break; // Formes de vie inconnue
    case 252: return 'black-hole.svg';    break; // Modifications de la nature
    case 256: return 'power.svg';         break; // Sources d'énergie
    case 253: return 'clock.svg';         break; // Temps
    case 260: return 'gears.svg';         break; // Théories scientifiques
    case 257: return 'atom.svg';          break; // Transports
    case 255: return 'daily.svg';         break; // Vie quotidienne
    case 268: return 'autre.svg';         break; // Autre
    default : return 'autre.svg';         break;
  }
}

function getValCodeRefAuReelModalite($_strCode){
  switch ($_strCode){
    case 'SER' : return 'Sérieux'; break;
    case 'SAT' : return 'Satire'; break;
    case 'HOM' : return 'Hommage'; break;
    case 'REF' : return 'Réfutation'; break;
    default    : return '???'; break;
  }
  return false;
}

function getValCodeRefAuReelDiscipline($_strCode){
  switch ($_strCode){
    case 'VIE' : return 'Sciences de la vie (inclut biologie, botanique, zoologie) '; break;
    case 'MED' : return 'Sciences médicales'; break;
    case 'TER' : return 'Sciences  de la terre et de l’espace  (astronomie, géologie, géographie)'; break;
    case 'PCM' : return 'Physique, chimie et mathématiques'; break;
    case 'ING' : return 'Ingénierie et technique'; break;
    case 'AUT' : return 'Autre'; break;
    default    : return '???'; break;
  }
}

function getValCodeSociDegreTechno($_strCode){
  switch ($_strCode){
    case 'F' : return 'Fort'; break;
    case 'N' : return 'Neutre'; break;
    case 'B' : return 'Faible'; break;
    case 'I' : return 'Indéterminé'; break;
    default  : return '???'; break;
  }
}

function getValCodeSociStatutScient($code){
  switch ($code){
    case 'C' : return 'Central'; break;
    case 'M' : return 'Marginal'; break;
    case 'V' : return 'Valorisé'; break;
    case 'Q' : return 'Critiqué'; break;
    case 'I' : return 'Indéterminé'; break;
    // default  : return '???'; break;
    default  : return $code; break;
  }
}

function getValCodeSociHierarchie($code){
  switch ($code){
    case 'S' : return 'Science domine'; break;
    case 'E' : return 'Égalité de traitement'; break;
    case 'C' : return 'Conflit'; break;
    case 'H' : return 'Humanités dominent'; break;
    case 'I' : return 'Inconnue'; break;
    default  : return '???'; break;
  }
}

function getValCodeSociValeur($_strCode){
  switch ($_strCode){
    case 'P' : return 'Positive'; break;
    case 'N' : return 'Négative'; break;
    case 'T' : return 'Neutre'; break;
    case 'A' : return 'Ambivalente'; break;
    case 'I' : return 'Indéterminée'; break;
    default  : return '???'; break;
  }
}

// Retourne une chaine de caractères sans les accents
function strSupprimeAccents($str, $encoding = 'utf-8') {
  mb_regex_encoding($encoding); 
  // Tableau des corespondance
  $str_ascii = array(
    'A'  => 'ÀÁÂÃÄÅ',
    'a'  => 'àáâãäå',
    'C'  => 'Ç',
    'c'  => 'ç',
    'D'  => 'Ð',
    'E'  => 'ÈÉÊË',
    'e'  => 'èéêë',
    'I'  => 'ÌÍÎÏ',
    'N'  => 'Ñ',
    'n'  => 'ñ',
    'O'  => 'ÒÓÔÕÖØ',
    'o'  => 'òóôõöø',
    'S'  => 'Š',
    's'  => 'š',
    'U'  => 'ÙÚÛÜ',
    'u'  => 'ùúûü',
    'Y'  => 'ÝŸ',
    'y'  => 'ýÿ',
    'Z'  => 'Ž',
    'z'  => 'ž',
    'et' => '&',
    // Ligatures
    'AE' => 'Æ',
    'ae' => 'æ',
    'OE' => 'Œ',
    'oe' => 'œ',
 
  );
 
  foreach ($str_ascii as $k => $v) {
    $result = mb_ereg_replace('['.$v.']', $k, $str);
    if ($result != FALSE) {
      $str = $result;
    }
  }
 
  return $str;
}

function getListeNatureText($_OConnexion) {
  // Renvoie la liste des natures de texte (idRef IN (1, 2, 3))
  $req = "SELECT idRef, libelle FROM tableref WHERE idRef IN (1, 2, 3)";
  if (($SQLResult = $_OConnexion->query($req)) === false)
    throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$_OConnexion->error."\r\n\n$req</pre>");
  while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
    $tab[] = $row;
  }
  return $tab;
}

function getListeRepresentation($_OConnexion, $idOeuvre, $section){
  if ($idOeuvre != null) {
    // Renvoie la liste des mots de la section Représentation d'une oeuvre, sous-section $section
    if (!isEntierPos($idOeuvre))
      throw new Exception("idOeuvre incorrect [$idOeuvre]");
    if (!isEntierPos($section))
      throw new Exception("section incorrect [$section]");
    $req  = "SELECT idMot, libelle FROM representations R, tableref T ";
    $req .= "WHERE (R.idMot=T.idRef) AND (R.idOeuvre=$idOeuvre) AND (R.section=$section) ORDER BY groupe, top DESC, libelle";
  } else {
    $req  = "SELECT idMot, libelle FROM representations R, tableref T ";
    $req .= "WHERE (R.idMot=T.idRef) AND (R.section=$section) ORDER BY groupe, top DESC, libelle";
  }
  if (($SQLResult = $_OConnexion->query($req)) === false)
    throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$_OConnexion->error."\r\n\n$req</pre>");
  $tabResTmp=array();
  while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
    $tabResTmp[] = $row;
  }
  $tabRes = array();
  foreach ($tabResTmp as $mot)
    $tabRes[$mot['idMot']] = $mot['libelle'];
  return $tabRes;
}

function getListeEsthetique($_OConnexion, $idOeuvre){
  if ($idOeuvre != null) {
    // Renvoie la liste des mots de la section Esthétique d'une oeuvre
    if (!isEntierPos($idOeuvre))
      throw new Exception("idOeuvre incorrect [$idOeuvre]");
    $req = "SELECT idMot, libelle FROM esthetique E, tableref T WHERE (E.idMot=T.idRef) AND (E.idOeuvre=$idOeuvre) ORDER BY Libelle";
  } else {
    $req = "SELECT idMot, libelle FROM esthetique E, tableref T WHERE (E.idMot=T.idRef) GROUP BY Libelle ORDER BY Libelle";
  }
  if (($SQLResult = $_OConnexion->query($req)) === false)
    throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$_OConnexion->error."\r\n\n$req</pre>");
  $tabResTmp=array();
  while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
    $tabResTmp[] = $row;
  }
  $tabRes = array();
  foreach ($tabResTmp as $mot)
    $tabRes[$mot['idMot']] = $mot['libelle'];
  return $tabRes;
}

function getListeAdaptations($_OConnexion, $idOeuvre){
  if ($idOeuvre != null) {
    // Renvoie le tableau Adaptations d'une oeuvre
    if (!isEntierPos($idOeuvre))
      throw new Exception("idOeuvre incorrect [$idOeuvre]");
    $req = "SELECT * FROM adaptations WHERE idOeuvre=$idOeuvre ORDER BY dDate";
  } else {
    // Renvoie la liste de toutes les natures d'adaptation
    $req = "SELECT nature FROM adaptations GROUP BY nature ORDER BY nature";
  }
  if (($SQLResult = $_OConnexion->query($req)) === false)
    throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$_OConnexion->error."\r\n\n$req</pre>");
  $tab=array();
  while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
    $tab[] = $row;
  }
  return $tab;
}

function getListePoetique($_OConnexion, $idOeuvre, $section){
  if ($idOeuvre != null) {
    // Renvoie la liste des mots de la section Poetique d'une oeuvre, sous-section $section
    if (!isEntierPos($idOeuvre))
      throw new Exception("idOeuvre incorrect [$idOeuvre]");
    if (!isEntierPos($section))
      throw new Exception("section incorrect [$section]");
    $req  = "SELECT idMot, libelle FROM poetiquekw P, tableref T ";
    $req .= "WHERE (P.idMot=T.idRef) AND (P.idOeuvre=$idOeuvre) AND (P.section=$section) ORDER BY groupe, top DESC, libelle";
  } else {
    $req  = "SELECT idMot, libelle FROM poetiquekw P, tableref T ";
    $req .= "WHERE (P.idMot=T.idRef) AND (P.section=$section) ORDER BY groupe, top DESC, libelle";
  }
  if (($SQLResult = $_OConnexion->query($req)) === false)
    throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$_OConnexion->error."\r\n\n$req</pre>");
  $tabResTmp=array();
  while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
    $tabResTmp[] = $row;
  }
  $tabRes = array();
  foreach ($tabResTmp as $mot)
    $tabRes[$mot['idMot']] = $mot['libelle'];
  return $tabRes;
}

function getListeRef($_OConnexion, $section){
  // Renvoie la liste des valeurs de référence d'une section
  $req = "SELECT * FROM tableref WHERE section='".$_OConnexion->real_escape_string($section)."' ORDER BY groupe, top DESC, libelle";
  if (($SQLResult = $_OConnexion->query($req)) === false)
    throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__FUNCTION__."\r\n".$_OConnexion->error."\r\n\n$req</pre>");
  $tab=array();
  while ($row = $SQLResult->fetch_array(MYSQLI_ASSOC)) {
    $tab[] = $row;
  }
  return $tab;
}

?>
