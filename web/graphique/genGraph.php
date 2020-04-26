<?php
require('connexionV2.php');
$conn = Connexion::getBD();

/**
 * String -> tableau de donneés
 * @param data Le JSON en entrée
 */
function makeTab($data) {
    // Transformer en tableau
    $listeID = [];
    foreach($data as $_ => $val) {
        array_push($listeID, $val['idOeuvre']);
    }
    return $listeID;
}

/**
 * Retourne le SQL nécéssaire pour faire une sous-requete.
 * Ce code est le même pour toutes les requêtes, 
 * parce que nous avons besoin uniquement des oeuvres elle-mêmes.
 * @param data Les données de  base (tableau js.)
 */
function makeSubrequest($data) {
    $sql = implode($data, ","); // "1,2,34,238"...
    return $sql;
}

function barChart($data, $sub_sql, $conn) {
    return $conn->infoBarChart($data, $sub_sql, $conn);
}

function bubbleChart($data, $sub_sql, $conn) {
    return $conn->infoBubbleChart($data, $sub_sql, $conn);
}

function networkChart($data, $sub_sql, $conn) {
    error_reporting(0);
    $tabLinks = array();
    $tabLiensAuteurs = array();
    for($i=0; $i<count($data); $i++){
      // Voir connexionV2
      $tabLiensAuteurs = $conn->infoNetwork($data[$i]);
      //print_r($tabLiensAuteurs);
      for($j=0; $j<count($tabLiensAuteurs); $j++){
      // tab = Array({ 'Jean'=>{}, 'Dupond'=>{}, 'Jule'=>{} })
        if(array_key_exists($tabLiensAuteurs[$j]['auteurCompare'],$tabLinks)){
          if(!in_array($tabLiensAuteurs[$i]['titrePE'], $tabLinks[$tabLiensAuteurs[$j]['auteurCompare']])){
            array_push($tabLinks[$tabLiensAuteurs[$j]['auteurCompare']], $tabLiensAuteurs[$j]['titrePE']);
          }
        }
        else{
          $tabLinks[$tabLiensAuteurs[$j]['auteurCompare']] = array();
          array_push($tabLinks[$tabLiensAuteurs[$j]['auteurCompare']], $tabLiensAuteurs[$j]['titrePE']);
        }
      }
    }
    
    $nodes = array();
    foreach ($tabLinks as $c => $v){
      $nodes[]=array('id'=>$c);
    }

    $edges = array();
    foreach($tabLinks as $c => $v){
      foreach($v as $cle => $val){
        $edges[]=array('from'=>$c, 'to'=>$val);
      }
    }
    return array($nodes,$edges);
}


/* Main
*/
if (!isset($_POST)) {
    echo json_encode("erreur: pas de paramètre");
    exit();
}

$typeGraphe = $_POST['typeGraphe'];
$data = makeTab($_POST['data']);
//echo $data;
$sub_sql = makeSubrequest($data);
//echo $sub_sql;

if ($typeGraphe === 'bar'){
    $result = barChart($data, $sub_sql, $conn);
}else if ($typeGraphe === 'bubble') {
    $result = bubbleChart($data, $sub_sql, $conn);
}else if ($typeGraphe === 'network') {
    $result = networkChart($data, $sub_sql, $conn);
}

echo json_encode($result);
?>
