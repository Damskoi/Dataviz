<form id="formRechAvance" class="form-horizontal">
  <div class="panel panel-anticipation">
    <div class="panel-heading" role="tab" id="pheadRechAvanc">
      <div class="row"><div class="col-md-11">

      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#idColpsRechAvance" aria-controls="idColpsRechAvance">
          <span id="idImgColpsRechAvanc" class="glyphicon glyphicon-chevron-up"></span> Formulaire de génération de graphiques
        </a>
      </h4>

      </div><!-- /col-md-11 -->

      </div><!-- /row -->
    </div><!-- /panel-heading -->

  <div id="idColpsRechAvance" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="pheadRechAvanc"><div class="panel-body">
        <div class="panel panel-anticipation">
      <div class="panel-heading" role="tab" id="pheadPresente">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#idColpsPresente" aria-controls="idColpsPresente">
            <span id="idImgColpsPresente" class="glyphicon glyphicon-chevron-up"></span> Présentation
          </a>
        </h4>
      </div><!-- /panel-heading -->
      <div id="idColpsPresente" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="pheadPresente"><div class="panel-body">

        <script type="text/javascript">
          $('#idColpsPresente').on('shown.bs.collapse', function () { vSwitchChevron($('#idImgColpsPresente'), 'up'); })
          $('#idColpsPresente').on('hidden.bs.collapse', function () { vSwitchChevron($('#idImgColpsPresente'), 'down'); })
        </script>

        <div class="form-group">
          <label class="col-md-2 control-label">Titre de l'oeuvre</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtTitrePE" name="titre" placeholder="Titre de l&#39;oeuvre">
              <script>$('#txtTitrePE').focus();</script>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Nom de l'auteur</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtAuteur" name="name" placeholder="Nom de l&#39;auteur">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Prénom de l'auteur</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtAuteur" name="surname" placeholder="Prénom de l&#39;auteur">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Date de première édition</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODatePrEdit" title="" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA&lt;br /&gt;- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.&lt;br /&gt;- Pour filtrer les publications avant une année, saisissez l&#39;année dans le deuxième champ et laisser le premier vide.&lt;br /&gt;- Pour filtrer les publications après une année, saisissez l&#39;année dans le premier champ et laisser le deuxième vide." data-original-title="Info" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <script type="text/javascript"> $('#spPODatePrEdit').popover()</script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control" id="txtAnneePEDeb" name="dateTot" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"> à </span>
                <input type="text" class="form-control" id="txtAnneePEFin" name="dateTard" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
            </div><!-- /form-inline -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Recherche par mot clé</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtMotCle" name="KeyW" placeholder="Mot clé">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

      </div></div><!-- /panel-body /panel-collapse -->
    </div><!-- /panel -->

    <div class="panel panel-anticipation">
      <div class="panel-heading" role="tab" id="pheadEtudeGenre">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#idColpsEtudeGenre" aria-controls="idColpsEtudeGenre">
            <span id="idImgColpsEtudeGenre" class="glyphicon glyphicon-chevron-down"></span> Étude du genre
          </a>
        </h4>
      </div><!-- /panel-heading -->
      <div id="idColpsEtudeGenre" class="panel-collapse collapse" role="tabpanel" aria-labelledby="pheadEtudeGenre"><div class="panel-body">

        <script type="text/javascript">
          $('#idColpsEtudeGenre').on('shown.bs.collapse', function () { vSwitchChevron($('#idImgColpsEtudeGenre'), 'up'); })
          $('#idColpsEtudeGenre').on('hidden.bs.collapse', function () { vSwitchChevron($('#idImgColpsEtudeGenre'), 'down'); })
        </script>

        <div class="form-group">
          <label class="col-md-2 control-label">Désignations génériques</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtAuteur" name="designation" placeholder="Désignation du discours auctorial, du dispositif éditorial ou de la réception critique">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Année de la (des) désignation(s)</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODateDes" title="" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA&lt;br /&gt;- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.&lt;br /&gt;- Pour filtrer les publications avant une année, saisissez l&#39;année dans le deuxième champ et laisser le premier vide.&lt;br /&gt;- Pour filtrer les publications après une année, saisissez l&#39;année dans le premier champ et laisser le deuxième vide." data-original-title="Info" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <script type="text/javascript"> $('#spPODateDes').popover()</script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control" id="txtAnneeDesignationDateDeb" name="AnneeDebut" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"> à </span>
                <input type="text" class="form-control" id="txtAnneeDesignationDateFin" name="AnneeFin" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
            </div><!-- /form-inline -->
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Filtrage sur les types de désignations</label>
          <div class="col-md-10">
            <div class="input-group">
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkTypeDes1" name="boxFiltre[]" value="Discours auctorial" checked=""> Discours auctorial
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkTypeDes2" name="boxFiltre[]" value="Dispositif éditorial" checked=""> Dispositif éditorial
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkTypeDes3" name="boxFiltre[]" value="Réception critique" checked=""> Réception critique
                  </label>
                </div>
              </span><!-- /input-group-addon -->
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <hr>

        <div class="form-group">
          <label class="col-md-2 control-label">Auteurs comparés</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtAuteur" name="auteurComp" placeholder="Désignation du discours auctorial, du dispositif éditorial ou de la réception critique">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Date du lien avec l'auteur</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODateLienAut" title="" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA&lt;br /&gt;- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.&lt;br /&gt;- Pour filtrer les publications avant une année, saisissez l&#39;année dans le deuxième champ et laisser le premier vide.&lt;br /&gt;- Pour filtrer les publications après une année, saisissez l&#39;année dans le premier champ et laisser le deuxième vide." data-original-title="Info" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <script type="text/javascript"> $('#spPODateLienAut').popover()</script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control" id="txtAnneeLienAAuteurDateDeb" name="dateADebut" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
                <!-- <span class="input-group-addon" style="cursor:pointer;">
                  <a onClick="javascript:$('#dateLienAAuteurDateDeb').datepicker('show');" title="Calendrier"><span class="glyphicon glyphicon-calendar"></span></a>
                </span>
                <script type="text/javascript">
                  $(function() {
                    $.datepicker.setDefaults($.datepicker.regional["fr"]);
                    $("#dateLienAAuteurDateDeb").datepicker({
                      showOtherMonths: true,
                      selectOtherMonths: true,
                      changeYear: true
                    });
                  });
                </script> -->
              </div><!-- /input-group -->
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"> à </span>
                <input type="text" class="form-control" id="txtAnneeLienAAuteurDateFin" name="dateAFin" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
                <!-- <span class="input-group-addon" style="cursor:pointer;">
                  <a onClick="javascript:$('#dateLienAAuteurDateFin').datepicker('show');" title="Calendrier"><span class="glyphicon glyphicon-calendar"></span></a>
                </span>
                <script type="text/javascript">
                  $(function() {
                    $.datepicker.setDefaults($.datepicker.regional["fr"]);
                    $("#dateLienAAuteurDateFin").datepicker({
                      showOtherMonths: true,
                      selectOtherMonths: true,
                      changeYear: true
                    });
                  });
                </script> -->
              </div><!-- /input-group -->
            </div><!-- /form-inline -->
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->


      </div></div><!-- /panel-body /panel-collapse -->
    </div><!-- /panel -->


    <div class="panel panel-anticipation">
      <div class="panel-heading" role="tab" id="pheadDescMat">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#idColpsDescMat" aria-controls="idColpsDescMat">
            <span id="idImgColpsDescMat" class="glyphicon glyphicon-chevron-down"></span> Description matérielle
          </a>
        </h4>
      </div><!-- /panel-heading -->
      <div id="idColpsDescMat" class="panel-collapse collapse" role="tabpanel" aria-labelledby="pheadDescMat"><div class="panel-body">

        <script type="text/javascript">
          $('#idColpsDescMat').on('shown.bs.collapse', function () { vSwitchChevron($('#idImgColpsDescMat'), 'up'); })
          $('#idColpsDescMat').on('hidden.bs.collapse', function () { vSwitchChevron($('#idImgColpsDescMat'), 'down'); })
        </script>

    <div class="form-group">
      <label class="col-md-2 control-label">Désignations génériques</label>
      <div class="col-md-10">
        <div class="input-group">
          <input type="text" class="form-control" id="txtListeSupportPub-0" name="support" placeholder="Support de publication">
        </div><!-- /input-group -->
      </div><!-- /col-md- -->
    </div><!-- /form-group -->


        <div class="form-group">
          <label class="col-md-2 control-label">Année de parution</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODateSPAnParution" title="" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA&lt;br /&gt;- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.&lt;br /&gt;- Pour filtrer les publications avant une année, saisissez l&#39;année dans le deuxième champ et laisser le premier vide.&lt;br /&gt;- Pour filtrer les publications après une année, saisissez l&#39;année dans le premier champ et laisser le deuxième vide." data-original-title="Info" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <script type="text/javascript"> $('#spPODateSPAnParution').popover()</script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control" id="txtSPAPAnneeDeb" name="yearParutionDebut" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"> à </span>
                <input type="text" class="form-control" id="txtSPAPAnneeFin" name="yearParutionFin" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
            </div><!-- /form-inline -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->
        
        <div class="form-group">
          <label class="col-md-2 control-label">Filtrage des résultats sur les types d'éditions</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe273" name="boxFil[]" value="V"> volume                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe275" name="boxFil[]" value="P"> périodique                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe271" name="boxFil[]" value="L"> livraison                  </label>
                </div>
              </span><!-- /input-group-addon -->
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Catégories et collections spécialisées</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe273" name="boxC[]" value="273"> Anticipation                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe275" name="boxC[]" value="275"> Aventure                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe271" name="boxC[]" value="271"> Édition de luxe / bibliophilie                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe277" name="boxC[]" value="277"> Fantastique                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe269" name="boxC[]" value="269"> Jeunesse                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe272" name="boxC[]" value="272"> Littérature générale                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe276" name="boxC[]" value="276"> Policier                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe270" name="boxC[]" value="270"> Populaire                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe278" name="boxC[]" value="278"> Sentimental                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe274" name="boxC[]" value="274"> SF                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe279" name="boxC[]" value="279"> Autre                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkSPCatColSpe280" name="boxC[]" value="280"> Rien                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Nom de l'illustrateur</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtListeIllustrAuteur-0" name="nomIllus" placeholder="Support de publication">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->


        <hr>

        <div class="form-group">
          <label class="col-md-2 control-label">Langue de la traduction</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtListeLangue-0" name="langueTrad" placeholder="Langue de traduction">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->
        


        <hr>

        <div class="form-group">
          <label class="col-md-2 control-label">Nature d'adaptation</label>
          <div class="col-md-10">
            <div class="row"><div class="col-md-12">
              <select id="selNatureAdapt" class="form-control" name="natureAdaptation" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
              <option class="text-left" value="null" selected="">--- Sélectionnez un élément de la liste---</option><option value="BD">BD</option>
                <option value="Danse">Danse</option>
                <option value="Film">Film</option>
                <option value="Livre Audio">Livre Audio</option>
                <option value="Musique">Musique</option>
                <option value="Pièce radiophonique">Pièce radiophonique</option>
                <option value="Radio">Radio</option>
                <option value="Théâtre">Théâtre</option>
              </select><!-- /form-control -->
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->
      </div>
    </div>
  </div></div><!-- /panel-body /panel-collapse -->
