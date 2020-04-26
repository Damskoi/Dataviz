// --------------------------------------------- //
// divers.js                                     //
//                                               //
// diverses fonctions javascript pour le site    //
//                                               //
// --------------------------------------------- //


// ------------------------------------------------------------- //
//                                                               //
// Modification des fonctionalités d'autocomplétion de jquery.ui //
//                                                               //
// ------------------------------------------------------------- //
$.widget( "custom.catcomplete", $.ui.autocomplete, {
  _create: function() {
    this._super();
    this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
  },
  _renderMenu: function( ul, items ) {
    var that = this,
      currentCategory = "";
    $.each( items, function( index, item ) {
      var li;
      if ( item.category != currentCategory ) {
        ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
        currentCategory = item.category;
      }
      li = that._renderItemData( ul, item );
      if ( item.category ) {
        li.attr( "aria-label", item.category + " : " + item.label );
      }
    });
  }
});

function vChargeRecherche(_iCmd, _ligneDeb) {

  try {
    strDivDest = '';
    strArgs = '';
    if ($('#divCentral')) $('#divCentral').empty();
    if (typeof maxLignes == "undefined") { maxLignes = 20; }
    if (typeof _ligneDeb == "undefined") { _ligneDeb = 1; }
    if (typeof strTriChamp == "undefined") { strTriChamp = ''; }
    if (typeof strTriOrdre == "undefined") { strTriOrdre = ''; }
    if (typeof exportData == "undefined") { exportData = ''; } // Bien laisser le var pour le test après la requête AJAX (sinon in ne reconnais pas la variable)... mais je ne vois pas pourquoi... :/
    switch (_iCmd) {
      case 1: // Affichage du formulaire de recherche simple
      case 2: // Affichage du formulaire de recherche avancée
        strDivDest = '#divRechercheForm';
        strDataType = 'html';
        break;
      case 20: // Affichage du résultat de recherche simple
      case 21: // Affichage du résultat de recherche avancée
      case 22: // Affichage des fiches en cours de rédaction
      case 23: // Affichage des Fiches incomplètes
      case 24: // Affichage des Fiches complètes, à relire
      case 25: // Affichage des Fiches relues, corrections à effectuer
      case 26: // Affichage des Fiches prêtes pour la publication
      case 27: // Liste des Sociétés imaginaires (onglet 5)
      case 28: // Liste des mots-clés (onglet 5)
      case 29: // Détail des critères trouvés d'une oeuvre pour une recherche simple
      case 30: // Détail des critères trouvés d'une oeuvre pour une recherche avancée
      case 31: // Affichage des Fiches sans aucune information sur l'avancement de la saisie
      case 32: // Statistiques / Présence des disciplines dans les oeuvres
      case 33: // Statistiques / Personnalités scientifiques réelles
      case 34: // Détail des critères trouvés pour toutes les oeuvres d'une recherche simple
      case 35: // Détail des critères trouvés pour toutes les oeuvres d'une recherche avancée
        strDivDest = '#divRechercheResult';
        if (exportData == 'CSV' || exportData == 'JSON') {
          strDataType = 'text';
        } else {
          strDataType = 'json';
        }
        strArgs = '';
        if (_iCmd == 20 || _iCmd == 29 || _iCmd == 34) {
          strArgs = $('#formRechSimple').serialize();
          strDestination = 'Simple';
          if (_iCmd == 29) {
            // idO correspond à l'identifiant de l'oeuvre (variable globale)
            strArgs += '&idO='+idO;
          } else if (_iCmd == 34) {
            // récupération des idOs de chaque oeuvre à l'écran
            var bPrems = true;
            var strPlus = '';
            var idOs = '';
            $('tr[id^="trClpsDetIdO"]').each(function() {
              idOs += strPlus+$(this).attr('idO');
              if (bPrems == true) {
                bPrems = false;
                strPlus = '|';
              }
            });
            strArgs += '&idOs='+idOs;
          }
          strArgs += '&strTriChamp='+strTriChamp+'&strTriOrdre='+strTriOrdre;
        } else if (_iCmd == 21 || _iCmd == 30 || _iCmd == 35) {
          strArgs = $('#formRechAvance').serialize();
          if (typeof strTriChecked != "undefined") {
            strArgs += '&triChecked='+strTriChecked;
          }
          // Ajout des nombres de champs pour les listes
          strArgs += '&iNbDescription='+iNbDescription+'&iNbLien='+iNbLien+'&iNbSupportPub='+iNbSupportPub+'&iNbIllustrAuteur='+iNbIllustrAuteur+'&iNbLangueTrad='+iNbLangueTrad+'&iNbNatureAdapt='+iNbNatureAdapt+'&iNbCadreSpat='+iNbCadreSpat+'&iNbRefInterTxt='+iNbRefInterTxt+'&iNbPersDiscip='+iNbPersDiscip+'&iNbPersProf='+iNbPersProf+'&iNbPersCaract='+iNbPersCaract+'&iNbReelThInv='+iNbReelThInv+'&iNbReelPersSci='+iNbReelPersSci+'&iNbImaginDesc='+iNbImaginDesc+'&iNbImaginDomaine='+iNbImaginDomaine+'&iNbImaginVoyage='+iNbImaginVoyage+'&iNbSocImaginTraitsSpec='+iNbSocImaginTraitsSpec+'&iNbImaginEsthetique='+iNbImaginEsthetique;
          strDestination = 'Avance';
          if (_iCmd == 30) {
            // idO correspond à l'identifiant de l'oeuvre (variable globale)
            strArgs += '&idO='+idO;
          } else if (_iCmd == 35) {
            // récupération des idOs de chaque oeuvre à l'écran
            // récupération des idOs de chaque oeuvre à l'écran
            var bPrems = true;
            var strPlus = '';
            var idOs = '';
            $('tr[id^="trClpsDetIdO"]').each(function() {
              idOs += strPlus+$(this).attr('idO');
              if (bPrems == true) {
                bPrems = false;
                strPlus = '|';
              }
            });
            strArgs += '&idOs='+idOs;
          }
        } else if (_iCmd == 22) {
          strDestination = 'FichesEnCoursRedac';
        } else if (_iCmd == 23) {
          strDestination = 'FichesIncompl';
        } else if (_iCmd == 24) {
          strDestination = 'FichesComplRelect';
        } else if (_iCmd == 25) {
          strDestination = 'FichesRelueCorrection';
        } else if (_iCmd == 26) {
          strDestination = 'FichesOKPub';
        } else if (_iCmd == 27) {
          strDestination = 'ListeSocietesImaginaires';
        } else if (_iCmd == 28) {
          strDestination = 'ListeMotsCles';
        } else if (_iCmd == 31) {
          strDestination = 'FichesSansInfoRedac';
        } else if (_iCmd == 32) {
          strDestination = 'Disciplines par années';
        } else if (_iCmd == 33) {
          strDestination = 'Personnalités scientifiques réelles par années';
        }
        break;
      default:
        break;
    }

    // alert('DBG-vChargeRecherche Patience.show');
    $('#Patience').modal('show');
    // exportData est vidé après son passage dans AJAX. Pourquoi?... mystère!!!
    memoExpData = exportData;
    memoDataType = strDataType;
    $.ajax({
      type : "POST",
      url : "ajax-recherche.php",
      dataType : strDataType,
      data : "iCmd="+_iCmd+'&maxLignes='+maxLignes+'&ligneDeb='+_ligneDeb+'&exportData='+exportData+'&strTriChamp='+strTriChamp+'&strTriOrdre='+strTriOrdre+'&'+strArgs,
      success : function(retour){
        if ($('#pnlTabAccueil')) {
          $('#pnlTabAccueil').remove();
        }
        switch (_iCmd) {
          case 1: // Affichage du formulaire de recherche simple
          case 2: // Affichage du formulaire de recherche avancée
            if ($('#divRechercheResult')) {
              $('#divRechercheResult').empty();
            }
            // Affichage direct
            $(strDivDest).html(retour);
            break;
          case 20: // Affichage du résultat de recherche Simple
          case 21: // Affichage du résultat de recherche avancée
          case 22: // Affichage des fiches en cours de rédaction
          case 23: // Affichage des Fiches incomplètes
          case 24: // Affichage des Fiches complètes, à relire
          case 25: // Affichage des Fiches relues, corrections à effectuer
          case 26: // Affichage des Fiches prêtes pour la publication
          case 27: // Liste des tableaux "Société imaginaire" des fiches (onglet 5)
          case 28: // Liste des mots-clés (onglet 5)
          case 31: // Affichage des Fiches sans aucune information sur l'avancement de la saisie
            if (_iCmd != 21 && $('#divRechercheForm')) {
              $('#divRechercheForm').empty();
            }
            if (memoExpData == 'CSV' || memoExpData == 'JSON') {
              // Création temporaire et artificielle d'une balise <a> pour utiliser l'attribut download afin de préciser le nom du fichier... si quelqu'un trouve mieux, je suis preneur!
              var tmpA = document.createElement("a");
              if (memoExpData == 'CSV') {
                tmpA.href = 'data:text/csv;charset:UTF-8,'+encodeURIComponent(retour);
                tmpA.download = "tableau.csv";
              } else if (memoExpData == 'JSON') {
                // tmpA.href = 'data:text/json;charset:UTF-8,'+encodeURIComponent(retour);
                // if(window.JSON && JSON.parse){
                //   jsJSON = JSON.parse(retour);
                // }else{
                //   (new Function("jsJSON = " + retour))()
                // }
                // alert('retour: '+$(jsJSON).serialize);
                // tmpA.href = 'data:text/json;charset:UTF-8,'+$.parseJSON(retour);
                tmpA.href = 'data:text/json;charset:UTF-8,'+retour;
                tmpA.download = "tableau.json";
              }

              document.body.appendChild(tmpA);
              tmpA.click();
              document.body.removeChild(tmpA);

              delete(maxLignes);

            } else {
              // Transformation en HTML
              // if (memoDataType == 'json') {
              //   jsJSON = JSON.parse(retour);
              //   alert('retour: '+$(jsJSON).serialize);
              // }
              // getTableau(_iCmd, strDivDest, strDestination, retour);
              getListeResult(_iCmd, strDivDest, strDestination, retour);
            }
            // $('#Patience').modal('hide');
            break;
          case 29: // Détail des critères trouvés d'une oeuvre pour une recherche simple
          case 30: // Détail des critères trouvés d'une oeuvre pour une recherche avancée
            getDetail('#divClpsDetIdO-'+idO, retour);
            // $('#Patience').modal('hide');
            break;
          case 32: // Statistiques / Présence des disciplines dans les oeuvres
          case 33: // Statistiques / Personnalités scientifiques réelles
            getDivStat(_iCmd, strDivDest, strDestination, retour);
            break;
          case 34: // Détail des critères trouvés pour toutes les oeuvres d'une recherche simple
          case 35: // Détail des critères trouvés pour toutes les oeuvres d'une recherche avancée
            getDetailTous('#divClpsDetIdO-', retour);
            // $('#Patience').modal('hide');
            break;
          default:
            break;
        }
        $('#Patience').modal('hide');
      },
      // error : function(retour)
      error : function(retour){
        // (strDataType == 'json' && Array.isArray(retour))
        if (strDataType == 'json' && typeof(retour) === 'object') {
          aErreur = JSON.parse(retour.responseText);
          strRetour = aErreur.strErreur;
        } else {
          strRetour = $(retour).serialize();
        }
        if (strRetour == 'NoSession') {
          window.location = './identification.php';
        } else {
          $('#Patience').modal('hide');
          document.getElementById('bodyInfo').firstChild.nodeValue = '[Recherche-Erreur] Votre demande n\'a pas pu aboutir.\nMerci de contacter l\'administrateur du site.\n'+strRetour;
          $('#divInfo').modal('show');
        }
      }
    });
  }
  catch (OException) {
    $('#Patience').modal('hide');
    strPlus = '';
    if (typeof(bDBG) != 'undefined' && bDBG == true) strPlus = strDBG+'\nDBG: '+OException;
    alert('[Recherche-Exception] Un problème est survenu sur le site. Merci de nous contacter avant de poursuivre votre opération.'+strPlus);
    strDBG = '';
  }

  // delete(exportData);
  exportData = '';
  strTriChamp = '';

}

