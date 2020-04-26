<?php
/***********************************************************************************
 *
 *  connexion.php : contient la classe pour la connexion à la base de données
 *
 ***********************************************************************************/

class Connexion extends mysqli{
  private $bd;
  private static $instance = null;

  public function __construct() {
    $this->bd = new PDO("mysql:host=localhost;dbname=anticipation","php","jesuistresencolere");
    $this->bd-> query("SET NAME utf8");
    $this->bd-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public static function getBD() {
    if(self::$instance === null)
      self::$instance = new Connexion();
    return self::$instance;
    }
    
/***********************************************************************************
 *
 *  PREMIER CHAMP
 *
 ***********************************************************************************/
 
 ##########################################################################################################################################
 #
 #  Les divers champs sont faits de sorte à pouvoir facilement etre mit à jour/modifier celui-ci suivant une architecture qui se répète pour tous les champs
 #
 ##########################################################################################################################################

  public function getResearch($var, $var2, $var3, $var4, $varTab6){ //Fait pour la recherche dans la table ouevres
    $test = count($varTab6)!=0;
    if($var!=null or $var2!=null or $var3!=null or $var4!=null or $test){
      $txt = 'SELECT distinct idOeuvre FROM oeuvres WHERE';
      if ($var != null){ //Nom
        $txt = $txt." LOCATE(:var, titrePE)";
      }

      if ($var!=null and $var2!=null){
        $txt = $txt.' AND';
      }

      if($var2!=null){ 
        $txt = $txt.' auteurNom = :var2 or auteurNom2 = :var2 or auteurNom3 = :var2';
        $txt = $txt.' or auteurNomReel = :var2 or auteurNomReel2 = :var2 or auteurNomReel3 = :var2';
        $txt = $txt.' or auteurPrenom = :var2 or auteurPrenom2 = :var2 or auteurPrenom3 = :var2';
        $txt = $txt.' or auteurPrenomReel = :var2 or auteurPrenomReel2 = :var2 or auteurPrenomReel3 = :var2';
      }

      if (($var!=null or $var2!=null) and $var3!=null){
        $txt = $txt.' AND';
      }

      if($var3!=null){ 
        $txt = $txt.' anneePE> :var3';
      }


      if (($var!=null or $var2!=null or $var3!=null) and $var4!=null){
        $txt = $txt.' AND';
      }

      if($var4!=null){ //Année publication
        $txt = $txt.' anneePE< :var4';
      }


      if ($test){ //Nom
        if ($var!=null or $var2!=null or $var3!=null or $var4!=null)
          $txt = $txt.' AND';
        $testFirst=0;
        foreach($varTab6 as $c => $v){
          if ($testFirst>=1 and $testFirst<=count($varTab6)){
            $txt = $txt." OR";
          }
          if ($v=='R'){
            $txt = $txt.' natureTxt=1 '; 
            $testFirst++;
          }
          else if ($v=='RC'){
            $txt = $txt." natureTxt=2"; 
            $testFirst++;
          }
          else if ($v=='BD'){
            $txt = $txt.' natureTxt=3'; 
            $testFirst++;
          }
      }
    }

      $txt = $txt.' GROUP BY idOeuvre';
      $req0 = $this->bd->prepare($txt);
      if ($var!=null){
        $req0->bindValue(':var', $var);
      }

      if ($var2!=null){
        $req0->bindValue(':var2', $var2);
      }

      if ($var3!=null){
        $req0->bindValue(':var3', $var3);
      }

      if ($var4!=null){
        $req0->bindValue(':var4', $var4);
      }

    //echo $txt;
      $req0->execute();
      $tabNom = $req0->fetchAll(PDO::FETCH_ASSOC);
      return $tabNom;
    }
    return null;
  }
  
 /***********************************************************************************
 *
 *  DEUXIEME CHAMP 
 *
 ***********************************************************************************/



  public function getResearchGenre($var, $var2, $var3, $varTab4, $var5, $var6, $var7){ //Fait pour la recherche dans la table ouevres

    $test4 = count($varTab4)!=0;
    if($var!=null or $var2!=null or $var3!=null or $test4!=null or $var5!=null or $var6!=null or $var7!=null){
      $txt = 'SELECT idOeuvre FROM oeuvres WHERE';

      if ($var != null){ //Nom
        $txt = $txt.' exists (SELECT idOeuvre from dispositifeditorial where a.idOeuvre=dispositifeditorial.idOeuvre and LOCATE(:var1,designation))';
      }

      if ($var!=null and ($var2!=null or $var3!=null)){
        $txt = $txt.' AND';
      }

      if($var2!=null and $var3!=null){
        $txt = $txt.' exists (SELECT idOeuvre from dispositifeditorial where a.idOeuvre=dispositifeditorial.idOeuvre and dDate>:var2 and dDate<:var3)';
      }

      else if ($var2!=null){
        $txt = $txt.' exists (SELECT idOeuvre from dispositifeditorial where a.idOeuvre=dispositifeditorial.idOeuvre and dDate>:var2)';
      }

      else if($var3!=null){
        $txt = $txt.' exists (SELECT idOeuvre from dispositifeditorial where a.idOeuvre=dispositifeditorial.idOeuvre and dDate<:var3)';
      }


      if ($test4){ //Nom
        if ($var!=null or $var2!=null or $var3!=null)
          $txt = $txt.' AND';
        $testFirst=0;
        foreach($varTab4 as $c => $v){
          if ($testFirst>=1 and $testFirst<=count($varTab4)){
            $txt = $txt." AND";
          }
          if ($v=='Discours auctorial'){
            $txt = $txt.' discoursAuctorialOK!=1'; 
            $testFirst++;
          }
          else if ($v=='Réception critique'){
            $txt = $txt." discoursAuctorialCom!='null'"; 
            $testFirst++;
          }
          else if ($v=='Dispositif éditorial'){
            $txt = $txt.' dispositifEditorialOK=1';
            $testFirst++;
          }
      }
    }

    if(($var!=null or $var2!=null or $var3!=null or $test4) and $var5!=null){
      $txt = $txt.' AND';
    }

    if($var5!=null){
      $txt = $txt.' exists (SELECT idOeuvre from liensaitresauteurs where a.idOeuvre=liensaitresauteurs.idOeuvre and  LOCATE(:var5,auteurCompare))';
    }

    if(($var!=null or $var2!=null or $var3!=null or $test4 or $var5!=null1) and ($var6!=null or $var7!=null)){
      $txt = $txt.' AND';
    }

    if($var6!=null and $var7!=null){
      $txt = $txt.' exists (SELECT idOeuvre from liensaitresauteurs where a.idOeuvre=liensaitresauteurs.idOeuvre and dDate>:var6 and dDate<:var7)';
    }

    else if ($var6!=null){
      $txt = $txt.' exists (SELECT idOeuvre from liensaitresauteurs where a.idOeuvre=liensaitresauteurs.idOeuvre and dDate>:var6)';
    }

    else if($var7!=null){
      $txt = $txt.' exists (SELECT idOeuvre from liensaitresauteurs where a.idOeuvre=liensaitresauteurs.idOeuvre and dDate<:var7)';
    }

      $req0 = $this->bd->prepare($txt);
      if ($var!=null){
        $req0->bindValue(':var1', $var);
      }

      if ($var2!=null){
        $req0->bindValue(':var2', $var2);
      }

      if ($var3!=null){
        $req0->bindValue(':var3', $var3);
      }

      if ($var5!=null){
        $req0->bindValue(':var5', $var5);
      }

      if ($var6!=null){
        $req0->bindValue(':var6', $var6);
      }

      if ($var7!=null){
        $req0->bindValue(':var7', $var7);
      }

      $req0->execute();
      $tabNom = $req0->fetchAll(PDO::FETCH_ASSOC);
      return $tabNom;
    }
    return null;
  }

 /***********************************************************************************
 *
 *  TROISIEME CHAMP
 *
 ***********************************************************************************/

  public function getResearchMaterial($var, $var2, $var2Bis,$tabChecked1,$tabChecked2, $var3, $var4, $var5){ //Fait pour la recherche dans la table ouevres
    $test1 = count($tabChecked1)!=0;
    $test2 = count($tabChecked2)!=0;
    if($var!=null or $var2!=null or $var2Bis!=null or $test1 or $test2 or $var3!=null or $var4!=null or ($var5!=null and $var5!='null') ){
      $txt = 'SELECT distinct idOeuvre FROM oeuvres WHERE';

      if ($var != null){ //Nom
        $txt = $txt.'  exists (SELECT idOeuvre from editions where oeuvres.idOeuvre=editions.idOeuvre and LOCATE(:var,volEditeur) or LOCATE(:var,livEditeur) or LOCATE(:var,livCollecNom) or LOCATE(:var,perNom))'; //A regler si en distinct
      }

      if ($var!=null and $var2!=null){
        $txt = $txt.' AND';
      }

      if($var2!=null){ //auteurPrenom
          $txt = $txt.'  exists (SELECT idOeuvre from editions where oeuvres.idOeuvre=editions.idOeuvre and anneeParution>:var2)'; 
      }

      if (($var!=null or $var2!=null) and $var2Bis!=null){
        $txt = $txt.' AND';
      }


      if($var2Bis!=null){ //Titre
          $txt = $txt.'  exists (SELECT idOeuvre from editions where oeuvres.idOeuvre=editions.idOeuvre and anneeParution<:var2)'; 
      }


      if ($test1){ //Nom
        if ($var!=null or $var2!=null or $var2Bis!=null)
          $txt = $txt.' AND';
        $txt = $txt.' exists (SELECT idOeuvre from editions where oeuvres.idOeuvre=editions.idOeuvre and ';
        $testFirst=0;
        foreach($tabChecked1 as $c => $v){
          if ($testFirst>=1 and $testFirst<=count($tabChecked1)){
            $txt = $txt." AND";
          }
          if ($v=='V'){
            $txt = $txt." typeEdit ='V'"; 
            $testFirst++;
          }
          else if ($v=='P'){
            $txt = $txt." typeEdit ='P'"; 
            $testFirst++;
          }
          else if ($v=='L'){
            $txt = $txt." typeEdit ='L'"; 
            $testFirst++;
          }
      }
      $txt = $txt.')';
    }

    if ($test2){ //Nom
      if ($var!=null or $var2!=null or $var2Bis!=null or $test1)
        $txt = $txt.' AND';
      $txt = $txt.' exists (SELECT idOeuvre from liste_catedit natural join editions as b where oeuvres.idOeuvre=b.idOeuvre and';
      $testFirst=0;
      foreach($tabChecked2 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($tabChecked2)){
          $txt = $txt." AND";
        }
        if ($v=='273'){
          $txt = $txt." idRef =273"; 
          $testFirst++;
        }
        else if ($v=='269'){
          $txt = $txt." idRef =269"; 
          $testFirst++;
        }
        else if ($v=='278'){
          $txt = $txt." idRef =278"; 
          $testFirst++;
        }
        else if ($v=='275'){
          $txt = $txt." idRef =275"; 
          $testFirst++;
        }
        else if ($v=='272'){
          $txt = $txt." idRef =272"; 
          $testFirst++;
        }
        else if ($v=='274'){
          $txt = $txt." idRef =274"; 
          $testFirst++;
        }
        else if ($v=='271'){
          $txt = $txt." idRef =271"; 
          $testFirst++;
        }
        else if ($v=='276'){
          $txt = $txt." idRef =276"; 
          $testFirst++;
        }
        else if ($v=='279'){
          $txt = $txt." idRef =279";
          $testFirst++;
        }
        else if ($v=='277'){
          $txt = $txt." idRef =277"; 
          $testFirst++;
        }
        else if ($v=='270'){
          $txt = $txt." idRef =270"; 
          $testFirst++;
        }
        else if ($v=='280'){
          $txt = $txt." idRef =280";
          $testFirst++;
        }
    }
    $txt = $txt.')';
  }





    if (($var!=null or $var2!=null or $var2Bis!=null or $test1 or $test2) and $var3!=null){
      $txt = $txt.' AND';
    }

      if($var3!=null){ 
        $txt = $txt.'  exists (SELECT idOeuvre from editions where oeuvres.idOeuvre=editions.idOeuvre and volIllustrAuteur=:var3 or livIllustrAuteur=:var3  or perIllustrAuteur=:var3)';
      }

      if (($var!=null or $var2!=null or $var2Bis!=null or $test1 or $test2 or $var3!=null) and $var4!=null){
        $txt = $txt.' AND';
      }

      if($var4!=null){ 
        $txt = $txt.'  exists (SELECT idOeuvre from traductions where oeuvres.idOeuvre=traductions.idOeuvre and LOCATE(:var4,langue))';
      }

      if (($var!=null or $var2!=null or $var2Bis!=null or $test1 or $test2 or $var3!=null or $var4!=null) and ($var5!=null and $var5!='null')){
        $txt = $txt.' AND';
      }

      if (($var5!=null and $var5!='null'))
        $txt = $txt.' exists (SELECT idOeuvre from adaptations where oeuvres.idOeuvre=adaptations.idOeuvre and nature=:var5)';


      $req0 = $this->bd->prepare($txt);
      if ($var!=null){
        $req0->bindValue(':var', $var);
      }

      if ($var2!=null){
        $req0->bindValue(':var2', $var2);
      }

      if ($var2Bis!=null){
        $req0->bindValue(':var2Bis', $var2Bis);
      }

      if ($var3!=null){
        $req0->bindValue(':var3', $var3);
      }

      if ($var4!=null){
        $req0->bindValue(':var4', $var4);
      }

      if ($var5!=null){
        $req0->bindValue(':var5', $var5);
      }

      $txt=$txt.' group by idOeuvre';
      $req0->execute();
      $tabNom = $req0->fetchAll(PDO::FETCH_ASSOC);
      return $tabNom;
    }
    return null;
  }

  
 /***********************************************************************************
 *
 *  QUATRIEME CHAMP
 *
 ***********************************************************************************/
  
