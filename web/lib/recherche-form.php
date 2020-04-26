<?php
// ---------------------------------------------------------- //
// recherche-form.php                                         //
//                                                            //
// librairies pour la génération des formulaires de recherche //
//                                                            //
// ---------------------------------------------------------- //

?>

<form id="formRechAvance" class="form-horizontal">
  <div class="panel panel-anticipation">
    <div class="panel-heading" role="tab" id="pheadRechAvanc">
      <div class="row"><div class="col-md-11">
      <!-- <h3 class="panel-title">Recherche avancée</h3> -->
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" href="#idColpsRechAvance" aria-controls="idColpsRechAvance">
          <span id="idImgColpsRechAvanc" class="glyphicon glyphicon-chevron-up"></span> Formulaire de recherche
        </a>
      </h4>
      </div><!-- /col-md-11 -->
  
<?php
  //     // <div class="col-md-1 text-right">
  //     //   <button id="btnFermeFormAvance" type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
  //     //   <script type="text/javascript"> $('#btnFermeFormAvance').click(function () { $('#formRechAvance').remove(); }) </script>
  //     // </div>
?>
  
      </div><!-- /row -->
    </div><!-- /panel-heading -->
  
  <div id="idColpsRechAvance" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="pheadRechAvanc"><div class="panel-body">
    <?php
    // <script type="text/javascript">
    //   $('#idColpsRechAvance').on('shown.bs.collapse', function () { vSwitchChevron($('#idImgColpsRechAvanc'), 'up'); })
    //   $('#idColpsRechAvance').on('hidden.bs.collapse', function () { vSwitchChevron($('#idImgColpsRechAvanc'), 'down'); })
    // </script>

    ?>
    <div class="panel panel-anticipation">
      <div class="panel-heading" role="tab" id="pheadPresente">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" href="#idColpsPresente" aria-controls="idColpsPresente">
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
              <input type="text" class="form-control" id="txtTitrePE" name="txtTitrePE" placeholder="Titre de l'oeuvre">
              <script>$('#txtTitrePE').focus();</script>
              <span class="input-group-addon">
                <input type="radio" id="rdTitrePE" name="rdTitrePE" value="contient" checked> contient le mot
              </span>
              <span class="input-group-addon">
                <input type="radio" id="rdTitrePE" name="rdTitrePE" value="commence"> commence par
              </span>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Auteur de l'oeuvre</label>
          <div class="col-md-10">
            <div class="input-group">
              <input type="text" class="form-control" id="txtAuteur" name="txtAuteur" placeholder="Nom ou Prénom de l'auteur">
              <span class="input-group-addon">
                <input type="radio" id="rdAuteur" name="rdAuteur" value="NomPrenom" checked> Nom et Prénom
              </span>
              <span class="input-group-addon">
                <input type="radio" id="rdAuteur" name="rdAuteur" value="Nom"> Nom uniquement
              </span>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Date de première édition</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODatePrEdit" title="Info" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA<br />- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.<br />- Pour filtrer les publications avant une année, saisissez l'année dans le deuxième champ et laisser le premier vide.<br />- Pour filtrer les publications après une année, saisissez l'année dans le premier champ et laisser le deuxième vide." data-original-title="Détails sur la saisie des dates" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <script type="text/javascript"> $('#spPODatePrEdit').popover()</script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control" id="txtAnneePEDeb" name="txtAnneePEDeb" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"> à </span>
                <input type="text" class="form-control" id="txtAnneePEFin" name="txtAnneePEFin" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
            </div><!-- /form-inline -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Nature du texte</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
                foreach ($aListeNatureTexte as $key => $value) {
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                  <?php
                    echo '<input type="checkbox" id="chkNatureTxt'.$key.'" name="chkNatureTxt[]" value="'.$value['idRef'].'|'.$value['libelle'].'"> '.$value['libelle']."\n";
                  ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                } // /foreach
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

      </div></div><!-- /panel-body /panel-collapse -->
    </div><!-- /panel -->

    <div class="panel panel-anticipation">
      <div class="panel-heading" role="tab" id="pheadEtudeGenre">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" href="#idColpsEtudeGenre" aria-controls="idColpsEtudeGenre">
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
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutDesignation" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              // <span class="input-group-addon">
              //   <div class="checkbox">
              //     <label>
              //       <input type="checkbox" id="chkDesGeneriqueTous" name="chkDesGeneriqueTous" value="discAuctorial"> Tous
              //     </label>
              //   </div>
              // </span><!-- /input-group-addon -->
              ?>
              <span class="input-group-addon"><input id="chkDesGeneriqueTous" name="chkDesGeneriqueTous" type="checkbox" value="tous" aria-label="..."> Toutes</span>
              <span id="btnAjoutDesignation" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfDesAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtDesGenerique" name="txtDesGenerique" placeholder="Désignation du discours auctorial, du dispositif éditorial ou de la réception critique">
            </div><!-- /input-group -->
            <div id="listeDesGenerique">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeDescription-0" name="txtListeDescription-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkDesGeneriqueTous').click(function(){
                if (document.getElementById('chkDesGeneriqueTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Désignation génériques" ne sera prise en compte dans la requête');
                  $('#listeDesGenerique :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtDesGenerique').attr('disabled', '');
                } else {
                  $('#listeDesGenerique :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtDesGenerique').removeAttr('disabled');
                }
              });
              $('#btnAjoutDesignation').click(function(){
                if ($('#txtDesGenerique').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbDescription++;
                  vAjouteChamp('listeDesGenerique', 'txtListeDescription', iNbDescription, $('#txtDesGenerique'), 0);
                  // On vide le champ txtDesGenerique
                  $('#txtDesGenerique').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtDesGenerique").autocomplete
                $("#txtDesGenerique").catcomplete({
                  source: function (request, response){
                    if ($('#imgInfDesAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfDesAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfDesAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfDesAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfDesAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfDesAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 3, strDesignation: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfDesAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              category: item.category,
                              label: item.designation,
                              value: item.designation
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfDesAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfDesAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfDesAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfDesAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfDesAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfDesAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfDesAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfDesAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des désignations
                    iNbDescription++;
                    vAjouteChamp('listeDesGenerique', 'txtListeDescription', iNbDescription, ui, 0);
                    $('#txtDesGenerique').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbDescription = 0;
            </script>
          </div><!-- /col-md-10 -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Année de la (des) désignation(s)</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODateDes" title="Info" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA<br />- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.<br />- Pour filtrer les publications avant une année, saisissez l'année dans le deuxième champ et laisser le premier vide.<br />- Pour filtrer les publications après une année, saisissez l'année dans le premier champ et laisser le deuxième vide." data-original-title="Détails sur la saisie des dates" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <script type="text/javascript"> $('#spPODateDes').popover()</script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control" id="txtAnneeDesignationDateDeb" name="txtAnneeDesignationDateDeb" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"> à </span>
                <input type="text" class="form-control" id="txtAnneeDesignationDateFin" name="txtAnneeDesignationDateFin" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
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
                    <input type="checkbox" id="chkTypeDes1" name="chkTypeDes[]" value="discAuctorial" checked> Discours auctorial
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkTypeDes2" name="chkTypeDes[]" value="dispEditorial" checked> Dispositif éditorial
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkTypeDes3" name="chkTypeDes[]" value="recepCritique" checked> Réception critique
                  </label>
                </div>
              </span><!-- /input-group-addon -->
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->
        <?php
        // <script type="text/javascript">
        //   // On impose qu'au moins un discours soit coché
        //   $('input:checkbox[id*=chkTypeDes]').click(function(){
        //     // Si chkScSoDiscThem du groupe existe, on le coche
        //     if ($(this).attr('idChkGroup') && $('chkScSoDiscThem'+$(this).attr('idChkGroup')) && document.getElementById($(this).attr('id')).checked && !document.getElementById('chkScSoDiscThem'+$(this).attr('idChkGroup')).checked) {
        //       // Pas réussi à faire la même chose avec JQuery: $('chkScSoDiscThem'+$(this).attr('idChkGroup')).attr('checked', 'true');
        //       document.getElementById('chkScSoDiscThem'+$(this).attr('idChkGroup')).checked = true;
        //     } else {
        //       // S'il existe des chkScSoDiscThem avec attribut idChkGroup correspondant à celui cliqué, on force à le coché si un chkScSoDiscThem est coché... je ne sait pas si l'explication est claire ^_^
        //       var OExpReguliere = /chkScSoDiscThem(\d*)/
        //       // Récupération du mot[id] du groupe
        //       OExpReguliere.exec($(this).attr('id'));
        //       $('input[type=checkbox][idChkGroup='+RegExp.$1+']:checked').each(function() {
        //         // Au moins une discipline ou thémathique du groupe coché: on force le checkbox du groupe à être coché
        //         document.getElementById('chkScSoDiscThem'+RegExp.$1).checked = true;
        //       });
        //     }
        //   });
        // </script>
        ?>

        <hr />

        <div class="form-group">
          <label class="col-md-2 control-label">Auteurs comparés</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutAuteur" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkAutCompTous" name="chkAutCompTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <span id="btnAjoutAuteur" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfAAuteursAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtLiensAAuteurs" name="txtLiensAAuteurs" placeholder="Saisissez un auteur comparé">
            </div><!-- /input-group -->
            <div id="listeLiensAAuteurs">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeLien-0" name="txtListeLien-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkAutCompTous').click(function(){
                if (document.getElementById('chkAutCompTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Auteurs comparés" ne sera prise en compte dans la requête');
                  $('#listeLiensAAuteurs :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtLiensAAuteurs').attr('disabled', '');
                } else {
                  $('#listeLiensAAuteurs :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtLiensAAuteurs').removeAttr('disabled');
                }
              });
              $('#btnAjoutAuteur').click(function(){
                if ($('#txtLiensAAuteurs').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbLien++;
                  vAjouteChamp('listeLiensAAuteurs', 'txtListeLien', iNbLien, $('#txtLiensAAuteurs'), 0);
                  // On vide le champ txtLiensAAuteurs
                  $('#txtLiensAAuteurs').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtLiensAAuteurs").catcomplete
                $("#txtLiensAAuteurs").autocomplete({
                  source: function (request, response){
                    if ($('#imgInfAAuteursAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfAAuteursAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfAAuteursAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfAAuteursAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfAAuteursAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfAAuteursAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 4, strAuteur: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfAAuteursAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              label: item.auteurCompare,
                              value: item.auteurCompare
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfAAuteursAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfAAuteursAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfAAuteursAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfAAuteursAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfAAuteursAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfAAuteursAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfAAuteursAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfAAuteursAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbLien++;
                    vAjouteChamp('listeLiensAAuteurs', 'txtListeLien', iNbLien, ui, 0);
                    $('#txtLiensAAuteurs').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbLien = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Date du lien avec l'auteur</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODateLienAut" title="Info" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA<br />- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.<br />- Pour filtrer les publications avant une année, saisissez l'année dans le deuxième champ et laisser le premier vide.<br />- Pour filtrer les publications après une année, saisissez l'année dans le premier champ et laisser le deuxième vide." data-original-title="Détails sur la saisie des dates" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <script type="text/javascript"> $('#spPODateLienAut').popover()</script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control" id="txtAnneeLienAAuteurDateDeb" name="txtAnneeLienAAuteurDateDeb" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
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
                <input type="text" class="form-control" id="txtAnneeLienAAuteurDateFin" name="txtAnneeLienAAuteurDateFin" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
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
          <a class="collapsed" role="button" data-toggle="collapse" href="#idColpsDescMat" aria-controls="idColpsDescMat">
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
          <label class="col-md-2 control-label">Support de publication</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutSupportPub" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkSupportPubTous" name="chkSupportPubTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <span id="btnAjoutSupportPub" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfSupportPubAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtSupportPub" name="txtSupportPub" placeholder="Sélectionnez un support de publication">
            </div><!-- /input-group -->
            <div id="listeSupportPub">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeSupportPub-0" name="txtListeSupportPub-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkSupportPubTous').click(function(){
                if (document.getElementById('chkSupportPubTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Support de publication" ne sera prise en compte dans la requête');
                  $('#listeSupportPub :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtSupportPub').attr('disabled', '');
                } else {
                  $('#listeSupportPub :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtSupportPub').removeAttr('disabled');
                }
              });
              $('#btnAjoutSupportPub').click(function(){
                if ($('#txtSupportPub').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbSupportPub++;
                  vAjouteChamp('listeSupportPub', 'txtListeSupportPub', iNbSupportPub, $('#txtSupportPub'), 0);
                  // On vide le champ txtSupportPub
                  $('#txtSupportPub').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtSupportPub").autocomplete
                $("#txtSupportPub").catcomplete({
                  source: function (request, response){
                    if ($('#imgInfSupportPubAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfSupportPubAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfSupportPubAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfSupportPubAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfSupportPubAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfSupportPubAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 16, strSupportPub: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfSupportPubAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              category: item.category,
                              label: item.support,
                              value: item.support
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfSupportPubAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfSupportPubAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfSupportPubAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfSupportPubAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfSupportPubAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfSupportPubAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfSupportPubAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfSupportPubAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des désignations
                    iNbSupportPub++;
                    vAjouteChamp('listeSupportPub', 'txtListeSupportPub', iNbSupportPub, ui, 0);
                    $('#txtSupportPub').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbSupportPub = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Année de parution</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODateSPAnParution" title="Info" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA<br />- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.<br />- Pour filtrer les publications avant une année, saisissez l'année dans le deuxième champ et laisser le premier vide.<br />- Pour filtrer les publications après une année, saisissez l'année dans le premier champ et laisser le deuxième vide." data-original-title="Détails sur la saisie des dates" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <script type="text/javascript"> $('#spPODateSPAnParution').popover()</script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control" id="txtSPAPAnneeDeb" name="txtSPAPAnneeDeb" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"> à </span>
                <input type="text" class="form-control" id="txtSPAPAnneeFin" name="txtSPAPAnneeFin" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
            </div><!-- /form-inline -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->
        <?php

        // <div class="form-group">
        //   <label class="col-md-2 control-label">Filtrage des résultats sur les supports de publication</label>
        //   <div class="col-md-10">
        //     <div class="input-group">
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkTypeSupportPub1" name="chkTypeSupportPub[]" value="Editeur"> éditeur
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkTypeSupportPub2" name="chkTypeSupportPub[]" value="Collection"> collection
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkTypeSupportPub3" name="chkTypeSupportPub[]" value="Periodique"> périodique
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //     </div><!-- /input-group -->
        //   </div><!-- /col-md- -->
        // </div><!-- /form-group -->
        ?>

        <div class="form-group">
          <label class="col-md-2 control-label">Filtrage des résultats sur les types d'éditions</label>
          <div class="col-md-10">
            <div class="input-group">
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkSPTypeEdition1" name="chkSPTypeEdition[]" value="Volume"> volume
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkSPTypeEdition2" name="chkSPTypeEdition[]" value="Periodique"> périodique
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkSPTypeEdition3" name="chkSPTypeEdition[]" value="Livraison"> livraison
                  </label>
                </div>
              </span><!-- /input-group-addon -->
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <?php
        // <div class="form-group">
        //   <label class="col-md-2 control-label">Filtrage des résultats sur les catégories d'éditeur</label>
        //   <div class="col-md-10">
        //     <div class="input-group">
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCatEditeur1" name="chkSPCatEditeur[]" value="Jeunesse"> jeunesse
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCatEditeur2" name="chkSPCatEditeur[]" value="Populaire"> populaire
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCatEditeur3" name="chkSPCatEditeur[]" value="LuxeBibliophilie"> luxe, bibliophilie
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCatEditeur4" name="chkSPCatEditeur[]" value="Generale"> générale
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //     </div><!-- /input-group -->
        //   </div><!-- /col-md- -->
        // </div><!-- /form-group -->

        // <div class="form-group">
        //   <label class="col-md-2 control-label">Filtrage des résultats sur les collections spécialisées</label>
        //   <div class="col-md-10">
        //     <div class="input-group">
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCollSp1" name="chkSPCollSp[]" value="Anticipation"> anticipation
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCollSp2" name="chkSPCollSp[]" value="SF"> SF
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCollSp3" name="chkSPCollSp[]" value="Aventure"> aventure
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCollSp4" name="chkSPCollSp[]" value="Policier"> policier
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCollSp5" name="chkSPCollSp[]" value="Fantastique"> fantastique
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //             <input type="checkbox" id="chkSPCollSp6" name="chkSPCollSp[]" value="Sentimental"> sentimental
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //     </div><!-- /input-group -->
        //   </div><!-- /col-md- -->
        // </div><!-- /form-group -->
        ?>

        <div class="form-group">
          <label class="col-md-2 control-label">Catégories et collections spécialisées</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
                $iCpt = 0;
                foreach ($aListeSPCatColSpe as $aMot) {
                  if ($iCpt > 0 AND $iCpt % 4 == 0) {
              ?>
            </div><!-- /input-group -->
            <div class="input-group">
              <?php
                  }
                  $iCpt++;
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                    echo '<input type="checkbox" id="chkSPCatColSpe'.$aMot['idRef'].'" name="chkSPCatColSpe[]" value="'.$aMot['idRef'].'|'.$aMot['libelle'].'"> '.$aMot['libelle'];
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                }
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Nom de l'illustrateur</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutIllustrAuteur" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkIllustrAuteurTous" name="chkIllustrAuteurTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <span id="btnAjoutIllustrAuteur" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfIllustrAuteurAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtIllustrAuteur" name="txtIllustrAuteur" placeholder="Sélectionnez un support de publication">
            </div><!-- /input-group -->
            <div id="listeIllustrAuteur">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeIllustrAuteur-0" name="txtListeIllustrAuteur-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkIllustrAuteurTous').click(function(){
                if (document.getElementById('chkIllustrAuteurTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Nom d\'illustrateur" ne sera prise en compte dans la requête');
                  $('#listeIllustrAuteur :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtIllustrAuteur').attr('disabled', '');
                } else {
                  $('#listeIllustrAuteur :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtIllustrAuteur').removeAttr('disabled');
                }
              });
              $('#btnAjoutIllustrAuteur').click(function(){
                if ($('#txtIllustrAuteur').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbIllustrAuteur++;
                  vAjouteChamp('listeIllustrAuteur', 'txtListeIllustrAuteur', iNbIllustrAuteur, $('#txtIllustrAuteur'), 0);
                  // On vide le champ txtIllustrAuteur
                  $('#txtIllustrAuteur').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtIllustrAuteur").autocomplete
                $("#txtIllustrAuteur").catcomplete({
                  source: function (request, response){
                    if ($('#imgInfIllustrAuteurAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfIllustrAuteurAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfIllustrAuteurAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfIllustrAuteurAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfIllustrAuteurAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfIllustrAuteurAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 18, strIllustrAuteur: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfIllustrAuteurAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              category: item.category,
                              label: item.illustrateur,
                              value: item.illustrateur
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfIllustrAuteurAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfIllustrAuteurAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfIllustrAuteurAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfIllustrAuteurAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfIllustrAuteurAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfIllustrAuteurAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfIllustrAuteurAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfIllustrAuteurAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des désignations
                    iNbIllustrAuteur++;
                    vAjouteChamp('listeIllustrAuteur', 'txtListeIllustrAuteur', iNbIllustrAuteur, ui, 0);
                    $('#txtIllustrAuteur').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbIllustrAuteur = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <hr />

        <div class="form-group">
          <label class="col-md-2 control-label">Langue de la traduction</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutLangueTrad" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkLangueTradTous" name="chkLangueTradTous" type="checkbox" value="tous" aria-label="..."> Toutes</span>
              <span id="btnAjoutLangueTrad" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfLangueTradAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtLangueTrad" name="txtLangueTrad" placeholder="Sélectionnez une langue de traduction">
            </div><!-- /input-group -->
            <div id="listeLangueTrad">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeLangue-0" name="txtListeLangue-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkLangueTradTous').click(function(){
                if (document.getElementById('chkLangueTradTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Langue de traduction" ne sera prise en compte dans la requête');
                  $('#listeLangueTrad :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtLangueTrad').attr('disabled', '');
                } else {
                  $('#listeLangueTrad :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtLangueTrad').removeAttr('disabled');
                }
              });
              $('#btnAjoutLangueTrad').click(function(){
                if ($('#txtLangueTrad').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbLangueTrad++;
                  vAjouteChamp('listeLangueTrad', 'txtListeLangue', iNbLangueTrad, $('#txtLangueTrad'), 0);
                  // On vide le champ txtLangueTrad
                  $('#txtLangueTrad').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtLangueTrad").catcomplete
                $("#txtLangueTrad").autocomplete({
                  source: function (request, response){
                    if ($('#imgInfLangueTradAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfLangueTradAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfLangueTradAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfLangueTradAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfLangueTradAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfLangueTradAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 5, strLangueTrad: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfLangueTradAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              label: item.langue,
                              value: item.langue
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfLangueTradAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfLangueTradAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfLangueTradAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfLangueTradAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfLangueTradAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfLangueTradAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfLangueTradAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfLangueTradAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbLangueTrad++;
                    vAjouteChamp('listeLangueTrad', 'txtListeLangue', iNbLangueTrad, ui, 0);
                    $('#txtLangueTrad').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbLangueTrad = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <hr />

        <div class="form-group">
          <label class="col-md-2 control-label">Nature d'adaptation</label>
          <div class="col-md-10">
            <div class="row"><div class="col-md-12">
              <select id="selNatureAdapt" class="form-control" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
              <?php
                // La liste des natures d'adaptation est dans le tableau $aListeNatureAdapt
                // !!! Bien laisser la première option en premier !!!
                $strRet = '<option class="text-left" value="null" selected>--- Sélectionnez un élément de la liste---</option>';
                foreach ($aListeNatureAdapt as $key => $value) {
                  if (!empty(trim($value['nature']))) $strRet .= '<option value="'.$value['nature'].'">'.$value['nature'].'</option>'."\n";
                }
                echo $strRet;
              ?>
              </select><!-- /form-control -->
              <script>
                $('#selNatureAdapt').change(function(){
                  iNbNatureAdapt++;
                  vAjouteChamp('listeNatureAdapt', 'txtListeNatureAdapt', iNbNatureAdapt, this, 1);
                  this.selectedIndex = 0;
                });
                var iNbNatureAdapt = 0;
              </script>
            </div></div><!-- /col-md-12 /row-->
            <div id="listeNatureAdapt">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeNatureAdapt-0" name="txtListeNatureAdapt-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

      </div></div><!-- /panel-body /panel-collapse -->
    </div><!-- /panel -->

    <div class="panel panel-anticipation">
      <div class="panel-heading" role="tab" id="pheadPoeteEtc">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" href="#idColpsPoeteEtc" aria-controls="idColpsPoeteEtc">
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
                    <input type="checkbox" id="chkPoetique1" name="chkPoetique[]" value="NarPPers"> Narration à la 1ère personne
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkPoetique2" name="chkPoetique[]" value="NarTPers"> Narration à la 3ème personne
                  </label>
                </div>
              </span><!-- /input-group-addon -->
            </div><!-- /input-group -->
            <div class="input-group">
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkPoetique3" name="chkPoetique[]" value="NarMulti"> Narrateurs multiples
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkPoetique4" name="chkPoetique[]" value="NarEnchass"> Narration enchâssée
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
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutCadreSpat" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkCadreSpatTous" name="chkCadreSpatTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <span id="btnAjoutCadreSpat" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfCadreSpatAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtCadreSpat" name="txtCadreSpat" placeholder="Sélectionnez un cadre spatial">
            </div><!-- /input-group -->
            <div id="listeCadreSpat">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeCadreSpat-0" name="txtListeCadreSpat-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkCadreSpatTous').click(function(){
                if (document.getElementById('chkCadreSpatTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Cadre Spatial" ne sera prise en compte dans la requête');
                  $('#listeCadreSpat :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtCadreSpat').attr('disabled', '');
                } else {
                  $('#listeCadreSpat :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtCadreSpat').removeAttr('disabled');
                }
              });
              $('#btnAjoutCadreSpat').click(function(){
                if ($('#txtCadreSpat').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbCadreSpat++;
                  vAjouteChamp('listeCadreSpat', 'txtListeCadreSpat', iNbCadreSpat, $('#txtCadreSpat'), 0);
                  // On vide le champ txtCadreSpat
                  $('#txtCadreSpat').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtCadreSpat").catcomplete
                $("#txtCadreSpat").autocomplete({
                  source: function (request, response){
                    if ($('#imgInfCadreSpatAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfCadreSpatAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfCadreSpatAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfCadreSpatAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfCadreSpatAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfCadreSpatAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 7, strCadreSpat: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfCadreSpatAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              label: item.libelle,
                              value: item.libelle
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfCadreSpatAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfCadreSpatAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfCadreSpatAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfCadreSpatAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfCadreSpatAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfCadreSpatAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfCadreSpatAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfCadreSpatAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbCadreSpat++;
                    vAjouteChamp('listeCadreSpat', 'txtListeCadreSpat', iNbCadreSpat, ui, 0);
                    // $('#txtCadreSpat').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbCadreSpat = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Date de l'histoire</label>
          <div class="col-md-10">
            <div class="form-inline">
              <div class="input-group">
                <span class="input-group-addon">
                  <a id="spPODateHistoire" title="Info" style="cursor:pointer;" role="button" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="- Format de la date (année):AAAA<br />- Pour filtrer sur une année unique, saisissez la même année dans les deux champs.<br />- Pour filtrer les publications avant une année, saisissez l'année dans le deuxième champ et laisser le premier vide.<br />- Pour filtrer les publications après une année, saisissez l'année dans le premier champ et laisser le deuxième vide." data-original-title="Détails sur la saisie des dates" data-html="true"><span class="glyphicon glyphicon-question-sign"></span></a>
                </span>
                <span class="input-group-addon"><input id="chkDateHistoireTous" name="chkDateHistoireTous" type="checkbox" value="tous" aria-label="..."> Toutes</span>
                <script type="text/javascript">
                  $('#spPODateHistoire').popover();
                  $('#chkDateHistoireTous').click(function(){
                    if (document.getElementById('chkDateHistoireTous').checked === true) {
                      // On a coché Tous
                      alert('En sélectionnant cette case aucune "Date de l\'histoire" ne sera prise en compte dans la requête');
                      $('#txtDateHistoireDeb').attr('disabled', '');
                      $('#txtDateHistoireFin').attr('disabled', '');
                    } else {
                      $('#txtDateHistoireDeb').removeAttr('disabled');
                      $('#txtDateHistoireFin').removeAttr('disabled');
                    }
                  });
                </script>
                <span class="input-group-addon"> De </span>
                <input type="text" class="form-control col-xs-2" id="txtDateHistoireDeb" name="txtDateHistoireDeb" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              <?php
              // </div><!-- /input-group -->
              // <div class="input-group">
              ?>
                <span class="input-group-addon" id="basic-addon1"> à </span>
                <input type="text" class="form-control col-xs-2" id="txtDateHistoireFin" name="txtDateHistoireFin" placeholder="AAAA" title="Année au format AAAA" maxlength="4">
              </div><!-- /input-group -->
            </div><!-- /form-inline -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Écart temporel</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
                // Récupérer la liste avec getValCodeEcartCSP
                foreach ([ 'PL', 'PP', 'PR', 'FP', 'FL' ] as $key => $strCode) {
                  if ($key == 2) {
              ?>
            </div>
            <div class="input-group">
              <?php
                  }
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                echo '<input type="checkbox" id="chkEcartTemp'.($key+1).'" name="chkEcartTemp[]" value="'.$strCode.'|'.getValCodeEcartCSP($strCode).'"> '.getValCodeEcartCSP($strCode);
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                } // /foreach
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Rapport au temps</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
                $iCpt = 0;
                foreach ($aListeRapportTemps as $key => $value) {
                  if (empty($value)) continue;
                  $iCpt++;
                  // $strRet .= '<option value="'.$key.'">'.$value.'</option>'."\n";
                  if ($iCpt == 4) {
                    $iCpt = 1;
              ?>
            </div>
            <div class="input-group">
              <?php
                  }
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                    echo '<input type="checkbox" id="chkRapTemps'.$key.'" name="chkRapTemps[]" value="'.$key.'|'.$value.'"> '.$value;
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                }
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Références intertextuelles (oeuvre ou auteur)</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutRefInterTxt" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkRefInterTxtTous" name="chkRefInterTxtTous" type="checkbox" value="tous" aria-label="..."> Toutes</span>
              <span id="btnAjoutRefInterTxt" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfRefInterTxtAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtRefInterTxt" name="txtRefInterTxt" placeholder="Sélectionnez une référence">
            </div><!-- /input-group -->
            <div id="listeRefInterTxt">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeRefInterTxt-0" name="txtListeRefInterTxt-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkRefInterTxtTous').click(function(){
                if (document.getElementById('chkRefInterTxtTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Références intertextuelles" ne sera prise en compte dans la requête');
                  $('#listeRefInterTxt :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtRefInterTxt').attr('disabled', '');
                } else {
                  $('#listeRefInterTxt :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtRefInterTxt').removeAttr('disabled');
                }
              });
              $('#btnAjoutRefInterTxt').click(function(){
                if ($('#txtRefInterTxt').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbRefInterTxt++;
                  vAjouteChamp('listeRefInterTxt', 'txtListeRefInterTxt', iNbRefInterTxt, $('#txtRefInterTxt'), 0);
                  // On vide le champ txtRefInterTxt
                  $('#txtRefInterTxt').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtRefInterTxt").autocomplete
                $("#txtRefInterTxt").catcomplete({
                  source: function (request, response){
                    if ($('#imgInfRefInterTxtAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfRefInterTxtAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfRefInterTxtAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfRefInterTxtAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfRefInterTxtAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfRefInterTxtAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 8, strRefInterTxt: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfRefInterTxtAutocomp').toggleClass("glyphicon-warning-sign");
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
                        if ($('#imgInfRefInterTxtAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfRefInterTxtAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfRefInterTxtAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfRefInterTxtAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfRefInterTxtAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfRefInterTxtAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfRefInterTxtAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfRefInterTxtAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbRefInterTxt++;
                    vAjouteChamp('listeRefInterTxt', 'txtListeRefInterTxt', iNbRefInterTxt, ui, 0);
                    // $('#txtRefInterTxt').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbRefInterTxt = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <hr />
        <div class="row"><div class="col-md-4">
          <blockquote>Personnages</blockquote>
        </div></div><!-- /col-md-4 /row -->

        <div class="form-group">
          <?php // <label class="col-md-2 control-label">Discipline scientifique</label> ?>
          <label class="col-md-2 control-label">Personnage scientifique</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutPersDiscip" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <?php // <span class="input-group-addon"><input id="chkPersDiscipTous" name="chkPersDiscipTous" type="checkbox" value="tous" aria-label="..."> Toutes</span> ?>
              <span class="input-group-addon"><input id="chkPersDiscipTous" name="chkPersDiscipTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <span id="btnAjoutPersDiscip" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfPersDiscipAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtPersDiscip" name="txtPersDiscip" placeholder="Sélectionnez une discipline d'un personnage scientifique">
            </div><!-- /input-group -->
            <div id="listePersDiscip">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListePersDiscip-0" name="txtListePersDiscip-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkPersDiscipTous').click(function(){
                if (document.getElementById('chkPersDiscipTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des disciplines du "Personnage scientifique" ne sera prise en compte dans la requête');
                  $('#listePersDiscip :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtPersDiscip').attr('disabled', '');
                } else {
                  $('#listePersDiscip :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtPersDiscip').removeAttr('disabled');
                }
              });
              $('#btnAjoutPersDiscip').click(function(){
                if ($('#txtPersDiscip').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbPersDiscip++;
                  vAjouteChamp('listePersDiscip', 'txtListePersDiscip', iNbPersDiscip, $('#txtPersDiscip'), 0);
                  // On vide le champ txtPersDiscip
                  $('#txtPersDiscip').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtPersDiscip").catcomplete
                $("#txtPersDiscip").autocomplete({
                  source: function (request, response){
                    if ($('#imgInfPersDiscipAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfPersDiscipAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfPersDiscipAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfPersDiscipAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfPersDiscipAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfPersDiscipAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 9, strPersDiscip: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfPersDiscipAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              // category: item.category,
                              label: item.discipline,
                              value: item.discipline
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfPersDiscipAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfPersDiscipAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfPersDiscipAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfPersDiscipAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfPersDiscipAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfPersDiscipAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfPersDiscipAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfPersDiscipAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbPersDiscip++;
                    vAjouteChamp('listePersDiscip', 'txtListePersDiscip', iNbPersDiscip, ui, 0);
                    // $('#txtPersDiscip').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbPersDiscip = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Profession</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutPersProf" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkPersProfTous" name="chkPersProfTous" type="checkbox" value="tous" aria-label="..."> Toutes</span>
              <span id="btnAjoutPersProf" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfPersProfAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtPersProf" name="txtPersProf" placeholder="Saisissez une profession">
            </div><!-- /input-group -->
            <div id="listePersProf">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListePersProf-0" name="txtListePersProf-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkPersProfTous').click(function(){
                if (document.getElementById('chkPersProfTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Profession" ne sera prise en compte dans la requête');
                  $('#listePersProf :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtPersProf').attr('disabled', '');
                } else {
                  $('#listePersProf :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtPersProf').removeAttr('disabled');
                }
              });
              $('#btnAjoutPersProf').click(function(){
                if ($('#txtPersProf').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbPersProf++;
                  vAjouteChamp('listePersProf', 'txtListePersProf', iNbPersProf, $('#txtPersProf'), 0);
                  // On vide le champ txtPersProf
                  $('#txtPersProf').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtPersProf").catcomplete
                $("#txtPersProf").autocomplete({
                  source: function (request, response){
                    if ($('#imgInfPersProfAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfPersProfAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfPersProfAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfPersProfAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfPersProfAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfPersProfAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 10, strPersProf: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfPersProfAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              // category: item.category,
                              label: item.profession,
                              value: item.profession
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfPersProfAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfPersProfAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfPersProfAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfPersProfAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfPersProfAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfPersProfAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfPersProfAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfPersProfAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbPersProf++;
                    vAjouteChamp('listePersProf', 'txtListePersProf', iNbPersProf, ui, 0);
                    // $('#txtPersProf').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbPersProf = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Genre</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
                // Récupérer la liste avec getValCodeGenrePers
                foreach ([ 'M', 'F', 'I' ] as $key => $strCode) {
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                echo '<input type="checkbox" id="chkPersGenre'.($key+1).'" name="chkPersGenre[]" value="'.$strCode.'|'.getValCodeGenrePers($strCode).'"> '.getValCodeGenrePers($strCode);
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                } // /foreach
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Valorisation</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
                // Récupérer la liste avec getValCodeValorisationPers
                foreach ([ 'P', 'N', 'M', 'T' ] as $key => $strCode) {
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                echo '<input type="checkbox" id="chkPersValo'.($key+1).'" name="chkPersValo[]" value="'.$strCode.'|'.getValCodeValorisationPers($strCode).'"> '.getValCodeValorisationPers($strCode);
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                } // /foreach
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Caractéristiques</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutPersCaract" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkPersCaractTous" name="chkPersCaractTous" type="checkbox" value="tous" aria-label="..."> Toutes</span>
              <span id="btnAjoutPersCaract" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfPersCaractAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtPersCaract" name="txtPersCaract" placeholder="Sélectionnez une caractéristique">
            </div><!-- /input-group -->
            <div id="listePersCaract">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListePersCaract-0" name="txtListePersCaract-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>

            <script type="text/javascript">
              $('#chkPersCaractTous').click(function(){
                if (document.getElementById('chkPersCaractTous').checked === true) {
                  // On a coché Tous
                  alert('En sélectionnant cette case aucune saisie des "Caractéristiques" ne sera prise en compte dans la requête');
                  $('#listePersCaract :input').each(function(){
                    $(this).attr('disabled', '');
                  });
                  $('#txtPersCaract').attr('disabled', '');
                } else {
                  $('#listePersCaract :input').each(function(){
                    $(this).removeAttr('disabled');
                  });
                  $('#txtPersCaract').removeAttr('disabled');
                }
              });
              $('#btnAjoutPersCaract').click(function(){
                if ($('#txtPersCaract').val() != '') {
                  // Ajout d'un champ manuellement (sans le sélectionner dans la liste d'autocomplétion)
                  iNbPersCaract++;
                  vAjouteChamp('listePersCaract', 'txtListePersCaract', iNbPersCaract, $('#txtPersCaract'), 0);
                  // On vide le champ txtPersCaract
                  $('#txtPersCaract').val('');
                } else {
                  document.getElementById('bodyMessage').firstChild.nodeValue = 'Vous devez saisir un texte avant de l\'ajouter';
                  $('#Message').modal('show');
                }
                return false;
              });
              $(function () {
                // $("#txtPersCaract").catcomplete
                $("#txtPersCaract").autocomplete({
                  source: function (request, response){
                    if ($('#imgInfPersCaractAutocomp').hasClass("glyphicon-warning-sign")) {
                      $('#imgInfPersCaractAutocomp').toggleClass("glyphicon-warning-sign");
                    }
                    if ($('#imgInfPersCaractAutocomp').hasClass("glyphicon-pencil")) {
                      $('#imgInfPersCaractAutocomp').toggleClass("glyphicon-pencil");
                    }
                    if (!$('#imgInfPersCaractAutocomp').hasClass("glyphicon-hourglass")) {
                      $('#imgInfPersCaractAutocomp').toggleClass("glyphicon-hourglass");
                    }
                    objData = { iCmd: 11, strPersCaract: request.term, maxLignes: 10 };
                    $.ajax({
                      url: "./ajax-recherche.php",
                      dataType: "json",
                      data: objData,
                      type: 'POST',
                      success: function (data) {
                        // if (data.size() == 0) {
                          // $('#imgInfPersCaractAutocomp').toggleClass("glyphicon-warning-sign");
                        // } else {
                          response($.map(data, function (item) {
                            return {
                              // category: item.category,
                              label: item.caracteristique,
                              value: item.caracteristique
                            }
                          }
                        // }
                        ));
                        if ($('#imgInfPersCaractAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfPersCaractAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfPersCaractAutocomp').hasClass("glyphicon-pencil")) {
                          $('#imgInfPersCaractAutocomp').toggleClass("glyphicon-pencil");
                        }
                      },
                      error: function(data){
                        if ($('#imgInfPersCaractAutocomp').hasClass("glyphicon-hourglass")) {
                          $('#imgInfPersCaractAutocomp').toggleClass("glyphicon-hourglass");
                        }
                        if (!$('#imgInfPersCaractAutocomp').hasClass("glyphicon-warning-sign")) {
                          $('#imgInfPersCaractAutocomp').toggleClass("glyphicon-warning-sign");
                        }
                      }
                    });

                  },
                  select: function (event, ui) {
                    // Ajout de la valeur saisie dans la liste des liens
                    iNbPersCaract++;
                    vAjouteChamp('listePersCaract', 'txtListePersCaract', iNbPersCaract, ui, 0);
                    // $('#txtPersCaract').val('');
                  },
                  minLength: 3,
                  delay: 400
                });
              });
              var iNbPersCaract = 0;
            </script>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Figure de l'altérité</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
                $iCpt = 0;
                // Récupérer la liste avec getValCodeAlterite
                foreach ([ 'EU', 'EE', 'ET', 'CA', 'MU', 'ZZ' ] as $key => $strCode) {
                  $iCpt++;
                  // $strRet .= '<option value="'.$key.'">'.$value.'</option>'."\n";
                  if ($iCpt == 4) {
                    $iCpt = 1;
              ?>
            </div>
            <div class="input-group">
              <?php
                  }
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                echo '<input type="checkbox" id="chkPersFigAlt'.($key+1).'" name="chkPersFigAlt[]" value="'.$strCode.'|'.getValCodeAlterite($strCode).'"> '.getValCodeAlterite($strCode);
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                } // /foreach
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <hr />

        <div class="form-group">
          <label class="col-md-2 control-label">Esthétique</label>
          <div class="col-md-10">
            <div class="row"><div class="col-md-12"><div class="input-group">
              <span class="input-group-addon"><input id="chkImaginEsthetiqueTous" name="chkImaginEsthetiqueTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <select id="selImaginEsthetique" class="form-control" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
              <?php
                // La liste des traits spécifiques est dans le tableau $aListeEstethique
                // !!! Bien laisser la première option en premier !!!
                $strRet = '<option class="text-left" value="null" selected>--- Sélectionnez un élément de la liste---</option>';
                foreach ($aListeEstethique as $key => $value) {
                  $strRet .= '<option value="'.$key.'">'.$value.'</option>'."\n";
                }
                echo $strRet;
              ?>
              </select><!-- /form-control -->
              <script>
                $('#chkImaginEsthetiqueTous').click(function(){
                  if (document.getElementById('chkImaginEsthetiqueTous').checked === true) {
                    // On a coché Tous
                    alert('En sélectionnant cette case aucune saisie des éléments "Esthétique" ne sera prise en compte dans la requête');
                    $('#listeImaginEsthetique :input').each(function(){
                      $(this).attr('disabled', '');
                    });
                    $('#selImaginEsthetique').attr('disabled', '');
                  } else {
                    $('#listeImaginEsthetique :input').each(function(){
                      $(this).removeAttr('disabled');
                    });
                    $('#selImaginEsthetique').removeAttr('disabled');
                  }
                });
                $('#selImaginEsthetique').change(function(){
                  iNbImaginEsthetique++;
                  vAjouteChamp('listeImaginEsthetique', 'txtListeImaginEsthetique', iNbImaginEsthetique, this, 1);
                  this.selectedIndex = 0;
                });
                var iNbImaginEsthetique = 0;
              </script>
            </div></div></div><!-- /input-group /col-md-12 /row-->
            <div id="listeImaginEsthetique">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeImaginEsthetique-0" name="txtListeImaginEsthetique-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

      </div></div><!-- /panel-body /panel-collapse -->
    </div><!-- /panel -->

    <div class="panel panel-anticipation">
      <div class="panel-heading" role="tab" id="pheadScieSoc">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" href="#idColpsScieSoc" aria-controls="idColpsScieSoc">
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
                  <a class="collapsed" role="button" data-toggle="collapse" href="#idColpsDiscThem" aria-controls="idColpsDiscThem">
                    <span id="idImgColpsDiscThem" class="glyphicon glyphicon-chevron-down"></span> Cliquez pour obtenir la liste des disciplines et thématiques
                  </a>
                </h4>
              </div><!-- /panel-heading -->
              <div id="idColpsDiscThem" class="panel-collapse collapse" role="tabpanel" aria-labelledby="pheadDiscThem"><div class="panel-body">

                <div class="panel panel-anticipation"><div class="input-group"><span class="input-group-addon"><div class="checkbox"><label>
                  <input id="chkScSoDiscThemTous" name="chkScSoDiscThemTous" type="checkbox" value="tous" aria-label="..."> Toutes
                </label></div></span></div></div><!-- /label /checkbox /input-group-addon /input-group /panel -->
                <script>
                  $('#chkScSoDiscThemTous').click(function(){
                    if (document.getElementById('chkScSoDiscThemTous').checked === true) {
                      // On a coché Tous
                      alert('En sélectionnant cette case aucune des "Disciplines et thématiques" cochées ne sera prise en compte dans la requête');
                      $('#idColpsDiscThem :input').not('[id="chkScSoDiscThemTous"]').each(function(){
                        $(this).attr('disabled', '');
                      });
                    } else {
                      $('#idColpsDiscThem :input').not('[id="chkScSoDiscThemTous"]').each(function(){
                        $(this).removeAttr('disabled');
                      });
                    }
                  });
                </script>

                <div class="panel panel-anticipation">
                <?php
                // <script type="text/javascript">
                //   $('#idColpsDiscThem').on('shown.bs.collapse', function () { vSwitchChevron($('#idImgColpsDiscThem'), 'up'); })
                //   $('#idColpsDiscThem').on('hidden.bs.collapse', function () { vSwitchChevron($('#idImgColpsDiscThem'), 'down'); })
                // </script>

                // Quelques explications pour la personne qui reprendrait ce dossier... ou pour moi si je ne me souviens plus du fonctionnement
                // Principe:
                //   Les groupes de disciplines et techniques sont encadrées dans un panel(<div class="panel panel-anticipation">) et le nom du groupe est mis dans l'entête du panel
                //   Les autres disciplines et technologies qui ne sont pas dans des groupes sont regroupées (au fil de l'eau... donc mélangées parmi les groupes) aussi dans un panel
                //   Globalement on ne met que 4 disciplines ou technologies par ligne (<div class="input-group">)

                  $iCpt = 0;
                  $bPrems = true;
                  $bGroup = false;
                  // foreach ($aListeDiscThem as $key => $value) {
                  foreach ($aListeDTGroupes as $idGroupe=>$mot){
                    // Parcours des groupes de disciplines et thématiques
                    if (!isset($aListeDTIdLib[$idGroupe])){
                      // Groupe sans sous-élément
                      if ($iCpt == 0 AND !$bPrems) {
                ?>
                </div><!-- /input-group -->
                <?php
                        if ($bGroup) {
                          // Si on était dans un group, on ferme aussi le panel ... et on en ouvre un autre
                ?>
                </div></div><!-- /panel-body /panel -->
                <div class="panel panel-anticipation">
                <?php
                        } // /if $bGroup
                ?>
                <div class="input-group">
                <?php
                      } // /if $iCpt == 0 AND !$bPrems
                      $bGroup = false;
                ?>
                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <?php
                        $bPrems = false;
                        $iCpt++;
                        // echo '<input type="checkbox" id="chkScSoDiscThem'.$mot['id'].'" name="chkScSoDiscThem[]" value="'.$mot['id'].'"> '.$mot['lib'];
                        echo '<input type="checkbox" id="chkScSoDiscThem'.$mot['id'].'" name="chkScSoDiscThem[]" value="'.$mot['id'].'|'.$mot['lib'].'"> '.$mot['lib'];
                ?>
                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                <?php
                      if ($iCpt > 0 AND $iCpt % 4 == 0) {
                        // 4 cases par ligne, on ferme input-group mais pas le panel
                      // if (TRUE) {
                ?>
                </div><!-- /input-group -->
                <div class="input-group">
                <?php
                        $iCpt = 0;
                      } // /if ($iCpt > 0 AND $iCpt % 4 == 0)
                    } else {
                      if (!$bPrems) {
                        // On ferme l'input-group de toute façon (sauf s'il n'y a rien encore)
                ?>
                </div><!-- /input-group -->
                <?php
                        if ($bGroup) {
                          // On était dans un groupe donc on avait un panel-body... donc on le ferme
                ?>
                </div><!-- /panel-body -->
                <?php
                        }
                        // On ferme le panel pour mettre en évidence le groupe de disciplines et de technologies
                ?>
                </div><!-- /panel -->
                <div class="panel panel-anticipation">
                <?php
                      }
                      $bGroup = true;
                      // Dans le panel-heading on met le nom du groupe
                ?>
                  <div class="panel-heading">
                    <div class="checkbox">
                      <label>
                <?php
                      $bPrems = false;
                      $iCpt = 0;
                      // echo '<input type="checkbox" id="chkScSoDiscThem'.$mot['id'].'" name="chkScSoDiscThem[]" value="'.$mot['id'].'"> '.$mot['lib'];
                      echo '<input type="checkbox" id="chkScSoDiscThem'.$mot['id'].'" name="chkScSoDiscThem[]" value="'.$mot['id'].'|'.$mot['lib'].'"> '.$mot['lib'];
                ?>
                      </label>
                    </div>
                  </div><!-- /panel-heading -->
                  <div class="panel-body"><div class="input-group">
                <?php
                      // S'il y a des disciplines et des thématiques dans ce groupe (on force la création d'un input-group)
                      foreach ($aListeDTIdLib[$idGroupe] as $mot2) {
                        if ($iCpt > 0 AND $iCpt % 4 == 0) {
                          // 4 cases par ligne
                        // if (TRUE) {
                ?>
                </div><!-- /input-group -->
                <div class="input-group">
                <?php
                          $iCpt = 0;
                        } // /if ($key > 0 AND $key % 4 == 0)
                ?>
                  <span class="input-group-addon">
                    <div class="checkbox">
                      <label>
                <?php
                        // echo '<input type="checkbox" id="chkScSoDiscThem'.$mot2['id'].'" name="chkScSoDiscThem[]" value="'.$mot2['id'].'" idChkGroup="'.$mot['id'].'"> '.$mot2['lib'];
                        echo '<input type="checkbox" id="chkScSoDiscThem'.$mot2['id'].'" name="chkScSoDiscThem[]" value="'.$mot2['id'].'|'.$mot2['lib'].'" idChkGroup="'.$mot['id'].'"> '.$mot2['lib'];
                        $iCpt++;
                        $bPrems = false;
                ?>
                      </label>
                    </div>
                  </span><!-- /input-group-addon -->
                <?php
                      } // /foreach de aListeDTIdLib
                      $iCpt = 0;
                    } // /else if !isset($aListeDTIdLib[$idGroupe])
                  } // /foreach de aListeDTGroupes
                  if ($bGroup) {
                    // Si le dernier panel était un group, on ajoute un /div pour le panel-body
                ?>
                </div><!-- Pour le panel-body -->
                <?php
                  }
                ?>
                </div></div><!-- /input-group /panel -->
              </div></div><!-- /panel-body /panel-collapse -->
            </div><!-- /panel -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->
        <?php
        // <script type="text/javascript">
        //   // Gestion de la sélection des groupes de discipline et de thématique
        //   $('input:checkbox[id*=chkScSoDiscThem]').click(function(){
        //     // Si chkScSoDiscThem du groupe existe, on le coche
        //     if ($(this).attr('idChkGroup') && $('chkScSoDiscThem'+$(this).attr('idChkGroup')) && document.getElementById($(this).attr('id')).checked && !document.getElementById('chkScSoDiscThem'+$(this).attr('idChkGroup')).checked) {
        //       // Pas réussi à faire la même chose avec JQuery: $('chkScSoDiscThem'+$(this).attr('idChkGroup')).attr('checked', 'true');
        //       document.getElementById('chkScSoDiscThem'+$(this).attr('idChkGroup')).checked = true;
        //     } else {
        //       // S'il existe des chkScSoDiscThem avec attribut idChkGroup correspondant à celui cliqué, on force à le coché si un chkScSoDiscThem est coché... je ne sait pas si l'explication est claire ^_^
        //       var OExpReguliere = /chkScSoDiscThem(\d*)/
        //       // Récupération du mot[id] du groupe
        //       OExpReguliere.exec($(this).attr('id'));
        //       $('input[type=checkbox][idChkGroup='+RegExp.$1+']:checked').each(function() {
        //         // Au moins une discipline ou thémathique du groupe coché: on force le checkbox du groupe à être coché
        //         document.getElementById('chkScSoDiscThem'+RegExp.$1).checked = true;
        //       });
        //     }
        //   });
        // </script>
        ?>

        <hr />
        <div class="row"><div class="col-md-4">
          <blockquote>Références à des éléments scientifiques réels</blockquote>
        </div></div><!-- /col-md-4 /row -->

        <div class="form-group">
          <label class="col-md-2 control-label">Théorie ou invention</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutReelThInv" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkReelThInvTous" name="chkReelThInvTous" type="checkbox" value="tous" aria-label="..."> Toutes</span>
              <span id="btnAjoutReelThInv" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfReelThInvAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtReelThInv" name="txtReelThInv" placeholder="Sélectionnez une théorie ou une invention">
            </div><!-- /input-group -->
            <div id="listeReelThInv">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeReelThInv-0" name="txtListeReelThInv-0" value="Aucune saisie" readonly>
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
              <input type="text" class="form-control" id="txtReelPersSci" name="txtReelPersSci" placeholder="Sélectionnez une personnalité scientifique">
            </div><!-- /input-group -->
            <div id="listeReelPersSci">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeReelPersSci-0" name="txtListeReelPersSci-0" value="Aucune saisie" readonly>
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
              <?php
                // Récupérer la liste avec getValCodeRefAuReelDiscipline
                foreach ([ 'VIE', 'MED', 'TER', 'PCM', 'ING', 'AUT' ] as $key => $strCode) {
                if ($key > 0 AND ($key == 2 OR $key == 3)) {
                  // 3 cases par ligne
              ?>
            </div><!-- /input-group -->
            <div class="input-group">
              <?php
                } // /if ($key > 0 AND $key % 3 == 0)
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                echo '<input type="checkbox" id="chkReelDiscipline'.($key+1).'" name="chkReelDiscipline[]" value="'.$strCode.'|'.getValCodeRefAuReelDiscipline($strCode).'"> '.getValCodeRefAuReelDiscipline($strCode);
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                } // /foreach
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Modalité</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
                // Récupérer la liste avec getValCodeRefAuReelModalite
                foreach ([ 'SER', 'SAT', 'HOM', 'REF' ] as $key => $strCode) {
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                echo '<input type="checkbox" id="chkReelModal'.($key+1).'" name="chkReelModal[]" value="'.$strCode.'|'.getValCodeRefAuReelModalite($strCode).'"> '.getValCodeRefAuReelModalite($strCode);
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                } // /foreach
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <hr />
        <div class="row"><div class="col-md-4">
          <blockquote>Références à des éléments scientifiques imaginaires</blockquote>
        </div></div><!-- /col-md-4 /row -->

        <div class="form-group">
          <label class="col-md-2 control-label">Termes utilisés dans la description</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
              // <div class="input-group-btn">
              //   <a id="btnAjoutImaginDesc" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></a>
              // </div><!-- /input-group-btn -->
              ?>
              <span class="input-group-addon"><input id="chkImaginDescTous" name="chkImaginDescTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <span id="btnAjoutImaginDesc" class="input-group-addon btn-success" role="button"><span class="glyphicon glyphicon-plus"></span></span>
              <span class="input-group-addon"><span id="imgInfImaginDescAutocomp" class="glyphicon glyphicon-pencil"></span></span>
              <input type="text" class="form-control" id="txtImaginDesc" name="txtImaginDesc" placeholder="Sélectionnez un terme dans les descriptions">
            </div><!-- /input-group -->
            <div id="listeImaginDesc">
              <div class="row"><div class="col-md-12">
                <input type="text" class="form-control" id="txtListeImaginDesc-0" name="txtListeImaginDesc-0" value="Aucune saisie" readonly>
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
              <select id="selImaginDomaine" class="form-control" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
              <?php
                // La liste des traits spécifiques est dans le tableau $aListeDomaines
                // !!! Bien laisser la première option en premier !!!
                $strRet = '<option class="text-left" value="null" selected>--- Sélectionnez un élément de la liste---</option>';
                foreach ($aListeDomaines as $key => $value) {
                  $strRet .= '<option value="'.$value['idRef'].'">'.$value['libelle'].'</option>'."\n";
                }
                echo $strRet;
              ?>
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
                <input type="text" class="form-control" id="txtListeImaginDomaine-0" name="txtListeImaginDomaine-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <div class="form-group">
          <label class="col-md-2 control-label">Voyage(s)</label>
          <div class="col-md-10">
            <div class="row"><div class="col-md-12"><div class="input-group">
              <span class="input-group-addon"><input id="chkImaginVoyageTous" name="chkImaginVoyageTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <select id="selImaginVoyage" class="form-control" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
              <?php
                // La liste des traits spécifiques est dans le tableau $aListeVoyages
                // !!! Bien laisser la première option en premier !!!
                $strRet = '<option class="text-left" value="null" selected>--- Sélectionnez un élément de la liste---</option>';
                foreach ($aListeVoyages as $key => $value) {
                  $strRet .= '<option value="'.$value['idRef'].'">'.$value['libelle'].'</option>'."\n";
                }
                echo $strRet;
              ?>
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
                <input type="text" class="form-control" id="txtListeImaginVoyage-0" name="txtListeImaginVoyage-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

        <hr />
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
                    <input type="checkbox" id="chkImaginSoci1" name="chkImaginSoci[]" value="P|Présente"> Présente
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkImaginSoci2" name="chkImaginSoci[]" value="A|Absente"> Absente
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="chkImaginSoci3" name="chkImaginSoci[]" value="M|Plusieurs"> Plusieurs
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
              <?php
                // Récupérer la liste avec getValCodeSociDegreTechno
                foreach ([ 'F', 'N', 'B', 'I'] as $key => $strCode) {
            //    if ($key > 0 AND $key % 3 == 0) {
            //      // 3 cases par ligne
            //   ?
            // </div><!-- /input-group -->
            // <div class="input-group">
            //   ?php
            //     } // /if ($key > 0 AND $key % 3 == 0)
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                echo '<input type="checkbox" id="chkImaginTechno'.($key+1).'" name="chkImaginTechno[]" value="'.$strCode.'|'.getValCodeSociDegreTechno($strCode).'"> '.getValCodeSociDegreTechno($strCode);
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                } // /foreach
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <?php
        // <div class="form-group">
        //   <label class="col-md-2 control-label">Statut du scientifique</label>
        //   <div class="col-md-10">
        //     <div class="input-group">
        //       ?php
        //         // Récupérer la liste avec getValCodeSociStatutScient
        //         foreach ([ 'C', 'M', 'V', 'Q', 'I'] as $key => $strCode) {
        //     //    if ($key > 0 AND $key % 3 == 0) {
        //     //      // 3 cases par ligne
        //     //   ?
        //     // </div><!-- /input-group -->
        //     // <div class="input-group">
        //     //   ?php
        //     //     } // /if ($key > 0 AND $key % 3 == 0)
        //       ?
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //       ?php
        //         echo '<input type="checkbox" id="chkImaginStatutSci'.($key+1).'" name="chkImaginStatutSci[]" value="'.$strCode.'|'.getValCodeSociStatutScient($strCode).'"> '.getValCodeSociStatutScient($strCode);
        //       ?
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       ?php
        //         } // /foreach
        //       ?
        //     </div><!-- /input-group -->
        //   </div><!-- /col-md- -->
        // </div><!-- /form-group -->
        ?>

        <?php
        // <div class="form-group">
        //   <label class="col-md-2 control-label">Hiérarchie</label>
        //   <div class="col-md-10">
        //     <div class="input-group">
        //       ?php
        //         // Récupérer la liste avec getValCodeSociHierarchie
        //         foreach ([ 'S', 'E', 'C', 'H', 'I'] as $key => $strCode) {
        //     //    if ($key > 0 AND $key % 3 == 0) {
        //     //      // 3 cases par ligne
        //     //   ?
        //     // </div><!-- /input-group -->
        //     // <div class="input-group">
        //     //   ?php
        //     //     } // /if ($key > 0 AND $key % 3 == 0)
        //       ?
        //       <span class="input-group-addon">
        //         <div class="checkbox">
        //           <label>
        //       ?php
        //         echo '<input type="checkbox" id="chkImaginHierarchie'.($key+1).'" name="chkImaginHierarchie[]" value="'.$strCode.'|'.getValCodeSociHierarchie($strCode).'"> '.getValCodeSociHierarchie($strCode);
        //       ?
        //           </label>
        //         </div>
        //       </span><!-- /input-group-addon -->
        //       ?php
        //         } // /foreach
        //       ?
        //     </div><!-- /input-group -->
        //   </div><!-- /col-md- -->
        // </div><!-- /form-group -->
        ?>

        <div class="form-group">
          <label class="col-md-2 control-label">Valeur</label>
          <div class="col-md-10">
            <div class="input-group">
              <?php
                // Récupérer la liste avec getValCodeSociValeur
                foreach ([ 'P', 'N', 'T', 'A', 'I'] as $key => $strCode) {
            //    if ($key > 0 AND $key % 3 == 0) {
            //      // 3 cases par ligne
            //   ?
            // </div><!-- /input-group -->
            // <div class="input-group">
            //   ?php
            //     } // /if ($key > 0 AND $key % 3 == 0)
              ?>
              <span class="input-group-addon">
                <div class="checkbox">
                  <label>
              <?php
                echo '<input type="checkbox" id="chkImaginValeur'.($key+1).'" name="chkImaginValeur[]" value="'.$strCode.'|'.getValCodeSociValeur($strCode).'"> '.getValCodeSociValeur($strCode);
              ?>
                  </label>
                </div>
              </span><!-- /input-group-addon -->
              <?php
                } // /foreach
              ?>
            </div><!-- /input-group -->
          </div><!-- /col-md- -->
        </div><!-- /form-group -->

        <div class="form-group">
          <label class="col-md-2 control-label">Traits spécifiques de la société imaginaire</label>
          <div class="col-md-10">
            <div class="row"><div class="col-md-12"><div class="input-group">
              <span class="input-group-addon"><input id="chkSocImaginTraitsSpecTous" name="chkSocImaginTraitsSpecTous" type="checkbox" value="tous" aria-label="..."> Tous</span>
              <select id="selSocImaginTraitsSpec" class="form-control" style="padding-top: 2px;padding-bottom: 2px; height:34px;">
              <?php
                // La liste des traits spécifiques est dans le tableau $aListeTraitsSpec
                // !!! Bien laisser la première option en premier !!!
                $strRet = '<option class="text-left" value="null" selected>--- Sélectionnez un élément de la liste---</option>';
                foreach ($aListeTraitsSpec as $key => $value) {
                  $strRet .= '<option value="'.$key.'">'.$value.'</option>'."\n";
                }
                echo $strRet;
              ?>
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
                <input type="text" class="form-control" id="txtListeSocImaginTraitsSpec-0" name="txtListeSocImaginTraitsSpec-0" value="Aucune saisie" readonly>
              </div></div><!-- /col-md-12 /row-->
            </div>
          </div><!-- /col-md- -->
        </div><!-- /form-group /col-lg -->

      </div></div><!-- /panel-body /panel-collapse -->
    </div><!-- /panel Sciences et sociétés -->

  </div></div><!-- /idColpsRechAvance /panel-body -->

  <div class="panel-footer">
    <div class="btn-group" role="group">
      <?php
      // <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
      // <button id="btnRechAvanceReset" class="btn btn-default" type="reset">Reset</button>
      // <button id="btnRechAvanceSubmit" class="btn btn-danger">Lancer la recherche</button>

      // PYJ - ... je ne sais plus pourquoi j'ai utilisé des <a> pour ce site... mais pb pour le reset!
      // <a id="btnRechAvanceReset" class="btn btn-default" href="#" role="button">Reset</a>
      // <a id="btnRechAvanceSubmit" class="btn btn-danger" href="#" role="button">Lancer la recherche</a>
      ?>
      <button id="btnRechAvanceReset" class="btn btn-default" type="reset">Reset</button>
      <button id="btnRechAvanceSubmit" class="btn btn-danger">Lancer la recherche</button>
    </div>
  </div>

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

<div class="container-fluid" id="divRechercheResult">
</div><!-- /divRechercheResult -->


<script type="text/javascript">
  $('#Patience').modal('hide');
</script>