// Transformation d'un tableau JSon en tableau HTML
function getTableau(_iCmd, _idDest, _strDestination, _aJson) {
  try {

    // Suppression du résultat précédent éventuel
    if ($(_idDest).children()) {
      $(_idDest).children().remove();
    }

    // Création du tableau
    $('<div id="divPanelResult'+_strDestination+'" class="panel panel-default">\n<div class="panel-body"><table id="tabResult'+_strDestination+'" class="table table-striped table-hover table-condensed table-bordered">\n</table></div>\n</div>').appendTo(_idDest);

    // Création du corps du tableau
    var OTbody = $('<tbody />');
    $('#tabResult'+_strDestination).append(OTbody);

    var bAucunResultat = true;
    var iNbCol = 0;
    // ODivHaut contiendra: Titre | navigation | bouton de fermeture
    var ODivHaut = $('<div class="row"/>');
    // ODivRecap contiendra: Critères sélectionnés + liste des critères
    var ODivRecap = $('<div class="row"/>');
    $('#divPanelResult'+_strDestination).prepend($(ODivHaut));
    $('#divPanelResult'+_strDestination).prepend($(ODivRecap));
    var OCol4 = $('<div class="col-md-4" />');
    // var OCol2 = $('<div class="col-md-2" />');
    if (_iCmd == 20) {
      var iCmdDet = 29;
      var iCmdDetTous = 34;
    } else if (_iCmd == 21) {
      var iCmdDet = 30;
      var iCmdDetTous = 35;
    }
    $.each(_aJson, function (iLigne, OLigne) {

      if (iLigne == 0) {
        // Dans la première ligne du tableau JSon il y a les informations de pagination et du titre de la recherche
        if ((_iCmd == 20 || _iCmd == 21) && $.trim(OLigne.strRecapRecherche) != '') {
          var strRecap = '<h3>'+OLigne.strTitreRecherche+
                         '  <button class="btn btn-info btn-xs" type="button" data-toggle="collapse" data-target="#colpsRecap" aria-expanded="false" aria-controls="colpsRecap">'+
                         '  Critères <span class="glyphicon glyphicon-chevron-down"></span></button>'+
                         '  <button class="btn btn-info btn-xs" type="button" aria-expanded="false" title="Exporter les résultats au format CSV" onClick="javascript:exportData=\'CSV\';maxLignes=100000;vChargeRecherche('+_iCmd+', 0);">CSV</button>'+
                         '</h3>'+
                         '<div class="collapse" id="colpsRecap">'+
                         '  <div class="well well-sm"><small>'+
                         '  '+OLigne.strRecapRecherche+
                         '  </small></div>'+
                         '</div>';
        } else {
          var strRecap = '<h3>'+OLigne.strTitreRecherche+
                         ' <button class="btn btn-info btn-xs" type="button" aria-expanded="false" title="Exporter les résultats au format CSV" onClick="javascript:exportData=\'CSV\';maxLignes=100000;vChargeRecherche('+_iCmd+', 0);">CSV</button>'+
                         // ' <button class="btn btn-info btn-xs" type="button" aria-expanded="false" title="Exporter les résultats au format JSON" onClick="javascript:exportData=\'JSON\';maxLignes=100000;vChargeRecherche('+_iCmd+', 0);">JSON</button></h3>'+
                         '</h3>';
        }
        $(ODivHaut).append($(OCol4).clone().append(strRecap));
        iDeb = OLigne.iLigneDeb;

        // if (_iCmd == 32) {
        //   // Un div vide pour maintenir les alignements
        //   $(ODivHaut).append($(OCol4).clone().append('<nav><ul class="pager"></ul></nav>'));
        // } else if (OLigne.iNbLigneTot > maxLignes) {
        if (OLigne.iNbLigneTot > maxLignes) {
          // Gestion de la pagination de la forme: <début> <précédent> (Numéro du premier de la page - dernier de la page / Nb total de résultat) <suivant> <fin> (je pars aussi du principe que (iLigneDeb - 1) est systématiquement un multiple de maxLignes)
          bPagination = false;
          var ONav = $('<nav />');
          var OUl = $('<ul class="pager"/>');

          if (OLigne.iLigneDeb != 1) {
            // Il existe une page précédente
            if (OLigne.iLigneDeb - maxLignes > 1) {
              // Il existe plus d'une page précédente
              OUl.append($('<li><a href="javascript:vChargeRecherche('+_iCmd+', 1);">Début</a></li>'));
            }
            OUl.append($('<li><a href="javascript:vChargeRecherche('+_iCmd+', '+(Number(OLigne.iLigneDeb) - Number(maxLignes))+');">Précédent</a></li>'));
            bPagination = true;
          }
          // Affichage de la position dans la liste complète
          if (OLigne.iNbLigneTot - OLigne.iLigneDeb + 1 > maxLignes) {
            var iIdLigneFin = Number(OLigne.iLigneDeb)+Number(maxLignes)-1;
          } else {
            var iIdLigneFin = OLigne.iNbLigneTot;
          }
          OUl.append($('<b>&nbsp;('+OLigne.iLigneDeb+'-'+iIdLigneFin+'/<a href="javascript:maxLignes=100000;vChargeRecherche('+_iCmd+', 0);">'+OLigne.iNbLigneTot+'</a>)&nbsp;</b>'));
          if (OLigne.iNbLigneTot - OLigne.iLigneDeb + 1 > maxLignes) {
            // Il existe une page suivante
            OUl.append($('<li><a href="javascript:vChargeRecherche('+_iCmd+', '+(Number(OLigne.iLigneDeb) + Number(maxLignes))+');">Suivant</a></li>'));
            if (OLigne.iNbLigneTot - OLigne.iLigneDeb > (maxLignes+maxLignes)) {
              // Il existe plus d'une page suivante: calcule du ligneDeb de la dernière page OLigne.iNbLigneTot - OLigne.iNbLigneTot % maxLignes + 1
              OUl.append($('<li><a href="javascript:vChargeRecherche('+_iCmd+', '+(Number(OLigne.iNbLigneTot) - (Number(OLigne.iNbLigneTot) % Number(maxLignes)) + 1)+');">Fin</a></li>'));
            }
            bPagination = true;
          }
          if (bPagination) {
            // Création de l'entête et du bas du panel
            // var OPanelHeading = $('<div class="panel-heading"/>');
            // $('#divPanelResult'+_strDestination).prepend(OPanelHeading);
            // var OPanelFooter = $('<div class="panel-footer"/>');
            // $('#divPanelResult'+_strDestination).append(OPanelFooter);

            ONav.append(OUl);
            // OPanelHeading.append(ONav);
            // OPanelFooter.append($(ONav).clone());

            $(ODivHaut).append($(OCol4).clone().append(ONav));
            // $('#divPanelResult'+_strDestination).prepend(ONav);
            $('#divPanelResult'+_strDestination).append($(ONav).clone());
          }

        } else {
          // Un div vide pour maintenir les alignements
          // !!! Rajouter le nombre de résultat !!!
          $(ODivHaut).append($(OCol4).clone().append('<nav><ul class="pager"><b>('+OLigne.iNbLigneTot+'/'+OLigne.iNbLigneTot+')</b></ul></nav>'));
        }
      } else if (iLigne == 1) {
        // Dans la seconde ligne du tableau JSon il y a l'entête (th) du tableau HTML

        // Création de l'entête
        var OThead = $('<thead />');
        $('#tabResult'+_strDestination).append(OThead);
        var OTr = $('<tr />');
        $(OThead).append(OTr);

        if (_iCmd == 20 || _iCmd == 21) {
          // On rajoute dans la première colonne un bouton permettant de visualiser les champs correspondant à la recherche
          // OTr.append($('<th><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></th>'));
          OTr.append($('<th><button id="btnClpsDetTous" title="Déplier les détails de tous les critères trouvés" type="button" class="btn btn-default btn-xs" aria-label="Déplier les détail de tous les critères trouvés"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></th>'+
                       '<script type="text/javascript">'+
                         'bDeplie = false;\n'+
                         '$(\'#btnClpsDetTous\').on(\'click\',  function() {\n'+
                           // 'vDeplieTout('+iCmdDet+');\n'+
                           'if (bDeplie == false) {\n'+
                           '  maxLignes = 100000;\n'+
                           '  vChargeRecherche('+iCmdDetTous+');\n'+
                           '  bDeplie = true;\n'+
                           '} else {\n'+
                           '  $(\'tr[id^="trClpsDetIdO"]\').each(function() {\n'+
                           '    if ($(this).hasClass(\'visible\')) {$(this).toggleClass(\'visible\');}\n'+
                           '    if (!$(this).hasClass(\'hidden\')) {$(this).toggleClass(\'hidden\');}\n'+
                           '    var idOTmp = $(this).attr(\'idO\');\n'+
                           '    $(\'#divClpsDetIdO-\'+idOTmp).collapse(\'hide\');\n'+
                           '  });\n'+
                           '  bDeplie = false;\n'+
                           '}\n'+
                         '});'+
                       '</script>'));


        }
        $.each(OLigne, function (champ, valeur) {
          if (champ != 'Plus') {
            // if (_iCmd == 32) {
            //   var strEntete = '<th nowrap>'+valeur['titre']+'</th>'
            // } else {
              var strClassBtnAsc = '';
              var strClassBtnDesc = '';
              if (strTriChamp == valeur['champ']) {
                if (strTriOrdre == 'ASC') {
                  strClassBtnAsc = ' btn-warning';
                } else {
                  strClassBtnDesc = ' btn-warning';
                }
              }
              var strEntete = '<th nowrap><div class="btn-group" role="group" aria-label="...">'+
                              '  <button type="button" class="btn btn-xs'+strClassBtnAsc+'" onClick="javascript:strTriChamp=\''+valeur['champ']+'\';strTriOrdre=\'ASC\';maxLignes='+maxLignes+';vChargeRecherche('+_iCmd+','+iDeb+');" title="tri croissant">'+
                              '    <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>'+
                              '  </button>'+
                              '  <button type="button" class="btn btn-xs'+strClassBtnDesc+'" onClick="javascript:strTriChamp=\''+valeur['champ']+'\';strTriOrdre=\'DESC\';maxLignes='+maxLignes+';vChargeRecherche('+_iCmd+','+iDeb+');" title="tri décroissant">'+
                              '    <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>'+
                              '  </button>'+
                              '</div> '+valeur['titre']+'</th>'
            // }
            OTr.append($(strEntete));
            iNbCol++;
          }
        });
        iNbCol++;

      } else {
        // Nouvelle ligne (+1 car la première colonne n'est pas dans le tableau)
        var OLidO = OLigne.Id;
        bAucunResultat = false;
        // if (_iCmd == 32) {
        //   var OTr = $('<tr/>');
        // } else {
          var OTr = $('<tr style="cursor:pointer;"/>');
          OTr.attr('onClick', 'javascript:if (typeof bWOpen == "undefined" || bWOpen) {window.open(\'./fiche.php?idO='+OLidO+'\', \'_blank\');}else{bWOpen=true;}');
        // }
        $(OTbody).append(OTr);
        if (_iCmd == 20 || _iCmd == 21) {
          // Rajout d'une ligne (invisible au départ) pour accueillir les détails des critères qui ont correspondus à la recherche
          $(OTbody).append('<tr id="trClpsDetIdO'+OLidO+'" idO="'+OLidO+'" class="hidden"><td colspan="'+iNbCol+'">\n'+
                           '  <div id="divClpsDetIdO-'+OLidO+'" class="collapse"></div>\n'+
                           '  <script type="text/javascript">\n'+
                           '    bDeplie'+OLidO+' = false;\n'+
                           '    $(\'#divClpsDetIdO-'+OLidO+'\').on(\'show.bs.collapse\', function() {'+
                           '      bDeplie'+OLidO+' = true;\n'+
                           '    });'+
                           '    $(\'#divClpsDetIdO-'+OLidO+'\').on(\'hide.bs.collapse\', function() {'+
                           '      bDeplie'+OLidO+' = false;\n'+
                           '    });'+
                           '  </script>\n'+
                           '</td></tr>');
        }
        $.each(OLigne, function (cle, valeur) {
          var bContinue = false;
          if (cle == 'Id') {
            // OTr.attr('onClick', 'javascript:if (typeof bWOpen == "undefined" || bWOpen) {window.open(\'./fiche.php?idO='+valeur+'\', \'_blank\');}else{bWOpen=true;}');
          } else if ((_iCmd == 20 || _iCmd == 21) && cle == 'aCorrespondances') {
            // Bouton pour afficher les correspondances des critères recherchés
            OTr.prepend($('<td><button title="Détail des critères trouvés" type="button" class="btn btn-default btn-xs" onClick="javascript:bDeplie'+OLidO+'=getDeplie('+OLidO+', bDeplie'+OLidO+', '+iCmdDet+');" data-toggle="collapse" data-target="#divClpsDetIdO-'+OLidO+'" aria-expanded="false" aria-controls="divClpsDetIdO'+OLidO+'"><span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span></button></td>'));
            bContinue = true;
          } else if (cle == 'Plus') {
            bContinue = true;
          }
          if (!bContinue) {
            OTr.append($('<td>'+valeur+'</td>'));
          }
        });
      }
    });
    if (bAucunResultat) {
      // Aucun résultat
      var strPlus = '<tr><td colspan="'+iNbCol+'">Aucun résultat</td></tr>\n';
      $(OTbody).append(strPlus);
    }
    // Suppression de maxLignes
    delete(maxLignes);
    // Ajout d'un bouton pour supprimer le panel... pas bien propre mais à améliorer plus tard
    // var strPlus = '<div class="row"><div class="col-md-1 col-md-offset-11 text-right">\n'+
    //               '  <button id="btnFermePanelResult" type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>\n'+
    //               '  <script type="text/javascript"> $("#btnFermePanelResult").click(function () { $("#divPanelResult'+_strDestination+'").remove(); }) </script>\n'+
    //               '</div></div>\n';
    // $('#divPanelResult'+_strDestination).prepend(strPlus);
    var strPlus = '<p class="text-right"><button id="btnFermePanelResult" type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></p>\n'+
                  '<script type="text/javascript"> $("#btnFermePanelResult").click(function () { $("#divPanelResult'+_strDestination+'").remove(); }) </script>\n';
    $(ODivHaut).append($(OCol4).clone().append(strPlus));

    // // Création du corps du tableau
    // var OTbody = $('<tbody />');
    // $('#tabResult'+_strDestination).append(OTbody);

    // $.each(_aJson, function (key, value) {  })

    // for (var i=1; i < _aJson.length; i++) {
    // }
  }
  catch (OException) {
    $('#Patience').modal('hide');
    strPlus = '';
    if (typeof(bDBG) != 'undefined' && bDBG == true) strPlus = strDBG+'\nDBG: '+OException;
    alert('[Tableau-Exception] Un problème est survenu sur le site. Merci de nous contacter avant de poursuivre votre opération.'+strPlus);
    strDBG = '';
  }
}