  public function getResearchPoet($varTab1, $var1, $var2, $var2Bis, $varTab2, $varTab3, $var3, $var4, $var5, $varTab4, $varTab5, $var6, $varTab6, $var7){ //Fait pour la recherche dans la table ouevres

    $test = count($varTab1)!=0;

    $test2 = count($varTab2)!=0;

    $test3 = count($varTab3)!=0;

    $test4 = count($varTab4)!=0;

    $test5 = count($varTab5)!=0;

    $test6 = count($varTab6)!=0;


    if($test or $var1!=null or $var2!=null or $var2Bis!=null or $test2 or $test3 or $var3 or $var4 or $var5 or $test4 or $test5 or $var6 or $test6 or $var7!='null'){
      $txt = 'SELECT distinct idOeuvre FROM oeuvres WHERE'; 

      if ($test){ //Nom

        $testFirst=0;
        foreach($varTab1 as $c => $v){
          if ($testFirst>=1 and $testFirst<=count($varTab1)){
            $txt = $txt." AND";
          }
          if ($v=='1st'){
            $txt = $txt.' narrationP1=1';
            $testFirst++;
          }
          else if ($v=='3rd'){
            $txt = $txt.' narrationP3=1';
            $testFirst++;
          }
          else if ($v=='multiple'){
            $txt = $txt.' narrationMulti=1';
            $testFirst++;
          }
          else if ($v=='enchassee'){
            $txt = $txt.' narrationEnchassee=1';
            $testFirst++;
          }
      }
    }



    if ($test and $var1!=null)
      $txt = $txt.' AND';

    if ($var1!=null)
      $txt = $txt."exists (SELECT idOeuvre from lieux where oeuvres.idOeuvre=lieux.idOeuvre and LOCATE(:var1,libelle))";


    if (($test or  $var1!=null) and ($var2!=null or $var2Bis!=null))
      $txt = $txt.' AND';

    if($var2!=null or $var2Bis!=null)
      $txt = $txt." exists (SELECT idOeuvre from spaciotemporel where oeuvres.idOeuvre=spaciotemporel.idOeuvre and ";


    if($var2!=null and $var2Bis!=null)
      $txt = $txt." dateDeb>=$var2 and dateFin<=$var2Bis";
    else if ($var2!=null)
      $txt = $txt." dateDeb>=$var2";
    else if ($var2Bis!=null)
      $txt = $txt." dateFin<=$var2Bis";


    if ($test2){ //Nom
      if ($test or $var1!=null or $var2!=null or $var2Bis!=null)
        $txt = $txt.' AND';

      $txt = $txt." exists (SELECT idOeuvre from spaciotemporel where oeuvres.idOeuvre=spaciotemporel.idOeuvre and";

      $testFirst=0;
      foreach($varTab2 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab2)){ 
          $txt = $txt." AND";
        }
        if ($v=='passeLointain'){
          $txt = $txt." ecart='PL'";
          $testFirst++;
        }
        else if($v=='passeProche'){
          $txt = $txt." ecart='PP'"; 
          $testFirst++;
        }
        else if($v=='present'){
          $txt = $txt." ecart='PR'"; 
          $testFirst++;
        }
        else if ($v=='futurProche'){
          $txt = $txt." ecart='FP'"; 
          $testFirst++;
        }
        else if ($v=='futurLointain'){
          $txt = $txt." ecart='FL'"; 
          $testFirst++;
        }
    }
    $txt = $txt.' )';
  }

