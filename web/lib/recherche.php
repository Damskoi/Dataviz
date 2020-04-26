<?php
// ------------------------------------------------------------------------------------------------------------ //
//                                                                                                              //
// recherche.php - contient les fonctions de recherche pour filtrer les œuvres à afficher                       //
//                                                                                                              //
//                                                                                                              //
// ------------------------------------------------------------------------------------------------------------ //

include_once 'lib/recherche-inc.php';

// Récupère la liste des oeuvre en fonction des filtres
// 
// _aFiltre est un tableau contenant
//   _aFiltre['strFrom']: --------- nom de la table de référence
//   _aFiltre['strJoin']: --------- de la forme 'LEFT JOIN table1 ON table1.id = table2.id'
//   _aFiltre['strGroup']: -------- chaine contenant les champs pour le regroupement
//   _aFiltre['strOrder']: -------- chaine contenant les champs pour le trie
//   _aFiltre[]['strTable']: ------ nom de la table
//   _aFiltre[]['strChamp']: ------ nom du champ
//   _aFiltre[]['strFiltre']: ----- chaîne à rechercher dans ce champ
//   _aFiltre[]['quote']: --------- si présent, indique si on doit mettre la valeur du filtre entre cotes
//   _aFiltre[]['strOperateur']: -- de la forme '=', '>=', '<=', 'LIKE' ...
function aFiltreOeuvre($_OConnexion, $_aFiltre) {
  $aResultat = array();
  // $strJoin = $strGroup = $strOrder = '';
  $strWhereSupl = $strPlusJoin = $strSelect = $strWhere = $strAndOr = $strRequete = '';
  $strPlusSelect = 'SELECT ';
  $strPlusWhere = '';

  // Construction de la requête
  // $strFrom = 'FROM '.$_aFiltre['strFrom'];
  // if (!empty($_aFiltre['strGroup'])) $strGroup = 'GROUP BY '.$_aFiltre['strGroup'];
  // if (!empty($_aFiltre['strOrder'])) $strOrder = 'ORDER BY '.$_aFiltre['strOrder'];
  if (!empty($_aFiltre['strAndOr'])) {
    $strAndOr = $_OConnexion->real_escape_string($_aFiltre['strAndOr']);
  } else {
    $strAndOr = ' OR ';
  }
  foreach ($_aFiltre as $key => $aFiltre) {
    if (!empty($aFiltre['strTable'])) {
      // C'est un filtre pour le SELECT
      $strSelect .= $strPlusSelect.$_OConnexion->real_escape_string($aFiltre['strTable']).'.'.$_OConnexion->real_escape_string($aFiltre['strChamp']);
      $strPlusSelect = ', ';
      if (!empty($aFiltre['strFiltre'])) {
        if (!empty($aFiltre['quote'])) {
          $strQuote = "'";
        } else {
          $strQuote = '';
        }
        $strWhere .= $strPlusWhere.$_OConnexion->real_escape_string($aFiltre['strTable']).'.'.$_OConnexion->real_escape_string($aFiltre['strChamp']).' '.
                     $_OConnexion->real_escape_string($aFiltre['strOperateur']).' '.$strQuote.$_OConnexion->real_escape_string($aFiltre['strFiltre']).$strQuote;
        $strPlusWhere = $strAndOr;
      }
    }
  }

  // Rajout de filtres supplémentaires
  if (!empty($_aFiltre['strWhere'])) {
    $strWhereSupl = $_aFiltre['strWhere']."\n";
  }

  // Rajout des champs pour la création des filtres
  $strSelect .= $strPlusSelect.' concat(oeuvres.auteurNom, \'---\', oeuvres.auteurPrenom) \'NomPrenom\', natureTxt';
  $strRequete = $strSelect."\n".
                $_aFiltre['strFrom']."\n".
                (!empty($_aFiltre['strJoin']) ? $_aFiltre['strJoin'] : '')."\n".
                'WHERE ('.$strWhere.')'."\n".
                'AND oeuvres.deleted = 0'."\n".
                $strWhereSupl.
                (!empty($_aFiltre['strGroup']) ? $_aFiltre['strGroup'] : '')."\n".
                (!empty($_aFiltre['strOrder']) ? $_aFiltre['strOrder'] : '')."\n";

  $aTypeOeuvre = array();
  $aNomPrenom = array();
  $aAnneePE = array();
  // Récupération des id de toutes les oeuvres (sauf deleted!=0)
  if ($OResult = $_OConnexion->query($strRequete)) {
    while ($ligne = $OResult->fetch_array(MYSQLI_ASSOC)) {
      foreach ($ligne as $strNomChamp => $strValeurChamp) {
        $aResultat['oeuvre'][$ligne['idOeuvre']][$strNomChamp] = $strValeurChamp;
        // Récupération des listes pour les filtres (type d'œuvre, "<nom>---<prénom>" de l'auteur, anneePE min et anneePE max)
        switch ($strNomChamp) {
          case 'natureTxt': if (!in_array($strValeurChamp, $aTypeOeuvre)) $aTypeOeuvre[] = $strValeurChamp; break;
          case 'NomPrenom': if (!in_array($strValeurChamp, $aNomPrenom))  $aNomPrenom[]  = $strValeurChamp; break;
          case 'anneePE':   if (!in_array($strValeurChamp, $aAnneePE))    $aAnneePE[]    = $strValeurChamp; break;
        }
      }
    }
  }
  sort($aNomPrenom);
  sort($aAnneePE);
  $aResultat['strDBG'] = 'requête: '.$strRequete."\n";
  $aResultat['typeOeuvre'] = $aTypeOeuvre;
  $aResultat['NomPrenom'] = $aNomPrenom;
  $aResultat['anneePE'] = $aAnneePE;
  return $aResultat;

}

?>