function getDetail(_strDivDest, _aJson) {

  try {
  // Suppression du résultat précédent éventuel
  $(_strDivDest).html('');
  // if ($(_strDivDest).children()) {
  //   $(_strDivDest).children().remove();
  // }

  var ODivRetour = $('<div class="well well-sm" />');
  $(_strDivDest).append(ODivRetour);
  var ODl = $('<dl class="dl-horizontal" />');
  // <dt>Titre</dt><dd>Valeur</dd>
  // On rattache ODl à ODivRetour
  $(ODivRetour).append(ODl);
  
  // On complète ODl avec les valeur contenue dans _aJson
  $.each(_aJson, function (iLigne, OLigne) {
    if (iLigne != 0 && iLigne != 1 && OLigne != null && typeof(OLigne) == 'object') {
      // Les données sont dans le 3ème élément du tableau
      if ($(OLigne).length === 0) {
        $(ODl).append('<strong>Aucun critère trouvé</strong>');
      } else {
        $.each(OLigne, function (cle, valeur) {
          if (cle == 'aCorrespondances') {
            // On ne s'intéresse qu'à l'entrée aCorrespondances
            if ($(valeur).length === 0) {
              $(ODl).append('<strong>Aucun critère trouvé</strong>');
            } else {
              $.each(valeur, function (cleDt, valeurDd) {
                $(ODl).append('<dt>'+valeurDd.champ+'</dt><dd>'+valeurDd.valeur+'</dd>');
              });
            }
          } else if (valeur != null && typeof(valeur['champ']) != 'undefined' && typeof(valeur['valeur']) != 'undefined') {
            $(ODl).append('<dt>'+valeur['champ']+'</dt><dd>'+valeur['valeur']+'</dd>');
          }
        });
      }
    }
  });
  }
  catch (OException) {
    $('#Patience').modal('hide');
    strPlus = '';
    if (typeof(bDBG) != 'undefined' && bDBG == true) strPlus = strDBG+'\nDBG: '+OException;
    alert('[getDetail-Exception] Un problème est survenu sur le site. Merci de nous contacter avant de poursuivre votre opération.'+strPlus);
    strDBG = '';
  }

}

