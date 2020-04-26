<!DOCTYPE html>
<?php
  include_once 'lib/anticipation-inc.php';
  include_once 'lib/divers.php';
  include_once 'lib/connexion.php';

  // Quelques initialisations
  $OConnexion = new Connexion();
  $IDOeuvre = null;
  $bRechercheAvancee = $bRechercheSimple = $bIndexOeuvres = FALSE;
  $strRecherche = $strWhereSupl = $strJScriptPlus = '';

  // Récupération de la liste des natures de texte (tableref where idRef in [1, 2, 3])
  $aListeNatureTexte = getListeNatureText($OConnexion);
  // Récupération de la liste des traits spécifiques à la société imaginaire (getListeRepresentation dans lib/lib.php)
  $aListeTraitsSpec = getListeRepresentation($OConnexion, null, 534);
  // Récupération de la liste des caractéristiques esthétiques
  $aListeEstethique = getListeEsthetique($OConnexion, null);
  // Récupération de la liste des natures d'adaptation
  $aListeNatureAdapt = getListeAdaptations($OConnexion, null);
  // Récupération de la liste des rapports au temps
  $aListeRapportTemps = getListePoetique($OConnexion, null, 43);
  // Récupération de la liste des catégories et collections spécialisées
  $aListeSPCatColSpe = getListeRef($OConnexion, '3.1.2');
  // Récupération de la liste des type de voyage
  $aListeVoyages = getListeRef($OConnexion, '5.2');
  // Récupération de la liste des domaines d'invention technique
  $aListeDomaines = getListeRef($OConnexion, '5.1.3.2');
  // Récupération de la liste des disciplines et thématiques mobilisées (getListeRepresentation dans lib/lib.php)
  $aListeDTHierarchie = getListeRef($OConnexion, '5.1.1');
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
  $aListeDiscThem = getListeRepresentation($OConnexion, null, 511);

  if (!empty($_GET['idOeuvre'])) {
    include_once 'lib/uneoeuvre.php';
    $IDOeuvre = $OConnexion->real_escape_string($_GET['idOeuvre']);
    // Récupération des informations concernant l'oeuvre
    $aOeuvre = aGetOeuvre($OConnexion, $IDOeuvre);
    if (empty($aOeuvre['oeuvre']['idOeuvre'])) {
      $IDOeuvre = null;
    }
  } else if (!empty($_GET['bAuHasard'])) {
    include_once 'lib/uneoeuvre.php';
    // Récupération de tous les id des œuvres et on en tire une au hasard
    $aIdOeuvres = aGetIdOeuvres($OConnexion);
    if (!empty($aIdOeuvres)) {
      $IDOeuvre = array_rand($aIdOeuvres);
      $aOeuvre = aGetOeuvre($OConnexion, $IDOeuvre);
    }
  } else if (!empty($_GET['bRechercheSimple'])) {
    include_once 'lib/recherche.php';
    if (!empty($_GET['recherche'])) {
      $strRecherche = $OConnexion->real_escape_string($_GET['recherche']);
    }
    // Construction du filtre
// _aFiltre est un tableau contenant
//   _aFiltre['strFrom']: --------- nom de la table de référence
//   _aFiltre['strJoin']: --------- de la forme 'LEFT JOIN table1 ON table1.id = table2.id'
//   _aFiltre['strGroup']: -------- chaine contenant les champs pour le regroupement
//   _aFiltre['strOrder']: -------- chaine contenant les champs pour le trie
//   _aFiltre['strWhere']: -------- chaine contenant des filtres globaux à placer dans le WHERE
//   _aFiltre[]['strTable']: ------ nom de la table
//   _aFiltre[]['strChamp']: ------ nom du champ
//   _aFiltre[]['strFiltre']: ----- chaîne à rechercher dans ce champ
//   _aFiltre[]['quote']: --------- si présent, indique si on doit mettre la valeur du filtre entre cotes
//   _aFiltre[]['strOperateur']: -- de la forme '=', '>=', '<=', 'LIKE' ...
    // Récupération du tri
    if (!empty($_GET['tri'])) {
      switch ($_GET['tri']) {
        case 'titre':
        default:
          $strOrder = 'ORDER BY titrePE';
          $strTitreTri = 'titre de l\'œuvre';
          break;
        case 'date':
          $strOrder = 'ORDER BY anneePE, titrePE';
          $strTitreTri = 'année de première édition';
          break;
        case 'auteur':
          $strOrder = 'ORDER BY auteurNom, auteurPrenom, anneePE, titrePE';
          $strTitreTri = 'par le nom de l\'auteur';
          break;
      }
    } else {
      $strOrder = 'ORDER BY titrePE';
      $strTitreTri = 'titre de l\'œuvre';
    }
    $aFiltres = ['strFrom' => 'FROM oeuvres', 'strOrder' => $strOrder];

    if (!empty($_GET['typeOeuvre'])) {
      $strPlus = '(';
      // Récupération du filtre sur les type d'œuvre (de la forme 0***1***2 ...)
      $aFiltreTypeOeuvre = explode('***', $_GET['typeOeuvre']);
      foreach ($aFiltreTypeOeuvre as $iTypeOeuvre) {
        if ($iTypeOeuvre == 'i') $iTypeOeuvre = 0;
        $strWhereSupl .= $strPlus.'oeuvres.natureTxt = '.$OConnexion->real_escape_string($iTypeOeuvre)."\n";
        $strPlus = 'OR ';
      }
      $strWhereSupl .= ')'."\n";
    }
    if (!empty($_GET['auteur'])) {
      // Récupération du filtre sur les nom d'auteur (de la forme nom1---prenom1***nom2---prenom2***nom3---prenom3 ...)
      $aFiltreAuteurTmp = explode('***', $_GET['auteur']);
      $strPlus = (empty($strWhereSupl) ? '(' : 'AND (');
      foreach ($aFiltreAuteurTmp as $strNomPrenom) {
        $aFiltreAuteur[] = $strNomPrenom;
        $aNomPrenom = explode('---', $strNomPrenom);
        $strWhereSupl .= $strPlus.'oeuvres.auteurNom = "'.$OConnexion->real_escape_string(urldecode($aNomPrenom[0])).'"'.
                                  ' AND oeuvres.auteurPrenom = "'.$OConnexion->real_escape_string(urldecode($aNomPrenom[1])).'"'."\n";
        $strPlus = 'OR ';
      }
      $strWhereSupl .= ')'."\n";
    }
    if (!empty($_GET['periodeDeb']) OR !empty($_GET['periodeFin'])) {
      $strPlus = (empty($strWhereSupl) ? '' : 'AND ');
      if (!empty($_GET['periodeDeb'])) {
        $strWhereSupl .= $strPlus.'oeuvres.anneePE >= '.$OConnexion->real_escape_string(urldecode($_GET['periodeDeb']))."\n";
        $strPlus = 'AND ';
      }
      if (!empty($_GET['periodeFin'])) {
        $strWhereSupl .= $strPlus.'oeuvres.anneePE <= '.$OConnexion->real_escape_string(urldecode($_GET['periodeFin']))."\n";
      }
    }
    // Ajout de filtres supplémentaires
    if (!empty($strWhereSupl)) {
      $aFiltres['strWhere'] = 'AND ('.$strWhereSupl.')';
      // $aFiltres['strWhere'] = $strWhereSupl;
    }
    foreach ($aRechSimpleFiltrage as $aFiltre) {
      $aFiltres[] = ['strTable' => $aFiltre['table'],
                     'strChamp' => $aFiltre['champ'],
                     'strFiltre' => (!empty($aFiltre['quote']) ? '%'.$strRecherche.'%' : (int)$strRecherche),
                     'quote' => $aFiltre['quote'],
                     'strOperateur' => (!empty($aFiltre['quote']) ? 'LIKE' : '='),
                    ];
    }
    // Récupération du résultat de la recherche
    $aResultatRecherche = aFiltreOeuvre($OConnexion, $aFiltres);
    // if (!empty($aResultatRecherche['strDBG'])) {
    //   $strDBG .= '<br />'.$aResultatRecherche['strDBG'];
    // }
    $bRechercheSimple = TRUE;
  } else if (!empty($_GET['bRechercheAvancee'])) {
    $bRechercheAvancee = TRUE;
  } else if (!empty($_GET['Index'])) {
    if ($_GET['Index'] == 'O') {
      // if (!empty($_GET['Index'])) {
      //   $strIndex = $OConnexion->real_escape_string($_GET['Index']);
      // } else {
      //   $strIndex = 'A';
      // }
      // Récupération de la liste des oeuvres (ordre alphabéthique)
      // $aListeOeuvres = aGetListeOeuvres($OConnexion, $strIndex);
      $aListeOeuvres = aGetListeOeuvres($OConnexion, 1);
      // Récupération d'un alphabet indiquant pour chaque lettre si une œuvre possède un titre qui commence par cette lettre
      $aListeAlpha = aGetListeAlpha($OConnexion, 1);
      $bIndexOeuvres = TRUE;
    } else if ($_GET['Index'] == 'A') {
      // Récupération de la liste des auteurs
      $aListeOeuvres = aGetListeOeuvres($OConnexion, 2);
      // Récupération d'un alphabet indiquant pour chaque lettre si une œuvre possède un auteur qui commence par cette lettre
      $aListeAlpha = aGetListeAlpha($OConnexion, 2);
      $bIndexAuteurs = TRUE;
    } else if ($_GET['Index'] == 'C') {
      // Récupération de la liste des oeuvres (ordre chronologique)
      $aListeOeuvres = aGetListeOeuvres($OConnexion, 3);
      // Récupération de la liste des années de première édition indiquant pour chaque année si une œuvre a eu sa première édition
      $aListeAnnePE = aGetListeAnnePE($OConnexion);
      $bIndexChrono = TRUE;
    }
  }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>ANR Anticipation - Fiche Livre </title>
        
        <?php
        // <link rel="stylesheet" href="css/bootstrap-4.1.1.min.css">
        // <link rel="stylesheet" href="css/bootstrap-3.3.7.min.css">
        // <link rel="stylesheet" href="css/style3.css">
        // <link rel="stylesheet" href="css/jquery.mCustomScrollbar-3.1.5.min.css"> 
        // <link rel="stylesheet" href="css/fonts.css">
        // PYJ - <link rel="stylesheet" href="css/jquery.ui.css"> 

        // <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        // <!-- Bootstrap CSS CDN -->
        // <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        // <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito|Adamina|Yanone+Kaffeesatz">
        // <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css"> 

        if (defined('bDBG') AND bDBG) {
          echo '<script type="text/javascript"> var bDBG=true; var strDBG="";</script>'."\n";
        }
        // Bien laisser l'ordre du chargement des librairies JS... sinon erreurs JS
        ?>
        <script src="js/jquery-3.3.1.js<?php echo '?V='.VersionJS; ?>"></script>
        <script src="js/jquery-ui-1.12.1.js<?php echo '?V='.VersionJS; ?>"></script>
        <script src="js/jquery-ui-fr.js<?php echo '?V='.VersionJS; ?>"></script>
        <script src="js/popper-1.14.3.min.js<?php echo '?V='.VersionJS; ?>"></script>
        <script src="js/bootstrap-3.3.7.min.js<?php echo '?V='.VersionJS; ?>"></script>
        <script src="js/jquery.mCustomScrollbar-3.1.5.concat.min.js<?php echo '?V='.VersionJS; ?>"></script>
        <!--  Quelques fonctions JS -->
        <script src="js/divers.js<?php echo '?V='.VersionJS; ?>"></script>
        
        <link rel="stylesheet" href="css/bootstrap-4.1.1.css<?php echo '?V='.VersionCSS; ?>">
        <link rel="stylesheet" href="css/bootstrap-3.3.7.css<?php echo '?V='.VersionCSS; ?>">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="css/style3.css<?php echo '?V='.VersionCSS; ?>">
        <link rel="stylesheet" href="css/ihrim-anticipation.css<?php echo '?V='.VersionCSS; ?>">
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="css/jquery.mCustomScrollbar-3.1.5.css"> 
        <link rel="stylesheet" href="css/fonts.css<?php echo '?V='.VersionCSS; ?>">
        <link rel="stylesheet" href="css/jquery-ui-1.12.1.css<?php echo '?V='.VersionCSS; ?>"> 
        <link rel="stylesheet" href="css/jquery-ui-ajout.css<?php echo '?V='.VersionCSS; ?>"> 
    </head>
    <?php
    if ($aOeuvre['oeuvre']['deleted'] === 0 OR $bIndexOeuvres === TRUE OR $bIndexAuteurs === TRUE OR $bIndexChrono === TRUE OR $bRechercheAvancee === TRUE OR $bRechercheSimple === TRUE) {
    ?>
    <body data-spy="scroll" data-target=".scrollSpy">
    <?php
    } else {
    ?>
    <body class="body_home" data-spy="scroll" data-target=".scrollSpy">
    <?php
    }
    ?>

      <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="labelInfo">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 id="labelInfo" class="modal-title">Pour information</h3>
            </div>
            <div id="bodyInfo" class="modal-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <div class="modal fade" id="Patience" tabindex="-1" role="dialog" aria-labelledby="labelPatience" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!-- Bouton x à supprimer après les dev -->
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 id="labelPatience">Travail en cours... merci de patienter.</h3>
            </div>
            <div class="modal-body">
              <div class="progress">
                <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                </div>
              </div>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

        <!-- WRAPPER -->
        <div class="wrapper">
            <?php
            if ($aOeuvre['oeuvre']['deleted'] === 0 OR $bIndexOeuvres === TRUE OR $bIndexAuteurs === TRUE OR $bIndexChrono === TRUE OR $bRechercheAvancee === TRUE OR $bRechercheSimple === TRUE) {
            ?>
            <!-- SIDEBAR MENU BURGER -->
            <nav id="sidebar">
                <div id="dismiss">
                    <i class="glyphicon glyphicon-remove fermermenuprincipal"></i>
                </div>
                <div class="menuprincipal">
                    <ul class="list-unstyled components">
                        <li class="active itemmenuprincipal">
                            <div class="dropdown-divider dividermenuprincipal"></div>
                            <a href="#">Accueil</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="#">Qu'est-ce que le récit d'anticipation ?</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="./graphique">Le récit d'anticipation en graphique</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="#">L'ANR Anticipation</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="#">Principes de sélection des oeuvres</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="#">Les contributeurs</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="#">Signaler une erreur</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a  href="?bRechercheAvancee=1">Recherche avancée</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="./?Index=O">Index des oeuvres</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="./?Index=A">Index des auteurs</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="./?Index=C">Index chronologique des œuvres</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                        <li class="itemmenuprincipal">
                            <a href="?bAuHasard=1">Au hasard</a>
                            <div class="dropdown-divider dividermenuprincipal"></div>
                        </li>
                    </ul>
                    <div class="sponsors d-flex justify-content-center">
                        <a href="http://ihrim.ens-lyon.fr/"><img src="images/logo_ihrim.png" class="logosSponsors"></a>
                        <a href="https://anr.fr"><img src="images/logo_anr.png" class="logosSponsors"></a>
                    </div>
                </div>
            </nav>
            <!-- FIN SIDEBAR MENU BURGER -->
            <!-- FONCTIONS LATERALES DROITE --> 
            <div class="btn-group-vertical fonctions_laterales">
                  <?php
                    // <a class="btn btn_fonctions_laterales" data-toggle="tooltip" data-placement="left" title="Télécharger la fiche" href="javascript:window.print();"><img class="icon_fonctions_laterales" src="images/document.svg"></a>
                    // <a class="btn btn_fonctions_laterales" data-toggle="tooltip" data-placement="left" title="Mettre en favori"><img class="icon_fonctions_laterales" src="images/bookmark.svg"></a>
                    // <a class="btn btn_fonctions_laterales" data-toggle="tooltip" data-placement="left" title="Annoter"><img class="icon_fonctions_laterales" src="images/pencil.svg"></a>
                  ?>
            </div>
            <!-- FIN FONCTIONS LATERALES DROITE --> 
            <?php
            }
            ?>
            <!-- CONTENU DE LA PAGE -->
            <div id="content">
                <?php
                if ($aOeuvre['oeuvre']['deleted'] === 0 OR $bIndexOeuvres === TRUE OR $bIndexAuteurs === TRUE OR $bIndexChrono === TRUE OR $bRechercheAvancee === TRUE OR $bRechercheSimple === TRUE) {
                ?>
                <!-- BARRE DE MENU SUPERIEURE -->
                <header class="navbar navbar-expand-lg navbar-light">  
                    <div class="collapse navbar-collapse" id="navbarText2">
                        <a class="navbar-brand" href="/">
                            <?php // <img class="logoAnticipation" src="images/logo_anticipation_v0.png" alt="logo"> ?>
                            <img class="logoAnticipation" src="images/logo_anticipation.png" alt="logo">
                        </a>
                    </div>
                    <div class="d-none d-lg-flex shortcuts-top">
                        <?php
                        // if (!empty($aOeuvre['navigation']['idOeuvrePrec']['idOeuvre'])) { ? 
                        // <a class="nav-link" href="./?idOeuvre= ?php echo $aOeuvre['navigation']['idOeuvrePrec']['idOeuvre']; ? "><span class="glyphicon glyphicon-chevron-left"></span> Œuvre précédente</a>
                        //  ?php } ? 
                        //  ?php
                        //   if (!empty($aOeuvre['navigation']['idOeuvreSuiv']['idOeuvre'])) {
                        //     if (!empty($aOeuvre['navigation']['idOeuvrePrec']['idOeuvre'])) {
                        //       echo '<a class="nav-link"> | </a>';
                        //     }
                        // ? 
                        // <a class="nav-link" href="./?idOeuvre= ?php echo $aOeuvre['navigation']['idOeuvreSuiv']['idOeuvre']; ? ">Œuvre suivante <span class="glyphicon glyphicon-chevron-right"></span></a>
                        // }
                        ?>
                        <a class="nav-link" href="?bAuHasard=1">Au hasard</a>
                        <a class="nav-link" href="?Index=O">Index œuvres</a>
                        <a class="nav-link" href="?Index=A">Index auteurs</a>
                        <a class="nav-link" href="?Index=C">Chronologie œuvres</a>
                        <?php // <a class="nav-link" href="#" data-toggle="modal" data-target="#modRechercheAvancee">Recherche avancée (mod)...</a> ?>
                        <a class="nav-link" href="?bRechercheAvancee=1">Recherche avancée</a>
                        <form class="form-inline my-2 my-lg-0 formRecherche">
                            <input type="hidden" name="bRechercheSimple" value="1">
                            <?php // <input class="form-control mr-sm-2 champRecherche" type="search" name="recherche" placeholder="Chercher simple..." aria-label="Search" value=" ?php echo (!empty($_GET['recherche']) ? $OConnexion->real_escape_string($_GET['recherche']) : ''); ? "> ?>
                            <input class="form-control mr-sm-2 champRecherche" type="search" name="recherche" placeholder="Recherche simple..." aria-label="Search">
                            <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </form>
                        <div class="navbar-header">
                            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                    </div>
                </header> 
                <?php
                }
                ?>
                <!-- FIN BARRE DE MENU SUPERIEURE -->
                <!-- DIV PRINCIPALE -->
                  <?php
                  if ($aOeuvre['oeuvre']['deleted'] === 0 OR $bIndexOeuvres === TRUE OR $bIndexAuteurs === TRUE OR $bIndexChrono === TRUE OR $bRechercheAvancee === TRUE OR $bRechercheSimple === TRUE) {
                  ?>
                <div class="row_principale row col-sm-12">
                    <!-- BARRE DE MENU GAUCHE SCROLLSPY -->
                  <?php if ($IDOeuvre != null) { ?>
                    <img src="images/macaron_anticipation.png" class="macaron_bg">
                  <?php } ?>
                    <div class="col-sm-2 list-group sidebarLeft d-md-none d-lg-block">
                        <?php if ($IDOeuvre != null) { ?>
                        <div class="scrollSpy nav">
                            <a class="list-group-item list-group-item-action scrollSpyItem" href="#">
                            <?php if (!empty($aOeuvre['navigation']['idOeuvrePrec']['idOeuvre'])) { ?>
                            <span style="cursor:pointer;" onClick="window.location.href='./?idOeuvre=<?php echo $aOeuvre['navigation']['idOeuvrePrec']['idOeuvre']; ?>'"><span class="glyphicon glyphicon-chevron-left"></span> préc.</span>
                            <?php } ?>
                            <?php
                              if (!empty($aOeuvre['navigation']['idOeuvreSuiv']['idOeuvre'])) {
                                if (!empty($aOeuvre['navigation']['idOeuvrePrec']['idOeuvre'])) {
                                  echo ' | ';
                                }
                            ?>
                            <span style="cursor:pointer;" onClick="window.location.href='./?idOeuvre=<?php echo $aOeuvre['navigation']['idOeuvreSuiv']['idOeuvre']; ?>'">suiv. <span class="glyphicon glyphicon-chevron-right"></span></span>
                            <?php } ?>
                            </a>
                            <a class="list-group-item list-group-item-action scrollSpyItem" href="#titre_resume">Résumé</a>
                            <a class="list-group-item list-group-item-action scrollSpyItem" href="#titre_editions_reception">Editions, réception</a>
                            <a class="list-group-item list-group-item-action scrollSpyItem" href="#titre_poetique">Poétique</a>
                            <a class="list-group-item list-group-item-action scrollSpyItem" href="#titre_cadre_s_t">Cadre spatio-temporel</a>
                            <a class="list-group-item list-group-item-action scrollSpyItem" href="#titre_sciences">Sciences</a>
                            <a class="list-group-item list-group-item-action scrollSpyItem" href="#titre_societes_imaginaires">Sociétés imaginaires</a>
                            <a class="list-group-item list-group-item-action scrollSpyItem" href="#titre_biblio">Bibliographie</a>
                            <a class="list-group-item list-group-item-action scrollSpyItem" href="#titre_about">A propos</a>
                        </div>
                        <?php
                        } else if ($bRechercheSimple) {
                        // Menu pour filtrer le résultat de recherche
                        // Ajouter $_GET['recherche'] et $_GET['bRechercheSimple']
                        $strPlusGET = '';
                        if (!empty($_GET['recherche'])) {
                          $strPlusGET .= '&recherche='.$_GET['recherche'];
                        }
                        if (!empty($_GET['bRechercheSimple'])) {
                          $strPlusGET .= '&bRechercheSimple='.$_GET['bRechercheSimple'];
                        }
                        echo '<div class="scrollSpy nav">'."\n".
                             '  <a class="list-group-item list-group-item-action scrollSpyItem" href="#" style="cursor:pointer;"'.
                             '     data-toggle="modal" data-target="#modFiltrerTrier">Filtrer et trier...<span class="glyphicon glyphicon-chevron-right"></span></a>'."\n".
                             '</div>'."\n";
                        // Création du menu pour les tris et les filtres
                        $strTriCheckedTitre = ' checked';
                        $strTriCheckedDate = $strTriCheckedAuteur = '';
                        switch ($_GET['tri']) {
                          // default :
                          // case 'titre':  $strTriCheckedTitre  = ' checked'; break;
                          case 'date':   $strTriCheckedDate   = ' checked'; break;
                          case 'auteur': $strTriCheckedAuteur = ' checked'; break;
                        }
                        if (!empty($aResultatRecherche['typeOeuvre'])) {
                          // Création du menu de filtrage pour les type d'œuvres
                          $strMenuFiltreTypOeuvre = '';
                          foreach ($aResultatRecherche['typeOeuvre'] as $cle => $iTypeOeuvre) {
                            if ($iTypeOeuvre == 0) $iTypeOeuvre = 'i';
                            if (empty($strMenuFiltreTypOeuvre)) {
                              $strMenuFiltreTypOeuvre = '<form>'."\n";
                            }
                            if (!empty($aFiltreTypeOeuvre) AND in_array($iTypeOeuvre, $aFiltreTypeOeuvre)) {
                              $strChecked = ' checked';
                            } else {
                              $strChecked = '';
                            }
                            // On remplace 0 par i pour pas avoir de problème avec empty($_GET['typeOeuvre'])
                            $strMenuFiltreTypOeuvre .= '<div class="checkbox">'."\n".
                                                       '  <label>'."\n".
                                                       '    <input type="checkbox" id="chkTypeOeuvre'.$cle.'" name="chkTypeOeuvre[]" value="'.$iTypeOeuvre.'"'.$strChecked.'> '.getValCodeNatureTxt($iTypeOeuvre)."\n".
                                                       '  </label>'."\n".
                                                       '</div>'."\n";
                          }
                          // $strMenuFiltreTypOeuvre .= '</form><button id="btnFiltrerTypeOeuvre" class="btn btn-danger" onClick="javascript:vValideFiltre()">Filtrer</button>'."\n";
                          $strMenuFiltreTypOeuvre .= '</form>'."\n";
                        }
                        if (!empty($aResultatRecherche['anneePE'])) {
                          // Création du menu de filtrage pour la période
                          $strOptionsPeriodeDeb = '<select class="form-control" name="selPeriodeDeb" id="selPeriodeDeb" style="padding-top: 2px;padding-bottom: 2px;"><option value="0">---</option>';
                          $strOptionsPeriodeFin = '<select class="form-control" name="selPeriodeFin" id="selPeriodeFin" style="padding-top: 2px;padding-bottom: 2px;"><option value="0">---</option>';
                          foreach ($aResultatRecherche['anneePE'] as $iAnneePE) {
                            if (!empty($_GET['periodeDeb']) AND $_GET['periodeDeb'] == $iAnneePE) {
                              $strSelectedDeb = ' selected="selected"';
                            } else {
                              $strSelectedDeb = '';
                            }
                            if (!empty($_GET['periodeFin']) AND $_GET['periodeFin'] == $iAnneePE) {
                              $strSelectedFin = ' selected="selected"';
                            } else {
                              $strSelectedFin = '';
                            }
                            $strOptionsPeriodeDeb .= '<option value="'.urlencode($iAnneePE).'"'.$strSelectedDeb.'>'.$iAnneePE.'</option>'."\n";
                            $strOptionsPeriodeFin .= '<option value="'.urlencode($iAnneePE).'"'.$strSelectedFin.'>'.$iAnneePE.'</option>'."\n";
                          }
                          $strOptionsPeriodeDeb .= '</select>'."\n";
                          $strOptionsPeriodeFin .= '</select>'."\n";
                          $strMenuFiltrePeriode = '<form class="form-horizontal">'."\n".
                                                  '<div class="form-group">'."\n".
                                                  '  <label for="selPeriodeDeb" class="col-sm-2 control-label">De</label>'."\n".
                                                  '  <div class="col-sm-10">'."\n".
                                                  $strOptionsPeriodeDeb.
                                                  '  </div>'."\n".
                                                  '</div>'."\n".
                                                  '<div class="form-group">'."\n".
                                                  '  <label for="selPeriodeFin" class="col-sm-2 control-label">À</label>'."\n".
                                                  '  <div class="col-sm-10">'."\n".
                                                  // str_replace('selPeriodeDeb', 'selPeriodeFin', $strOptionsPeriode)."\n".
                                                  $strOptionsPeriodeFin."\n".
                                                  '  </div>'."\n".
                                                  '</div>'."\n".
                                                  // '</form><br /><button id="btnFiltrerPeriode" class="btn btn-danger" onClick="javascript:vValideFiltre()">Filtrer</button>'."\n";
                                                  '</form>'."\n";
                        }
                        if (!empty($aResultatRecherche['NomPrenom'])) {
                          // Création du menu de filtrage pour auteurs
                          $strMenuFiltreAuteur = '';
                          foreach ($aResultatRecherche['NomPrenom'] as $cle => $strNomPrenom) {
                            // Où $strNomPrenom est de la forme <nom>---<prenom>
                            if (empty($strMenuFiltreAuteur)) {
                              $strMenuFiltreAuteur = '<form>'."\n";
                            }
                            if (!empty($aFiltreAuteur) AND in_array($strNomPrenom, $aFiltreAuteur)) {
                              // Filtrage sur ce NomPrenom
                              $strChecked = ' checked';
                            } else {
                              $strChecked = '';
                            }
                            $strMenuFiltreAuteur .= '<div class="checkbox">'."\n".
                                                    '  <label>'."\n".
                                                    '    <input type="checkbox" id="chkAuteur'.$cle.'" name="chkAuteur[]" value="'.urlencode($strNomPrenom).'"'.$strChecked.'> '.str_replace('---', ' ', $strNomPrenom)."\n".
                                                    '  </label>'."\n".
                                                    '</div>'."\n";
                          }
                          // $strMenuFiltreAuteur .= '</form><button id="btnFiltrerAuteur" class="btn btn-danger" onClick="javascript:vValideFiltre()">Filtrer</button>'."\n";
                          $strMenuFiltreAuteur .= '</form>'."\n";
                        }
                        $strModMenuTrieFiltre = '<!-- Modal - Menu pour trier et filtrer -->'."\n".
                                                '<div class="modal fade" id="modFiltrerTrier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'."\n".
                                                '  <div class="modal-dialog modal-lg" role="document">'."\n".
                                                '    <div class="modal-content">'."\n".
                                                // '      <div class="modal-header">'."\n".
                                                // '  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'."\n".
                                                // '  <h4 class="modal-title" id="myModalLabel">Modal title</h4>'."\n".
                                                // '      </div>'."\n". // /modal-header
                                                '      <div class="modal-body">'."\n".
                                                '      <div class="row">'."\n".
                                                '        <div class="col-md-6">'."\n".
                                                '          <div class="panel panel-default">'."\n".
                                                '            <div class="panel-heading">Trier</div>'."\n".
                                                '            <div class="panel-body">'."\n".
                                                '              <form><div class="radio">'."\n".
                                                '                <label>'."\n".
                                                '                  <input type="radio" name="radTri" id="radModTriTitrePE" value="titre"'.$strTriCheckedTitre.'> Titre de l\'œuvre'."\n".
                                                '                </label>'."\n".
                                                '              </div>'."\n".
                                                '              <div class="radio">'."\n".
                                                '                <label>'."\n".
                                                '                  <input type="radio" name="radTri" id="radModTriAnneePE" value="date"'.$strTriCheckedDate.'> Date de première édition'."\n".
                                                '                </label>'."\n".
                                                '              </div>'."\n".
                                                '              <div class="radio">'."\n".
                                                '                <label>'."\n".
                                                '                  <input type="radio" name="radTri" id="radModTriAuteur" value="auteur"'.$strTriCheckedAuteur.'> Nom de l\'auteur'."\n".
                                                '                </label>'."\n".
                                                '              </div></form>'."\n".
                                                // '              <button id="btnTrier" class="btn btn-danger" onClick="javascript:vValideTri();">Trier</button>'."\n".
                                                '            </div>'."\n". // /panel-body
                                                '          </div>'."\n". // /panel
                                                '          <div class="panel panel-default">'."\n".
                                                '            <div class="panel-heading">Filtrer sur la nature des œuvres</div>'."\n".
                                                '            <div class="panel-body">'."\n".
                                                $strMenuFiltreTypOeuvre.
                                                '            </div>'."\n". // /panel-body
                                                '          </div>'."\n". // /panel
                                                '          <div class="panel panel-default">'."\n".
                                                '            <div class="panel-heading">Filtrer sur une période</div>'."\n".
                                                '            <div class="panel-body">'."\n".
                                                $strMenuFiltrePeriode.
                                                '            </div>'."\n". // /panel-body
                                                '          </div>'."\n". // /panel
                                                '        </div>'."\n". // /col-md-6
                                                // '      </div>'."\n". // /row
                                                // '      <div class="row">'."\n".
                                                '        <div class="col-md-6">'."\n".
                                                '          <div class="panel panel-default">'."\n".
                                                '            <div class="panel-heading">Filtrer sur des noms d\'auteur</div>'."\n".
                                                '            <div class="panel-body">'."\n".
                                                $strMenuFiltreAuteur.
                                                '            </div>'."\n". // /panel-body
                                                '          </div>'."\n". // /panel
                                                '        </div>'."\n". // /col-md-6
                                                '      </div>'."\n". // /row
                                                '      </div>'."\n". // /modal-body
                                                '      <div class="modal-footer">'."\n".
                                                '  <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>'."\n".
                                                '  <button type="button" class="btn btn-danger" onClick="javascript:vValideTriFiltre()">Trier et filtrer <span class="glyphicon glyphicon-ok"></span></button>'."\n".
                                                '      </div>'."\n". // /modal-footer
                                                '    </div>'."\n". // /modal-content
                                                '  </div>'."\n". // /modal-dialog
                                                '</div>'."\n"; // /modal
                        }
                        ?>
                        <div class="sponsors d-flex align-content-center logosBottom">
                            <a href="http://ihrim.ens-lyon.fr/"><img src="images/logo_ihrim.png" ></a>
                            <a href="https://anr.fr"><img src="images/logo_anr.png" ></a>
                        </div>
                    </div>
                    <!-- FIN BARRE DE MENU GAUCHE SCROLLSPY -->
                    <?php
                      } else {
                    ?>
                <div class="row_principale row col-sm-12" style="margin-left: 0px;padding-left: 0px;">
                    <?php
                      }
                      if (!empty($strModMenuTrieFiltre)) echo $strModMenuTrieFiltre;
                      if ($aOeuvre['oeuvre']['deleted'] === 0 OR $bIndexOeuvres === TRUE OR $bIndexAuteurs === TRUE OR $bIndexChrono === TRUE OR $bRechercheAvancee === TRUE OR $bRechercheSimple === TRUE) {
                    ?>
                    <!-- CONTENU DE LA FICHE -->
                    <div class="container_fiche col-md-10 col-sm-10">
                    <?php
                      } else {
                    ?>
                    <div class="container_fiche col-md-12 col-sm-12" style="margin-top: 0px;">
                    <?php
                      }
                    ?>

                        <div class="contenuFiche">

                            <?php
                            if ($aOeuvre['oeuvre']['deleted'] === 0) {
                              // Définition de l'œuvre étudiée
                              $strEditionEtudiee = !empty($aOeuvre['oeuvre']['wrkEdit']) ? $aOeuvre['oeuvre']['wrkEdit'] : 'première édition de '.$aOeuvre['oeuvre']['anneePE'];
                            ?>
                            <div class="metadata_fiche">
                                <div class="bordure_top"></div>
                                <?php
                                echo '<h1 class="name_book">'.$aOeuvre['oeuvre']['titrePE'].
                                     // (!empty($aOeuvre['oeuvre']['txtIntegral']) ? ' <a href="'.$aOeuvre['oeuvre']['txtIntegral'].'" class="link_book"><img class="img_link_book" src="images/open-book.svg" data-toggle="tooltip" data-placement="top" data-original-title="Voir la version en ligne de l\'œuvre" target="_blank"></a>' : '').
                                     (!empty($aOeuvre['oeuvre']['txtIntegral']) ? ' <a href="'.$aOeuvre['oeuvre']['txtIntegral'].'" class="link_book" target="_blank"><img id="poTxtIntegral" class="img_link_book" src="images/open-book.svg" data-toggle="popover" data-placement="top" data-content="Voir la version en ligne de l\'œuvre" data-trigger="hover"></a><script type="text/javascript"> $("#poTxtIntegral").popover(); </script>' : '').
                                     '</h1>'."\n".
                                     '<h2 class="name_author">'.$aOeuvre['oeuvre']['auteurPrenom'].' '.$aOeuvre['oeuvre']['auteurNom'].'</h2>'."\n".
                                     '<p class="date_publication">'.(!empty($aOeuvre['oeuvre']['anneePE']) ? '('.$aOeuvre['oeuvre']['anneePE'].')' : '').'</p>'."\n";
                                ?>
                                <div class="bordure_bottom"></div>
                              <?php
                                // <a href="" class="cover_book"><img src="images/sense-8.jpeg" alt="Couverture du livre" class=""></a>
                                $strPlus = '';
                                if (!empty($aOeuvre['oeuvre']['urlIllustration'])) {
                                  $strSrcImg = $aOeuvre['oeuvre']['urlIllustration'];
                                  $strPlus = ' href="'.$aOeuvre['oeuvre']['urlIllustration'].'" target="_blank"';
                                } else {
                                  $strSrcImg = 'images/logo_anticipation_logo.png';
                                }
                                echo '<a class="cover_book"'.$strPlus.'><img src="'.$strSrcImg.'" alt="Couverture du livre" class=""></a>'."\n".
                                     '<p class="date_publication">'.(!empty($aOeuvre['oeuvre']['natureTxt']) ? getValCodeNatureTxt($aOeuvre['oeuvre']['natureTxt']) : '').'</p>'."\n";
                              ?>
                            </div>
                            <!-- RESUME -->
                            <div class="resume col-sm-12">
                                <div class="d-flex">
                                    <div class="symbole_paragraphe d-flex"></div>
                                    <h3 id="titre_resume" class="titres_fiche d-flex">Résumé</h3>
                                </div>
                                <div class="contenu_decale">
                                    <p><?php echo nl2br($aOeuvre['oeuvre']['resume']); ?></p>
                                </div>
                            </div>
                            <!-- FIN RESUME -->
                            <!-- EDITIONS RECEPTION -->
                            <div class="editions_reception col-sm-12">
                                <div class="d-flex">
                                    <div class="symbole_paragraphe d-flex"></div>
                                    <h3 id="titre_editions_reception" class="titres_fiche d-flex">Éditions, réception</h3>
                                </div>
                                <div class="contenu_decale">
                                    <!-- EDITIONS -->
                                    <h4 id="titre_editions_reception_edition" class="sous_rubrique">Éditions</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="menu_selection_editions dropdown">
                                        <button type="button" id="bouton_dropdown_editions" class="btn btn-danger btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Choisir les données à comparer</button>
                                        <div class="menu_dropdown_editions dropdown-menu" aria-labelledby="bouton_dropdown_editions">
                                            <a class="dropdown_item"><input id="checkbox_col1" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col1" onclick="selectColEditions()" checked><label for="checkbox_col1">Edition</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col2" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col2" onclick="selectColEditions()" checked><label for="checkbox_col2">Éditeur, collection</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col3" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col3" onclick="selectColEditions()" checked><label for="checkbox_col3">Catégorie éditoriale</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col4" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col4" onclick="selectColEditions()" checked><label for="checkbox_col4">Périodique</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col5" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col5" onclick="selectColEditions()" checked><label for="checkbox_col5">Informations supplémentaires sur la date</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col6" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col6" onclick="selectColEditions()" checked><label for="checkbox_col6">Numéros et numéros de pages</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col7" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col7" onclick="selectColEditions()" checked><label for="checkbox_col7">Titre du recueil</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col8" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col8" onclick="selectColEditions()" checked><label for="checkbox_col8">Illustrations</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col9" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col9" onclick="selectColEditions()" checked><label for="checkbox_col9">Paratexte</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col10" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col10" onclick="selectColEditions()" checked><label for="checkbox_col10">Notes</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col11" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col11" onclick="selectColEditions()" checked><label for="checkbox_col11">Lieu</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col12" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col12" onclick="selectColEditions()" checked><label for="checkbox_col12">Format</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col13" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col13" onclick="selectColEditions()" checked><label for="checkbox_col13">Prix</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col14" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col14" onclick="selectColEditions()" checked><label for="checkbox_col14">Nombre de pages du volume</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col15" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col15" onclick="selectColEditions()" checked><label for="checkbox_col15">Nombre de livraisons</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col16" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col16" onclick="selectColEditions()" checked><label for="checkbox_col16">Nombre de pages d’un fascicule / numéro</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col17" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col17" onclick="selectColEditions()" checked><label for="checkbox_col17">Périodicité</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col18" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col18" onclick="selectColEditions()" checked><label for="checkbox_col18">Nom de l'auteur</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col19" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col19" onclick="selectColEditions()" checked><label for="checkbox_col19">Éditeur scientifique</label></a>
                                            <a class="dropdown_item"><input id="checkbox_col20" type="checkbox" aria-label="Checkbox" name="afficher" value="editions_col20" onclick="selectColEditions()" checked><label for="checkbox_col20">Titre utilisé pour l’œuvre</label></a>
                                        </div>
                                    </div>
                                    <table id="tableau_editions" class="table table-striped table-responsive">
                                        <thead>
                                            <tr class="d-flex align-middle">
                                            <th scope="col" class="table_editions table_editions_col1 ">Édition</th>
                                            <th scope="col" class="table_editions table_editions_col2 ">Éditeur, collection</th>
                                            <th scope="col" class="table_editions table_editions_col3 ">Catégorie éditoriale</th>
                                            <th scope="col" class="table_editions table_editions_col4 ">Périodique</th>
                                            <th scope="col" class="table_editions table_editions_col5 ">Informations supplémentaires sur la date</th>
                                            <th scope="col" class="table_editions table_editions_col6 ">Numéros et numéros de pages</th>
                                            <th scope="col" class="table_editions table_editions_col7 ">Titre du recueil</th>
                                            <th scope="col" class="table_editions table_editions_col8 ">Illustrations</th>
                                            <th scope="col" class="table_editions table_editions_col9 ">Paratexte</th>
                                            <th scope="col" class="table_editions table_editions_col10">Notes</th>
                                            <th scope="col" class="table_editions table_editions_col11">Lieu</th>
                                            <th scope="col" class="table_editions table_editions_col12">Format</th>
                                            <th scope="col" class="table_editions table_editions_col13">Prix</th>
                                            <th scope="col" class="table_editions table_editions_col14">Nombre de pages du volume</th>
                                            <th scope="col" class="table_editions table_editions_col15">Nombre de livraisons</th>
                                            <th scope="col" class="table_editions table_editions_col16">Nombre de pages d’un fascicule / numéro</th>
                                            <th scope="col" class="table_editions table_editions_col17">Périodicité</th>
                                            <th scope="col" class="table_editions table_editions_col18">Nom de l'auteur</th>
                                            <th scope="col" class="table_editions table_editions_col19">Éditeur scientifique</th>
                                            <th scope="col" class="table_editions table_editions_col20">Titre utilisé pour l’œuvre</th>
                                            <th scope="col" class="table_editions table_editions_col20">Commentaire</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                            if (!empty($aOeuvre['editions'])) {
                                              foreach ($aOeuvre['editions'] as $aEdition) {
                                                $strCommentaire = $strNbPagesLivPer = $strPrix = $strFormat = $strLieu = $strNotes = $strPlusNotes = $strInfoDate = $strIllustration = $strPlusIllustr = '';
                                                if ($aEdition['typeEdit'] == 'V') {
                                                  $strInfoDate = $aEdition['volDate'];
                                                  if (!empty($aEdition['volIllustrAuteur']) AND substr_compare('aucun', strtolower($aEdition['volIllustrAuteur']), 0, 5) != 0) {
                                                    $strIllustration = $aEdition['volIllustrAuteur'];
                                                    $strPlusIllustr = '. ';
                                                  }
                                                  if (!empty($aEdition['volIllustrations']) AND substr_compare('aucun', strtolower($aEdition['volIllustrations']), 0, 5) != 0) {
                                                    $strIllustration .= $strPlusIllustr.$aEdition['volIllustrations'];
                                                  }
                                                  $strLieu = $aEdition['volLieu'];
                                                  $strFormat = $aEdition['volFormat'];
                                                  $strPrix = $aEdition['volPrix'];
                                                  $strCommentaire = $aEdition['volCom'];
                                                } else if ($aEdition['typeEdit'] == 'L') {
                                                  $strInfoDate = $aEdition['livDate'];
                                                  if (!empty($aEdition['livIllustrAuteur']) AND substr_compare('aucun', strtolower($aEdition['livIllustrAuteur']), 0, 5) != 0) {
                                                    $strIllustration = $aEdition['livIllustrAuteur'];
                                                    $strPlusIllustr = '. ';
                                                  }
                                                  if (!empty($aEdition['livIllustrations']) AND substr_compare('aucun', strtolower($aEdition['livIllustrations']), 0, 5) != 0) {
                                                    $strIllustration .= $strPlusIllustr.$aEdition['livIllustrations'];
                                                  }
                                                  $strLieu = $aEdition['livLieu'];
                                                  $strFormat = $aEdition['livFormat'];
                                                  $strPrix = $aEdition['livPrix'];
                                                  $strNbPagesLivPer = $aEdition['livNbPages'];
                                                  $strCommentaire = $aEdition['livCom'];
                                                } else if ($aEdition['typeEdit'] == 'P') {
                                                  $strInfoDate = $aEdition['perDate'];
                                                  if (!empty($aEdition['perIllustrAuteur']) AND substr_compare('aucun', strtolower($aEdition['perIllustrAuteur']), 0, 5) != 0) {
                                                    $strIllustration = $aEdition['perIllustrAuteur'];
                                                    $strPlusIllustr = '. ';
                                                  }
                                                  if (!empty($aEdition['perIllustrations']) AND substr_compare('aucun', strtolower($aEdition['perIllustrations']), 0, 5) != 0) {
                                                    $strIllustration .= $strPlusIllustr.$aEdition['perIllustrations'];
                                                  }
                                                  $strLieu = $aEdition['perLieu'];
                                                  $strFormat = $aEdition['perFormat'];
                                                  $strPrix = $aEdition['perPrix'];
                                                  $strNbPagesLivPer = $aEdition['perNbPages'];
                                                  $strCommentaire = $aEdition['perCom'];
                                                }
                                                if (!empty($aEdition['paraNotesType'])) {
                                                  $strNotes = 'Type : '.($aEdition['paraNotesType'] == 'auto' ? 'Autographe' : ($aEdition['paraNotesType'] == 'allo' ? 'Allographe' : ''));
                                                  $strPlusNotes = '; ';
                                                }
                                                if (!empty($aEdition['paraNotesAuteur'])) {
                                                  $strNotes .= $strPlusNotes.'Auteur : '.$aEdition['paraNotesType'];
                                                  $strPlusNotes = '; ';
                                                }
                                                if (!empty($aEdition['paraNotesNature'])) {
                                                  $strNotes .= $strPlusNotes.'Nature : '.($aEdition['paraNotesNature'] == 'stech' ? 'Scientifique / technique' :
                                                                                         ($aEdition['paraNotesNature'] == 'autre' ? 'Autre' : ''));
                                                  $strPlusNotes = '; ';
                                                }
                                                if (!empty($aEdition['paraNotesNatureTxt'])) {
                                                  $strNotes .= $strPlusNotes.$aEdition['paraNotesNatureTxt'];
                                                }
                                                if (!empty($strCommentaire)) {
                                                  // Présentation cachée et affichage en cliquand sur un bouton
                                                  $strCommentaire = '<button id="btnClpsEdCom'.$aEdition['idEdition'].'" class="btn btn-danger" type="button" '.
                                                                      'data-toggle="collapse" data-target="#clpsEdCom'.$aEdition['idEdition'].'" aria-expanded="false" '.
                                                                      'aria-controls="clpsEdCom'.$aEdition['idEdition'].'">Afficher <span class="glyphicon glyphicon-chevron-down"></span></button>'."\n".
                                                                    '<div id="clpsEdCom'.$aEdition['idEdition'].'" class="collapse">'.$strCommentaire.'</div>'."\n";
                                                }
                                                // Récupération des paratextes
                                                $strParaTexte = $strPlus = '';
                                                if (!empty($aEdition['paratexte'])) {
                                                  $strPlus = '';
                                                  foreach ($aEdition['paratexte'] as $idPara => $aParatexte) {
                                                    if (!empty($aParatexte['nature'])) {
                                                      $strParaTexte .= $strPlus.$aParatexte['nature'];
                                                      $strPlus = ', ';
                                                    }
                                                    if (!empty($aParatexte['auteurType'])) {
                                                      $strParaTexte .= $strPlus.getValCodePtxtAuteurType($aParatexte['auteurType']);
                                                      $strPlus = ' - ';
                                                    }
                                                    if (!empty($aParatexte['auteur'])) {
                                                      $strParaTexte .= (empty($strPlus) ? ' - ' : $strPlus).$aParatexte['auteur'];
                                                    }
                                                    if (!empty($strPlus)) $strPlus = ';<br />'."\n";
                                                  }
                                                }
                                                if (!empty($aEdition['paraDedicace']) AND substr_compare('aucun', strtolower($aEdition['paraDedicace']), 0, 5) != 0
                                                                                      AND substr_compare('inconnu', strtolower($aEdition['paraDedicace']), 0, 7) != 0) {
                                                  $strParaTexte .= $strPlus.'Dédicace';
                                                  $strPlus = ';<br />'."\n";
                                                }
                                                if (!empty($aEdition['paraEpigraphe']) AND substr_compare('aucun', strtolower($aEdition['paraEpigraphe']), 0, 5) != 0
                                                                                       AND substr_compare('inconnu', strtolower($aEdition['paraEpigraphe']), 0, 7) != 0) {
                                                  $strParaTexte .= $strPlus.'Épigraphe';
                                                  $strPlus = ';<br />'."\n";
                                                }
                                                if (!empty($aEdition['paraCouv4']) AND substr_compare('aucun', strtolower($aEdition['paraCouv4']), 0, 5) != 0
                                                                                   AND substr_compare('inconnu', strtolower($aEdition['paraCouv4']), 0, 7) != 0) {
                                                  $strParaTexte .= $strPlus.'4e de couv';
                                                  $strPlus = ';<br />'."\n";
                                                }
                                                echo '<tr class="d-flex">'."\n".
 /* Edition                                   */     '    <th scope="row" class="table_editions table_editions_col1 ">'.$aEdition['anneeParution'].'</th>'."\n".
 /* Éditeur, collection                       */     '    <td class="table_editions table_editions_col2 ">'.$aEdition['volEditeur'].
                                                                                                           (!empty($aEdition['volCollecNom']) ? ', '.$aEdition['volCollecNom'] : '').'</td>'."\n".
 /* Catégorie éditoriale                      */     '    <td class="table_editions table_editions_col3 ">'.$aEdition['strCategories'].'</td>'."\n".
 /* Périodique                                */     '    <td class="table_editions table_editions_col4 ">'.$aEdition['perNom'].'</td>'."\n".
 /* Informations supplémentaires sur la date  */     '    <td class="table_editions table_editions_col5 ">'.$strInfoDate.'</td>'."\n".
 /* Numéros et numéros de pages               */     '    <td class="table_editions table_editions_col6 ">'.$aEdition['perNum'].'</td>'."\n".
 /* Titre du recueil                          */     '    <td class="table_editions table_editions_col7 ">'.$aEdition['titreRecueil'].'</td>'."\n".
 /* Illustrations                             */     '    <td class="table_editions table_editions_col8 ">'.$strIllustration.'</td>'."\n".
//  Paratexte = Cadre "Paratexte" : Nature, type auteur, texte) - Déjà dans la rubrique Paratexte?!
 /* Paratexte                                 */     '    <td class="table_editions table_editions_col9 ">'.$strParaTexte.'</td>'."\n".
 /* Notes                                     */     '    <td class="table_editions table_editions_col10">'.$strNotes.'</td>'."\n".
 /* Lieu                                      */     '    <td class="table_editions table_editions_col11">'.$strLieu.'</td>'."\n".
 /* Format                                    */     '    <td class="table_editions table_editions_col12">'.$strFormat.'</td>'."\n".
 /* Prix                                      */     '    <td class="table_editions table_editions_col13">'.$strPrix.'</td>'."\n".
 /* Nombre de pages du volume                 */     '    <td class="table_editions table_editions_col14">'.$aEdition['volNbPages'].'</td>'."\n".
 /* Nombre de livraisons                      */     '    <td class="table_editions table_editions_col15">'.$aEdition['livNbNum'].'</td>'."\n".
 /* Nombre de pages d’un fascicule / numéro   */     '    <td class="table_editions table_editions_col16">'.$strNbPagesLivPer.'</td>'."\n".
 /* Périodicité                               */     '    <td class="table_editions table_editions_col17">'.$aEdition['perPeriodicite'].'</td>'."\n".
 /* Nom de l'auteur                           */     '    <td class="table_editions table_editions_col18">'.$aEdition['paraAuteur'].'</td>'."\n".
 /* Éditeur scientifique                      */     '    <td class="table_editions table_editions_col19">'.$aEdition['volEditeurScient'].'</td>'."\n".
 /* Titre utilisé pour l’œuvre                */     '    <td class="table_editions table_editions_col20">'.$aEdition['titre'].'</td>'."\n".
 /* Commentaire sur l'édition                 */     '    <td class="table_editions table_editions_col20">'.$strCommentaire.'</td>'."\n".
                                                   '</tr>'."\n";
                                              }
                                            } else {
                                              echo 'Aucune édition'."\n";
                                            }
                                          ?>
                                        </tbody>
                                    </table>
                                    <!--FIN EDITIONS -->
                                    <!--PARATEXTE -->
                                    <h4 class="sous_rubrique">Paratexte</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="chronologie">
                                        <?php
                                          // Récupération des paratextes (onglet3) à trier par ordre chronologique:
                                          //   - date dans class="date_citation"
                                          //   - texte de la citation dans class="text_citation"
                                          //   - dans class="source_citation":
                                          //     | Dédicace, Épigraphe, Quatrième de couverture
                                          //  ou | Auteur - Type (Allographe, autohraphe) - nature
                                          if (!empty($aOeuvre['editions'])) {
                                            $strTmplParatexte = '<div class="container_citation col-md-12">'."\n".
                                                                '    <div class="citation col-md-12">'."\n".
                                                                '        <div class="col_gauche_citation">'."\n".
                                                                '            <div class="date_div">'."\n".
                                                                '            <p class="saut_de_ligne_date">&nbsp;</p>'."\n".
                                                                '            <p class="date_citation col_gauche_citation">%date%</p>'."\n".
                                                                '            </div>'."\n".
                                                                '            <img class="quotes_sans_date" src="images/quotes.svg">'."\n".
                                                                '            <div class="trait_vertical_citation_date"></div>'."\n".
                                                                '        </div>'."\n".
                                                                '        <div class="col_droite_citation">'."\n".
                                                                '            <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                                '            <p class="text_citation minimize">'."\n".
                                                                '                %citation%'."\n".
                                                                '            </p>'."\n".
                                                                '            <p class="source_citation">'."\n".
                                                                '                %source%'."\n".
                                                                '            </p>'."\n".
                                                                '        </div>'."\n".
                                                                '    </div>'."\n".
                                                                '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['editions'] as $aEdition) {
                                              if (!empty($aEdition['paraDedicace']) AND substr_compare('aucun', strtolower($aEdition['paraDedicace']), 0, 5) != 0
                                                                                    AND substr_compare('inconnu', strtolower($aEdition['paraDedicace']), 0, 7) != 0
                                                                                    AND substr_compare('rien', strtolower($aEdition['paraDedicace']), 0, 4) != 0
                                                                                    AND substr_compare('non', strtolower($aEdition['paraDedicace']), 0, 3) != 0) {
                                                if ($iCpt++ >= 2 AND !$bDejaBouton) {
                                                  echo '<button id="btnClpsParatextes" class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_paratexte" aria-expanded="false" aria-controls="contenu_cache_paratexte">Afficher tous les paratextes</button>'."\n".
                                                       '<div class="contenu_cache_paratexte collapse">'."\n";
                                                  $bDejaBouton = TRUE;
                                                }
                                                $aRecherche = array('%date%', '%citation%', '%source%');
                                                $aRemplace = array($aEdition['anneeParution'], nl2br($aEdition['paraDedicace']), 'Dédicace');
                                                echo str_replace($aRecherche, $aRemplace, $strTmplParatexte);
                                              }
                                              if (!empty($aEdition['paraEpigraphe']) AND substr_compare('aucun', strtolower($aEdition['paraEpigraphe']), 0, 5) != 0
                                                                                     AND substr_compare('inconnu', strtolower($aEdition['paraEpigraphe']), 0, 7) != 0
                                                                                     AND substr_compare('rien', strtolower($aEdition['paraEpigraphe']), 0, 4) != 0
                                                                                     AND substr_compare('non', strtolower($aEdition['paraEpigraphe']), 0, 3) != 0) {
                                                if ($iCpt++ >= 2 AND !$bDejaBouton) {
                                                  echo '<button id="btnClpsParatextes" class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_paratexte" aria-expanded="false" aria-controls="contenu_cache_paratexte">Afficher tous les paratextes</button>'."\n".
                                                       '<div class="contenu_cache_paratexte collapse">'."\n";
                                                  $bDejaBouton = TRUE;
                                                }
                                                $aRecherche = array('%date%', '%citation%', '%source%');
                                                $aRemplace = array($aEdition['anneeParution'], nl2br($aEdition['paraEpigraphe']), 'Épigraphe');
                                                echo str_replace($aRecherche, $aRemplace, $strTmplParatexte);
                                              }
                                              if (!empty($aEdition['paraCouv4']) AND substr_compare('aucun', strtolower($aEdition['paraCouv4']), 0, 5) != 0
                                                                                 AND substr_compare('inconnu', strtolower($aEdition['paraCouv4']), 0, 7) != 0
                                                                                 AND substr_compare('rien', strtolower($aEdition['paraCouv4']), 0, 5) != 0
                                                                                 AND substr_compare('non', strtolower($aEdition['paraCouv4']), 0, 3) != 0) {
                                                if ($iCpt++ >= 2 AND !$bDejaBouton) {
                                                  echo '<button id="btnClpsParatextes" class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_paratexte" aria-expanded="false" aria-controls="contenu_cache_paratexte">Afficher tous les paratextes</button>'."\n".
                                                       '<div class="contenu_cache_paratexte collapse">'."\n";
                                                  $bDejaBouton = TRUE;
                                                }
                                                $aRecherche = array('%date%', '%citation%', '%source%');
                                                $aRemplace = array($aEdition['anneeParution'], nl2br($aEdition['paraCouv4']), 'Quatrième de couverture');
                                                echo str_replace($aRecherche, $aRemplace, $strTmplParatexte);
                                              }
                                              if (!empty($aEdition['paratexte'])) {
                                                foreach ($aEdition['paratexte'] as $aParatexte) {
                                                  // if (substr_compare('aucun', strtolower($aParatexte), 0, 5) != 0 AND substr_compare('inconnu', strtolower($aParatexte), 0, 7) != 0
                                                  //     AND substr_compare('rien', strtolower($aParatexte), 0, 5) != 0 AND substr_compare('non', strtolower($aParatexte), 0, 3) != 0) {
                                                    if ($iCpt++ >= 2 AND !$bDejaBouton) {
                                                      echo '<button id="btnClpsParatextes" class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_paratexte" aria-expanded="false" aria-controls="contenu_cache_paratexte">Afficher tous les paratextes</button>'."\n".
                                                           '<div class="contenu_cache_paratexte collapse">'."\n";
                                                      $bDejaBouton = TRUE;
                                                    }
                                                    $strPlus = $strSource = '';
                                                    if (!empty($aParatexte['nature'])) {
                                                      $strSource = $aParatexte['nature'];
                                                      $strPlus = ', ';
                                                    }
                                                    if (!empty($aParatexte['auteurType'])) {
                                                      $strSource .= $strPlus.getValCodePtxtAuteurType($aParatexte['auteurType']);
                                                      $strPlus = ', de ';
                                                    }
                                                    if (!empty($aParatexte['auteur'])) {
                                                      $strSource .= $strPlus.$aParatexte['auteur'];
                                                    }
                                                    $aRecherche = array('%date%', '%citation%', '%source%');
                                                    $aRemplace = array($aEdition['anneeParution'], nl2br($aParatexte['texte']), $strSource);
                                                    echo str_replace($aRecherche, $aRemplace, $strTmplParatexte);
                                                  // }
                                                }
                                              }
                                            }
                                            if ($bDejaBouton) {
                                              echo '</div>'."\n";
                                              $strJScriptPlus .= '$(\'#btnClpsParatextes\').append(" ('.$iCpt.')");'."\n";
                                            }
                                            if ($iCpt == 0) {
                                              echo 'Aucun paratexte'."\n";
                                            }
                                          } else {
                                            echo 'Aucun paratexte'."\n";
                                          }
                                        ?>
                                    </div> <!-- /chronologie -->
                                    <!-- FIN PARATEXTE -->
                                    <!-- GENRES -->
                                    <h4 class="sous_rubrique">
                                      Genres
                                      <?php // <img class="img_infobulle" src="images/information.svg" data-toggle="tooltip" data-placement="top" title="Désignations génériques utilisées par l'auteur, les éditeurs ou les critiques pour caractériser l'oeuvre" data-original-title="Désignations génériques utilisées par l'auteur, les éditeurs ou les critiques pour caractériser l'oeuvre"> ?>
                                      <img id="poGenres" class="img_infobulle" src="images/information.svg" data-toggle="popover" data-placement="top" data-content="Désignations génériques utilisées par l'auteur, les éditeurs ou les critiques pour caractériser l'oeuvre" data-trigger="hover">
                                      <script type="text/javascript"> $('#poGenres').popover(); </script>
                                    </h4>
                                    <div class="semi_souligne"></div>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['genres'])) {
                                            $strTmplGenre = '<div class="container_citation col-md-12">'."\n".
                                                            '    <div class="citation col-md-12">'."\n".
                                                            '        <div class="col_gauche_citation">'."\n".
                                                            '            <div class="date_div">'."\n".
                                                            '            <p class="saut_de_ligne_date">&nbsp;</p>'."\n".
                                                            '            <p class="date_citation col_gauche_citation">%date%</p>'."\n".
                                                            '            </div>'."\n".
                                                            '            <img class="quotes_sans_date" src="images/quotes.svg">'."\n".
                                                            '            <div class="trait_vertical_citation_date"></div>'."\n".
                                                            '        </div>'."\n".
                                                            '        <div class="col_droite_citation">'."\n".
                                                            '            <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                            '            <p class="text_citation minimize">'."\n".
                                                            '                %citation%'."\n".
                                                            '            </p>'."\n".
                                                            '            <p class="source_citation">'."\n".
                                                            '                %source%'."\n".
                                                            '            </p>'."\n".
                                                            '        </div>'."\n".
                                                            '    </div>'."\n".
                                                            '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['genres'] as $key => $aGenre) {
                                              $strPlus = '';
                                              if ($iCpt++ >= 2 AND !$bDejaBouton) {
                                                echo '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_genres" aria-expanded="false" aria-controls="contenu_cache_genres">Afficher tous les genres ('.count($aOeuvre['genres']).')</button>'."\n".
                                                     '<div class="contenu_cache_genres collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              if (preg_match('/.*-DA$/', $key) === 1) {
                                                $strPlus = 'Discours auctorial - ';
                                              } else if (preg_match('/.*-DE$/', $key) === 1) {
                                                $strPlus = 'Dispositif éditorial - ';
                                              } else if (preg_match('/.*-RC$/', $key) === 1) {
                                                $strPlus = 'Réception critique - ';
                                              // } else {
                                              }
                                              $aRecherche = array('%date%', '%citation%', '%source%');
                                              $aRemplace = array($aGenre['dDate'], nl2br($aGenre['designation']), $strPlus.$aGenre['source']);
                                              echo str_replace($aRecherche, $aRemplace, $strTmplParatexte);
                                            }
                                            if ($bDejaBouton) echo '</div>'."\n";
                                          } else {
                                            echo 'Aucune information'."\n";
                                          }
                                        ?>
                                    </div>
                                    <!-- FIN GENRES -->
                                    <!-- Liens avec d'autres auteurs -->
                                    <h4 class="sous_rubrique">
                                      Liens avec d'autres auteurs
                                      <?php // <img class="img_infobulle" src="images/information.svg" data-toggle="tooltip" data-placement="top" data-original-title="Ecrivains auxquels l'auteur de l'œuvre est comparé"> ?>
                                      <img id="poLiensAuteurs" class="img_infobulle" src="images/information.svg" data-toggle="popover" data-placement="top" data-content="Ecrivains auxquels l'auteur de l'œuvre est comparé" data-trigger="hover">
                                      <script type="text/javascript"> $('#poLiensAuteurs').popover(); </script>
                                    </h4>
                                    <div class="semi_souligne"></div>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['liensauteurs'])) {
                                            $strTmplLiensAuteurs = '<div class="container_citation col-md-12">'."\n".
                                                                   '    <div class="citation col-md-12">'."\n".
                                                                   '        <div class="col_gauche_citation">'."\n".
                                                                   '            <div class="date_div">'."\n".
                                                                   '            <p class="saut_de_ligne_date">&nbsp;</p>'."\n".
                                                                   '            <p class="date_citation col_gauche_citation">%date%</p>'."\n".
                                                                   '            </div>'."\n".
                                                                   '            <img class="quotes_sans_date" src="images/link_authors.svg">'."\n".
                                                                   '            <div class="trait_vertical_citation_date"></div>'."\n".
                                                                   '        </div>'."\n".
                                                                   '        <div class="col_droite_citation col_droite_citation_sans_date">'."\n".
                                                                   '            <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                                   '            <p class="text_reference minimize">'."\n".
                                                                   '                %auteur%'."\n".
                                                                   '            </p>'."\n".
                                                                   '            <p class="citation_reference">'."\n".
                                                                   '                %citation%'."\n".
                                                                   '            </p>'."\n".
                                                                   '            <p class="source_citation">'."\n".
                                                                   '                %source%'."\n".
                                                                   '            </p>'."\n".
                                                                   '        </div>'."\n".
                                                                   '    </div>'."\n".
                                                                   '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['liensauteurs'] as $aLiensAuteurs) {
                                              if ($iCpt++ >= 2 AND !$bDejaBouton) {
                                                echo '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_liens_auteurs" aria-expanded="false" aria-controls="contenu_cache_liens_auteurs">Afficher tous les liens ('.count($aOeuvre['liensauteurs']).')</button>'."\n".
                                                     '<div class="contenu_cache_liens_auteurs collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              $aRecherche = array('%date%', '%auteur%', '%citation%', '%source%');
                                              $aRemplace = array($aLiensAuteurs['dDate'], $aLiensAuteurs['auteurCompare'], nl2br($aLiensAuteurs['citation']), $aLiensAuteurs['source']);
                                              echo str_replace($aRecherche, $aRemplace, $strTmplLiensAuteurs);
                                            }
                                            if ($bDejaBouton) echo '</div>'."\n";
                                          } else {
                                            echo 'Aucun lien'."\n";
                                          }
                                        ?>
                                    </div>
                                    <!-- FIN Liens avec d'autres auteurs -->
                                    <!-- TRADUCTIONS -->
                                    <h4 class="sous_rubrique">Traductions & adaptations</h4>
                                    <div class="semi_souligne"></div>
                                    <h5 class="sous_sous_rubrique">Traductions</h5>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['traductions'])) {
                                            $strTmplTraduction = '<div class="container_citation col-md-12">'."\n".
                                                                 '    <div class="citation col-md-12">'."\n".
                                                                 '        <div class="col_gauche_citation">'."\n".
                                                                 '            <div class="date_div">'."\n".
                                                                 '            <p class="saut_de_ligne_date">&nbsp;</p>'."\n".
                                                                 '            <p class="date_citation col_gauche_citation">%date%</p>'."\n".
                                                                 '            </div>'."\n".
                                                                 '            <img class="quotes_sans_date" src="images/world.svg">'."\n".
                                                                 '            <div class="trait_vertical_citation_date"></div>'."\n".
                                                                 '        </div>'."\n".
                                                                 '        <div class="col_droite_citation">'."\n".
                                                                 '            <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                                 '            <p class="text_citation minimize">'."\n".
                                                                 '                %titre%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="source_citation">'."\n".
                                                                 '                %source%'."\n".
                                                                 '            </p>'."\n".
                                                                 '        </div>'."\n".
                                                                 '    </div>'."\n".
                                                                 '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['traductions'] as $aTraduction) {
                                              if ($iCpt++ >= 2 AND !$bDejaBouton) {
                                                echo '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_traductions" aria-expanded="false" aria-controls="contenu_cache_traductions">Afficher toutes les traductions ('.count($aOeuvre['traductions']).')</button>'."\n".
                                                     '<div class="contenu_cache_traductions collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              $strSource = $strPlus = '';
                                              if (!empty($aTraduction['langue'])) {
                                                $strSource = $aTraduction['langue'];
                                                $strPlus = ' - ';
                                              }
                                              if (!empty($aTraduction['lieu'])) {
                                                $strSource .= $strPlus.$aTraduction['lieu'];
                                                $strPlus = ' - ';
                                              }
                                              if (!empty($aTraduction['editeur'])) {
                                                $strSource .= $strPlus.$aTraduction['editeur'];
                                                $strPlus = ' - ';
                                              }
                                              if (!empty($aTraduction['traducteur'])) {
                                                $strSource .= $strPlus.'trad. '.$aTraduction['traducteur'];
                                                $strPlus = ' - ';
                                              }
                                              $aRecherche = array('%date%', '%titre%', '%source%');
                                              $aRemplace = array($aTraduction['dDate'], nl2br($aTraduction['titre']), $strSource);
                                              echo str_replace($aRecherche, $aRemplace, $strTmplTraduction);
                                            }
                                            if ($bDejaBouton) echo '</div>'."\n";
                                          } else {
                                            echo 'Aucune traduction'."\n";
                                          }
                                        ?>
                                    </div>
                                    <!-- FIN TRADUCTIONS -->
                                    <!-- Adaptations -->
                                    <h5 class="sous_sous_rubrique">Adaptations</h5>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['adaptations'])) {
                                            $strTmplAdaptation = '<div class="container_citation col-md-12">'."\n".
                                                                 '    <div class="citation col-md-12">'."\n".
                                                                 '        <div class="col_gauche_citation">'."\n".
                                                                 '            <div class="date_div">'."\n".
                                                                 '            <p class="saut_de_ligne_date">&nbsp;</p>'."\n".
                                                                 '            <p class="date_citation col_gauche_citation">%date%</p>'."\n".
                                                                 '            </div>'."\n".
                                                                 '            <img class="quotes_sans_date" src="images/%srcimage%">'."\n".
                                                                 '            <div class="trait_vertical_citation_date"></div>'."\n".
                                                                 '        </div>'."\n".
                                                                 '        <div class="col_droite_citation">'."\n".
                                                                 '            <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                                 '            <p class="text_citation minimize">'."\n".
                                                                 '                %titre%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="source_citation">'."\n".
                                                                 '                %source%'."\n".
                                                                 '            </p>'."\n".
                                                                 '        </div>'."\n".
                                                                 '    </div>'."\n".
                                                                 '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['adaptations'] as $aAdaptation) {
                                              if ($iCpt++ >= 2 AND !$bDejaBouton) {
                                                echo '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_adaptations" aria-expanded="false" aria-controls="contenu_cache_adaptations">Afficher toutes les adaptations ('.count($aOeuvre['adaptations']).')</button>'."\n".
                                                     '<div class="contenu_cache_adaptations collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              $strSource = $strPlus = '';
                                              if (!empty($aAdaptation['nature'])) {
                                                $strSource = $aAdaptation['nature'];
                                                $strPlus = ' - ';
                                              }
                                              if (!empty($aAdaptation['auteur'])) {
                                                $strSource .= $strPlus.$aAdaptation['auteur'];
                                                $strPlus = ' - ';
                                              }
                                              if (!empty($aAdaptation['commentaire'])) {
                                                $strSource .= $strPlus.$aAdaptation['commentaire'];
                                                $strPlus = ' - ';
                                              }
                                              $aRecherche = array('%date%', '%srcimage%', '%titre%', '%source%');
                                              $aRemplace = array($aAdaptation['dDate'], getValSrcImgAdaptation($aAdaptation['nature']), nl2br($aAdaptation['titre']), $strSource);
                                              echo str_replace($aRecherche, $aRemplace, $strTmplAdaptation);
                                            }
                                            if ($bDejaBouton) echo '</div>'."\n";
                                          } else {
                                            echo 'Aucune adaptation'."\n";
                                          }
                                        ?>
                                    </div>
                                    <!-- FIN Adaptations -->
                                </div>
                            </div>
                            <!-- FIN EDITIONS RECEPTION -->
                            <!-- POETIQUE -->
                            <div class="poetique col-sm-12">
                                <div class="d-flex">
                                    <div class="symbole_paragraphe d-flex"></div>
                                    <h3 id="titre_poetique" class="titres_fiche d-flex">Poétique</h3>
                                </div>
                                <div class="contenu_decale">
                                    <!-- NARRATION -->
                                    <h4 class="sous_rubrique">Narration</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="liste_narration">
                                        <ul>
                                        <?php
                                          if ($aOeuvre['oeuvre']['narrationP1'] == 1) echo '<li>Narration à la 1<sup>ère</sup> personne</li>'."\n";
                                          if ($aOeuvre['oeuvre']['narrationP3'] == 1) echo '<li>Narration à la 3<sup>ème</sup> personne</li>'."\n";
                                          if ($aOeuvre['oeuvre']['narrationMulti'] == 1) echo '<li>Narrateurs multiples</li>'."\n";
                                          if ($aOeuvre['oeuvre']['narrationEnchassee'] == 1) echo '<li>Narration enchâssée</li>'."\n";
                                          if (!empty($aOeuvre['oeuvre']['narrationCom'])) echo '<li>Commentaire : '.$aOeuvre['oeuvre']['narrationCom'].'</li>'."\n";
                                        ?>
                                        </ul>
                                    </div>
                                    <!-- FIN NARRATION -->
                                    <!-- REGISTRES -->
                                    <h4 id="titre_poetique_registre" class="sous_rubrique">Registres</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="liste_encadree col-md-12 col-sm-12">
                                      <?php
                                        $iColEncadre = (empty($aOeuvre['registres']) OR count($aOeuvre['registres']) <= 1) ? 12 : 6;
                                        echo '<div class="colonne_encadree col-md-'.$iColEncadre.' col-sm-'.$iColEncadre.'" style="padding-left:0px">'."\n".
                                             '    <ul style="padding-left:0px">'."\n";
                                        if (!empty($aOeuvre['registres'])) {
                                          // On détermine le nombre de lignes par colonne
                                          $iNbLigne = intdiv(count($aOeuvre['registres']), 2);
                                          if (count($aOeuvre['registres']) % 2 === 0) $iNbLigne--;
                                          $iCpt = 0;
                                          $b2Ligne = FALSE;
                                          foreach ($aOeuvre['registres'] as $aRegistre) {
                                            $iCpt++;
                                            echo '<li>'.$aRegistre['libelle'].'</li>'."\n";
                                            if ($iCpt > $iNbLigne AND !$b2Ligne) {
                                              echo '     </ul>'."\n".
                                                   ' </div>'."\n".
                                                   ' <div class="colonne_encadree col-md-'.$iColEncadre.' col-sm-'.$iColEncadre.'">'."\n".
                                                   '     <ul>'."\n";
                                              $b2Ligne = TRUE;
                                            }
                                          }
                                        } else {
                                          echo '<li>Aucun registre</li>';
                                        }
                                      ?>
                                            </ul>
                                        </div>
                                        <img class="speech-bubble" src="images/speech-bubble.svg">
                                    </div>
                                    <!-- FIN REGISTRES -->
                                    <!-- PERSONNAGES -->
                                    <h4 class="sous_rubrique">Personnages</h4>
                                    <div class="semi_souligne"></div>
                                    <!-- PERSONNAGES SCIENTIFIQUES-->
                                    <h5 class="sous_sous_rubrique">Personnages scientifiques</h5>
                                        <?php
                                        if (!empty($aOeuvre['personnages']['F'])) {
                                          $iCpt = 0;
                                          $bDejaBouton = FALSE;
                                          $strTmplPersonnage = '<div class="liste_personnages col-md-12 col-sm-12">'."\n".
                                                               '    <div class="colonne_perso id_perso col-md-6 col-sm-12">'."\n".
                                                               '        <h6 class="nom_perso">%nom%</h6>'."\n".
                                                               '        <p class="discipline_perso">%profession%</p>'."\n".
                                                               '        <div class="divider_hori_perso"></div>'."\n".
                                                               '        <p class="rang_perso">%rang%</p>'."\n".
                                                               '    </div>'."\n".
                                                               '    <div class="colonne_perso specs_perso col-md-6 col-sm-12">'."\n".
                                                               '        <p class="caracteristiques_perso">%caracteristique%</p>'."\n".
                                                               '    </div>'."\n".
                                                               '</div>'."\n";
                                          foreach($aOeuvre['personnages']['F'] as $aPersoSci){
                                            if ($iCpt++ == 2) {
                                              echo '<!-- TIROIR PERSONNAGES SCIENTIFIQUES-->'."\n".
                                                   '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_perso_scien" aria-expanded="false" aria-controls="contenu_cache_perso_scien">Afficher la liste ('.count($aOeuvre['personnages']['F']).')</button>'."\n".
                                                   '<div class="contenu_cache_perso_scien collapse">'."\n";
                                              $bDejaBouton = TRUE;
                                            }
                                            $aRecherche = array('%nom%', '%profession%', '%rang%', '%caracteristique%');
                                            $strPlus = $strProfession = '';
                                            if (!empty($aPersoSci['profession'])) {
                                              $strProfession = 'Profession : '.$aPersoSci['profession'];
                                              $strPlus = ' ';
                                            }
                                            $strPlus = $strPlus.'(';
                                            if (!empty($aPersoSci['discipline'])) {
                                              $strProfession = $strPlus.$aPersoSci['discipline'].')';
                                            }
                                            $strRang = '';
                                            $strPlus = 'Personnage ';
                                            if (!empty($aPersoSci['rang'])) {
                                              $strRang = $strPlus.getValCodeRangPers($aPersoSci['rang']);
                                              $strPlus = ' ';
                                            }
                                            if (!empty($aPersoSci['genre'])) {
                                              $strRang .= $strPlus.getValCodeGenrePers($aPersoSci['genre']);
                                            }
                                            $strPlus = ', ';
                                            if (!empty($aPersoSci['valorisation'])) {
                                              $strRang .= $strPlus.getValCodeValorisationPers($aPersoSci['valorisation']);
                                              $strPlus = ' ';
                                            }
                                            $strCaracteristique = $strPlus = '';
                                            if (!empty($aPersoSci['caracteristique'])) {
                                              $strCaracteristique .= $aPersoSci['caracteristique'];
                                              $strPlus = '<br />';
                                            }
                                            if (!empty($aPersoSci['alterite'])) {
                                              $strCaracteristique .= $strPlus.'Origine : '.getValCodeAlterite($aPersoSci['alterite']).'.';
                                              $strPlus = ' ';
                                            }
                                            if (!empty($aPersoSci['alteriteNom'])) {
                                              $strCaracteristique .= $strPlus.'Groupe : '.$aPersoSci['alteriteNom'];
                                            }
                                            $aRemplace = array($aPersoSci['nom'],
                                                               $strProfession,
                                                               $strRang,
                                                               $strCaracteristique);
                                            echo str_replace($aRecherche, $aRemplace, $strTmplPersonnage);
                                          }
                                          if ($bDejaBouton) echo '</div><!-- FIN PERSONNAGES SCIENTIFIQUES -->'."\n";
                                        }
                                        ?>
                                    <!-- FIN TIROIR PERSONNAGES SCIENTIFIQUES-->
                                    <!-- AUTRES PERSONNAGES -->
                                    <h5 class="sous_sous_rubrique">Autres personnages</h5>
                                        <?php
                                        if (!empty($aOeuvre['personnages']['autres'])) {
                                          $iCpt = 0;
                                          $bDejaBouton = FALSE;
                                          $strTmplPersonnage = '<div class="liste_personnages col-md-12 col-sm-12">'."\n".
                                                               '    <div class="colonne_perso id_perso col-md-6 col-sm-12">'."\n".
                                                               '        <h6 class="nom_perso">%nom%</h6>'."\n".
                                                               '        <p class="discipline_perso">%profession%</p>'."\n".
                                                               '        <div class="divider_hori_perso"></div>'."\n".
                                                               '        <p class="rang_perso">%rang%</p>'."\n".
                                                               '    </div>'."\n".
                                                               '    <div class="colonne_perso specs_perso col-md-6 col-sm-12">'."\n".
                                                               '        <p class="caracteristiques_perso">%caracteristique%</p>'."\n".
                                                               '    </div>'."\n".
                                                               '</div>'."\n";
                                          foreach($aOeuvre['personnages']['autres'] as $aPersoAutre){
                                            if ($iCpt++ == 2) {
                                              echo '<!-- TIROIR AUTRES PERSONNAGES -->'."\n".
                                                   '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_autre_perso" aria-expanded="false" aria-controls="contenu_cache_autre_perso">Afficher la liste ('.count($aOeuvre['personnages']['autres']).')</button>'."\n".
                                                   '<div class="contenu_cache_autre_perso collapse">'."\n";
                                              $bDejaBouton = TRUE;
                                            }
                                            $aRecherche = array('%nom%', '%profession%', '%rang%', '%caracteristique%');
                                            $strPlus = $strProfession = '';
                                            if (!empty($aPersoAutre['profession'])) {
                                              $strProfession = 'Profession : '.$aPersoAutre['profession'];
                                              $strPlus = ' ';
                                            }
                                            $strPlus = $strPlus.'(';
                                            if (!empty($aPersoAutre['discipline'])) {
                                              $strProfession = $strPlus.$aPersoAutre['discipline'].')';
                                            }
                                            $strRang = '';
                                            $strPlus = 'Personnage ';
                                            if (!empty($aPersoAutre['type'])) {
                                              $strRang = $strPlus.getValCodeRangPers($aPersoAutre['type']);
                                              $strPlus = ' ';
                                            }
                                            if (!empty($aPersoAutre['genre'])) {
                                              $strRang .= $strPlus.getValCodeGenrePers($aPersoAutre['genre']);
                                            }
                                            $strPlus = ', ';
                                            if (!empty($aPersoAutre['valorisation'])) {
                                              $strRang .= $strPlus.getValCodeValorisationPers($aPersoAutre['valorisation']);
                                              $strPlus = ' ';
                                            }
                                            $strCaracteristique = $strPlus = '';
                                            if (!empty($aPersoAutre['caracteristique'])) {
                                              $strCaracteristique .= $aPersoAutre['caracteristique'];
                                              $strPlus = '<br />';
                                            }
                                            if (!empty($aPersoAutre['alterite'])) {
                                              $strCaracteristique .= $strPlus.'Origine : '.getValCodeAlterite($aPersoAutre['alterite']).'.';
                                              $strPlus = ' ';
                                            }
                                            if (!empty($aPersoAutre['alteriteNom'])) {
                                              $strCaracteristique .= $strPlus.'Groupe : '.$aPersoAutre['alteriteNom'];
                                            }
                                            $aRemplace = array($aPersoAutre['nom'],
                                                               $strProfession,
                                                               $strRang,
                                                               $strCaracteristique);
                                            echo str_replace($aRecherche, $aRemplace, $strTmplPersonnage);
                                          }
                                          if ($bDejaBouton) echo '</div><!-- FIN TIROIR AUTRES PERSONNAGES -->'."\n";
                                        }
                                        ?>
                                    <!-- FIN AUTRES PERSONNAGES -->
                                    <!-- FIN PERSONNAGES -->
                                    <!--REFERENCES INTERTEXTUELLES -->
                                    <h4 class="sous_rubrique">Références intertextuelles</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['references'])) {
                                            $strTmplRefInter = '<div class="container_citation col-md-12">'."\n".
                                                               '    <div class="citation col-md-12">'."\n".
                                                               '        <div class="col_gauche_citation col_gauche_citation_sans_date">'."\n".
                                                               '            <img class="quotes_sans_date" src="images/quotes.svg">'."\n".
                                                               '            <div class="trait_vertical_citation_sans_date"></div>'."\n".
                                                               '        </div>'."\n".
                                                               '        <div class="col_droite_citation col_droite_citation_sans_date">'."\n".
                                                               '            <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                               '            <p class="text_reference minimize">'."\n".
                                                               '                %reference%'."\n".
                                                               '            </p>'."\n".
                                                               '            <p class="citation_reference">'."\n".
                                                               '                %citation%'."\n".
                                                               '            </p>'."\n".
                                                               '            <p class="source_citation">'."\n".
                                                               '                Page %page% ('.$strEditionEtudiee.')'."\n".
                                                               '            </p>'."\n".
                                                               '        </div>'."\n".
                                                               '    </div>'."\n".
                                                               '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['references'] as $aReference) {
                                              if ($iCpt++ >= 2 AND !$bDejaBouton) {
                                                echo '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_references" aria-expanded="false" aria-controls="contenu_cache_references">Afficher toutes les références intertextuelles ('.count($aOeuvre['references']).')</button>'."\n".
                                                     '<div class="contenu_cache_references collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              $strPlus = '';
                                              if (!empty($aReference['auteur'])) {
                                                $strReference = $strPlus.$aReference['auteur'];
                                                $strPlus = ' - ';
                                              }
                                              if (!empty($aReference['titre'])) {
                                                $strReference .= $strPlus.$aReference['titre'];
                                              }
                                              $strCitation = '';
                                              if (!empty($aReference['citation'])) {
                                                $strCitation = '"'.nl2br($aReference['citation']).'"';
                                              }
                                              $aRecherche = array('%reference%', '%citation%', '%page%');
                                              $aRemplace = array($strReference, $strCitation, $aReference['page']);
                                              echo str_replace($aRecherche, $aRemplace, $strTmplRefInter);
                                            }
                                            if ($bDejaBouton) echo '</div>'."\n";
                                          } else {
                                            echo 'Aucune référence'."\n";
                                          }
                                        ?>
                                    </div>
                                    <!--FIN REFERENCES INTERTEXTUELLES -->
                                </div>
                            </div>
                            <!-- FIN POETIQUE --> 
                            <!-- CADRE SPATIO-TEMPOREL -->
                            <div class="cadre_s_t col-sm-12">
                                <div class="d-flex">
                                    <div class="symbole_paragraphe d-flex"></div>
                                    <h3 id="titre_cadre_s_t" class="titres_fiche d-flex">Cadre spatio-temporel</h3>
                                </div>
                                <div class="contenu_decale">
                                    <!-- LIEUX -->
                                    <h4 id="titre_cadre_s_t_lieu" class="sous_rubrique">Lieux</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="liste_encadree col-md-12 col-sm-12">
                                        <?php
                                        $iColEncadre = (empty($aOeuvre['lieux']) OR count($aOeuvre['lieux']) <= 1) ? 12 : 6;
                                        echo '<div class="colonne_encadree col-md-'.$iColEncadre.' col-sm-'.$iColEncadre.'" style="padding-left:0px">'."\n".
                                             '    <ul style="padding-left:0px">'."\n";
                                          if (!empty($aOeuvre['lieux'])) {
                                            // On détermine le nombre de lignes par colonne
                                            $iNbLigne = intdiv(count($aOeuvre['lieux']), 2);
                                            if (count($aOeuvre['lieux']) % 2 === 0) $iNbLigne--;
                                            $iCpt = 0;
                                            $b2Ligne = FALSE;
                                            foreach ($aOeuvre['lieux'] as $aLieu) {
                                              $iCpt++;
                                              echo '<li>'.$aLieu['libelle'].'</li>'."\n";
                                              if ($iCpt > $iNbLigne AND !$b2Ligne) {
                                                echo '     </ul>'."\n".
                                                     ' </div>'."\n".
                                                     ' <div class="colonne_encadree col-md-'.$iColEncadre.' col-sm-'.$iColEncadre.'">'."\n".
                                                     '     <ul>'."\n";
                                                $b2Ligne = TRUE;
                                              }
                                            }
                                          } else {
                                            echo '<li>Aucun lieu</li>';
                                          }
                                        ?>
                                            </ul>
                                        </div>
                                        <img class="speech-bubble" src="images/placeholder.svg">
                                    </div>
                                    <!-- FIN LIEUX -->
                                    <!-- TEMPS -->
                                    <h4 id="titre_cadre_s_t_temps" class="sous_rubrique">Temps</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="liste_encadree col-md-12 col-sm-12"><div class="row">
                                              <?php
                                                if (!empty($aOeuvre['ecartstempos'])) {
                                                  $iColEncadre = count($aOeuvre['ecartstempos']) <= 1 ? 12 : 6;
                                                  $strTmplCadreTempo = '<div class="colonne_encadree col-md-'.$iColEncadre.' col-sm-'.$iColEncadre.'" style="padding-left:0px;%margin%">'."\n".
                                                                       '  <ul style="padding-left:0px">'."\n".
                                                                       '    <li> Date : %typeDate%</li>'."\n".
                                                                       // '    <li> Date de début : %dateDeb%</li>'."\n".
                                                                       // '    <li> Date de fin : %dateFin%</li>'."\n".
                                                                       '    <li><div class="row">'."\n".
                                                                       '      <div class="col-md-3 col-md-offset-3">Date de début : %dateDeb%</div>'."\n".
                                                                       '      <div class="col-md-3">Date de fin : %dateFin%</div>'."\n".
                                                                       '    </div></li>'."\n".
                                                                       '    <li> Durée : %duree%</li>'."\n".
                                                                       '    <li> Écart temporel de l’intrigue par rapport à l’année de première publication : %ecart%</li>'."\n".
                                                                       '  </ul>'."\n".
                                                                       '</div>'."\n";
                                                  // On détermine le nombre de lignes par colonne
                                                  // if (count($aOeuvre['ecartstempos']) % 2 === 0) $iNbLigne--;
                                                  $iCpt = 0;
                                                  $strEcart = $strDuree = $strDateDeb = $strDateFin = $strTypeDate = '';
                                                  $strMargin = 'margin:0px;';
                                                  foreach ($aOeuvre['ecartstempos'] as $aEcartTempo) {
                                                    if ($iCpt != 0 AND $iCpt % 2 === 0) {
                                                      echo '</div>'."\n".
                                                           '<hr>'."\n".
                                                           '<div class="row">'."\n";
                                                    }
                                                    $iCpt++;
                                                    $strTypeDate = getValCodeTypeDateCSP($aEcartTempo['typeDate']);
                                                    $strDateDeb = $aEcartTempo['dateDeb'];
                                                    $strDateFin = $aEcartTempo['dateFin'];
                                                    $strDuree = $aEcartTempo['duree'];
                                                    $strEcart = getValCodeEcartCSP($aEcartTempo['ecart']);

                                                    $aRecherche = array('%margin%', '%typeDate%', '%dateDeb%', '%dateFin%', '%duree%', '%ecart%');
                                                    $aRemplace = array($strMargin, $strTypeDate, $strDateDeb, $strDateFin, $strDuree, $strEcart);
                                                    echo str_replace($aRecherche, $aRemplace, $strTmplCadreTempo);
                                                    $strMargin = '';
                                                  }
                                                } else {
                                                  echo '<div class="colonne_encadree col-md-12 col-sm-12" style="padding-left:0px">Aucun écart temporel</div>';
                                                }
                                                echo '</div><div class="row">'."\n".
                                                     '<div class="colonne_encadree col-md-12 col-sm-12" style="padding-left:0px">'."\n".
                                                     '  <ul style="padding-left:0px">'."\n".
                                                     '    <hr>'."\n".
                                                     '    <li> Rapport au temps : '.'</li>'."\n".
                                                     '  </ul>'."\n".
                                                     '</div>'."\n".
                                                     '</div><div class="row">'."\n";
                                                if (!empty($aOeuvre['rapporttempo'])) {
                                                  $iColEncadre = count($aOeuvre['rapporttempo']) <= 1 ? 12 : 6;
                                                  // On détermine le nombre de lignes par colonne
                                                  $iNbLigne = intdiv(count($aOeuvre['rapporttempo']), 2);
                                                  if (count($aOeuvre['rapporttempo']) % 2 === 0) $iNbLigne--;
                                                  $iCpt = 0;
                                                  $b2Ligne = FALSE;
                                                  $strPlus = '';
                                                  echo '<div class="colonne_encadree col-md-'.$iColEncadre.' col-sm-'.$iColEncadre.'" style="padding-left:0px">'."\n".
                                                       '  <ul style="padding-left:0px">'."\n";
                                                  foreach ($aOeuvre['rapporttempo'] as $aRapportTemps) {
                                                    $iCpt++;
                                                    echo '<li>'.$aRapportTemps['libelle'].'</li>'."\n";
                                                    if ($iCpt > $iNbLigne AND !$b2Ligne) {
                                                      echo '  </ul>'."\n".
                                                           '</div>'."\n".
                                                           '<div class="colonne_encadree col-md-'.$iColEncadre.' col-sm-'.$iColEncadre.'" style="padding-left:0px">'."\n".
                                                           '  <ul style="padding-left:0px">'."\n";
                                                      $b2Ligne = TRUE;
                                                    }
                                                  }
                                                  echo '</ul></div>'."\n";
                                                } else {
                                                  echo '<div class="colonne_encadree col-md-12 col-sm-12" style="padding-left:0px">Aucun rapport au temps</div>'."\n";
                                                }
                                              ?>
                                        </div>
                                        <img class="speech-bubble" src="images/time.svg">
                                    </div>
                                    <!-- FIN TEMPS -->
                                    <!-- VOYAGES -->
                                    <h4 id="titre_cadre_s_t_voyage" class="sous_rubrique">Voyages</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="liste_encadree col-md-12 col-sm-12">
                                      <?php
                                        $iColEncadre = (empty($aOeuvre['voyages']) OR count($aOeuvre['voyages']) <= 1) ? 12 : 6;
                                        echo '<div class="colonne_encadree col-md-'.$iColEncadre.' col-sm-'.$iColEncadre.'" style="padding-left:0px">'."\n".
                                             '    <ul style="padding-left:0px">'."\n";
                                        if (!empty($aOeuvre['voyages'])) {
                                          // On détermine le nombre de lignes par colonne
                                          $iNbLigne = intdiv(count($aOeuvre['voyages']), 2);
                                          if (count($aOeuvre['voyages']) % 2 === 0) $iNbLigne--;
                                          $iCpt = 0;
                                          $b2Ligne = FALSE;
                                          foreach ($aOeuvre['voyages'] as $aRegistre) {
                                            $iCpt++;
                                            echo '<li>'.$aRegistre['libelle'].'</li>'."\n";
                                            if ($iCpt > $iNbLigne AND !$b2Ligne) {
                                              echo '     </ul>'."\n".
                                                   ' </div>'."\n".
                                                   ' <div class="colonne_encadree col-md-'.$iColEncadre.' col-sm-'.$iColEncadre.'">'."\n".
                                                   '     <ul>'."\n";
                                              $b2Ligne = TRUE;
                                            }
                                          }
                                        } else {
                                          echo '<li>Aucun voyage</li>';
                                        }
                                      ?>
                                            </ul>
                                        </div>
                                        <img class="speech-bubble" src="images/travel.svg">
                                    </div>
                                    <!-- FIN VOYAGES -->
                                </div>
                            </div>
                            <!-- FIN CADRE SPATIO-TEMPOREL --> 
                            <!-- SCIENCES -->
                            <div class="sciences col-sm-12">
                                <div class="d-flex">
                                    <div class="symbole_paragraphe d-flex"></div>
                                    <h3 id="titre_sciences" class="titres_fiche d-flex">Sciences</h3>
                                </div>
                                <div class="contenu_decale">
                                    <!--Disciplines -->
                                    <h4 id="titre_sciences_disciplines" class="sous_rubrique">
                                      Disciplines
                                      <?php // <img class="img_infobulle" src="images/information.svg" data-toggle="tooltip" data-placement="top" data-original-title="Disciplines scientifiques jouant un rôle important dans le récit"> ?>
                                      <img id="poDisciplines" class="img_infobulle" src="images/information.svg" data-toggle="popover" data-placement="top" data-content="Disciplines scientifiques jouant un rôle important dans le récit" data-trigger="hover">
                                      <script type="text/javascript"> $('#poDisciplines').popover(); </script>
                                    </h4>
                                    <div class="semi_souligne"></div>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['disciplines'])) {
                                            $strTmplDiscipline = '<div class="container_citation col-md-12">'."\n".
                                                                 '    <div class="citation col-md-12">'."\n".
                                                                 '        <div class="col_gauche_citation col_gauche_citation_sans_date">'."\n".
                                                                 '            <img class="quotes_sans_date" src="images/%srcimage%">'."\n".
                                                                 '            <div class="trait_vertical_citation_sans_date"></div>'."\n".
                                                                 // '%plusdune%'."\n".
                                                                 '        </div>'."\n".
                                                                 '        <div class="col_droite_citation col_droite_citation_sans_date">'."\n".
                                                                 '            <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                                 '            <p class="text_reference minimize">'."\n".
                                                                 '                %topDiscipline%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="source_citation">'."\n".
                                                                 '                %disciplines%'."\n".
                                                                 '            </p>'."\n".
                                                                 '        </div>'."\n".
                                                                 '    </div>'."\n".
                                                                 '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            $iMemoGroupe = -1;
                                            $strTopDiscipline = $strDisciplines = $strPlus = $strPlusTop = '';
                                            foreach ($aOeuvre['disciplines'] as $aDiscipline) {
                                              // Comparaison du groupe avec celui mémorisé
                                              $bEnCours = FALSE;
                                              if ($iMemoGroupe == -1) {
                                                $iMemoGroupe = $aDiscipline['groupe'];
                                                $bEnCours = TRUE;
                                              } else if ($iMemoGroupe != $aDiscipline['groupe']) {
                                                // Nouveau groupe: affichage du précédent et mémorisation du groupe
                                                $iMemoGroupe = $aDiscipline['groupe'];
                                                // $aRecherche = array('%srcimage%', '%plusdune%', '%topDiscipline%', '%disciplines%');
                                                // $aRemplace = array($strImage, $strPlusDUne, $strTopDiscipline, $strDisciplines);
                                                $aRecherche = array('%srcimage%', '%topDiscipline%', '%disciplines%');
                                                $aRemplace = array($strImage, $strTopDiscipline, $strDisciplines);
                                                // Si on a plus de 4 disciplines, on les masque (elles seront visibles en cliquant sur le bouton)
                                                if ($iCpt++ >= 3 AND !$bDejaBouton) {
                                                  echo '<button id="btnClpsDisciplines" class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_disciplines" aria-expanded="false" aria-controls="contenu_cache_disciplines">Afficher toutes les disciplines</button>'."\n".
                                                       '<div class="contenu_cache_disciplines collapse">'."\n";
                                                  $bDejaBouton = TRUE;
                                                }
                                                echo str_replace($aRecherche, $aRemplace, $strTmplDiscipline);
                                                // $iMemoGroupe = -1;
                                                // $strPlusDUne = $strTopDiscipline = $strDisciplines = $strPlus = $strPlusTop = '';
                                                $strTopDiscipline = $strDisciplines = $strPlus = $strPlusTop = '';
                                              } else {
                                                $bEnCours = TRUE;
                                              }
                                              if ($aDiscipline['top'] == 1) {
                                                // Normalement, un seul top... mais on sait jamais ;)
                                                $strTopDiscipline .= $strPlusTop.$aDiscipline['libelle'];
                                                $strPlusTop = '<br />';
                                                $strImage = getValSrcImgDiscipline($aDiscipline['groupe']);
                                              } else {
                                                $strDisciplines .= $strPlus.$aDiscipline['libelle'];
                                                $strPlus = '<br />';
                                                // $strPlusDUne = '            <div class="trait_vertical_citation_sans_date"></div>'."\n";
                                              }
                                            }
                                            if ($bEnCours) {
                                              $aRecherche = array('%srcimage%', '%topDiscipline%', '%disciplines%');
                                              $aRemplace = array($strImage, $strTopDiscipline, $strDisciplines);
                                              // Si on a plus de 4 disciplines, on les masque (elles seront visibles en cliquant sur le bouton)
                                              if ($iCpt++ >= 3 AND !$bDejaBouton) {
                                                echo '<button id="btnClpsDisciplines" class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_disciplines" aria-expanded="false" aria-controls="contenu_cache_disciplines">Afficher toutes les disciplines</button>'."\n".
                                                     '<div class="contenu_cache_disciplines collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              echo str_replace($aRecherche, $aRemplace, $strTmplDiscipline);
                                            }
                                            if ($bDejaBouton) {
                                              echo '</div>'."\n";
                                              $strJScriptPlus .= '$(\'#btnClpsDisciplines\').append(" ('.$iCpt.')");'."\n";
                                            }
                                          } else {
                                            echo 'Aucune discipline';
                                          }
                                        ?>
                                    </div>
                                    <!--FIN DISCIPLINES -->
                                    <!--Élements scientifiques réels -->
                                    <h4 class="sous_rubrique">Élements scientifiques réels</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['eltsSciReels'])) {
                                            $strTmplEltSciReel = '<div class="container_citation col-md-12">'."\n".
                                                                 '    <div class="citation col-md-12">'."\n".
                                                                 '        <div class="col_gauche_citation col_gauche_citation_sans_date">'."\n".
                                                                 '            <img class="quotes_sans_date" src="images/%srcimage%">'."\n".
                                                                 '            <div class="trait_vertical_citation_sans_date"></div>'."\n".
                                                                 '        </div>'."\n".
                                                                 '        <div class="col_droite_citation col_droite_citation_sans_date">'."\n".
                                                                 '            <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                                 '            <p class="text_reference minimize">'."\n".
                                                                 '                %reference%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="sciences_citation minimize">'."\n".
                                                                 '                %citation%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="source_citation">'."\n".
                                                                 '                %discipline%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="source_citation">'."\n".
                                                                 '                %modalite%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="numero_page minimize">'."\n".
                                                                 '                %page%'."\n".
                                                                 '            </p>'."\n".
                                                                 '        </div>'."\n".
                                                                 '    </div>'."\n".
                                                                 '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['eltsSciReels'] as $aEltSciReel) {
                                              // Si on a plus de 4 disciplines, on les masque (elles seront visibles en cliquant sur le bouton)
                                              if ($iCpt++ >= 4 AND !$bDejaBouton) {
                                                echo '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_elem_scien_reel" aria-expanded="false" aria-controls="contenu_cache_elem_scien_reel">Afficher tous les éléments ('.count($aOeuvre['eltsSciReels']).')</button>'."\n".
                                                     '<div class="contenu_cache_elem_scien_reel collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              $strCitation = $strDiscipline = $strModalite = $strPage = $strReference = $strPlus = '';
                                              if (!empty($aEltSciReel['personnalite'])) {
                                                $strReference = $aEltSciReel['personnalite'];
                                                $strPlus = ' - ';
                                              }
                                              if (!empty($aEltSciReel['theorie'])) {
                                                $strReference .= $strPlus.$aEltSciReel['theorie'];
                                              }
                                              if (!empty($aEltSciReel['citation'])) {
                                                $strCitation = $aEltSciReel['citation'];
                                              }
                                              if (!empty($aEltSciReel['discipline'])) {
                                                $strDiscipline = getValCodeRefAuReelDiscipline($aEltSciReel['discipline']);
                                              }
                                              if (!empty($aEltSciReel['modalite'])) {
                                                $strModalite = getValCodeRefAuReelModalite($aEltSciReel['modalite']);
                                              }
                                              if (!empty($aEltSciReel['page'])) {
                                                $strPage = 'Page '.$aEltSciReel['page'];
                                              }
                                              $aRecherche = array('%srcimage%', '%reference%', '%citation%', '%discipline%', '%modalite%', '%page%');
                                              $aRemplace = array(getValSrcImgEltSciReel($aEltSciReel['discipline']), $strReference, $strCitation, $strDiscipline, $strModalite, $strPage);
                                              echo str_replace($aRecherche, $aRemplace, $strTmplEltSciReel);
                                            }
                                            if ($bDejaBouton) echo '</div>'."\n";
                                          } else {
                                            echo 'Aucun élément scientifique réel';
                                          }
                                        ?>
                                    </div>
                                    <!--FIN Élements scientifiques réels -->
                                    <!--Élements scientifiques imaginaires -->
                                    <h4 id="titre_sciences_elt_sci_magin" class="sous_rubrique">Élements scientifiques imaginaires</h4>
                                    <div class="semi_souligne"></div>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['eltsSciImg'])) {
                                            $strTmplEltSciImagin = '<div class="citation col-md-12">'."\n".
                                                                   '    <div class="col_gauche_citation col_gauche_citation_sans_date">'."\n".
                                                                   // '        <img class="quotes_sans_date" src="images/%srcimage%">'."\n".
                                                                   '%imgIcones%'.
                                                                   '        <div class="trait_vertical_citation_sans_date"></div>'."\n".
                                                                   '    </div>'."\n".
                                                                   '    <div class="col_droite_citation col_droite_citation_sans_date">'."\n".
                                                                   '        <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                                   '        <p class="text_reference minimize">'."\n".
                                                                   '            %reference%'."\n".
                                                                   '        </p>'."\n".
                                                                   '        <p class="description_elem_scien">'."\n".
                                                                   '            %description%'."\n".
                                                                   '        </p>'."\n".
                                                                   '        <p class="cat_elem_scien">'."\n".
                                                                   '            %categorie%'."\n".
                                                                   '        </p>'."\n".
                                                                   '        <p class="page_référence">'."\n".
                                                                   '            %page%'."\n".
                                                                   '        </p>'."\n".
                                                                   '    </div>'."\n".
                                                                   '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['eltsSciImg'] as $aEltSciImg) {
                                              // Si on a plus de 4 disciplines, on les masque (elles seront visibles en cliquant sur le bouton)
                                              if ($iCpt++ >= 4 AND !$bDejaBouton) {
                                                echo '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_elem_scien_imag" aria-expanded="false" aria-controls="contenu_cache_elem_scien_imag">Afficher tous les éléments ('.count($aOeuvre['eltsSciImg']).')</button>'."\n".
                                                     '<div class="contenu_cache_elem_scien_imag collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              $strReference = $strDescription = $strImg = $strPage = '';
                                              if (!empty($aEltSciImg['nom'])) {
                                                $strReference = $aEltSciImg['nom'];
                                              }
                                              if (!empty($aEltSciImg['description'])) {
                                                $strDescription = nl2br($aEltSciImg['description']);
                                              }
                                              if (!empty($aEltSciImg['strCategories'])) {
                                                $strCategories = 'Catégorie '.$aEltSciImg['strCategories'];
                                                $aIdRef = explode('; ', $aEltSciImg['strIdRef']);
                                                foreach ($aIdRef as $idRef) {
                                                  $strImg .= '        <img class="quotes_sans_date" src="images/'.getValSrcImgEltSciImag($idRef).'">'."\n";
                                                  // Pour une question technique, il est mieux de n'afficher que la première image de catégorie, sinon, visuellement pas joli
                                                  break;
                                                }
                                              } else {
                                                  $strImg .= '        <img class="quotes_sans_date" src="images/'.getValSrcImgEltSciImag(0).'">'."\n";
                                              }
                                              if (!empty($aEltSciImg['page'])) {
                                                $strPage = 'Page '.$aEltSciImg['page'];
                                              }
                                              $aRecherche = array('%imgIcones%', '%reference%', '%description%', '%categorie%', '%page%');
                                              $aRemplace = array($strImg, $strReference, $strDescription, $strCategories, $strPage);
                                              echo str_replace($aRecherche, $aRemplace, $strTmplEltSciImagin);
                                            }
                                            if ($bDejaBouton) echo '</div>'."\n";
                                          } else {
                                            echo 'Aucun élément scientifique imaginaire';
                                          }
                                    ?>
                                    </div>
                                    <!--FIN Élements scientifiques imaginaires -->
                                </div>
                            </div>
                            <!-- FIN SCIENCES --> 
                            <!-- SOCIETE IMAGINAIRES -->
                            <div class="societe_imaginaires col-sm-12">
                                <div class="d-flex">
                                    <div class="symbole_paragraphe d-flex"></div>
                                    <h3 id="titre_societes_imaginaires" class="titres_fiche d-flex">Sociétés imaginaires</h3>
                                </div>
                                <div class="contenu_decale">
                                    <div class="semi_souligne"></div>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['societeImg'])) {
                                            $strLienTag = ' onClick="javascript:window.location.href=\'#idTagSocImg\'"';
                                            $strTmplSocieteImg = '<div id="idTagSocImg%idSocImg%" class="container_citation col-md-12">'."\n".
                                                                 '    <div class="citation citation_sans_icon col-md-12">'."\n".
                                                                 '        <div class="col_droite_citation col_droite_citation_sans_date_sans_icon">'."\n".
                                                                 '            <p class="text_reference minimize">'."\n".
                                                                 '                %nom%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="description_elem_scien">'."\n".
                                                                 '                %traitsSpecifiques%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="cat_elem_scien">'."\n".
                                                                 '                %degreTechno%'."\n".
                                                                 '            </p>'."\n".
                                                                 '            <p class="page_référence">'."\n".
                                                                 '                %valeur%'."\n".
                                                                 '            </p>'."\n".
                                                                 '        </div>'."\n".
                                                                 '    </div>'."\n".
                                                                 '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['societeImg'] as $aSocieteImg) {
                                              // Si on a plus de 3 sociétés, on les masque (elles seront visibles en cliquant sur le bouton)
                                              if ($iCpt++ >= 4 AND !$bDejaBouton) {
                                                echo '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_societe_imag" aria-expanded="false" aria-controls="contenu_cache_societe_imag">Afficher toutes les sociétés ('.count($aOeuvre['societeImg']).')</button>'."\n".
                                                     '<div class="contenu_cache_societe_imag collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              $strNom = $strTraitsSpecifiques = $strDegreTechno = $strValeur = '';
                                              if (!empty($aSocieteImg['nom'])) {
                                                $strNom = $aSocieteImg['nom'];
                                              }
                                              if (!empty($aSocieteImg['strTraitSpec'])) {
                                                $strTraitsSpecifiques = 'Traits spécifiques évoqués : '.$aSocieteImg['strTraitSpec'];
                                              }
                                              if (!empty($aSocieteImg['degreTechno'])) {
                                                $strDegreTechno = 'Degré de technologie : '.getValCodeSociDegreTechno($aSocieteImg['degreTechno']);
                                              }
                                              if (!empty($aSocieteImg['valeur'])) {
                                                $strValeur = 'Valeur : '.getValCodeSociValeur($aSocieteImg['valeur']);
                                              }
                                              $aRecherche = array('%idSocImg%', '%nom%', '%traitsSpecifiques%', '%degreTechno%', '%valeur%');
                                              $aRemplace = array($aSocieteImg['idSociete'], $strNom, $strTraitsSpecifiques, $strDegreTechno, $strValeur);
                                              echo str_replace($aRecherche, $aRemplace, $strTmplSocieteImg);
                                            }
                                            if ($bDejaBouton) echo '</div>'."\n";
                                          } else {
                                            echo 'Aucune société imaginaire';
                                          }
                                        ?>
                                    </div>      
                                </div>
                            </div>
                            <!-- FIN SOCIETE IMAGINAIRES -->
                            <!-- BIBLIOGRAPHIE -->
                            <div class="biblio col-sm-12">
                                <div class="d-flex">
                                    <div class="symbole_paragraphe d-flex"></div>
                                    <h3 id="titre_biblio" class="titres_fiche d-flex">Bibliographie</h3>
                                </div>
                                <div class="contenu_decale">
                                    <div class="semi_souligne"></div>
                                    <div class="chronologie">
                                        <?php
                                          if (!empty($aOeuvre['bibliographies'])) {
                                            $strTmplBiblio = '<div class="container_citation col-md-12">'."\n".
                                                             '    <div class="citation col-md-12">'."\n".
                                                             '        <div class="col_gauche_citation">'."\n".
                                                             '            <div class="date_div">'."\n".
                                                             '            <p class="saut_de_ligne_date">&nbsp;</p>'."\n".
                                                             '            <p class="date_citation col_gauche_citation">%date%</p>'."\n".
                                                             '            </div>'."\n".
                                                             '            <img class="quotes_sans_date" src="images/books.svg">'."\n".
                                                             '            <div class="trait_vertical_citation_date"></div>'."\n".
                                                             '        </div>'."\n".
                                                             '        <div class="col_droite_citation">'."\n".
                                                             '            <p class="saut_de_ligne">&nbsp;</p>'."\n".
                                                             '            <p class="text_reference minimize">%reference%</p>'."\n".
                                                             '            <p class="source_citation"><a class="liens_biblio" href="%lien%">%lien%</a></p>'."\n".
                                                             '        </div>'."\n".
                                                             '    </div>'."\n".
                                                             '</div>'."\n";
                                            $iCpt = 0;
                                            $bDejaBouton = FALSE;
                                            foreach ($aOeuvre['bibliographies'] as $aBibliographie) {
                                              // Si on a plus de 4 bibliographies, on les masque (elles seront visibles en cliquant sur le bouton)
                                              if ($iCpt++ >= 4 AND !$bDejaBouton) {
                                                echo '<button class="btn btn-danger btn-secondary" type="button" data-toggle="collapse" data-target=".contenu_cache_biblio" aria-expanded="false" aria-controls="contenu_cache_biblio">Afficher toutes les références bibliographiques ('.count($aOeuvre['bibliographies']).')</button>'."\n".
                                                     '<div class="contenu_cache_biblio collapse">'."\n";
                                                $bDejaBouton = TRUE;
                                              }
                                              $strDate = $strReference = $strLien = '';
                                              if (!empty($aBibliographie['dDate'])) {
                                                $strDate = $aBibliographie['dDate'];
                                              }
                                              if (!empty($aBibliographie['publication'])) {
                                                $strReference = $aBibliographie['publication'];
                                              }
                                              if (!empty($aBibliographie['adresse'])) {
                                                $strLien = $aBibliographie['adresse'];
                                              }
                                              $aRecherche = array('%date%', '%reference%', '%lien%');
                                              $aRemplace = array($strDate, $strReference, $strLien);
                                              echo str_replace($aRecherche, $aRemplace, $strTmplBiblio);
                                            }
                                            if ($bDejaBouton) echo '</div>'."\n";
                                          } else {
                                            echo 'Aucune bibliographie';
                                          }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- FIN BIBLIO -->
                            <!-- A PROPOS -->
                            <div class="about col-sm-12">
                                <div class="d-flex">
                                    <div class="symbole_paragraphe d-flex"></div>
                                    <h3 id="titre_about" class="titres_fiche d-flex">À propos</h3>
                                </div>
                                <div class="contenu_decale">
                                    <?php
                                    if (!empty($aOeuvre['oeuvre']['comLibre'])) {
                                      echo '<p class="auteur_fiche">Commentaire : '.$aOeuvre['oeuvre']['comLibre'].'</p>'."\n";
                                    }
                                    $strPlus = '';
                                    $strAuteurs = 'Auteur de la fiche : ';
                                    if (!empty($aOeuvre['oeuvre']['auteurFiche'])) {
                                      $strAuteurs .= $aOeuvre['oeuvre']['auteurFiche'];
                                      $strPlus = ', en collaboration avec ';
                                    }
                                    if (!empty($aOeuvre['oeuvre']['auteursSecondaires'])) {
                                      $strAuteurs .= $strPlus.$aOeuvre['oeuvre']['auteursSecondaires'];
                                      $strPlus = ', ';
                                    }
                                    if (!empty($aOeuvre['oeuvre']['referentANR'])) {
                                      $strAuteurs .= $strPlus.$aOeuvre['oeuvre']['referentANR'];
                                    }
                                    echo '<p class="auteur_fiche">'.$strAuteurs.'.</p>'."\n";
                                    ?>
                                </div>
                            </div>
                            <!-- FIN A PROPOS -->
                            
                            <!-- TAGS -->
                            <div class="contenu_decale">
                                <div class="divider_fin col-sm-12"></div>
                                <div class="liste_tags">
                                <?php
                                  // Ordre des tags
                                  
                                  if (!empty($aOeuvre['tags'])) {
                                    $bUneSociete = FALSE;
                                    // $strTmplTag = '<a class="btn btn-default bouton_tags" href="%lienTag%" role="button">%tag%</a>'."\n";
                                    $strTmplTag = '<button type="button" class="btn btn-danger bouton_tags"%lienTag%>%tag%</button>'."\n";
                                    foreach ($aOeuvre['tags'] as $aTag) {
                                      // Nettoyage du libellé (sous la forme 04-Rapport au temps%%: Histoire cyclique)
                                      $strPlus = '';
                                      $strPatern = '/^(..)\-(.*)%%: (.*)$/';
                                      preg_match($strPatern, $aTag['libelle'], $aTrouve);
                                      if (!empty($aTrouve[3])) {
                                        // if ($aTrouve[1] == 8) {
                                        //   $bUneSociete = TRUE;
                                        // } else if ((int)$aTrouve[1] == 5) {
                                        //   $strPlus = $aTrouve['2'].': ';
                                        // }
                                        $strTag = $strLienTag = '';
                                        switch ($aTrouve[1]) {
                                          case 2: // 02- Année de première édition (lien sur les éditions: #titre_editions_reception_edition)
                                            $strLienTag = ' onClick="javascript:window.location.href=\'#titre_editions_reception_edition\'"';
                                            break;
                                          case 3: // 03- Esthétique (lien sur les registres: #titre_poetique_registre)
                                            $strLienTag = ' onClick="javascript:window.location.href=\'#titre_poetique_registre\'"';
                                            break;
                                          case 4: // 04- Écart temporel (lien sur les temps: #titre_cadre_s_t_temps)
                                            $strLienTag = ' onClick="javascript:window.location.href=\'#titre_cadre_s_t_temps\'"';
                                            $strTag = getValCodeEcartCSP($aTrouve[3]);
                                            break;
                                          case 5: // 05- Voyages (lien sur les voyages: #titre_cadre_s_t_voyage)
                                            if (substr_compare('aucun', strtolower($aEdition['paraDedicace']), 0, 5) != 0) {
                                              $strPlus = $aTrouve['2'].': ';
                                              $strLienTag = ' onClick="javascript:window.location.href=\'#titre_cadre_s_t_voyage\'"';
                                            } else {
                                              continue 2; // Si simple continue, équivalent d'un break ;)
                                            }
                                            break;
                                          case 6: // 06- Disciplines et thématiques (lien sur la discipline: #idTagDiscipline<idDiscipline>)
                                                  // !!! oui, mais pb: Quel ID prendre quand on a un groupe de disciplines...
                                            $strLienTag = ' onClick="javascript:window.location.href=\'#titre_sciences_disciplines\'"';
                                            break;
                                          case 7: // 07- Catégories des élément scientifiques imaginaires (lien vers les élément scientifiques imaginaires: #titre_sciences_elt_sci_magin)
                                            $strLienTag = ' onClick="javascript:window.location.href=\'#titre_sciences_elt_sci_magin\'"';
                                            break;
                                          case 8: // 08- Société imaginaire (lien vers la société imaginaire: #idTagSocImg<idSocImg>)
                                            $strLienTag = ' onClick="javascript:window.location.href=\'#idTagSocImg'.$aTag['idRef'].'\'"';
                                            $bUneSociete = TRUE;
                                            break;
                                          case 1: // 01- Nature du texte (pas de lien)
                                          default:
                                            break;
                                        }
                                        $aRecherche = array('%lienTag%', '%tag%');
                                        if (!empty($strTag)) {
                                          $aRemplace = array($strLienTag, $strTag);
                                        } else {
                                          $aRemplace = array($strLienTag, $strPlus.$aTrouve[3]);
                                        }
                                        echo str_replace($aRecherche, $aRemplace, $strTmplTag);
                                      } else if (!empty($aTrouve[1]) AND $aTrouve[1] == 8 AND !$bUneSociete) {
                                        $aRecherche = array('%tag%');
                                        $aRemplace = array('Société imaginaire');
                                        echo str_replace($aRecherche, $aRemplace, $strTmplTag);
                                      }
                                    }
                                  }
                                ?>
                                </div>
                            </div>
                            <?php
                            } else if ($bIndexOeuvres === TRUE OR $bIndexAuteurs === TRUE OR $bIndexChrono === TRUE) {
                              // Affichage de l'index des oeuvres ou des auteurs
                            ?>
                            <!-- Index des œuvres -->
                            <?php
                              // echo '<div class="d-flex">'."\n".
                              //      '    <div class="symbole_paragraphe d-flex"></div>'."\n";
                              // if ($bIndexOeuvres === TRUE) {
                              //   echo '<h3 id="titre_index_oeuvres" class="titres_fiche d-flex">Index des œuvres</h3>'."\n";
                              // } else if ($bIndexAuteurs === TRUE) {
                              //   echo '<h3 id="titre_index_auteurs" class="titres_fiche d-flex">Index des auteurs</h3>'."\n";
                              // } else if ($bIndexChrono === TRUE) {
                              //   echo '<h3 id="titre_index_chronologique" class="titres_fiche d-flex">Index chronologique des œuvres</h3>'."\n";
                              // }
                              // echo '</div>'."\n";
                              echo '<div class="metadata_fiche">'."\n".
                                   '    <div class="bordure_top"></div>'."\n";
                              if ($bIndexOeuvres === TRUE) {
                                echo '<h1 class="name_book">Index des œuvres</h1>'."\n";
                              } else if ($bIndexAuteurs === TRUE) {
                                echo '<h1 class="name_book">Index des auteurs</h1>'."\n";
                              } else if ($bIndexChrono === TRUE) {
                                echo '<h1 class="name_book">Index chronologique des œuvres</h1>'."\n";
                              }
                              echo '    <div class="bordure_bottom"></div>'."\n".
                                   '</div>'."\n";
                            ?>
                            <div class="contenu_decale">
                                <h4 class="sous_rubrique text-center" style="position:absolute; z-index:1; margin-top: 10px; width:100%;">
                                <?php
                                  if ($bIndexOeuvres === TRUE OR $bIndexAuteurs === TRUE) {
                                    foreach ($aListeAlpha as $strLettre => $iNbResult) {
                                      if ($iNbResult > 0) {
                                        echo '<a class="alphabet" href="#titre_index_'.$strLettre.'">'.$strLettre.'</a>&nbsp;'."\n";
                                      } else {
                                        echo '<span class="text-muted">'.$strLettre.'</span>&nbsp;'."\n";
                                      }
                                    }
                                  } else if ($bIndexChrono === TRUE) {
                                    $iMemoDecennie = 0;
                                    foreach ($aListeAnnePE as $strAnnee => $test) {
                                      // Récupération de la décénnie (strAnnee de la forme AAAA)
                                      $iDecennie = intdiv(substr((int)$strAnnee, -2), 10) * 10;
                                      if ($iMemoDecennie != $iDecennie) {
                                        $iMemoDecennie = $iDecennie;
                                        $strPlus = '<br />';
                                      } else {
                                        $strPlus = '';
                                      }
                                      if ($test === 'faux') {
                                        echo $strPlus.'<span class="chrono-annee-muted text-muted">'.$strAnnee.'</span>&nbsp;'."\n";
                                      } else {
                                        echo $strPlus.'<a class="chrono-annee" href="#titre_index_'.$strAnnee.'">'.$strAnnee.'</a>&nbsp;'."\n";
                                      }
                                    }
                                  }
                                ?>
                                </h4><br /><br /><br /><br />
                                <div class="chronologie">
                                <?php
                                  if (!empty($aListeOeuvres)) {
                                    if ($bIndexAuteurs) {
                                      $strTmplAlpha = '<div class="col-md-12">'.
                                                      '<div class="d-flex" style="margin-top: -100px;">'."\n".
                                                      '    <div class="symbole_paragraphe%classDFlex%"></div>'."\n".
                                                      '    <h3 id="titre_index_%lettre%" class="titres_fiche%classDFlex%">%lettre%</h3>'."\n".
                                                      // '    <div class="symbole_paragraphe d-flex"></div>'."\n".
                                                      // '    <h3 id="titre_index_%lettre%" class="titres_fiche d-flex">%lettre%</h3>'."\n".
                                                      '</div>'."\n".
                                                      '</div>'."\n";
                                    } else if ($bIndexChrono) {
                                      $strTmplAlpha = '<div class="col-md-12">'.
                                                      // le margin-top sera à adapter si le nombre d'années de première publication augmente
                                                      // voir si moyen de faire un algorythme en fonction de ce nombre...
                                                      // '<div class="d-flex" style="margin-bottom: 40px;margin-top: -40px;">'."\n".
                                                      '<div class="d-flex" style="margin-bottom: 40px;%marginTop%">'."\n".
                                                      '    <div class="symbole_paragraphe d-flex"></div>'."\n".
                                                      '    <h3 id="titre_index_%lettre%" class="titres_fiche">%lettre%</h3>'."\n".
                                                      '</div>'."\n".
                                                      '</div>'."\n";
                                      $strMarginTop = 'margin-top: -100px;';
                                    } else {
                                      $strTmplAlpha = '<div class="col-md-12">'.
                                                      // '<div class="d-flex" style="margin-bottom: 40px;margin-top: -100px;">'."\n".
                                                      '<div class="d-flex" style="margin-bottom: 40px;%marginTop%">'."\n".
                                                      '    <div class="symbole_paragraphe d-flex"></div>'."\n".
                                                      '    <h3 id="titre_index_%lettre%" class="titres_fiche">%lettre%</h3>'."\n".
                                                      '</div>'."\n".
                                                      '</div>'."\n";
                                      $strMarginTop = 'margin-top: -100px;';
                                    }
                                    $strTmplAuteur = '<div class="col-md-12" style="top: -10px; margin-bottom: 30px;">'.
                                                     '  <h4 id="titre_editions_reception_edition" class="sous_rubrique">%auteur%</h4>'."\n".
                                                     '  <div class="semi_souligne"></div>'."\n".
                                                     '</div>'."\n";
                                    $strTmplIndex = '<div class="col-md-12" '.
                                                         'style="cursor:pointer; border-bottom-style:solid; border-bottom-color:#D31D17; margin-bottom:45px;" '.
                                                         // 'onClick="javascript:window.open(\'./?idOeuvre=%idOeuvre%\', \'_self\');">'."\n".
                                                         'onClick="javascript:window.open(\'./?idOeuvre=%idOeuvre%\', \'_blank\');">'."\n".
                                                    '    <div class="col-md-2">'."\n".
                                                    '      <a class="cover_book"><img src="%urlIllustration%" alt="Couverture du livre"></a>'."\n".
                                                    '    </div>'."\n".
                                                    '    <div class="col-md-8">'."\n".
                                                    '        <div class="col_droite_citation">'."\n".
                                                    '            <p class="text_reference minimize">'."\n".
                                                    '                %titre%'."\n".
                                                    '            </p>'."\n".
                                                    '            <p class="description_elem_scien">'."\n".
                                                    '                %auteurDate%'."\n".
                                                    '            </p>'."\n".
                                                    '        </div>'."\n".
                                                    '    </div>'."\n".
                                                    '    <div class="col-md-2">'."\n".
                                                    '        <div class="col_droite_citation">'."\n".
                                                    '            <p class="description_elem_scien">'."\n".
                                                    '                <img class="icon_fonctions_laterales" src="images/signet.png">'."\n".
                                                    '                <button class="btn btn-danger btn-secondary">Voir la fiche</button>'."\n".
                                                    '            </p>'."\n".
                                                    '        </div>'."\n".
                                                    '    </div>'."\n".
                                                    '</div>'."\n";
                                    // Les noms de variables sont génériques et représentent autant des lettres que des années
                                    $strMemoAuteurNomPrenom = $strLettre = $strMemoLettre = 'ini';
                                    $bLettreReperePrems = TRUE;
                                    foreach ($aListeOeuvres as $key => $aUneOeuvre) {
                                      if ($bIndexAuteurs) {
                                        $strLettre = strtoupper(strSupprimeAccents(mb_substr($aUneOeuvre['auteurNom'], 0, 1)));
                                        if (empty($strLettre)) $strLettre = 'non renseigné';
                                      } else if ($bIndexOeuvres) {
                                        $strLettre = strtoupper(strSupprimeAccents(mb_substr($aUneOeuvre['titrePE'], 0, 1)));
                                      } else {
                                        $strLettre = $aUneOeuvre['anneePE'];
                                      }
                                      // if ((!is_numeric($strLettre) OR $bIndexChrono) AND $strMemoLettre != $strLettre) {
                                      if ($strMemoLettre != $strLettre) {
                                        // Affichage de la lettre pour créer un repère
                                        if ($bIndexAuteurs) {
                                          if ($bLettreReperePrems) {
                                            if (!empty($strLettre)) {
                                              $aRemplace = array($strLettre, '');
                                            } else {
                                              $aRemplace = array('non renseigné', '');
                                            }
                                          } else {
                                            $aRemplace = array($strLettre, ' d-flex');
                                          }
                                          $aRecherche = array('%lettre%', '%classDFlex%');
                                          echo str_replace($aRecherche, $aRemplace, $strTmplAlpha);
                                        } else {
                                          // if (!empty($strLettre) AND (!is_numeric($strLettre) OR $bIndexChrono) AND $strLettre != 'ini') {
                                          if ($bIndexAuteurs) {
                                            $strMarginTop = 'margin-top: -100px;';
                                          } else if ($bIndexChrono AND $bLettreReperePrems) {
                                            $strMarginTop = 'margin-top: 120px;';
                                          } else {
                                            $strMarginTop = 'margin-top: -100px;';
                                          }
                                          $aRecherche = array('%lettre%', '%marginTop%');
                                          if (!empty($strLettre) AND (!is_numeric($strLettre) OR $bIndexChrono)) {
                                            $aRemplace = array($strLettre, $strMarginTop);
                                            // echo str_replace('%lettre%', $strLettre, $strTmplAlpha);
                                            echo str_replace($aRecherche, $aRemplace, $strTmplAlpha);
                                          } else if (is_numeric($strLettre)) {
                                            // echo str_replace('%lettre%', '[0-9]', $strTmplAlpha);
                                            $aRemplace = array('[0-9]', $strMarginTop);
                                            echo str_replace($aRecherche, $aRemplace, $strTmplAlpha);
                                          } else {
                                            // echo str_replace('%lettre%', 'non renseigné', $strTmplAlpha);
                                            $aRemplace = array('non renseigné', $strMarginTop);
                                            echo str_replace($aRecherche, $aRemplace, $strTmplAlpha);
                                          }
                                        }
                                        $strMemoLettre = $strLettre;
                                        $bLettreReperePrems = FALSE;
                                      }
                                      if ($bIndexAuteurs) {
                                        // if (empty($aUneOeuvre['auteurNom'])) {
                                        //   // On n'affiche pas les œuvres sans auteur... même si ça ne devrait pas exister ;)
                                        //   continue;
                                        // }
                                        if ($strMemoAuteurNomPrenom != $aUneOeuvre['auteurNom'].' '.$aUneOeuvre['auteurPrenom']) {
                                          // Affichage du nom de l'auteur pour créer un groupe
                                          $strMemoAuteurNomPrenom = $aUneOeuvre['auteurNom'].' '.$aUneOeuvre['auteurPrenom'];
                                          if (!empty(trim($strMemoAuteurNomPrenom))) {
                                            echo str_replace('%auteur%', $strMemoAuteurNomPrenom, $strTmplAuteur);
                                          } else {
                                            echo str_replace('%auteur%', 'non renseigné', $strTmplAuteur);
                                          }
                                        }
                                      }
                                      $strPlus = $strTitre = $strUrlIllistration = $strAuteurDate = '';
                                      if (!empty($aUneOeuvre['urlIllustration'])) {
                                        $strUrlIllistration = $aUneOeuvre['urlIllustration'];
                                      } else {
                                        $strUrlIllistration = 'images/logo_anticipation_logo.png';
                                      }
                                      if (!empty($aUneOeuvre['titrePE'])) {
                                        $strTitre = $aUneOeuvre['titrePE'];
                                      }
                                      if (!$bIndexAuteurs) {
                                        if (!empty($aUneOeuvre['auteurNom'])) {
                                          $strAuteurDate = $aUneOeuvre['auteurNom'];
                                          $strPlus = ' ';
                                        }
                                        if (!empty($aUneOeuvre['auteurPrenom'])) {
                                          $strAuteurDate .= $strPlus.$aUneOeuvre['auteurPrenom'];
                                          $strPlus = ' - ';
                                        }
                                      }
                                      if (!empty($aUneOeuvre['anneePE'])) {
                                        $strAuteurDate .= $strPlus.$aUneOeuvre['anneePE'];
                                      }
                                      $aRecherche = array('%idOeuvre%', '%urlIllustration%', '%titre%', '%auteurDate%');
                                      $aRemplace = array($aUneOeuvre['idOeuvre'], $strUrlIllistration, $strTitre, $strAuteurDate);
                                      echo str_replace($aRecherche, $aRemplace, $strTmplIndex);
                                    }
                                  } else {
                                    echo 'Aucune œuvre trouvée'."\n";
                                  }
                                ?>
                                </div>
                            </div>
                            <!-- FIN Index des œuvres -->
                            <?php
                            } else if ($bRechercheAvancee === TRUE) {
                              // Affichage du formulaire de recherche avancée
                              echo '<div class="metadata_fiche" style="text-align: unset;">'."\n".
                                   '    <div class="bordure_top"></div>'."\n".
                                   '    <h1 class="name_book text-center">Recherche avancée</h1>'."\n";
                              include_once 'lib/recherche-form.php';
                              echo '    <div class="bordure_bottom"></div>'."\n".
                                   '    <br />'."\n".
                                   '</div>'."\n";
                            } else if ($bRechercheSimple === TRUE) {
                            ?>
                            <!-- Résultat de la recherche -->
                            <div class="metadata_fiche">
                                <div class="bordure_top"></div>
                                <h1 class="name_book">Recherche : <?php echo $strRecherche; ?></h1>
                                <div class="bordure_bottom"></div>
                            </div>
                            <?php
                              echo '<div class="d-flex">'."\n".
                                   '  <div class="symbole_paragraphe d-flex"></div>'."\n".
                                   '  <h3 class="titres_fiche d-flex">'.count($aResultatRecherche['oeuvre']).' résultat(s)</h3>'."\n".
                                   '</div>'."\n";
                              // $strInfotriFiltre = $strPlus = '';
                              // if (!empty($strTitreTri)) {
                              //   $strInfotriFiltre .= $strPlus.'trié(s) par '.$strTitreTri."\n";
                              //   $strPlus = '<br />';
                              // }
                              // if (!empty($strRecherche)) {
                              //   $strInfotriFiltre .= $strPlus.'filtre de recherche:'.$strRecherche."\n";
                              //   $strPlus = '<br />';
                              // }
                              // if (!empty($strPlus)) {
                              //   echo '<div class="contenu_decale" style="margin-top: -70px;">'."\n".
                              //        '    <h4 class="sous_rubrique">'."\n".$strInfotriFiltre.'</h4>'."\n".
                              //        '</div>'."\n";
                              // }
                            ?>
                            <div class="contenu_decale">
                                <h4><br /></h4>
                                <div class="chronologie">
                                <?php
                                  if (!empty($aResultatRecherche['oeuvre'])) {
                                    $strTmplResultRech = '<div class="container_citation col-md-12" '.
                                                              'style="cursor:pointer; margin-top:0px; %plusStyle%"'.
                                                              // 'onClick="javascript:window.open(\'./?idOeuvre=%idOeuvre%\', \'_self\');">'."\n".
                                                              'onClick="javascript:window.open(\'./?idOeuvre=%idOeuvre%\', \'_blank\');">'."\n".
                                                         '    <div class="citation citation_sans_icon col-md-2">'."\n".
                                                         '      <a class="cover_book"><img src="%urlIllustration%" alt="Couverture du livre" class=""></a>'."\n".
                                                         '    </div>'."\n".
                                                         '    <div class="citation col-md-8">'."\n".
                                                         '        <div class="col_droite_citation">'."\n".
                                                         '            <p class="text_reference minimize">'."\n".
                                                         '                %titre%'."\n".
                                                         '            </p>'."\n".
                                                         '            <p class="description_elem_scien">'."\n".
                                                         '                %auteurDate%'."\n".
                                                         '            </p>'."\n".
                                                         '        </div>'."\n".
                                                         '    </div>'."\n".
                                                         '    <div class="col-md-2">'."\n".
                                                         '        <div class="col_droite_citation">'."\n".
                                                         '            <p class="description_elem_scien">'."\n".
                                                         '                <img class="icon_fonctions_laterales" src="images/signet.png">'."\n".
                                                         '                <button class="btn btn-danger btn-secondary">Voir la fiche</button>'."\n".
                                                         '            </p>'."\n".
                                                         '        </div>'."\n".
                                                         '    </div>'."\n".
                                                         '</div>'."\n";
                                    $iCpt = 0;
                                    $strPlusStyle = 'margin-bottom:-40px;';
                                    foreach ($aResultatRecherche['oeuvre'] as $key => $aUneOeuvre) {
                                      if (!empty($aUneOeuvre['idOeuvre'])) {
                                        $strPlus = $strTitre = $strUrlIllistration = $strAuteurDate = '';
                                        if (!empty($aUneOeuvre['urlIllustration'])) {
                                          $strUrlIllistration = $aUneOeuvre['urlIllustration'];
                                        } else {
                                          $strUrlIllistration = 'images/logo_anticipation_logo.png';
                                        }
                                        if (!empty($aUneOeuvre['titrePE'])) {
                                          $strTitre = $aUneOeuvre['titrePE'];
                                        }
                                        if (!empty($aUneOeuvre['auteurNom'])) {
                                          $strAuteurDate = $aUneOeuvre['auteurNom'];
                                          $strPlus = ' ';
                                        }
                                        if (!empty($aUneOeuvre['auteurPrenom'])) {
                                          $strAuteurDate .= $strPlus.$aUneOeuvre['auteurPrenom'];
                                          $strPlus = ' - ';
                                        }
                                        if (!empty($aUneOeuvre['anneePE'])) {
                                          $strAuteurDate .= $strPlus.$aUneOeuvre['anneePE'];
                                        }
                                        $aRecherche = array('%plusStyle%', '%idOeuvre%', '%urlIllustration%', '%titre%', '%auteurDate%');
                                        $aRemplace = array($strPlusStyle, $aUneOeuvre['idOeuvre'], $strUrlIllistration, $strTitre, $strAuteurDate);
                                        echo str_replace($aRecherche, $aRemplace, $strTmplResultRech);
                                        if ($iCpt == 0) {
                                          $iCpt = 1;
                                          $strPlusStyle = 'border-top-style:solid; border-top-color:#D31D17; margin-bottom:-40px; padding-top:50px;';
                                        }
                                      }
                                    }
                                  } else {
                                    echo 'Aucune œuvre trouvée'."\n";
                                  }
                                ?>
                                </div>
                            </div>
                            <!-- FIN Résultat de la recherche -->
                            <?php
                            } else {
                              // Oeuvre indisponible
                            // <div class="metadata_fiche">
                            //     <div class="bordure_top"></div>
                            //     <h1 class="name_book">Œuvre indisponible</h1>
                            //     <div class="bordure_bottom"></div>
                            //     <a href="" class="cover_book"><img src="images/logo_anticipation_logo.png" alt="Couverture du livre" class=""></a>
                            //     <br /> <br /> <br /> <br /> <br /> <br />
                            // </div>
                            ?>
                            <?php // <a href="#" class="login"><img src="images/login.svg" class="icon_login"></a> ?>
                            <div class="headHome container">
                                <img class="logoAnticipationHome" src="images/logo_anticipation_home.png" alt="logo"> 
                                <h1 class="titresHomePage">500 récits d’anticipation français entre 1860 et 1940</h2>
                                <h2 class="titresHomePage">Un projet de l’ANR Anticipation</h2>   
                            </div>
                            <div class="container_fiche">
                                <div class="justify-content-md-center row">
                                    <form class="form-inline formRechercheHome col-md-12 justify-content-md-center">
                                        <input type="hidden" name="bRechercheSimple" value="1">
                                        <input class="form-control champRechercheHome col-md-5 col-sm-12" type="search" name="recherche" placeholder="Chercher une oeuvre, un auteur..." aria-label="Search">
                                        <button class="btn btn-danger btnRechercheHome col-md-2 col-sm-12" type="submit">Rechercher</i></button>
                                    </form>
                                </div>
                                
                                <div class="shortcutsHome flex-row">
                                    <a class="btn btn-danger shortcutsHomeBtn" href="?bAuHasard=1" role="button">Au hasard</a>
                                    <a class="btn btn-danger shortcutsHomeBtn" href="./?Index=O" role="button">Index des oeuvres</a>
                                    <a class="btn btn-danger shortcutsHomeBtn" href="./?Index=A" role="button">Index des auteurs</a>
                                    <a class="btn btn-danger shortcutsHomeBtn" href="?bRechercheAvancee=1" role="button">Recherche avancée</a>
                                </div>
                                <div class="menuprincipalHome">
                                    <ul class="list-unstyled">       
                                        <li class="itemmenuprincipalHome">
                                            <div class="dropdown-divider dividermenuprincipalHome"></div>
                                            <a href="#">Qu'est-ce que le récit d'anticipation ?</a>
                                            <div class="dropdown-divider dividermenuprincipalHome"></div>
                                        </li>
                                        <li class="itemmenuprincipalHome">
                                            <a href="./graphique">Le récit d'anticipation en graphique</a>
                                            <div class="dropdown-divider dividermenuprincipalHome"></div>
                                        </li>
                                        <li class="itemmenuprincipalHome">
                                            <a href="#">L'ANR Anticipation</a>
                                            <div class="dropdown-divider dividermenuprincipalHome"></div>
                                        </li>
                                        <li class="itemmenuprincipalHome">
                                            <a href="#">Principes de sélection des oeuvres</a>
                                            <div class="dropdown-divider dividermenuprincipalHome"></div>
                                        </li>
                                        <li class="itemmenuprincipalHome">
                                            <a href="#">Les contributeurs</a>
                                            <div class="dropdown-divider dividermenuprincipalHome"></div>
                                        </li>
                                    </ul>
                                    <div class="sponsors d-flex justify-content-center">
                                        <a href="http://ihrim.ens-lyon.fr/"><img src="images/logo_ihrim.png" class="logosSponsorsHome"></a>
                                        <a href="https://anr.fr"><img src="images/logo_anr.png" class="logosSponsorsHome"></a>
                                    </div>
                                </div>      
                            </div> <!--Fin de la colonne sm12 CONTENU DE LA FICHE -->
                            <?php
                            }
                            ?>
                        </div>
                        <!--Fin du Contenu Scrollspy -->
                    </div>
                    <!-- FIN CONTENU DE LA FICHE -->
                </div>
                <!-- FIN DIV PRINCIPALE -->
                <?php
                if ($aOeuvre['oeuvre']['deleted'] === 0 OR $bIndexOeuvres === TRUE OR $bIndexAuteurs === TRUE OR $bIndexChrono === TRUE OR $bRechercheAvancee === TRUE OR $bRechercheSimple === TRUE) {
                ?>
                <!-- PIED DE PAGE -->
                <div class="footer col-sm-12">
                    <div class="menu_footer offset-sm-2 col-sm-9">
                        <!--<a class="nav-link" href="#">Accueil</a>
                        <a class="nav-link" href="#">Le récit d'anticipation</a>
                        <a class="nav-link" href="#">En graphique</a>-->
                        <a class="nav-link" href="#">L'ANR Anticipation</a>
                        <a class="nav-link" href="#">Principe de sélection des oeuvres</a>
                        <a class="nav-link" href="#">Les contributeurs</a>
                        <a class="nav-link" href="#">Signaler une erreur</a>
                        <a class="nav-link" href="#">Mentions légales</a>
                    </div>   
                </div>
                <!-- FIN PIED DE PAGE -->
                <?php
                }
                ?>
            </div>
            <!-- FIN CONTENU DE LA PAGE -->
        </div>
        <!-- FIN WRAPPER -->
        <a id="back-to-top" href="#" class="btn btn-danger btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>


        <?php
        // <!-- jQuery CDN -->
        // <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        // <!-- Popper JS -->
        // <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        // <!-- Bootstrap Js CDN -->
        // <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        // <!-- jQuery Custom Scroller CDN -->
        // <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
        // <!--  Quelques fonctions JS -->
        // <script src="js/divers.js"></script>
        // PYJ - <script src="js/bootstrap-4.1.1.min.js"></script>
        // PYJ - <script src="js/jquery-1.12.0.min.js"></script>
        // PYJ - <script src="js/jquery-ui.js"></script>
        // PYJ - <script src="js/jquery-2.2.4.js"></script>
        ?>
        <!--  Menu Burger -->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });

                $('#dismiss, .overlay').on('click', function () {
                    $('#sidebar').removeClass('active');
                    $('.overlay').fadeOut();
                });

                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').addClass('active');
                    $('.overlay').fadeIn();
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
            });
        </script>
        <!--  Couper les citations trop longues -->
        <script type="text/javascript">
        jQuery(function(){
            var minimized_elements = $('p.minimize');
            minimized_elements.each(function(){    
                var t = $(this).text();        
                if(t.length < 1000) return;
                $(this).html(
                    t.slice(0,1000)+'<span>... </span><a href="#" class="more">  Lire la suite</a>'+
                    '<span style="display:none;">'+ t.slice(1000,t.length)+' </br><a href="#" class="less" style="position: relative; z-index: 1000;">   Réduire</a></span>'
                );
            }); 
            $('a.more', minimized_elements).click(function(event){
                event.preventDefault();
                $(this).hide().prev().hide();
                $(this).next().show();        
            });
            $('a.less', minimized_elements).click(function(event){
                event.preventDefault();
                $(this).parent().hide().prev().show().prev().show();    
            });
            });
        </script>
        <!--  SCROLLBACK -->
        <script type="text/javascript">
            $(document).ready(function(){
                $(window).scroll(function () {
                        if ($(this).scrollTop() > 50) {
                            $('#back-to-top').fadeIn();
                        } else {
                            $('#back-to-top').fadeOut();
                        }
                    });
                    // scroll body to 0px on click
                    $('#back-to-top').click(function () {
                        // $('#back-to-top').tooltip('hide');
                        $('body,html').animate({
                            scrollTop: 0
                        }, 800);
                        return false;
                    });
                    
                    // $('#back-to-top').tooltip('show');

            });
        </script>