</div><!-- /panel -->

    <div class="panel panel-anticipation">
      <div class="panel-heading" role="tab" id="pheadPoeteEtc">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#idColpsPoeteEtc" aria-controls="idColpsPoeteEtc">
            <span id="idImgColpsPoeteEtc" class="glyphicon glyphicon-chevron-down"></span> Poétique, temps, espace, personnage et esthétique
          </a>
        </h4>
      </div><!-- /panel-heading -->
      <div id="idColpsPoeteEtc" class="panel-collapse collapse" role="tabpanel" aria-labelledby="pheadPoeteEtc"><div class="panel-body">

        <script type="text/javascript">
          $('#idColpsPoeteEtc').on('shown.bs.collapse', function () { vSwitchChevron($('#idImgColpsPoeteEtc'), 'up'); })
          $('#idColpsPoeteEtc').on('hidden.bs.collapse', function () { vSwitchChevron($('#idImgColpsPoeteEtc'), 'down'); })
        </script>

        <div class="form-group">
          <label class="col-md-2 control-label">Poétique</label>
          <div class="col-md-10">
            <div class="input-group">
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkPoetique1" name="boxNaration[]" value="1st"> Narration à la 1ère personne
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkPoetique2" name="boxNaration[]" value="3rd"> Narration à la 3ème personne
                  </label>
                </div>
              </span><!-- /input-group-addon -->
            </div><!-- /input-group -->
            <div class="input-group">
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkPoetique3" name="boxNaration[]" value="multiple"> Narrateurs multiples
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkPoetique4" name="boxNaration[]" value="enchassee"> Narration enchâssée
                  </label>
                </div>
              </span><!-- /input-group-addon -->
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->


        <div class="form-group">
          <label class="col-md-2 control-label">Cadre spatial</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtListeCadreSpat-0" name="cadreSpatial" placeholder="Cadre spatial">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->


        <div class="form-group">
          <label class="col-md-2 control-label">Date de l'histoire</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODateHistoire" title="" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA&lt;br /&gt;- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.&lt;br /&gt;- Pour filtrer les publications avant une année, saisissez l&#39;année dans le deuxième champ et laisser le premier vide.&lt;br /&gt;- Pour filtrer les publications après une année, saisissez l&#39;année dans le premier champ et laisser le deuxième vide." data-original-title="Info" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <script type="text/javascript"> $('#spPODateSPAnParution').popover()</script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control" id="txtDateHistoireDeb" name="dateHistoireDebut" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"> à </span>
                <input type="text" class="form-control" id="txtDateHistoireFin" name="dateHistoireFin" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
            </div><!-- /form-inline -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Écart temporel</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkEcartTemp1" name="boxNaration2[]" value="passeLointain"> Passé lointain (+ de 50 ans)                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkEcartTemp2" name="boxNaration2[]" value="passeProche"> Passé proche (- de 50 ans)                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div>
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkEcartTemp3" name="boxNaration2[]" value="present"> Présent                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkEcartTemp4" name="boxNaration2[]" value="futurProche"> Futur proche (- de 50 ans)                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkEcartTemp5" name="boxNaration2[]" value="futurLointain"> Futur lointain (+ de 50 ans)                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Rapport au temps</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkRapTemps47" name="boxNaration3[]" value="ageOr"> Âge d'or                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkRapTemps48" name="boxNaration3[]" value="decadence"> Décadence                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkRapTemps46" name="boxNaration3[]" value="eschatologie"> Eschatologie                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div>
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkRapTemps51" name="boxNaration3[]" value="evolutionnisme"> Évolutionnisme                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkRapTemps49" name="boxNaration3[]" value="histoireCyclique"> Histoire cyclique                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkRapTemps224" name="boxNaration3[]" value="progres"> Progrès                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->


        <div class="form-group">
          <label class="col-md-2 control-label">Références intertextuelles (oeuvre ou auteur)</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control ui-autocomplete-inpu" id="txtRefInterTxt" name="referencesInter" placeholder="Référence">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->




        <hr>
        <div class="row"><div class="col-md-4">
          <blockquote>Personnages</blockquote>
        </div></div><!-- /col-md-4 /row -->

        <div class="form-group">
          <label class="col-md-2 control-label">Personnage scientifique</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control ui-autocomplete-inpu" id="txtPersDiscip" name="persoScientifique" placeholder="Discipline d&#39;un personnage scientifique">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->


        <div class="form-group">
          <label class="col-md-2 control-label">Profession</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control ui-autocomplete-inpu" id="txtPersProf" name="profession" placeholder="Profession">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->


        <div class="form-group">
          <label class="col-md-2 control-label">Genre</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersGenre1" name="boxNaration4[]" value="masculin"> Masculin                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersGenre2" name="boxNaration4[]" value="feminin"> Féminin                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersGenre3" name="boxNaration4[]" value="indetermine"> Indéterminé                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Valorisation</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersValo1" name="boxNaration5[]" value="positif"> Positif                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersValo2" name="boxNaration5[]" value="négatif"> Négatif                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersValo3" name="boxNaration5[]" value="problématique"> Problématique                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersValo4" name="boxNaration5[]" value="neutre"> Neutre                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->


        <div class="form-group">
          <label class="col-md-2 control-label">Caractéristiques</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control ui-autocomplete-inpu" id="txtPersCaract" name="caracteristiques" placeholder="Caractéristique">
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->


        <div class="form-group">
          <label class="col-md-2 control-label">Figure de l'altérité</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersFigAlt1" name="boxNaration6[]" value="europe"> Européenne                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersFigAlt2" name="boxNaration6[]" value="extra-europe"> Extra-européenne                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersFigAlt3" name="boxNaration6[]" value="extra-terrestre"> Extra-terrestre                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div>
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersFigAlt4" name="boxNaration6[]" value="creature-artificielle"> Créature artificielle                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersFigAlt5" name="boxNaration6[]" value="mutante"> Mutante                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkPersFigAlt6" name="boxNaration6[]" value="autre"> Autre                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <hr>

        <div class="form-group">
          <label class="col-md-2 control-label">Esthétique</label>
          <div class="col-md-10">
            <div class="row"><div class="col-md-12"><div class="input-group">
              <select name="selectPoet" id="selImaginEsthetique" class="form-control" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
                <option class="text-left" value="null" selected="">--- Sélectionnez un élément de la liste---</option>
                <option value="29">Aucun</option>
                <option value="21">Aventure</option>
                <option value="244">Conte philosophique</option>
                <option value="5">Didactique</option>
                <option value="12">Dystopie</option>
                <option value="7">Épique</option>
                <option value="25">Érotique</option>
                <option value="177">Ésotérique</option>
                <option value="227">étiologique</option>
                <option value="8">Fantastique</option>
                <option value="293">historique </option>
                <option value="10">Horreur</option>
                <option value="17">Humoristique</option>
                <option value="15">Ironique</option>
                <option value="28">Journalistique</option>
                <option value="209">Lyrique</option>
                <option value="9">Merveilleux</option>
                <option value="217">Mystérieux</option>
                <option value="18">Parodique</option>
                <option value="6">Pathétique</option>
                <option value="249">patriotique</option>
                <option value="26">Philosophie</option>
                <option value="27">Poésie</option>
                <option value="19">Policier</option>
                <option value="23">Post-apocalyptique</option>
                <option value="221">Psychologique</option>
                <option value="24">Religieux</option>
                <option value="22">Robinsonnade</option>
                <option value="308">roman d'apprentissage</option>
                <option value="220">Roman de moeurs</option>
                <option value="243">Roman philosophique</option>
                <option value="283">Roman préhistorique</option>
                <option value="16">Satirique</option>
                <option value="20">Sentimental</option>
                <option value="178">Tragique</option>
                <option value="13">Uchronie</option>
                <option value="11">Utopie</option>
              </select><!-- /form-control -->
            </div></div></div><!-- /input-group /col-md-12 /row-->

          </div><!-- /col-md- -->
        </div><!-- /form-group -->

      </div></div><!-- /panel-body /panel-collapse -->
    </div><!-- /panel -->

    <div class="panel panel-anticipation">
      <div class="panel-heading" role="tab" id="pheadScieSoc">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#idColpsScieSoc" aria-controls="idColpsScieSoc">
            <span id="idImgColpsScieSoc" class="glyphicon glyphicon-chevron-down"></span> Sciences et sociétés
          </a>
        </h4>
      </div><!-- /panel-heading -->
      <div id="idColpsScieSoc" class="panel-collapse collapse" role="tabpanel" aria-labelledby="pheadScieSoc"><div class="panel-body">

        <script type="text/javascript">
          $('#idColpsScieSoc').on('shown.bs.collapse', function () { vSwitchChevron($('#idImgColpsScieSoc'), 'up'); })
          $('#idColpsScieSoc').on('hidden.bs.collapse', function () { vSwitchChevron($('#idImgColpsScieSoc'), 'down'); })
        </script>

        <div class="form-group">
          <label class="col-md-2 control-label">Disciplines et thématiques</label>
          <div class="col-md-10">
            <div class="panel panel-anticipation">
              <div class="panel-heading" role="tab" id="pheadDiscThem">
                <h4 class="panel-title">
                  <a class="collapsed" role="button" data-toggle="collapse" href="https://anticipation-dev.huma-num.fr/?bRechercheAvancee=1#idColpsDiscThem" aria-controls="idColpsDiscThem">
                    <span id="idImgColpsDiscThem" class="glyphicon glyphicon-chevron-down"></span> Cliquez pour obtenir la liste des disciplines et thématiques
                  </a>
                </h4>
              </div><!-- /panel-heading -->
              <div id="idColpsDiscThem" class="panel-collapse collapse" role="tabpanel" aria-labelledby="pheadDiscThem"><div class="panel-body">


                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
              Agronomie                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem90" name="boxScience[]" value="agriculture" idchkgroup="89"> Agriculture (ex : acclimatation d’espèces nouvelles)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem91" name="boxScience[]" value="veterinaire" idchkgroup="89"> Arts vétérinaires (épizooties, maladies)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem92" name="boxScience[]" value="diet" idchkgroup="89"> Diététique (alimentation)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div></div><!-- /panel-body /panel -->
                <div class="panel panel-anticipation">
                                <div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem93" name="boxScienceAlt2[]" value="anthropologie"> Anthropologie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem94" name="boxScienceAlt2[]" value="archeologie"> Archéologie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem95" name="boxScienceAlt2[]" value="armement"> Armement : applications aux arts militaires (explosifs, canons, machines…)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem96" name="boxScienceAlt2[]" value="construction"> Art des constructions (génie civil), grands travaux (canaux, isthmes)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                <div class="input-group">
                                </div><!-- /input-group -->
                                <div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem97" name="boxScienceAlt2[]" value="astronomie"> Astronomie / Astrophysique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem98" name="chkScSoDiscThem[]" value="98|Chimie"> Chimie                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem99" name="boxScience1[]" value="chimieAnalytique" idchkgroup="98"> Chimie analytique, classifications des éléments                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem100" name="boxScience1[]" value="chimieIndustrielle" idchkgroup="98"> Chimie industrielle, procédés de fabrication (alliages, produits de synthèse)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem101" name="boxScience1[]" value="chimieOrganique" idchkgroup="98"> Chimie organique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel-body -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem102" name="chkScSoDiscThem[]" value="102|Énergie"> Énergie                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem107" name="boxScience2[]" value="atomique" idchkgroup="102"> Atomique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem104" name="boxScience2[]" value="electricite" idchkgroup="102"> Électricité                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem199" name="boxScience2[]" value="eolienne" idchkgroup="102"> Éolienne                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem106" name="boxScience2[]" value="ether" idchkgroup="102"> Éther / solaire                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                <div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem197" name="boxScience2[]" value="geothermique" idchkgroup="102"> Géothermique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem198" name="boxScience2[]" value="hydraulique" idchkgroup="102"> Hydraulique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem105" name="boxScience2[]" value="magnetisme" idchkgroup="102"> Magnétisme                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem103" name="boxScience2[]" value="thermodynamique" idchkgroup="102"> Thermodynamique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel-body -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem108" name="chkScSoDiscThem[]" value="108|Inventions / innovations techniques"> Inventions / innovations techniques                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem109" name="boxScience3[]" value="eclairage" idchkgroup="108"> Éclairage                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem110" name="boxScience3[]" value="steampunk" idchkgroup="108"> Machines à vapeur, moteurs électriques                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem111" name="boxScience3[]" value="photo" idchkgroup="108"> Photographie (galvanoplastie), cinématographe, phonographe                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem112" name="boxScience3[]" value="tele" idchkgroup="108"> Télégraphe, téléphone, radio                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div></div><!-- /panel-body /panel -->
                <div class="panel panel-anticipation">
                                <div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem113" name="boxScienceAlt3" value="math"> Mathématiques                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem114" name="chkScSoDiscThem[]" value="114|Médecine"> Médecine                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem115" name="boxScience4[]" value="anatomie" idchkgroup="114"> Anatomie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem116" name="boxScience4[]" value="chirurgie" idchkgroup="114"> Chirurgie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem117" name="boxScience4[]" value="histologie" idchkgroup="114"> Histologie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem118" name="boxScience4[]" value="homeopathie" idchkgroup="114"> Homéopathie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                <div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem119" name="boxScience4[]" value="hygiene" idchkgroup="114"> Hygiène publique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem120" name="boxScience4[]" value="pathologie" idchkgroup="114"> Pathologies : épidémies, infections…                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem122" name="boxScience4[]" value="physiologie" idchkgroup="114"> Physiologie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem176" name="boxScience4[]" value="psychologie" idchkgroup="114"> Psychologie / psychiatrie (magnétisme, hypnose)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                <div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem121" name="boxScience4[]" value="therapeute" idchkgroup="114"> Thérapeutiques : électrothérapies, inoculations, vaccinations                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div></div><!-- /panel-body /panel -->
                <div class="panel panel-anticipation">
                                <div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem123" name="boxScienceAlt" value="paleon"> Paléontologie, préhistoire                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem124" name="chkScSoDiscThem[]" value="124|Physique"> Physique                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem125" name="boxScience5[]" value="acoustique" idchkgroup="124"> Acoustique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem126" name="boxScience5[]" value="electriciteMagn" idchkgroup="124"> Électricité, magnétisme                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem127" name="boxScience5[]" value="mecanique" idchkgroup="124"> Mécanique, hydraulique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem128" name="boxScience5[]" value="optique" idchkgroup="124"> Optique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                <div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem129" name="boxScience5[]" value="physiqueAtome" idchkgroup="124"> Physique atomique, rayonnements                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem130" name="boxScience5[]" value="thermodynamique" idchkgroup="124"> Thermodynamique (chaleur)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel-body -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem131" name="chkScSoDiscThem[]" value="131|Sciences biologiques"> Sciences biologiques                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem190" name="boxScience6[]" value="bacteriologie" idchkgroup="131"> Bactériologie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem132" name="boxScience6[]" value="genetique" idchkgroup="131"> Génétique / héréditarisme                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem134" name="boxScience6[]" value="microbiologie" idchkgroup="131"> Microbiologie / biochimie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel-body -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem135" name="chkScSoDiscThem[]" value="135|Sciences naturelles"> Sciences naturelles                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem136" name="boxScience7[]" value="botanique" idchkgroup="135"> Botanique                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem137" name="boxScience7[]" value="entomologie" idchkgroup="135"> Entomologie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem138" name="boxScience7[]" value="mycologie" idchkgroup="135"> Mycologie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem139" name="boxScience7[]" value="zoologie" idchkgroup="135"> Zoologie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel-body -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem140" name="chkScSoDiscThem[]" value="140|Sciences de la terre"> Sciences de la terre                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem195" name="boxScience8[]" value="catastrophe" idchkgroup="140"> Catastrophes naturelles                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem141" name="boxScience8[]" value="ethnologie" idchkgroup="140"> Ethnologie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem143" name="boxScience8[]" value="geographie" idchkgroup="140"> Géographie, géodésie (voyages scientifiques d’exploration, expéditions)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem142" name="boxScience8[]" value="geologie" idchkgroup="140"> Géologie / Minéralogie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                <div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem144" name="boxScience8[]" value="meteorologie" idchkgroup="140"> Météorologie (ex : inondations)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem145" name="boxScience8[]" value="oceanologie" idchkgroup="140"> Océanographie                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel-body -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem146" name="chkScSoDiscThem[]" value="146|Sociabilités scientifiques"> Sociabilités scientifiques                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem147" name="boxScience9[]" value="mondeSavant" idchkgroup="146"> Monde savant, communauté scientifique (académies, sociétés savantes, université)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem148" name="boxScience9[]" value="spectacles" idchkgroup="146"> Spectacles scientifiques (expositions universelles, conférences et démonstrations publiques)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- /input-group -->
                                </div><!-- /panel-body -->
                                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem149" name="chkScSoDiscThem[]" value="149|Transports"> Transports                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem150" name="boxScience10[]" value="aerostats, appareils aériens" idchkgroup="149"> Aérostats, appareils aériens                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem152" name="boxScience10[]" value="transportMaritime" idchkgroup="149"> Transport maritime (bateaux à vapeur, sous-marins…)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem154" name="boxScience10[]" value="transportSouterrain" idchkgroup="149"> Transport souterrain (métro…)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <input type="checkbox" id="chkScSoDiscThem151" name="boxScience10[]" value="transportTerrestre" idchkgroup="149"> Transport terrestre (automobiles, chemin de fer…)                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                                </div><!-- Pour le panel-body -->
                                </div></div><!-- /input-group /panel -->
              </div></div><!-- /panel-body /panel-collapse -->
            </div><!-- /panel -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <hr>
        <div class="row"><div class="col-md-4">
          <blockquote>Références à des éléments scientifiques réels</blockquote>
        </div></div><!-- /col-md-4 /row -->

        <div class="form-group">
          <label class="col-md-2 control-label">Théorie ou invention</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon"><input id="chkReelThInvTous" name="chkReelThInvTous" type="checkbox" value="tous" aria-label="..."> Toutes</span>
              <span id="btnAjoutReelThInv" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfReelThInvAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control ui-autocomplete-input" id="txtReelThInv" name="theorie" placeholder="Sélectionnez une théorie ou une invention" autocomplete="off">
            </div><!-- /input-group -->
            <div id="listeReelThInv">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeReelThInv-0" name="txtListeReelThInv-0" value="Aucune saisie" readonly="">
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkReelThInvTous').click(function(){
                if (document.getElementById('chkReelThInvTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Théhorie ou invention" ne sera prise en compte dans la requête');
                  $('#listeReelThInv :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtReelThInv').attr('disabled', '');
                } else {
                  $('#listeReelThInv :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtReelThInv').removeAttr('disabled');
                }
              });
              $('#btnAjoutReelThInv').click(function(){
                if ($('#txtReelThInv').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbReelThInv++;
                  vAjouteChamp('listeReelThInv', 'txtListeReelThInv', iNbReelThInv, $('#txtReelThInv'), 0);
                  // On vide le champ txtReelThInv
                  $('#txtReelThInv').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                $("#txtReelThInv").catcomplete({
                  source: function (request, response){
                    if ($('#imgInfReelThInvAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfReelThInvAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfReelThInvAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfReelThInvAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfReelThInvAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfReelThInvAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 12, strReelThInv: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfReelThInvAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              category: item.category,
                              label: item.reference,
                              value: item.reference
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfReelThInvAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfReelThInvAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfReelThInvAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfReelThInvAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfReelThInvAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfReelThInvAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfReelThInvAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfReelThInvAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbReelThInv++;
                    vAjouteChamp('listeReelThInv', 'txtListeReelThInv', iNbReelThInv, ui, 0);
                    // $('#txtReelThInv').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbReelThInv = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Personnalité scientifique</label>
          <div class="col-md-10">
            <div class="input-group">
              <span class="input-group-addon"><input id="chkReelPersSciTous" name="chkReelPersSciTous" type="checkbox" value="tous" aria-label="..."> Toutes</span>
              <span id="btnAjoutReelPersSci" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfReelPersSciAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control ui-autocomplete-input" id="personaliteScientifique" name="txtReelPersSci" placeholder="Sélectionnez une personnalité scientifique" autocomplete="off">
            </div><!-- /input-group -->
            <div id="listeReelPersSci">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeReelPersSci-0" name="txtListeReelPersSci-0" value="Aucune saisie" readonly="">
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkReelPersSciTous').click(function(){
                if (document.getElementById('chkReelPersSciTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Personnalité scientifique" ne sera prise en compte dans la requête');
                  $('#listeReelPersSci :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtReelPersSci').attr('disabled', '');
                } else {
                  $('#listeReelPersSci :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtReelPersSci').removeAttr('disabled');
                }
              });
              $('#btnAjoutReelPersSci').click(function(){
                if ($('#txtReelPersSci').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbReelPersSci++;
                  vAjouteChamp('listeReelPersSci', 'txtListeReelPersSci', iNbReelPersSci, $('#txtReelPersSci'), 0);
                  // On vide le champ txtReelPersSci
                  $('#txtReelPersSci').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtReelPersSci").autocomplete
                $("#txtReelPersSci").catcomplete({
                  source: function (request, response){
                    if ($('#imgInfReelPersSciAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfReelPersSciAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfReelPersSciAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfReelPersSciAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfReelPersSciAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfReelPersSciAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 19, strReelPersSci: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfReelPersSciAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              category: item.category,
                              label: item.reference,
                              value: item.reference
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfReelPersSciAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfReelPersSciAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfReelPersSciAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfReelPersSciAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfReelPersSciAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfReelPersSciAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfReelPersSciAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfReelPersSciAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbReelPersSci++;
                    vAjouteChamp('listeReelPersSci', 'txtListeReelPersSci', iNbReelPersSci, ui, 0);
                    // $('#txtReelPersSci').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbReelPersSci = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Discipline</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelDiscipline1" name="boxScience11[]" value="scienceVie"> Sciences de la vie (inclut biologie, botanique, zoologie)                   </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelDiscipline2" name="boxScience11[]" value="scienceMedicale"> Sciences médicales                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelDiscipline3" name="boxNaration11[]" value="scienceTerre"> Sciences  de la terre et de l’espace  (astronomie, géologie, géographie)                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelDiscipline4" name="boxScience11[]" value="sciencePhysique"> Physique, chimie et mathématiques                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelDiscipline5" name="boxScience11[]" value="ingenieurie"> Ingénierie et technique                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelDiscipline6" name="boxScience11[]" value="autree"> Autre                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Modalité</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelModal1" name="boxScience12[]" value="serieux"> Sérieux                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelModal2" name="boxScience12[]" value="satire"> Satire                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelModal3" name="boxScience12[]" value="hommage"> Hommage                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkReelModal4" name="boxScience12[]" value="refutation"> Réfutation                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <hr>
        <div class="row"><div class="col-md-4">
          <blockquote>Références à des éléments scientifiques imaginaires</blockquote>
        </div></div><!-- /col-md-4 /row -->

        <div class="form-group">
          <label class="col-md-2 control-label">Termes utilisés dans la description</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon"><input id="chkImaginDescTous" name="chkImaginDescTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <span id="btnAjoutImaginDesc" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfImaginDescAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control ui-autocomplete-input" id="txtImaginDesc" name="termeDescription" placeholder="Sélectionnez un terme dans les descriptions" autocomplete="off">
            </div><!-- /input-group -->
            <div id="listeImaginDesc">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeImaginDesc-0" name="txtListeImaginDesc-0" value="Aucune saisie" readonly="">
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkImaginDescTous').click(function(){
                if (document.getElementById('chkImaginDescTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Références (...)" ne sera prise en compte dans la requête');
                  $('#listeImaginDesc :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtImaginDesc').attr('disabled', '');
                } else {
                  $('#listeImaginDesc :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtImaginDesc').removeAttr('disabled');
                }
              });
              $('#btnAjoutImaginDesc').click(function(){
                if ($('#txtImaginDesc').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbImaginDesc++;
                  vAjouteChamp('listeImaginDesc', 'txtListeImaginDesc', iNbImaginDesc, $('#txtImaginDesc'), 0);
                  // On vide le champ txtImaginDesc
                  $('#txtImaginDesc').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtImaginDesc").catcomplete
                $("#txtImaginDesc").autocomplete({
                  source: function (request, response){
                    if ($('#imgInfImaginDescAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfImaginDescAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfImaginDescAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfImaginDescAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfImaginDescAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfImaginDescAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 13, strImaginDesc: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfImaginDescAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              // category: item.category,
                              label: item.description,
                              value: item.description
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfImaginDescAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfImaginDescAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfImaginDescAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfImaginDescAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfImaginDescAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfImaginDescAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfImaginDescAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfImaginDescAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbImaginDesc++;
                    vAjouteChamp('listeImaginDesc', 'txtListeImaginDesc', iNbImaginDesc, ui, 0);
                    // $('#txtImaginDesc').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbImaginDesc = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Domaine des inventions techniques</label>
          <div class="col-md-10">
            <div class="row"><div class="col-md-12"><div class="input-group">
              <span class="input-group-addon"><input id="chkImaginDomaineTous" name="chkImaginDomaineTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <select id="inventionsTechniques" class="form-control" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
                <option class="text-left" value="null" selected="">--- Sélectionnez un élément de la liste---</option>
                <option value="258">Armes</option>
                <option value="259">Communications, image/son</option>
                <option value="250">Corps humain, pouvoirs psychiques, vie/mort</option>
                <option value="254">Espace</option>
                <option value="251">Formes de vie inconnue</option>
                <option value="252">Modifications de la nature</option>
                <option value="256">Sources d'énergie</option>
                <option value="253">Temps</option>
                <option value="260">Théories scientifiques</option>
                <option value="257">Transports</option>
                <option value="255">Vie quotidienne</option>
                <option value="268">Autre</option>
              </select><!-- /form-control -->
              <script>
                $('#chkImaginDomaineTous').click(function(){
                  if (document.getElementById('chkImaginDomaineTous').checked === true) {
                    // On a coché Tous
                    alert('En sélectionnant cette case aucune saisie des "Domaine des inventions techniques" ne sera prise en compte dans la requête');
                    $('#listeImaginDomaine :input').each(function(){
                      $(this).attr('disabled', '');
                    });
                    $('#selImaginDomaine').attr('disabled', '');
                  } else {
                    $('#listeImaginDomaine :input').each(function(){
                      $(this).removeAttr('disabled');
                    });
                    $('#selImaginDomaine').removeAttr('disabled');
                  }
                });
                $('#selImaginDomaine').change(function(){
                  iNbImaginDomaine++;
                  vAjouteChamp('listeImaginDomaine', 'txtListeImaginDomaine', iNbImaginDomaine, this, 1);
                  this.selectedIndex = 0;
                });
                var iNbImaginDomaine = 0;
              </script>
            </div></div></div><!-- /input-group /col-md-12 /row-->
            <div id="listeImaginDomaine">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeImaginDomaine-0" name="txtListeImaginDomaine-0" value="Aucune saisie" readonly="">
              </div></div><!-- /col-md-12 /row-->
            </div>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Voyage(s)</label>
          <div class="col-md-10">
            <div class="row"><div class="col-md-12"><div class="input-group">
              <span class="input-group-addon"><input id="chkImaginVoyageTous" name="chkImaginVoyageTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <select name="voyages" id="selImaginVoyage" class="form-control" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
                <option class="text-left" value="null" selected="">--- Sélectionnez un élément de la liste---</option><option value="81">Sur la Terre</option>
                <option value="82">À l'intérieur de la Terre</option>
                <option value="83">Dans l'espace</option>
                <option value="84">Sur une autre planète</option>
                <option value="85">Rêvé (par le personnage)</option>
                <option value="86">Temporel</option>
                <option value="87">À l’intérieur du corps humain</option>
                <option value="223">Mondes parallèles et autres dimensions</option>
                <option value="88">Aucun</option>
              </select><!-- /form-control -->
              <script>
                $('#chkImaginVoyageTous').click(function(){
                  if (document.getElementById('chkImaginVoyageTous').checked === true) {
                    // On a coché Tous
                    alert('En sélectionnant cette case aucune saisie des "Voyage" ne sera prise en compte dans la requête');
                    $('#listeImaginVoyage :input').each(function(){
                      $(this).attr('disabled', '');
                    });
                    $('#selImaginVoyage').attr('disabled', '');
                  } else {
                    $('#listeImaginVoyage :input').each(function(){
                      $(this).removeAttr('disabled');
                    });
                    $('#selImaginVoyage').removeAttr('disabled');
                  }
                });
                $('#selImaginVoyage').change(function(){
                  iNbImaginVoyage++;
                  vAjouteChamp('listeImaginVoyage', 'txtListeImaginVoyage', iNbImaginVoyage, this, 1);
                  this.selectedIndex = 0;
                });
                var iNbImaginVoyage = 0;
              </script>
            </div></div></div><!-- /input-group /col-md-12 /row-->
            <div id="listeImaginVoyage">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeImaginVoyage-0" name="txtListeImaginVoyage-0" value="Aucune saisie" readonly="">
              </div></div><!-- /col-md-12 /row-->
            </div>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <hr>
        <div class="row"><div class="col-md-4">
          <blockquote>Représentation de la société</blockquote>
        </div></div><!-- /col-md-4 /row -->

        <div class="form-group">
          <label class="col-md-2 control-label">Représentation d'une société imaginaire</label>
          <div class="col-md-10">
            <div class="input-group">
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkImaginSoci1" name="boxScience13[]" value="presentTemp"> Présente
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkImaginSoci2" name="boxScience13[]" value="absentTemp"> Absente
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkImaginSoci3" name="boxScience13[]" value="plusieursTemp"> Plusieurs
                  </label>
                </div>
              </span><!-- /input-group-addon -->
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Degré de technologie</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkImaginTechno1" name="boxNaration14[]" value="fortDegre"> Fort                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkImaginTechno2" name="boxScience14[]" value="neutreDegre"> Neutre                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkImaginTechno3" name="boxScience14[]" value="faibleDegre"> Faible                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkImaginTechno4" name="boxScience14[]" value="indetermiteDegre"> Indéterminé                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->



        <div class="form-group">
          <label class="col-md-2 control-label">Valeur</label>
          <div class="col-md-10">
            <div class="input-group">
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkImaginValeur1" name="boxScience15[]" value="positifValeur"> Positive                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkImaginValeur2" name="boxScience15[]" value="negatifValeur"> Négative                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkImaginValeur3" name="boxScience15[]" value="neutreValeur"> Neutre                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkImaginValeur4" name="boxScience15[]" value="ambivalenteValeur"> Ambivalente                  </label>
                </div>
              </span><!-- /input-group-addon -->
                            <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <input type="checkbox" id="chkImaginValeur5" name="boxNaration15[]" value="indetermineValeur"> Indéterminée                  </label>
                </div>
              </span><!-- /input-group-addon -->
                          </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Traits spécifiques de la société imaginaire</label>
          <div class="col-md-10">
            <div class="row"><div class="col-md-12"><div class="input-group">
              <span class="input-group-addon"><input id="chkSocImaginTraitsSpecTous" name="chkSocImaginTraitsSpecTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <select name="selectSoc" id="selSocImaginTraitsSpec" class="form-control" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
                <option class="text-left" value="null" selected="">--- Sélectionnez un élément de la liste---</option>
                <option value="39">Anarchisme</option>
                <option value="37">Aristocratie</option>
                <option value="38">Démocratie</option>
                <option value="34">Dictature</option>
                <option value="35">Monarchie</option>
                <option value="36">Ploutocratie</option>
                <option value="33">Politique</option>
                <option value="205">République</option>
                <option value="204">Révolution</option>
                <option value="43">Capitalisme</option>
                <option value="40">Économie</option>
                <option value="42">Marxisme</option>
                <option value="41">Socialisme</option>
                <option value="245">Géopolitique</option>
                <option value="44">Guerre</option>
                <option value="45">Religion</option>
                <option value="50">Positivisme</option>
                <option value="53">Agriculture</option>
                <option value="54">Commerce</option>
                <option value="52">Écologie</option>
                <option value="55">Justice</option>
                <option value="186">Presse</option>
                <option value="213">habitat</option>
                <option value="56">Industrie</option>
                <option value="175">Langues</option>
                <option value="58">Moyens de communication</option>
                <option value="57">Transport</option>
                <option value="59">Urbanisme</option>
                <option value="63">Musique</option>
                <option value="62">Peinture</option>
                <option value="60">Poésie/littérature</option>
                <option value="61">Sculpture</option>
                <option value="68">Alimentation</option>
                <option value="192">Climat</option>
                <option value="64">Éducation</option>
                <option value="67">Famille</option>
                <option value="69">Habillement</option>
                <option value="72">Loisirs</option>
                <option value="66">Mariage</option>
                <option value="70">Mort</option>
                <option value="71">Santé</option>
                <option value="65">Sexualité</option>
                <option value="75">Classes sociales</option>
                <option value="74">Colonialisme</option>
                <option value="78">Handicap</option>
                <option value="73">Place des femmes</option>
                <option value="76">Races</option>
                <option value="77">Vieillesse</option>
                <option value="188">Animaux</option>
                <option value="248">Science</option>
              </select><!-- /form-control -->
              <script>
                $('#chkSocImaginTraitsSpecTous').click(function(){
                  if (document.getElementById('chkSocImaginTraitsSpecTous').checked === true) {
                    // On a coché Tous
                    alert('En sélectionnant cette case aucune saisie des "Traits spécifiques de la société imaginaire" ne sera prise en compte dans la requête');
                    $('#listeSocImaginTraitsSpec :input').each(function(){
                      $(this).attr('disabled', '');
                    });
                    $('#selSocImaginTraitsSpec').attr('disabled', '');
                  } else {
                    $('#listeSocImaginTraitsSpec :input').each(function(){
                      $(this).removeAttr('disabled');
                    });
                    $('#selSocImaginTraitsSpec').removeAttr('disabled');
                  }
                });
                $('#selSocImaginTraitsSpec').change(function(){
                  iNbSocImaginTraitsSpec++;
                  vAjouteChamp('listeSocImaginTraitsSpec', 'txtListeSocImaginTraitsSpec', iNbSocImaginTraitsSpec, this, 1);
                  this.selectedIndex = 0;
                });
                var iNbSocImaginTraitsSpec = 0;
              </script>
            </div></div></div><!-- /input-group /col-md-12 /row-->
            <div id="listeSocImaginTraitsSpec">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeSocImaginTraitsSpec-0" name="txtListeSocImaginTraitsSpec-0" value="Aucune saisie" readonly="">
              </div></div><!-- /col-md-12 /row-->
            </div>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

      </div></div><!-- /panel-body /panel-collapse -->
    </div><!-- /panel Sciences et sociétés -->

  </div></div><!-- /idColpsRechAvance /panel-body -->

  <div class="panel-footer">
    <div class="btn-group" role="group">
            <button id="btnRechAvanceReset" class="btn btn-default" type="reset">Réinitialiser</button>
            <button id="btnRechAvanceSubmit" class="btn btn-danger">Choisir le graphique le plus pertinent</button>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#guideModal">
              <span class="glyphicon glyphicon-question-sign"></span>

            </button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="guideModal" tabindex="-1" role="dialog" aria-labelledby="guideModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="guideModalLabel">Guide d'utilisation</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div>Pour générer un graphique il faut d'abord remplir les champs de recherches souhaités
            puis choisir un graphique en cliquant dessus.</div>
            <img title="La barre du menu" class="guide" src="../images/graphique/exemple_barre_plot.ly.png"/>
            <div>
            Tous les graphiques à l'exception du graphe réseaux et du nuage de mots disposent d'une barre visible en haut à droite du graphique généré offrant plusieurs fonctionnalités à l'utilisateur :</br>
            <ul>
                <li>Sauvegarder l'image en .png</li>
                <li>Sauvegarder l'image en .svg</li>
                <li>Sélection rectangulaire</li>
                <li>Sélection lasso</li>
                <li>Activer/désactiver les pics</li>
                <li>Données les plus proches en survol</li>
                <li>Comparaison entre données en survol</li>
            </ul>
          </div>
          Vous pouvez à l'aide d'un clic droit sur le graphe réseau accéder aux fonctionnalités suivantes :
          <ul>
              <li>Sélection rectangulaire</li>
              <li>Sauvegarder le graphe aux formats : .png, .jpg, .pdf et .svg</li>
              <li>Partager le graphe</li>
              <li>Sauvegarder les données du graphe aux formats : .csv et .xlsx</li>
              <li>Imprimer</li>
              <li>Mettre le graphe en plein écran</li>
          </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-dark-red" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div id='response'></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js "></script>
<script>
var globalData = false;
$(document).ready(function(){
    $('#formRechAvance').submit(function(){

        // show that something is loading
        $('#response').html("<b>Chargement des graphiques... Veuillez patienter.</b>");

        /*
         * 'post_receiver.php' - where you will pass the form data
         * $(this).serialize() - to easily read form data
         * function(data){... - data contains the response from post_receiver.php
         */
        $.ajax({
            type: 'POST',
            url: 'searchBase.php',
            data: $(this).serialize(),
            async: false,
            dataType: "json",
            success: function(data){

              // Remettre l'html vide
              $('#response').html("");

              globalData = data;
              // Si l'on a pas choisi de graphe, générer un bar chart par défault
              // TODO: Il faudrait faire le choix de graphe automatiquement
              // Ne pas faire ce choix si un graphique est déja choisi
              if (selectedChart === null) {
                selectedChart = "graphique-type1";
              }
              generateChosenChart(selectedChart);
            }
        });

        // to prevent refreshing the whole page page
        return false;

    });
});
</script>

</div><!-- /panel -->

  <script>
    $('#formRechAvance').on('submit', function() {
      return false;
    });
    $('#btnRechAvanceSubmit').on('click', function () {
      $('#idColpsRechAvance').collapse('hide');
      $('#Patience').modal('show');
      // Simulation de 5 secondes d'attente
      // window.setTimeout("$('#btnRechAvanceSubmit').button('reset');$('#Patience').modal('hide');$('#idColpsRechAvance').collapse('show');",5000);
      strTriChamp = '';
      strTriOrdre = '';
      // maxLignes = 20;
      maxLignes = 100000;
      vChargeRecherche(21);
      return false;
    })
    $('#Patience').on('hide.bs.modal', function() {
      $('#btnRechAvanceSubmit').button('reset');
    });
    $('#btnRechAvanceReset').on('click', function () {
      // On supprime tous les disabled du formulaire (pour l'instant, limité aux textes, select et checkbox)
      // PS: trouver éventuellement un moyen de faire ça dans une commande JQuery ;)
      $('#formRechAvance input:disabled[type="text"]').not('[id$="-0"]').each(function() { $(this).removeAttr('disabled'); });
      $('#formRechAvance input:disabled[type="checkbox"]').each(function() { $(this).removeAttr('disabled'); });
      $('#formRechAvance select:disabled').each(function() { $(this).removeAttr('disabled'); });
      // Suppression des div class="input-group" contenant les txtListe* (qui ne le sont pas avec un reset javascript du formulaire)
      // Récupération de la base de l'identifiant
      var OExpReguliere = /(txtListe.*)-\d*/
      $('#formRechAvance input[type="text"][id^="txtListe"]').not('[id$="-0"]').each(function() {
        // Sauvegarde de l'id pour ajout si besoin d'un élément vide
        OExpReguliere.exec($(this).attr('id'));
        var strId = RegExp.$1;
        if (!$("input[id^='"+strId+"-']").eq(1).is('input')) {
          // Il y n'y a plus qu'un élément dans la liste (celui qui sera supprimé) donc: création d'un élément pour indiqué "Aucune saisie")
          $(this).parent().parent().append('<div class="row"><div class="col-md-12"> <input type="text" class="form-control" id="'+strId+'-0" name="'+strId+'-0" value="Aucune saisie" readonly> </div></div>\n');
        }
        $(this).parent().remove();
      });
      // return false;
    });
  </script>

</form>