function getDetailTous(_strDivDest, _aJson) {
  try {
    $.each(_aJson, function (cle, ODetOeuvre) {
      if (cle != 0 && cle != 1) {
        getDetail(_strDivDest+ODetOeuvre['Id'], ODetOeuvre);
        $(_strDivDest+ODetOeuvre['Id']).collapse('show');
        if (!$('#trClpsDetIdO'+ODetOeuvre['Id']).hasClass('visible')) {$('#trClpsDetIdO'+ODetOeuvre['Id']).toggleClass('visible');}
        if ($('#trClpsDetIdO'+ODetOeuvre['Id']).hasClass('hidden')) {$('#trClpsDetIdO'+ODetOeuvre['Id']).toggleClass('hidden');}
      }
    });
  }
  catch (OException) {
    $('#Patience').modal('hide');
    strPlus = '';
    if (typeof(bDBG) != 'undefined' && bDBG == true) strPlus = strDBG+'\nDBG: '+OException;
    alert('[getDetailTous-Exception] Un problème est survenu sur le site. Merci de nous contacter avant de poursuivre votre opération.'+strPlus);
    strDBG = '';
  }
}

function getDeplie(_idO, _bDeplie, _iCmdDet) {

  bWOpen = false;
  if (_bDeplie === false) {
    if (!$('#trClpsDetIdO'+_idO).hasClass('visible')) {$('#trClpsDetIdO'+_idO).toggleClass('visible');}
    if ($('#trClpsDetIdO'+_idO).hasClass('hidden')) {$('#trClpsDetIdO'+_idO).toggleClass('hidden');}
    idO = _idO;
    vChargeRecherche(_iCmdDet);
  } else {
    if ($('#trClpsDetIdO'+_idO).hasClass('visible')) {$('#trClpsDetIdO'+_idO).toggleClass('visible');}
    if (!$('#trClpsDetIdO'+_idO).hasClass('hidden')) {$('#trClpsDetIdO'+_idO).toggleClass('hidden');}
  }
  return !_bDeplie;
}


