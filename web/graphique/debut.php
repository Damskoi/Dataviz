<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>ANR Anticipation - Graphique</title>
  <link rel="icon" type="image/png" href="../images/logo_anticipation_logo.png" />

  <script src="../js/jquery-3.3.1.js?V=0.12"></script>
  <script src="../js/jquery-ui-1.12.1.js?V=0.12"></script>
  <script src="../js/jquery-ui-fr.js?V=0.12"></script>
  <script src="../js/popper-1.14.3.min.js?V=0.12"></script>
  <script src="../js/bootstrap-3.3.7.min.js?V=0.12"></script>
  <script src="../js/jquery.mCustomScrollbar-3.1.5.concat.min.js?V=0.12"></script>
  <!--  Quelques fonctions JS -->
  <script src="../js/divers.js?V=0.12"></script>

  <link rel="stylesheet" href="../css/bootstrap-4.1.1.css?V=0.6">
  <link rel="stylesheet" href="../css/bootstrap-3.3.7.css?V=0.6">

  <!-- Génération de graphiques -->
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
  <script src="https://cdn.plot.ly/plotly-locale-fr-latest.js"></script>

  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="../css/style3.css?V=0.6">
  <link rel="stylesheet" href="../css/ihrim-anticipation.css?V=0.6">
  <!-- CSS graphique -->
  <link rel="stylesheet" href="../css/graphique.css">

  <!-- Scrollbar Custom CSS -->
  <link rel="stylesheet" href="../css/jquery.mCustomScrollbar-3.1.5.css">
  <link rel="stylesheet" href="../css/fonts.css?V=0.6">
  <link rel="stylesheet" href="../css/jquery-ui-1.12.1.css?V=0.6">
  <link rel="stylesheet" href="../css/jquery-ui-ajout.css?V=0.6">
  
<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-graph.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">


</head>
<body data-spy="scroll" data-target=".scrollSpy">

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
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
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
    <!-- SIDEBAR MENU BURGER -->
    <nav id="sidebar" class="mCustomScrollbar _mCS_1 mCS-autoHide" style="overflow: visible;"><div id="mCSB_1" class="mCustomScrollBox mCS-minimal mCSB_vertical mCSB_outside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
      <div id="dismiss">
        <i class="glyphicon glyphicon-remove fermermenuprincipal"></i>
      </div>
      <div class="menuprincipal">
        <ul class="list-unstyled components">
          <li class="active itemmenuprincipal">
            <div class="dropdown-divider dividermenuprincipal"></div>
            <a href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">Accueil</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">Qu'est-ce que le récit d'anticipation ?</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href=".">Le récit d'anticipation en graphique</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">L'ANR Anticipation</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">Principes de sélection des oeuvres</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">Les contributeurs</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#">Signaler une erreur</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1">Recherche avancée</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?Index=O">Index des oeuvres</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?Index=A">Index des auteurs</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?Index=C">Index chronologique des œuvres</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
          <li class="itemmenuprincipal">
            <a href="https://anticipation-dev.huma-num.fr/?bAuHasard=1">Au hasard</a>
            <div class="dropdown-divider dividermenuprincipal"></div>
          </li>
        </ul>
        <div class="sponsors d-flex justify-content-center">
          <a href="http://ihrim.ens-lyon.fr/"><img src="../images/logo_ihrim.png" class="logosSponsors mCS_img_loaded"></a>
          <a href="https://anr.fr/"><img src="../images/logo_anr.png" class="logosSponsors mCS_img_loaded"></a>
        </div>
      </div>
    </div></div><div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-minimal mCSB_scrollTools_vertical" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 50px; display: block; height: 904px; max-height: 907.25px; top: 0px;"><div class="mCSB_dragger_bar" style="line-height: 50px;"></div></div><div class="mCSB_draggerRail"></div></div></div></nav>
    <!-- FIN SIDEBAR MENU BURGER -->
    <!-- FONCTIONS LATERALES DROITE -->
    <div class="btn-group-vertical fonctions_laterales">
    </div>
    <!-- FIN FONCTIONS LATERALES DROITE -->

    <!-- CONTENU DE LA PAGE -->
    <div id="content">
      <!-- BARRE DE MENU SUPERIEURE -->
      <header class="navbar navbar-expand-lg navbar-light">
        <div class="collapse navbar-collapse" id="navbarText2">
          <a class="navbar-brand" href="https://anticipation-dev.huma-num.fr/">
            <img class="logoAnticipation" src="../images/logo_anticipation.png" alt="logo">
          </a>
        </div>
        <div class="d-none d-lg-flex shortcuts-top">
          <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?bAuHasard=1">Au hasard</a>
          <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?Index=O">Index œuvres</a>
          <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?Index=A">Index auteurs</a>
          <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?Index=C">Chronologie œuvres</a>
          <a class="nav-link" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1">Recherche avancée</a>
          <form class="form-inline my-2 my-lg-0 formRecherche">
            <input type="hidden" name="bRechercheSimple" value="1">
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
      <!-- FIN BARRE DE MENU SUPERIEURE -->