<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
    // Un peu de debuggage...

    <?php
      if (!empty($strDBG)) {
        echo "document.getElementById('bodyErreur').firstChild.nodeValue = '".str_replace("\n", ' ', str_replace("'", "\'", $strDBG))."'; $('#Erreur').modal('show');\n";
      }
      if (!empty($strJScriptPlus)) {
        echo $strJScriptPlus;
      }
    ?>
    <?php if (!empty($_GET['bRechercheAvancee'])) { ?>
    strTypeRecherche = 'bRechercheAvancee=1';
    <?php } else if (!empty($_GET['bRechercheSimple'])) { ?>
    strTypeRecherche = 'bRechercheSimple=1';
    <?php } // if (!empty($strRecherche)) { // Création systématique de strRecherche, même vide ?>
    strRecherche = <?php echo "'".str_replace("'", "\'", $strRecherche)."'"; ?>;
    <?php // } ?>
</script>

      <?php
      // <div class="modal fade" id="modRechercheAvancee" tabindex="-1" role="dialog" aria-labelledby="labelRechercheAvancee">
      //   <div class="modal-dialog modal-lg" role="document">
      //     <div class="modal-content">
      //       <div class="modal-header">
      //         <h3 id="labelRechercheAvancee" class="modal-title">Formulaire de recherche avancée</h3>
      //       </div>
      //       <div id="bodyRechercheAvancee" class="modal-body">
      //       < php include_once 'lib/recherche-form.php';  >
      //       </div>
      //       <div class="modal-footer">
      //         <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
      //       </div>
      //     </div><!-- /.modal-content -->
      //   </div><!-- /.modal-dialog -->
      // </div><!-- /.modal -->
      ?>

      <?php
      // <!-- Modal - Menu pour trier et filtrer -->
      // <div class="modal fade" id="modRechercheAvancee" tabindex="-1" role="dialog" aria-labelledby="labelModRechercheAvancee">
      //   <div class="modal-dialog modal-lg" role="document">
      //     <div class="modal-content">
      //        ?php
      //       // <div class="modal-header">
      //       //   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      //       //   <h4 class="modal-title" id="labelModRechercheAvancee">Formulaire de recherche avancée</h4>
      //       // </div>
      //       ? 
      //       <div class="modal-body">
      //        ?php include_once 'lib/recherche-form.php'; ? 
      //       </div>
      //        ?php
      //       // <div class="modal-footer">
      //       //   <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
      //       //   <button type="button" class="btn btn-danger">Rechercher <span class="glyphicon glyphicon-ok"></span></button>
      //       // </div>
      //       ? 
      //     </div>
      //   </div>
      // </div>
      ?>

    </body>
</html>