function selectColEditions(){
    // Compter le nombre de colonnes dans le tableau
    var colCount = 0;
    $('#tableau_editions thead th').each(function () {
        if ($(this).attr('colspan')) {
            colCount += +$(this).attr('colspan');
        } else {
            colCount++;
        }
    });
    
    for (var i = 1; i<colCount; i++) {
        // Get the checkbox
        var checkBox = document.getElementById("checkbox_col"+i);
        var column = $('#checkbox_col'+i).val();
        // If the checkbox is checked, display the output text
        if (checkBox.checked == true){
            $('.table_' + column).show();
        } else {
                $('.table_' + column).hide();
        }
    }
}

function vValideTri(){
  window.location.href='./?'+strTypeRecherche+'&recherche='+strRecherche+'&tri='+$('input[name="radTri"]:checked').val();
}

function vValideTriFiltre(){
  // la liste des filtres est de la forme valeur1***valeur2***valeur3 ...

  var strFiltre = '';
  var strPlus = '';
  var strMessage = '';
  var strMsgSansFiltre = '';

  // Récupération des filtres sur les type d'œuvre
  if ($('input[name="chkTypeOeuvre[]"]:checked').val()) {
    strPlus = '&typeOeuvre=';
    $('input[name="chkTypeOeuvre[]"]:checked').each( function() {
      strFiltre += strPlus+$(this).val();
      strPlus = '***';
    });
  }

  // Récupération des filtres sur une période
  strPlus = '';
  if ($('select[name="selPeriodeDeb"] option:selected').val() && $('select[name="selPeriodeDeb"] option:selected').val() != 0) {
    strFiltre += '&periodeDeb='+$('select[name="selPeriodeDeb"] option:selected').val();
    strPlus = '&periodeDeb='+$('select[name="selPeriodeDeb"] option:selected').val();
    var iAnneeDeb = parseInt($('select[name="selPeriodeDeb"] option:selected').val());
  }
  if ($('select[name="selPeriodeFin"] option:selected').val() && $('select[name="selPeriodeFin"] option:selected').val() != 0) {
    strFiltre += '&periodeFin='+$('select[name="selPeriodeFin"] option:selected').val();
    var iAnneeFin = parseInt($('select[name="selPeriodeFin"] option:selected').val());
    if (iAnneeDeb && iAnneeDeb > iAnneeFin) {
      strMessage = 'La sélection des années pour le filtrage sur la période n\'est pas correcte';
    }
  }

  // Récupération des filtres sur les auteurs
  if ($('input[name="chkAuteur[]"]:checked').val()) {
    strPlus = '&auteur=';
    $('input[name="chkAuteur[]"]:checked').each( function() {
      strFiltre += strPlus+$(this).val();
      strPlus = '***';
    });
  }

  if (strFiltre == '') {
    // strMsgSansFiltre = 'Vous devez séléctionner au moins un élément pour filtrer la recherche';
    strMsgSansFiltre = 'Vous n\'avez sélectionnez aucun filtre. Êtes-vous sûr de vouloir valider cette recherche?\n(cliquez sur annuler pour annuler)';
  }

  if ($('input[name="radTri"]:checked').val()) {
    strFiltre += '&tri='+$('input[name="radTri"]:checked').val();
  } else {
    strPlus = '';
    var iNb = document.getElementsByName('radTri').length;
    for (var i=0; i<iNb; i++) {
      if (document.getElementsByName('radTri')[i].checked) {
        strPlus = document.getElementsByName('radTri')[i].value;
        break;
      }
    }
    strFiltre += '&tri='+strPlus;
  }

  if (strMessage == '') {
    if (strMsgSansFiltre == '' || confirm(strMsgSansFiltre)) {
      window.location.href='./?'+strTypeRecherche+'&recherche='+strRecherche+strFiltre;
    }
  } else {
    alert(strMessage);
  }
}

function vSwitchChevron(_OImg, _strUpDown) {
  try {
    if (_strUpDown == 'up') {
      if (_OImg.hasClass('glyphicon-chevron-down')) {
        _OImg.toggleClass('glyphicon-chevron-down');
      }
      if (!_OImg.hasClass('glyphicon-chevron-up')) {
        _OImg.toggleClass('glyphicon-chevron-up');
      }
    } else if (_strUpDown == 'down') {
      if (_OImg.hasClass('glyphicon-chevron-up')) {
        _OImg.toggleClass('glyphicon-chevron-up');
      }
      if (!_OImg.hasClass('glyphicon-chevron-down')) {
        _OImg.toggleClass('glyphicon-chevron-down');
      }
    }
  }
  catch (OException) {
    $('#Patience').modal('hide');
    strPlus = '';
    if (typeof(bDBG) != 'undefined' && bDBG == true) strPlus = strDBG+'\nDBG: '+OException;
    alert('[Chevron-Exception] Un problème est survenu sur le site. Merci de nous contacter avant de poursuivre votre opération.'+strPlus);
    strDBG = '';
  }
}