  if ($test3){ //Nom
    if ($test or $var1!=null or $var2!=null or $var2Bis!=null or $test2)
      $txt = $txt.' AND';

    $txt = $txt." exists (SELECT idOeuvre from poetiquekw where oeuvres.idOeuvre=poetiquekw.idOeuvre and";

    $testFirst=0;
    foreach($varTab3 as $c => $v){
      if ($testFirst>=1 and $testFirst<=count($varTab3)){ 
        $txt = $txt." AND";
      }
      if ($v=='ageOr'){
        $txt = $txt." idMot=47"; 
        $testFirst++;
      }
      else if($v=='decadence'){
        $txt = $txt." idMot=48"; 
        $testFirst++;
      }
      else if($v=='eschatologie'){
        $txt = $txt." idMot=46"; 
        $testFirst++;
      }
      else if ($v=='evolutionnisme'){
        $txt = $txt." idMot=51"; 
        $testFirst++;
      }
      else if ($v=='histoireCyclique'){
        $txt = $txt." idMot=49";
        $testFirst++;
      }
      else if ($v=='progres'){
        $txt = $txt." idMot=224";
        $testFirst++;
      }
  }
  $txt = $txt.' )';
}


  if (($test or $var1!=null or $var2!=null or $var2Bis!=null or $test2) and $var3!=null)
      $txt = $txt.' AND';

