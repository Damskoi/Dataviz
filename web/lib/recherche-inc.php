<?php

// --------------------------------------------------------------------------------------------------- //
// recherche-inc.php                                                                                   //
//                                                                                                     //
// définitions de variables pour la recherche dans la base                                             //
//                                                                                                     //
// --------------------------------------------------------------------------------------------------- //

// Recherche simple: champs à filtrer
$aRechSimpleFiltrage = [
  [ 'table' => 'oeuvres', 'champ' => 'idOeuvre', 'titre' => 'Id', 'quote' => '' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteurNom', 'titre' => 'Nom', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteurPrenom', 'titre' => 'Prénom', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'titrePE', 'titre' => 'Titre de l\'oeuvre', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'anneePE', 'titre' => 'Année de 1ère éd.', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'wrkEdit', 'titre' => 'Édition utilisée', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'txtIntegral', 'titre' => 'URL texte intégral', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'urlIllustration', 'titre' => 'URL de la couverture', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'resume', 'titre' => 'Résumé', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'discoursAuctorialCom', 'titre' => 'Discours auctoriale', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'dispositifEditorialCom', 'titre' => 'Dispositif éditoriale', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'receptionCritiqueCom', 'titre' => 'Réception critique', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'lienAutresAuteursCom', 'titre' => 'Liens avec d\'autres auteurs', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'traductionsCom', 'titre' => 'Traduction', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'adaptationsCom', 'titre' => 'Adaptation', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'biblioCritiqueCom', 'titre' => 'Biblio critique', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'narrationCom', 'titre' => 'Narration', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'refIntertextuellesCom', 'titre' => 'Référence intertextuelle', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'refAuReelCom', 'titre' => 'Référence au réel', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'eltImaginairesCom', 'titre' => 'Élément imaginaire', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'motsClesScientifiques', 'titre' => 'Mots clés scientifiques', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'comLibre', 'titre' => 'Com libre', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteurFiche', 'titre' => 'Auteur de la fiche', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'referentANR', 'titre' => 'Référent ANR', 'quote' => '1' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteursSecondaires', 'titre' => 'Auteurs secondaires', 'quote' => '1' ],
];

// Recherche simple: champs à afficher
$aRechSimpleAffichage = [
  // 'Plus' => [ 'tableFrom' => 'oeuvres', 'orderBy' => 'titrePE' ],
  'Plus' => [ 'tableFrom' => 'oeuvres', 'orderBy' => 'anneePE' ],
  // !!! Attention à ne pas mettre des " dans les titres !!!
	// Le premier champ doit être Id pour les traitements dans divers.js>getTableau(). Si changement, adapter le javascript
  '0' => [ 'table' => 'oeuvres', 'champ' => 'idOeuvre', 'titre' => 'Id' ],
  '1' => [ 'table' => 'oeuvres', 'champ' => 'auteurNom', 'titre' => 'Nom' ],
  '2' => [ 'table' => 'oeuvres', 'champ' => 'auteurPrenom', 'titre' => 'Prénom' ],
  '3' => [ 'table' => 'oeuvres', 'champ' => 'titrePE', 'titre' => 'Titre de l\'oeuvre' ],
  '4' => [ 'table' => 'oeuvres', 'champ' => 'anneePE', 'titre' => 'Année de 1ère éd.' ],
  '5' => [ 'table' => 'oeuvres', 'champ' => 'auteurFiche', 'titre' => 'Auteur de la fiche' ],
];

// Recherche avancée: champs à filtrer
$aRechAvanceeFiltrage = [
  [ 'table' => 'oeuvres', 'champ' => 'idOeuvre', 'titre' => 'Id' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteurNom', 'titre' => 'Nom' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteurPrenom', 'titre' => 'Prénom' ],
  [ 'table' => 'oeuvres', 'champ' => 'titrePE', 'titre' => 'Titre de l\'oeuvre' ],
  [ 'table' => 'oeuvres', 'champ' => 'wrkEdit', 'titre' => 'Édition utilisée' ],
  [ 'table' => 'oeuvres', 'champ' => 'txtIntegral', 'titre' => 'URL texte intégral' ],
  [ 'table' => 'oeuvres', 'champ' => 'resume', 'titre' => 'Résumé' ],
  [ 'table' => 'oeuvres', 'champ' => 'discoursAuctorialCom', 'titre' => 'Discours auctoriale' ],
  [ 'table' => 'oeuvres', 'champ' => 'dispositifEditorialCom', 'titre' => 'Dispositif éditoriale' ],
  [ 'table' => 'oeuvres', 'champ' => 'receptionCritiqueCom', 'titre' => 'Réception critique' ],
  [ 'table' => 'oeuvres', 'champ' => 'lienAutresAuteursCom', 'titre' => 'Liens avec d\'autres auteurs' ],
  [ 'table' => 'oeuvres', 'champ' => 'traductionsCom', 'titre' => 'Traduction' ],
  [ 'table' => 'oeuvres', 'champ' => 'adaptationsCom', 'titre' => 'Adaptation' ],
  [ 'table' => 'oeuvres', 'champ' => 'biblioCritiqueCom', 'titre' => 'Biblio critique' ],
  [ 'table' => 'oeuvres', 'champ' => 'narrationCom', 'titre' => 'Narration' ],
  [ 'table' => 'oeuvres', 'champ' => 'refIntertextuellesCom', 'titre' => 'Référence intertextuelle' ],
  [ 'table' => 'oeuvres', 'champ' => 'refAuReelCom', 'titre' => 'Référence au réel' ],
  [ 'table' => 'oeuvres', 'champ' => 'eltImaginairesCom', 'titre' => 'Élément imaginaire' ],
  [ 'table' => 'oeuvres', 'champ' => 'motsClesScientifiques', 'titre' => 'Mots clés scientifiques' ],
  [ 'table' => 'oeuvres', 'champ' => 'comLibre', 'titre' => 'Com libre' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteurFiche', 'titre' => 'Auteur de la fiche' ],
  [ 'table' => 'oeuvres', 'champ' => 'referentANR', 'titre' => 'Référent ANR' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteursSecondaires', 'titre' => 'Auteurs secondaires' ],
  [ 'table' => 'oeuvres', 'champ' => 'anneePE', 'titre' => 'Année de première édition' ],
  [ 'table' => 'oeuvres', 'champ' => 'urlIllustration', 'titre' => 'URL de la première couverture' ],
];

// Recherche avancée: champs à afficher
$aRechAvanceeAffichage = [
  // !!! Attention à ne pas mettre des " dans les titres !!!
  [ 'table' => 'oeuvres', 'champ' => 'idOeuvre', 'titre' => 'Id' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteurNom', 'titre' => 'Nom' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteurPrenom', 'titre' => 'Prénom' ],
  // [ 'table' => 'oeuvres', 'champ' => 'titrePE', 'titre' => 'Titre de l\'oeuvre' ],
  [ 'table' => 'oeuvres', 'champ' => 'titrePE', 'titre' => 'titrePE' ],
  // [ 'table' => 'oeuvres', 'champ' => 'anneePE', 'titre' => 'Année de 1ère éd.' ],
  [ 'table' => 'oeuvres', 'champ' => 'anneePE', 'titre' => 'anneePE' ],
  [ 'table' => 'oeuvres', 'champ' => 'auteurFiche', 'titre' => 'Auteur de la fiche' ],
  // [ 'table' => 'oeuvres', 'champ' => 'urlIllustration', 'titre' => 'URL de la première couverture' ],
  [ 'table' => 'oeuvres', 'champ' => 'urlIllustration', 'titre' => 'urlIllustration' ],
];

?>