function vAjouteChamp(_strIdListe, _strIdElt, _iCpt, _OSelect, _iTypeOSelect) {
  try {
    // alert('!!! vAjouteChamp !!! - checked() = '+$('#chkAuctorial>0').checked);
    // Suppression du premier DIV si son input correspond à _strIdElt-0
    $('div#'+_strIdListe+'>div>div>input#'+_strIdElt+'-0').parent().remove();

    // Ajout de l'élément dans la liste... s'il n'a pas déjà été sélectionnée
    $('div#'+_strIdListe).append('<div class="input-group"> <input type="text" class="form-control" id="'+_strIdElt+'-'+_iCpt+'" name="'+_strIdElt+'-'+_iCpt+'" readonly><input type="hidden" class="form-control" id="hidden'+_strIdElt+'-'+_iCpt+'" name="hidden'+_strIdElt+'-'+_iCpt+'"> <div class="input-group-btn"> <a class="btn btn-danger" role="button" onClick="javascript:vSupprimeChamp(this, \''+_strIdListe+'\', \''+_strIdElt+'\');"><span class="glyphicon glyphicon-trash"></span></a> </div> </div>\n');
    if (_iTypeOSelect == 1) {
      $('#'+_strIdElt+'-'+_iCpt).val(_OSelect.options[_OSelect.selectedIndex].text.replace(/"/g, "'"));
      $('#hidden'+_strIdElt+'-'+_iCpt).val(_OSelect.options[_OSelect.selectedIndex].value);
    } else if (_OSelect.item) {
      $('#'+_strIdElt+'-'+_iCpt).val(_OSelect.item.value);
    } else if (_OSelect.val()) {
      $('#'+_strIdElt+'-'+_iCpt).val(_OSelect.val());
    }
  }
  catch (OException) {
    strPlus = '';
    if (typeof(bDBG) != 'undefined' && bDBG == true) strPlus = strDBG+'\nDBG: '+OException;
    alert('[Ajout-Exception] Un problème est survenu sur le site. Merci de nous contacter avant de poursuivre votre opération.'+strPlus);
    strDBG = '';
    $('#Patience').modal('hide');
  }
}

function vSupprimeChamp(_OObjet, _strIdListe, _strIdElt) {
  try {
    $(_OObjet).parent().parent().remove();
    // S'il n'y a plus de champ sélectionné: on rajoute "Aucune saisie"
    if (!$("input[id^='"+_strIdElt+"-']").is('input')) {
      $('div#'+_strIdListe).append('<div class="row"><div class="col-md-12"> <input type="text" class="form-control" id="'+_strIdElt+'-0" name="'+_strIdElt+'-0" value="Aucune saisie" readonly> </div></div>\n');
    }
  }
  catch (OException) {
    strPlus = '';
    if (typeof(bDBG) != 'undefined' && bDBG == true) strPlus = strDBG+'\nDBG: '+OException;
    alert('[Suppression-Exception] Un problème est survenu sur le site. Merci de nous contacter avant de poursuivre votre opération.'+strPlus);
    strDBG = '';
    $('#Patience').modal('hide');
  }
}

// Transformation d'un tableau JSon en liste de résultats
function getListeResult(_iCmd, _idDest, _strDestination, _aJson) {
  try {

    // Suppression du résultat précédent éventuel
    if ($(_idDest).children()) {
      $(_idDest).children().remove();
    }

    // Création du tableau
    $('<div class="contenu_decale">\n'+
      '    <h4><br /></h4>\n'+
      '    <div id="divResult'+_strDestination+'" class="chronologie">\n'+
      '    </div>\n'+
      '</div>\n').appendTo(_idDest);

    var bAucunResultat = true;
    var iNbCol = 0;
    // ODivHaut contiendra: Titre | navigation | bouton de fermeture
    var ODivHaut = $('<div class="row"/>');
    $('#divResult'+_strDestination).prepend($(ODivHaut));
    var OCol5 = $('<div class="col-md-5" />');

    var strPlusStyle = 'margin-bottom:-40px;';
    var strTriCheckedTitre = '';
    var strTriCheckedDate = '';
    var strTriCheckedAuteur = '';
    if (typeof strTriChecked != "undefined") {
      if (strTriChecked == 'titre') {
        strTriCheckedTitre = ' checked';
      } else if (strTriChecked == 'date') {
        strTriCheckedDate = ' checked';
      } else if (strTriChecked == 'auteur') {
        strTriCheckedAuteur = ' checked';
      }
    }

    $.each(_aJson, function (iLigne, OLigne) {

      if (iLigne == 0) {
        // Dans la première ligne du tableau JSon il y a les informations de pagination et du titre de la recherche
        var strCritereBtn = '';
        var strCritereClp = '';
        var strTriBtn = '';
        var strTriClp = '';
        if ($.trim(OLigne.strRecapRecherche) != '') {
          strCritereBtn = '  <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#colpsRecap" aria-expanded="false" aria-controls="colpsRecap">'+
                          '  Critères <span class="glyphicon glyphicon-chevron-down"></span></button>';
          strCritereClp = '<div class="collapse" id="colpsRecap">'+
                          '  <div class="well well-sm"><small>'+
                          '  '+OLigne.strRecapRecherche+
                          '  </small></div>'+
                          '</div>';
        }
        if (OLigne.iNbLigneTot != 0) {
          strTriBtn = '  <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#colpsTri" aria-expanded="false" aria-controls="colpsTri">'+
                      '  Trier par <span class="glyphicon glyphicon-chevron-down"></span></button>';
          strTriClp = '<div class="collapse" id="colpsTri">'+
                      '  <div class="well well-sm"><small>'+
                      '    <form><div class="radio">'+
                      '      <label>'+
                      '        <input type="radio" name="radTri" id="radModTriTitrePE" value="titre"'+strTriCheckedTitre+'> Titre de l\'œuvre'+
                      '      </label>'+
                      '    </div>'+
                      '    <div class="radio">'+
                      '      <label>'+
                      '        <input type="radio" name="radTri" id="radModTriAnneePE" value="date"'+strTriCheckedDate+'> Date de première édition'+
                      '      </label>'+
                      '    </div>'+
                      '    <div class="radio">'+
                      '      <label>'+
                      '        <input type="radio" name="radTri" id="radModTriAuteur" value="auteur"'+strTriCheckedAuteur+'> Nom de l\'auteur'+
                      '      </label>'+
                      '    </div></form>'+
                      '  </small></div>'+
                      '</div>';
        }
        var strRecap = '<h3>'+OLigne.strTitreRecherche+' ('+OLigne.iNbLigneTot+')'+
                       strCritereBtn+
                       strTriBtn+
                       ' <button class="btn btn-info" type="button" aria-expanded="false" title="Exporter les résultats au format CSV" onClick="javascript:exportData=\'CSV\';maxLignes=100000;vChargeRecherche('+_iCmd+', 0);">CSV</button>'+
                       '</h3>'+
                       strCritereClp+
                       strTriClp;
        $(ODivHaut).append($(OCol5).clone().append(strRecap));
        $('input[name="radTri"]').change( function () {
          strTriChecked = $('input[name="radTri"]:checked').val();
          vChargeRecherche(_iCmd);
        });

        if (typeof(bDBG) != 'undefined' && bDBG == true) {
          $('#Patience').modal('hide');
          document.getElementById('bodyInfo').firstChild.nodeValue = '[Liste résultat-DBG] '+OLigne.strDBG;
          $('#modalInfo').modal('show');
        }

      } else if (iLigne != 1) {
        bAucunResultat = false;
        // Nouvelle ligne (+1 car la première colonne n'est pas dans le tableau)
        var strAuteurDate = '';
        var strPlus = '';
        if ($.trim(OLigne.urlIllustration) != '') {
          var strUrlIllistration = OLigne.urlIllustration;
        } else {
          var strUrlIllistration = 'images/logo_anticipation_logo.png';
        }
        if ($.trim(OLigne.Nom) != '') {
          strAuteurDate = OLigne.Nom;
          strPlus = ' ';
        }
        if ($.trim(OLigne["Prénom"]) != '') {
          strAuteurDate += strPlus+OLigne['Prénom'];
        }
        strPlus = ' - ';
        if ($.trim(OLigne.anneePE) != '') {
          strAuteurDate += strPlus+OLigne.anneePE;
        }
        var strTmplResultRech = '<div class="row">'+
                                '<div id="divOeuvre'+OLigne.Id+'" class="container_citation col-md-12" '+
                                     'style="cursor:pointer; margin-top:40px; '+strPlusStyle+'"'+
                                     // 'onClick="javascript:window.open(\'./?idOeuvre='+OLigne.Id+'\', \'_self\');">\n'+
                                     'onClick="javascript:window.open(\'./?idOeuvre='+OLigne.Id+'\', \'_blank\');">\n'+
                                '    <div class="citation citation_sans_icon col-md-2">\n'+
                                '      <a class="cover_book"><img src="'+strUrlIllistration+'" alt="Couverture du livre"></a>\n'+
                                '    </div>\n'+
                                '    <div class="row">\n'+
                                '      <div class="citation col-md-8" style="margin-bottom: 0px;">\n'+
                                '          <div class="col_droite_citation">\n'+
                                '              <p class="text_reference minimize">\n'+
                                '                  '+OLigne.titrePE+'\n'+
                                '              </p>\n'+
                                '              <p class="description_elem_scien">\n'+
                                '                  '+strAuteurDate+'\n'+
                                '              </p>\n'+
                                '          </div>\n'+
                                '      </div>\n'+
                                '      <div class="col-md-2">\n'+
                                '          <div class="col_droite_citation">\n'+
                                '              <p class="description_elem_scien">\n'+
                                '                  <img class="icon_fonctions_laterales" src="images/signet.png">\n'+
                                '                  <button class="btn btn-danger btn-secondary">Voir la fiche</button>\n'+
                                '              </p>\n'+
                                '          </div>\n'+
                                '      </div>\n'+
                                '    </div>\n'+
                                '</div>\n'+
                                '</div>\n';
        $(strTmplResultRech).appendTo('#divResult'+_strDestination);

        // Affichage des correspondances
        // utiliser OLigne.aCorrespondances pour les correspondances...
        if ($.isArray(OLigne.aCorrespondances)) {
          $.each(OLigne.aCorrespondances, function (iKey, OCorrespondance) {
            if (OCorrespondance.valeur == null) {
              // Cas par exemple d'une invention scientifique imaginaire sans discipline... Sans doute que rendre ce champ obligatoire dans le formulaire résoudra le souci
              if (typeof(bDBG) != 'undefined' && bDBG == true) {
                OCorrespondance.valeur ='Problème dans la fiche%,%%,%TOD%,%';
              } else {
                return;
              }
            }
            if (OCorrespondance.champ == 'Modalité' || OCorrespondance.champ == 'Disciplines (des réf. au réel)') {
              // Pas d'affichage de ces champs qui sont inclus dans les TIPS
            } else if (OCorrespondance.champ.search(/TIPS\|/) == 0) {
              // cas des Théorie, invention ou personnalité scientifique présentée sous la forme [theorie|personnalite]%,%citation%,%discipline%,%modalite%;%
              var aRefsReel = OCorrespondance.valeur.split('%;%');
              aRefsReel.forEach(function(strRef){
                var aReference = strRef.split('%,%');
                var strTheoPers = '';
                var strCitation = '';
                // if (aReference[0] && aReference[0].trim().length != 0) {
                //   strTheoPers = aReference[0];
                // } else {
                //   strTheoPers = aReference[1];
                // }
                strTheoPers = aReference[0];
                if (aReference[1] && aReference[1].trim().length != 0) {
                  if (aReference[0] && aReference[0].trim().length != 0) {
                    strTheoPers += '<br />\n';
                  }
                  strTheoPers += aReference[1];
                }
                if (aReference[2] && aReference[2].trim().length != 0) {
                  strCitation = '        <p class="sciences_citation minimize">\n'+
                                '            '+aReference[2]+'\n'+
                                '        </p>\n';
                }
                if ($.trim(strTheoPers) != '' || $.trim(strCitation) != '') {
                  var strTmplRef = '<div class="row">\n'+
                                   '  <div class="citation col-md-12">\n'+
                                   '      <div class="col_gauche_citation col_gauche_citation_sans_date">\n'+
                                   '          <img class="quotes_sans_date" src="images/'+getValSrcImgEltSciReel(aReference[3])+'">\n'+
                                   '          <div class="trait_vertical_citation_sans_date"></div>\n'+
                                   '      </div>\n'+
                                   '      <div class="col_droite_citation col_droite_citation_sans_date">\n'+
                                   '          <p class="saut_de_ligne">&nbsp;</p>\n'+
                                   '          <p class="text_reference minimize">\n'+
                                   '              '+strTheoPers+'\n'+
                                   '          </p>\n'+
                                   strCitation+
                                   '          <p class="source_citation">\n'+
                                   '              '+getValCodeRefAuReelDiscipline(aReference[3])+' \n'+
                                   '          </p>\n'+
                                   '          <p class="source_citation">\n'+
                                   '              '+getValCodeRefAuReelModalite(aReference[4])+' \n'+
                                   '          </p>\n'+
                                   '      </div>\n'+
                                   '  </div>\n'+
                                   '</div>\n';
                  $(strTmplRef).appendTo('#divOeuvre'+OLigne.Id);
                }
              });
            } else if (OCorrespondance.champ.search(/ESI\|/) == 0) {
              // cas des éléments scientifiques imaginaires
              var aEltsSciImag = OCorrespondance.valeur.split('%;%');
              aEltsSciImag.forEach(function(strElt){
                var aElement = strElt.split('%,%');
                var strTmplEltSciImagin = '<div class="row">\n'+
                                          '  <div class="citation col-md-12">\n'+
                                          '    <div class="col_gauche_citation col_gauche_citation_sans_date">\n'+
                                          '      <img class="quotes_sans_date" src="images/'+getValSrcImgEltSciImag(aElement[2])+'">\n'+
                                          '      <div class="trait_vertical_citation_sans_date"></div>\n'+
                                          '    </div>\n'+
                                          '    <div class="col_droite_citation col_droite_citation_sans_date">\n'+
                                          '      <p class="saut_de_ligne">&nbsp;</p>\n'+
                                          '      <p class="text_reference minimize">\n'+
                                          '        '+aElement[0]+'\n'+
                                          '      </p>\n'+
                                          '      <p class="description_elem_scien">\n'+
                                          '        '+aElement[1]+'\n'+
                                          '      </p>\n'+
                                          '      <p class="cat_elem_scien">\n'+
                                          '        '+aElement[3]+'\n'+
                                          '      </p>\n'+
                                          '    </div>\n'+
                                          '  </div>\n'+
                                          '</div>\n';
                $(strTmplEltSciImagin).appendTo('#divOeuvre'+OLigne.Id);
              });
            } else if (OCorrespondance.valeur.trim().length != 0) {
              var strTmplDiscipline = '    <div class="row">\n'+
                                      '      <div class="citation col-md-12">\n'+
                                      '        <div class="col_gauche_citation col_gauche_citation_sans_date">\n'+
                                      '            <img class="quotes_sans_date" src="images/autre.svg">\n'+
                                      '            <div class="trait_vertical_citation_sans_date"></div>\n'+
                                      '        </div>\n'+
                                      '        <div class="col_droite_citation col_droite_citation_sans_date">\n'+
                                      '            <p class="saut_de_ligne">&nbsp;</p>\n'+
                                      '            <p class="text_reference minimize">\n'+
                                      '                '+OCorrespondance.champ+'\n'+
                                      '            </p>\n'+
                                      '            <p class="source_citation">\n'+
                                      '                '+OCorrespondance.valeur.replace('<br /><br />', '<br />')+'\n'+
                                      '            </p>\n'+
                                      '            <p class="source_citation">\n'+
                                      '            </p>\n'+
                                      '        </div>\n'+
                                      '      </div>\n'+
                                      '    </div>\n';
              $(strTmplDiscipline).appendTo('#divOeuvre'+OLigne.Id);
            }
          });
        }

        strPlusStyle = 'border-top-style:solid; border-top-color:#D31D17; margin-bottom:-40px; padding-top:50px;';
      }
    });
    if (bAucunResultat) {
      // Aucun résultat
      var strPlus = '<tr><td colspan="'+iNbCol+'">Aucun résultat</td></tr>\n';
      $(strPlus).appendTo('#divResult'+_strDestination);
    }

  }
  catch (OException) {
    $('#Patience').modal('hide');
    strPlus = '';
    if (typeof(bDBG) != 'undefined' && bDBG == true) strPlus = strDBG+'\nDBG: '+OException;
    alert('[Liste résultat-Exception] Un problème est survenu sur le site. Merci de nous contacter avant de poursuivre votre opération.'+strPlus);
    strDBG = '';
  }
}

function getValSrcImgEltSciReel(_strCode){
  switch (_strCode){
    case 'VIE' :             
    case '<mark>VIE</mark>' : return 'dna.svg';       break; // Sciences de la vie (inclut biologie, botanique, zoologie) 
    case 'MED' :             
    case '<mark>MED</mark>' : return 'heartbeat.svg'; break; // Sciences médicales
    case 'TER' :             
    case '<mark>TER</mark>' : return 'space.svg';     break; // Sciences  de la terre et de l’espace  (astronomie, géologie, géographie)
    case 'PCM' :             
    case '<mark>PCM</mark>' : return 'atom.svg';      break; // Physique, chimie et mathématiques
    case 'ING' :             
    case '<mark>ING</mark>' : return 'gears.svg';     break; // Ingénierie et technique
    case 'AUT' :             
    case '<mark>AUT</mark>' : return 'autre.svg';     break; // Autre';
    case 'TOD' :             
    case '<mark>TOD</mark>' : return 'todo.png';      break; // Indication d'une fiche incomplète
    default    :              return 'autre.svg';     break;
  }
  return false;
}

function getValCodeRefAuReelDiscipline(_strCode){
  switch (_strCode){
    case 'VIE' :              return 'Sciences de la vie (inclut biologie, botanique, zoologie)'; break;
    case '<mark>VIE</mark>' : return '<mark>Sciences de la vie (inclut biologie, botanique, zoologie)</mark>'; break;
    case 'MED' :              return 'Sciences médicales'; break;
    case '<mark>MED</mark>' : return '<mark>Sciences médicales</mark>'; break;
    case 'TER' :              return 'Sciences  de la terre et de l’espace  (astronomie, géologie, géographie)'; break;
    case '<mark>TER</mark>' : return '<mark>Sciences  de la terre et de l’espace  (astronomie, géologie, géographie)</mark>'; break;
    case 'PCM' :              return 'Physique, chimie et mathématiques'; break;
    case '<mark>PCM</mark>' : return '<mark>Physique, chimie et mathématiques</mark>'; break;
    case 'ING' :              return 'Ingénierie et technique'; break;
    case '<mark>ING</mark>' : return '<mark>Ingénierie et technique</mark>'; break;
    case 'AUT' :              return 'Autre'; break;
    case '<mark>AUT</mark>' : return '<mark>Autre</mark>'; break;
    case 'TOD' :              return 'Problème dans la fiche'; break;              // Indication d'une fiche incomplète
    case '<mark>TOD</mark>' : return '<mark>Problème dans la fiche</mark>'; break; // Indication d'une fiche incomplète
    default    :              return '???'; break;
  }
  return false;
}

function getValCodeRefAuReelModalite(_strCode){
  switch (_strCode){
    case 'SER' :              return 'Sérieux'; break;
    case '<mark>SER</mark>' : return '<mark>Sérieux</mark>'; break;
    case 'SAT' :              return 'Satire'; break;
    case '<mark>SAT</mark>' : return '<mark>Satire</mark>'; break;
    case 'HOM' :              return 'Hommage'; break;
    case '<mark>HOM</mark>' : return '<mark>Hommage</mark>'; break;
    case 'REF' :              return 'Réfutation'; break;
    case '<mark>REF</mark>' : return '<mark>Réfutation</mark>'; break;
    default    : return '???'; break;
  }
  return false;
}

function getValSrcImgEltSciImag(_idCode){
  switch (_idCode){
    case '258': return 'sword.svg';         break; // Armes
    case '259': return 'communication.svg'; break; // Communications, image/son
    case '250': return 'heartbeat.svg';     break; // Corps humain, pouvoirs psychiques, vie/mort
    case '254': return 'space.svg';         break; // Espace
    case '251': return 'alien.svg';         break; // Formes de vie inconnue
    case '252': return 'black-hole.svg';    break; // Modifications de la nature
    case '256': return 'power.svg';         break; // Sources d'énergie
    case '253': return 'clock.svg';         break; // Temps
    case '260': return 'gears.svg';         break; // Théories scientifiques
    case '257': return 'atom.svg';          break; // Transports
    case '255': return 'daily.svg';         break; // Vie quotidienne
    case '268': return 'autre.svg';         break; // Autre
    case 'TOD': return 'todo.png';          break; // Indication d'une fiche incomplète
    default   : return 'autre.svg';         break;
  }
}