  if ($var3!=null){
    $txt = $txt." exists (SELECT idOeuvre from refintertextuelles where oeuvres.idOeuvre=refintertextuelles.idOeuvre and LOCATE(:var3,titre) or LOCATE(:var3,auteur))";
  }

  if(($test or $var1!=null or $var2!=null or $var2Bis!=null or $test2 or $var3) and $var4){
    $txt = $txt.' AND';
  }
  if ($var4!=null){
    $txt = $txt." exists (SELECT idOeuvre from personnages where oeuvres.idOeuvre=personnages.idOeuvre and LOCATE(:var4,discipline))";
  }

  if(($test or $var1!=null or $var2!=null or $var2Bis!=null or $test2 or $var3 or $var4) and $var5){
    $txt = $txt.' AND';
  }
  if ($var5!=null){
    $txt = $txt." exists (SELECT idOeuvre from personnages where oeuvres.idOeuvre=personnages.idOeuvre and LOCATE(:var5,profession))";
  }

  if ($test4){ //REGLER LE PB DU NATURAL JOIN LIEUX
    if ($test or $var1!=null or $var2!=null or $var2Bis!=null or $test2 or $var3!=null or $var4!=null or $var5!=null)
      $txt = $txt.' AND';

    $txt = $txt." exists (SELECT idOeuvre from personnages where oeuvres.idOeuvre=personnages.idOeuvre and";

    $testFirst=0;
    foreach($varTab4 as $c => $v){
      if ($testFirst>=1 and $testFirst<=count($varTab4)){
        $txt = $txt." AND";
      }
      if ($v=='masculin'){
        $txt = $txt." genre='M'"; 
        $testFirst++;
      }
      else if($v=='feminin'){
        $txt = $txt." genre='F'"; 
        $testFirst++;
      }
      else if($v=='indetermine'){
        $txt = $txt." genre=''"; 
        $testFirst++;
      }
    }
  $txt = $txt.' )';
  }



if ($test5){ //REGLER LE PB DU NATURAL JOIN LIEUX
  if ($test or $var1!=null or $var2!=null or $var2Bis!=null or $var3!=null or $test2 or $var4!=null or $var5!=null or $test4)
    $txt = $txt.' AND';

  $txt = $txt." exists (SELECT idOeuvre from personnages where oeuvres.idOeuvre=personnages.idOeuvre and";

  $testFirst=0;
  foreach($varTab5 as $c => $v){
    if ($testFirst>=1 and $testFirst<=count($varTab5)){ 
      $txt = $txt." AND";
    }
    if ($v=='positif'){
      $txt = $txt." valorisation='P'"; 
      $testFirst++;
    }
    else if($v=='negatif'){
      $txt = $txt." valorisation='N'"; 
      $testFirst++;
    }
    else if($v=='problematique'){
      $txt = $txt." valorisation='M'"; 
      $testFirst++;
    }
    else if($v=='neutre'){
      $txt = $txt." valorisation='T'"; 
      $testFirst++;
    }
}
$txt = $txt.' )';
}

  if (($test or $var1!=null or $var2!=null or $var2Bis!=null or $var3!=null or $test2 or $var4!=null or $var5!=null or $test4 or $test5) and $var6!=null)
    $txt = $txt." AND";
  if ($var6!=null)
    $txt = $txt." exists (SELECT idOeuvre from personnages where oeuvres.idOeuvre=personnages.idOeuvre and LOCATE(:var6,caracteristique))";


  if ($test6){ 
    if ($test or $var1!=null or $var2!=null or $var2Bis!=null or $var3!=null or $test2 or $var4!=null or $var5!=null or $test4 or $test5 or $var6!=null)
      $txt = $txt.' AND';

    $txt = $txt." exists (SELECT idOeuvre from personnages where oeuvres.idOeuvre=personnages.idOeuvre and";

    $testFirst=0;
    foreach($varTab6 as $c => $v){
      if ($testFirst>=1 and $testFirst<=count($varTab6)){ 
        $txt = $txt." AND";
      }
      if ($v=='europe'){
        $txt = $txt." alterite='EU'"; 
        $testFirst++;
      }
      else if($v=='extra-europe'){
        $txt = $txt." alterite='EE'"; 
        $testFirst++;
      }
      else if($v=='extra-terrestre'){
        $txt = $txt." alterite='ET'"; 
        $testFirst++;
      }
      else if($v=='creature-artificielle'){
        $txt = $txt." alterite='CA'"; 
        $testFirst++;
      }
      else if($v=='mutante'){
        $txt = $txt." alterite='MU'"; 
        $testFirst++;
      }
      else if($v=='autre'){
        $txt = $txt." alterite='' or alterite='ZZ'"; 
        $testFirst++;
      }
  }
  $txt = $txt.' )';
  }

