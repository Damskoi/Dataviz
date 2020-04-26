<?php include 'debut.php';?>

<!-- DIV PRINCIPALE -->
<div class="row_principale row col-sm-12">
  <!-- BARRE DE MENU GAUCHE SCROLLSPY -->
  <div class="col-sm-2 list-group sidebarLeft d-md-none d-lg-block">
    <div class="sponsors d-flex align-content-center logosBottom">
      <a href="http://ihrim.ens-lyon.fr/"><img src="../images/logo_ihrim.png"></a>
      <a href="https://anr.fr/"><img src="../images/logo_anr.png"></a>
    </div>
  </div>
  <!-- FIN BARRE DE MENU GAUCHE SCROLLSPY -->
  <!-- CONTENU DE LA FICHE -->
  <div class="container_fiche col-md-10 col-sm-10">

    <div class="contenuFiche">

      <div class="metadata_fiche" style="text-align: unset;">
        <div class="bordure_top"></div>

        <div class="inline">
          <h1 class="name_book text-center">Le récit d'anticipation en graphique</h1>
        </div>

        <?php include 'formulaire_graphique.php';?>

        <!-- Pondération -->
        <label id="information" data-toggle="tooltip" data-placement="bottom" title="Activer la pondération permet de générer des graphiques avec des données ajustées en fonction du nombre d'oeuvres au total sur la période et pas seulement celle représentée dans la base de donnée.">
          <input id="ponderation" type="checkbox" name="ponderation" value="true" checked> <span id="underline">Activer la pondération ?</span></label>
          <!-- Fin pondération -->

          <!-- Sélection palette -->
          <label class="on-right" id="information"><span data-toggle="tooltip" data-placement="bottom" title="Choisir le style des graphiques" id="underline">Palettes de couleur du graphique</span>
            <select id="palette" name="palette">
              <?php
              include 'utils.php';
              $obj = loadConfig('./config.json');
              $nomPalettes = array_keys($obj["palette"]);
              foreach ($nomPalettes as $nom):?>
              <option><?=$nom?></option>
            <?php endforeach;?>
          </select></label>
          <!-- Fin sélection palette -->

          <!-- Début espace graphique -->
          <div id="graphique">
            <div id="choix-graphiques">
              <h2 id="titre" class="text-center">Choix du graphique à générer</h2>
              <div id="choix">

                <?php
                $allCharts = [
                  "Diagramme à barres" => ["graphique-type1", "diagramme_a_barres"],
                  "Circulaire" => ["graphique-type2", "circulaire"],
                  "Lignes" => ["graphique-type3", "lignes"],
                  "Radar" => ["graphique-type4", "radar"],
                  "Nuage de mots" => ["graphique-type5", "nuage_de_mots"],
                  "Réseau" => ["graphique-type6", "reseau"],
                  "Aires" => ["graphique-type7", "aires"],
                  "Bulles" => ["graphique-type8", "bulles"]
                ];

                foreach($allCharts as $name => $chart):?>
                <div class="boite-graphique" id="<?=$chart[0]?>">
                  <h4 id="titre-graphique"><?=$name?></h4>
                  <img id="img-graphique" src="../images/graphique/<?=$chart[1]?>.svg"></img>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div id="display" style="display: none" class="alert alert-info alert-RechAvance">
            <span class="font-weight-bold"> Information :</span> Au vue du nombre d'oeuvres comprises dans le graphique généré, il serait peut-être plus pertinent d'effectuer une <a href="../?bRechercheAvancee=1" class="font-weight-bold">recherche avancée</a>.
          </div>

          <script src="../js/graphique.js"></script>

          <a name="espace-graphique"></a>
          <div id="generation-graphique">

          </div>
        </div>
        <!-- Fin espace graphique -->
        <div class="bordure_bottom"></div>
        <br>
      </div>
    </div>
    <!--Fin du Contenu Scrollspy -->
  </div>
  <!-- FIN CONTENU DE LA FICHE -->
</div>
<!-- FIN DIV PRINCIPALE -->
<?php include 'fin.php';?>
