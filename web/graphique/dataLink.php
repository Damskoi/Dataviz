<?php
  require('connexionV2.php');
  $conn = Connexion::getBD();
  echo isset($conn);
  echo 'YES';

  function links($tabID){
    $tabLinks = array();
    $tabLiensAuteurs = array();
    $conn = Connexion::getBD();
    for($i=0; $i<count($tabID); $i++){
      echo '<br/>';
      $tabLiensAuteurs = $conn->informations($tabID[$i]);
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
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    //print_r($tabLinks);
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    //return $tabLinks;
    return $tabLinks;
  }

  $tab = [38,97];
  $tabL=links($tab);
  print_r($tabL);

?>