  if (($test or $var1!=null or $var2!=null or $var2Bis!=null or $var3!=null or $test2 or $var4!=null or $var5!=null or $test4 or $test5 or $var6!=null or $test6) and $var7!='null')
    $txt= $txt.' AND';

  if ($var7!='null')
    $txt = $txt." exists (SELECT idOeuvre from esthetique where oeuvres.idOeuvre=esthetique.idOeuvre and idMot=:var7)";


      $req0 = $this->bd->prepare($txt);

      if ($var1!=null){
        $req0->bindValue(':var1', $var1);
      }

      if ($var2!=null){
        $req0->bindValue(':var2', $var2);
      }

      if ($var2Bis!=null){
        $req0->bindValue(':var2Bis', $var2Bis);
      }

      if (($var3!=null) and ($test3 or $test4)){
        $req0->bindValue(':var3', $var3);
      }

      if ($var4!=null){
        $req0->bindValue(':var4', $var4);
      }

      if ($var5!=null){
        $req0->bindValue(':var5', $var5);
      }

      if ($var6!=null){
        $req0->bindValue(':var6', $var6);
      }

      if ($var7!='null'){
        $req0->bindValue(':var6', $var7);
      }

      $txt=$txt.' group by idOeuvre';

      $req0->execute();
      $tabNom = $req0->fetchAll(PDO::FETCH_ASSOC);
      return $tabNom;
    }
    return null;
  }
  
 /***********************************************************************************
 *
 *  CINQUIEME CHAMP
 *
 ***********************************************************************************/

  public function getResearchScience($varTab1, $varTab2, $varTab3, $varTab4, $varTab5, $varTabAlt, $varTab6, $varTab7, $varTab8,$varTab9,$varTab10,$varTab11, $var1, $var2, $varTab12, $varTab13, $varTab14, $varTab15, $varTab16, $var3, $var4, $var5, $var6, $varTabAlt2, $varTabAlt3){ //Fait pour la recherche dans la table ouevres

    $test1 = count($varTab1)!=0;

    $test2 = count($varTab2)!=0;

    $test3 = count($varTab3)!=0;

    $test4 = count($varTab4)!=0;

    $test5 = count($varTab5)!=0;

    $testAlt = count($varTabAlt)!=0;

    $test6 = count($varTab6)!=0;

    $test7 = count($varTab7)!=0;

    $test8 = count($varTab8)!=0;

    $test9 = count($varTab9)!=0;

    $test10 = count($varTab10)!=0;

    $test11 = count($varTab11)!=0;

    $test12 = count($varTab12)!=0;

    $test13 = count($varTab13)!=0;

    $test14 = count($varTab14)!=0;

    $test15 = count($varTab15)!=0;

    $test16 = count($varTab16)!=0;

    $testAlt2 = count($varTabAlt2)!=0;



    if($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or (strlen($var1)>0) or (strlen($var2)>0) or $test12 or $test13 or $test14 or ($var3!='null' and $var3!=null) or $test15 or  $test16 or $var3!='null' or $var4!=null or ($var5!='null' and $var5!=null) or $var6!='null' or $testAlt2 or $varTab3!=null){
      $txt = 'SELECT distinct idOeuvre FROM oeuvres WHERE'; 

      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11)
        $txt = $txt." exists (SELECT idOeuvre from representations where oeuvres.idOeuvre=representations.idOeuvre and";
      if ($test1){ //Nom
        $testFirst=0;
        foreach($varTab1 as $c => $v){
          if ($testFirst>=1 and $testFirst<=count($varTab1)){
            $txt = $txt." AND";
          }
          if ($v=='agriculture'){
            $txt = $txt."  idMot = 90"; 
            $testFirst++;
          }
          else if ($v=='veterinaire'){
            $txt = $txt." idMot = 91"; 
            $testFirst++;
          }
          else if ($v=='diet'){
            $txt = $txt." idMot = 92"; 
            $testFirst++;
          }
        }
      }

    if ($test1 and $test2)
      $txt = $txt.' AND';

    if ($test2){
      $testFirst=0;
      foreach($varTab2 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab2)){
          $txt = $txt." AND";
        }
        if ($v=='chimieAnalytique'){
          $txt = $txt." idMot = 99"; 
          $testFirst++;
        }
        else if ($v=='chimieIndustrielle'){
          $txt = $txt." idMot = 100"; 
          $testFirst++;
        }
        else if ($v=='chimieOrganique'){
          $txt = $txt." idMot = 101"; 
          $testFirst++;
        }
      }
    }

    if ($test3){
      if ($test1 or $test2)
        $txt = $txt.' AND';

      $testFirst=0;
      foreach($varTab3 as $c => $v){

        if ($testFirst>=1 and $testFirst<=count($varTab3)){
          $txt = $txt." AND";
        }
        if ($v=='atomique'){
          $txt = $txt." idMot = 107"; 
          $testFirst++;
        }
        else if ($v=='electricite'){
          $txt = $txt." idMot = 104"; 
          $testFirst++;
        }
        else if ($v=='eolienne'){
          $txt = $txt." idMot = 199"; 
          $testFirst++;
        }
        else if ($v=='ether'){
          $txt = $txt." idMot = 106"; 
          $testFirst++;
        }
        else if ($v=='geothermique'){
          $txt = $txt." idMot = 197";
          $testFirst++;
        }
        else if ($v=='hydraulique'){
          $txt = $txt." idMot = 198";
          $testFirst++;
        }
        else if ($v=='magnetisme'){
          $txt = $txt." idMot = 105";
          $testFirst++;
        }
        else if ($v=='thermodynamique'){
          $txt = $txt." idMot = 103";
          $testFirst++;
        }
      }
    }



    if ($test4){
      if ($test1 or $test2 or $test3)
        $txt = $txt.' AND';

      $testFirst=0;
      foreach($varTab4 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab4)){
          $txt = $txt." AND";
        }
        if ($v=='eclairage'){
          $txt = $txt." idMot = 109";
          $testFirst++;
        }
        else if ($v=='steampunk'){
          $txt = $txt." idMot = 110";
          $testFirst++;
        }
        else if ($v=='photo'){
          $txt = $txt." idMot = 111";
          $testFirst++;
        }
        else if ($v=='tele'){
          $txt = $txt." idMot = 112";
          $testFirst++;
        }
      }
    }


    if ($test5){
      if ($test1 or $test2 or $test3 or $test4)
        $txt = $txt.' AND';

      $testFirst=0;
      foreach($varTab5 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab5)){
          $txt = $txt." AND";
        }
        if ($v=='anatomie'){
          $txt = $txt." idMot = 115"; 
          $testFirst++;
        }
        else if ($v=='chirurgie'){
          $txt = $txt." idMot = 116"; 
          $testFirst++;
        }
        else if ($v=='histologie'){
          $txt = $txt." idMot = 117"; 
          $testFirst++;
        }
        else if ($v=='homeopathie'){
          $txt = $txt." idMot = 118"; 
          $testFirst++;
        }
        else if ($v=='hygiene'){
          $txt = $txt." idMot = 119"; 
          $testFirst++;
        }
        else if ($v=='pathologie'){
          $txt = $txt." idMot = 120"; 
          $testFirst++;
        }
        else if ($v=='physiologie'){
          $txt = $txt." idMot = 122"; 
          $testFirst++;
        }
        else if ($v=='psychologie'){
          $txt = $txt." idMot = 176"; 
          $testFirst++;
        }
        else if ($v=='therapeute'){
          $txt = $txt." idMot = 121";
          $testFirst++;
        }
      }
    }


    if ($testAlt){

      if ($test1 or $test2 or $test3 or $test4 or $test5)
        $txt = $txt.' AND';
      $testFirst=0;
      foreach($varTabAlt as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTabAlt)){
          $txt = $txt." AND";
        }
        if ($v=='paleon'){
          $txt = $txt." idMot = 123"; 
          $testFirst++;
        }
      }
    }

    if ($test6){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt)
        $txt = $txt.' AND';

      $testFirst=0;
      foreach($varTab6 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab6)){
          $txt = $txt." AND";
        }
        if ($v=='acoustique'){
          $txt = $txt." idMot = 125";
          $testFirst++;
        }
        else if ($v=='electriciteMagn'){
          $txt = $txt." idMot = 126";
          $testFirst++;
        }
        else if ($v=='mecanique'){
          $txt = $txt." idMot = 127";
          $testFirst++;
        }
        else if ($v=='optique'){
          $txt = $txt." idMot = 128";
          $testFirst++;
        }
        else if ($v=='physiqueAtome'){
          $txt = $txt." idMot = 129";
          $testFirst++;
        }
        else if ($v=='thermodynamique'){
          $txt = $txt." idMot = 130";
          $testFirst++;
        }
      }
    }


    if ($test7){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6)
        $txt = $txt.' AND';
      $testFirst=0;
      foreach($varTab7 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab7)){
          $txt = $txt." AND";
        }
        if ($v=='bacteriologie'){
          $txt = $txt."idMot = 190";
          $testFirst++;
        }
        else if ($v=='genetique'){
          $txt = $txt." idMot = 132";
          $testFirst++;
        }
        else if ($v=='microbiologie'){
          $txt = $txt." idMot = 134";
          $testFirst++;
        }
      }
    }



    if ($test8){

          if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7)
            $txt = $txt.' AND';
      $testFirst=0;
      foreach($varTab8 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab8)){
          $txt = $txt." AND";
        }
        if ($v=='botanique'){
          $txt = $txt." idMot = 136";
          $testFirst++;
        }
        else if ($v=='entomologie'){
          $txt = $txt." idMot = 137";
          $testFirst++;
        }
        else if ($v=='mycologie'){
          $txt = $txt." idMot = 138";
          $testFirst++;
        }
        else if ($v=='zoologie'){
          $txt = $txt." idMot = 139";
          $testFirst++;
        }
      }
    }




    if ($test9){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8)
        $txt = $txt.' AND';
      $testFirst=0;
      foreach($varTab9 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab9)){
          $txt = $txt." AND";
        }
        if ($v=='catastrophe'){
          $txt = $txt." idMot = 195";
          $testFirst++;
        }
        else if ($v=='ethnologie'){
          $txt = $txt." idMot = 141";
          $testFirst++;
        }
        else if ($v=='geographie'){
          $txt = $txt." idMot = 143";
          $testFirst++;
        }
        else if ($v=='geologie'){
          $txt = $txt." idMot = 142";
          $testFirst++;
        }
        else if ($v=='meteorologie'){
          $txt = $txt." idMot = 144";
          $testFirst++;
        }
        else if ($v=='oceanologie'){
          $txt = $txt." idMot = 145";
          $testFirst++;
        }
      }
    }



    if ($test10){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9)
        $txt = $txt.' AND';

      $testFirst=0;
      foreach($varTab10 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab10)){
          $txt = $txt." AND";
        }
        if ($v=='mondeSavant'){
          $txt = $txt." idMot = 147";
          $testFirst++;
        }
        else if ($v=='spectacles'){
          $txt = $txt." idMot = 148";
          $testFirst++;
        }
      }
    }


    if ($test11){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10)
        $txt = $txt.' AND';
      $testFirst=0;
      foreach($varTab11 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab11)){
          $txt = $txt." AND";
        }
        if ($v=='aerostats'){
          $txt = $txt." idMot = 150";
          $testFirst++;
        }
        else if ($v=='transportMaritime'){
          $txt = $txt." idMot = 152";
          $testFirst++;
        }
        else if ($v=='transportSouterrain'){
          $txt = $txt." idMot = 154"; 
          $testFirst++;
        }
        else if ($v=='transportTerrestre'){
          $txt = $txt." idMot = 151"; 
          $testFirst++;
        }
      }
    }

    if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11)
      $txt = $txt.")";


    if (($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11) and (strlen($var1)>0))
      $txt = $txt.' AND';
    if((strlen($var1)>0)){
      $txt = $txt.' exists (SELECT idOeuvre from refaureel where oeuvres.idOeuvre=refaureel.idOeuvre and LOCATE(:var1,theorie) or LOCATE(:var1,citation))';
    }

    if (($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or (strlen($var1)>0)) and (strlen($var2)>0))
      $txt = $txt.' AND';
    if((strlen($var2)>0)){
      $txt = $txt.' exists (SELECT idOeuvre from refaureel where oeuvres.idOeuvre=refaureel.idOeuvre and LOCATE(:var2,personnalite)) or LOCATE(:var2,citation)';
    }


    if ($test12){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null)
        $txt = $txt.' AND';

      $txt = $txt." exists (SELECT idOeuvre from refaureel where oeuvres.idOeuvre=refaureel.idOeuvre and";
      $testFirst=0;
      foreach($varTab12 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab12)){
          $txt = $txt." AND";
        }
        if ($v=='scienceVie'){
          $txt = $txt." LOCATE('VIE',discipline)";
          $testFirst++;
        }
        else if ($v=='scienceMedicale'){
          $txt = $txt." LOCATE('MED',discipline)";
          $testFirst++;
        }
        else if ($v=='scienceTerre'){
          $txt = $txt." LOCATE('TER',discipline)";
          $testFirst++;
        }
        else if ($v=='sciencePhysique'){
          $txt = $txt." LOCATE('PCM',discipline)";
          $testFirst++;
        }
        else if ($v=='ingenieurie'){
          $txt = $txt." LOCATE('ING',discipline)";
          $testFirst++;
        }
        else if ($v=='autree'){
          $txt = $txt." LOCATE('AUT',discipline)";
          $testFirst++;
        }
      }
      $txt = $txt.")";
    }

    if ($test13){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12)
        $txt = $txt.' AND';

      $txt = $txt." exists (SELECT idOeuvre from refaureel where oeuvres.idOeuvre=refaureel.idOeuvre and";
      $testFirst=0;
      foreach($varTab13 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab13)){
          $txt = $txt." AND";
        }
        if ($v=='serieux'){
          $txt = $txt." LOCATE('SER',modalite)";
          $testFirst++;
        }
        else if ($v=='satire'){
          $txt = $txt." LOCATE('SAT',modalite)";
          $testFirst++;
        }
        else if ($v=='hommage'){
          $txt = $txt." LOCATE('HOM',modalite)";
          $testFirst++;
        }
        else if ($v=='refutation'){
          $txt = $txt." LOCATE('REF',modalite)";
          $testFirst++;
        }
      }
      $txt = $txt.")";
    }


    if ($test14){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12 or $test13)
        $txt = $txt.' AND';

      $testFirst=0;
      foreach($varTab14 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab14)){
          $txt = $txt." AND";
        }
        if ($v=='presentTemp'){
          $txt = $txt." socrepresentations = 'P'";
          $testFirst++;
        }
        else if ($v=='absentTemp'){
          $txt = $txt." socrepresentations = 'A'";
          $testFirst++;
        }
        else if ($v=='plusieursTemp'){
          $txt = $txt." socrepresentations = 'M'";
          $testFirst++;
        }
      }
      $txt = $txt.")";
    }



    if ($test15){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12 or $test13 or $test14)
        $txt = $txt.' AND';
      $txt = $txt." exists (SELECT idOeuvre from societesimg where oeuvres.idOeuvre=societesimg.idOeuvre and";
      $testFirst=0;
      foreach($varTab15 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab15)){
          $txt = $txt." AND";
        }
        if ($v=='fortDegre'){
          $txt = $txt." LOCATE('F',degreTechno)";
          $testFirst++;
        }
        else if ($v=='neutreDegre'){
          $txt = $txt." LOCATE('N',degreTechno)";
          $testFirst++;
        }
        else if ($v=='faibleDegre'){
          $txt = $txt." LOCATE('B',degreTechno)";
          $testFirst++;
        }
        else if ($v=='indetermiteDegre'){
          $txt = $txt." LOCATE('I',degreTechno)";
          $testFirst++;
        }
      }
      $txt = $txt.")";
    }



    if ($test16){
      if ($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12 or $test13 or $test14 or $test13 or $test15)
        $txt = $txt.' AND';
      $txt = $txt." exists (SELECT idOeuvre from societesimg where oeuvres.idOeuvre=societesimg.idOeuvre and";
      $testFirst=0;
      foreach($varTab16 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTab16)){
          $txt = $txt." AND";
        }
        if ($v=='positifValeur'){
          $txt = $txt." LOCATE('P',valeur)";
          $testFirst++;
        }
        else if ($v=='negatifValeur'){
          $txt = $txt." LOCATE('N',valeur)";
          $testFirst++;
        }
        else if ($v=='neutreValeur'){
          $txt = $txt." LOCATE('T',valeur)";
          $testFirst++;
        }
        else if ($v=='ambivalenteValeur'){
          $txt = $txt." LOCATE('A',valeur)";
          $testFirst++;
        }
        else if ($v=='indetermineValeur'){
          $txt = $txt." LOCATE('I',valeur)";
          $testFirst++;
        }
      }
      $txt = $txt.")";
    }


    if (($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12 or $test13 or $test14 or $test15 or $test16) and ($var3!='null' and $var3!=null))
      $txt = $txt.' AND';
    if ($var3!='null'){
      $txt = $txt.' exists (SELECT idOeuvre from representations where oeuvres.idOeuvre=representations.idOeuvre and idMot=:var3)';
    }

    if (($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12 or $test13 or $test14 or $test15 or $test16 or ($var3!='null' and $var3!=null)) and $var4!=null)
      $txt = $txt.' AND';
    if ($var4!=null){
      $txt = $txt.' exists (SELECT idOeuvre from representations where oeuvres.idOeuvre=representations.idOeuvre and idMot=:var4)';
    }

    if (($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12 or $test13 or $test14 or $test15 or $test16 or($var3!='null' and $var3!=null) or $var4!=null) and ($var5!='null' and $var5!=null))
      $txt = $txt.' AND';
    if ($var5!='null' and $var5!=null){
      $txt = $txt.' exists (SELECT idOeuvre from representations where oeuvres.idOeuvre=representations.idOeuvre and idMot=:var5)';
    }

    if (($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12 or $test13 or $test14 or $test15 or $test16 or ($var3!='null' and $var3!=null) or $var4!=null or $var5!='null') and $var6!='null')
      $txt = $txt.' AND';
    if ($var6!='null'){
      $txt = $txt.' exists (SELECT idOeuvre from representations where oeuvres.idOeuvre=representations.idOeuvre and idMot=:var6)';
    }


    if ($testAlt2){
      if (($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12 or $test13 or $test14 or $test15 or $test16 or ($var3!='null' and $var3!=null) or $var4!=null or $var5!='null' or $var6!='null'))
        $txt = $txt.' AND';
      $txt = $txt." exists (SELECT idOeuvre from representations where oeuvres.idOeuvre=representations.idOeuvre and";
      $testFirst=0;
      foreach($varTabAlt2 as $c => $v){
        if ($testFirst>=1 and $testFirst<=count($varTabAlt2)){
          $txt = $txt." AND";
        }
        if ($v=='anthropologie'){
          $txt = $txt." idMot =93";
          $testFirst++;
        }
        else if ($v=='archeologie'){
          $txt = $txt." idMot =94";
          $testFirst++;
        }
        else if ($v=='armement'){
          $txt = $txt." idMot =95";
          $testFirst++;
        }
        else if ($v=='construction'){
          $txt = $txt." idMot =96";
          $testFirst++;
        }
        else if ($v=='astronomie'){
          $txt = $txt." idMot =97";
          $testFirst++;
        }
      }
      $txt = $txt.")";
    }

    if (($test1 or $test2 or $test3 or $test4 or $test5 or $testAlt or $test6 or $test7 or $test8 or $test9 or $test10 or $test11 or $var1!=null or $var2!=null or $test12 or $test13 or $test14 or $test15 or $test16 or ($var3!='null' and $var3!=null) or $var4!=null or $var5!='null' or $var6!='null' or $testAlt2) and $varTabAlt3!=null)
      $txt = $txt.' AND';

    if ($varTabAlt3!=null){
      $txt = $txt." exists (SELECT idOeuvre from representations where oeuvres.idOeuvre=representations.idOeuvre and idMot=113)";
    }







    $req0 = $this->bd->prepare($txt);

    if ($var1!=null){
      $req0->bindValue(':var1', $var1);
    }

    if ($var2!=null){
      $req0->bindValue(':var2', $var2);
    }

    if ($var3!='null'){
      $req0->bindValue(':var3', $var3);
    }

    if ($var4!=null){
      $req0->bindValue(':var4', $var4);
    }

    if ($var5!='null'){
      $req0->bindValue(':var5', $var5);
    }

    if ($var6!='null'){
      $req0->bindValue(':var6', $var6);
    }

    $txt=$txt.' group by idOeuvre';

  //echo $txt;

    $req0->execute();
    $tabNom = $req0->fetchAll(PDO::FETCH_ASSOC);
    return $tabNom;
  }
  return null;
}

/***********************************************************************************
 *
 *  DIVERS FONCTIONS POUR RECUPERER LES INFORMATIONS UTILES POUR LES GRAPHES VOULUS
 *
 ***********************************************************************************/

public function infoBarChart($data, $sub_sql, $conn){
  $sql = 
    'SELECT anneePE as x, count(*) as y
    from oeuvres
    where idOeuvre in (' 
    . $sub_sql 
    . ')
    group by anneePE
    order by anneePE asc;';

    //print $sql;
    $req = $this->bd->prepare($sql);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

public function infoBubbleChart($data, $sub_sql, $conn){
  $sql = 
    'SELECT anneePE as x, count(*) as y
    from oeuvres
    where idOeuvre in (' 
    . $sub_sql 
    . ')
    group by anneePE
    order by anneePE asc;';

    //print $sql;
    $req = $this->bd->prepare($sql);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

public function infoNetwork($ID){
  $txt = 'SELECT titrePE,auteurCompare FROM liensautresauteurs natural join oeuvres WHERE idOeuvre=:var';
  $req0 = $this->bd->prepare($txt);
  $req0->bindValue(':var', $ID);
  $req0->execute();
  $tabNom = $req0->fetchAll(PDO::FETCH_ASSOC);
  return $tabNom;
  }
}
?>
