<?php
  require('connexionV2.php');
  $conn = Connexion::getBD();

      $check1=null;
      $check2=null;
      $check3=null;
      $check4=null;
      $tabCheckedPresentation=array();
//Première partie pour la Presentation

      if (isset($_POST['titre']) and $_POST['titre']!=null)
        $check1 = $_POST['titre'];

      if (isset($_POST['name']) and $_POST['name']!=null)
        $check2 = $_POST['name'];

      if (isset($_POST['dateTot']) and $_POST['dateTot']!=null)
        $check3 = $_POST['dateTot'];

      if (isset($_POST['dateTard']) and $_POST['dateTard']!=null)
        $check4 = $_POST['dateTard'];

      if(!empty($_POST['boxPr'])){
         foreach ($_POST['boxPr'] as $c => $v){
          if ($v!=null or $v!=0 or $v!=''){
          $tabCheckedPresentation[]=$v;
          }
        }
      }

      $tab_1 = $conn->getResearch($check1,$check2,$check3,$check4,$tabCheckedPresentation);

      //Deuxième partie pour le Materiel
            $check1G=null;
            $check2G=null;
            $check3G=null;
            $check5G=null;
            $check6G=null;
            $check7G=null;
            $tabCheckedG=array();
      //Première partie pour la Presentation
            if(isset($_POST['designation']) and $_POST['designation']!=null)
              $check1G = $_POST['designation'];

            if (isset($_POST['AnneeDebut']) and $_POST['AnneeDebut']!=null)
              $check2G = $_POST['AnneeDebut'];

            if (isset($_POST['AnneeFin']) and $_POST['AnneeFin']!=null)
              $check3G = $_POST['AnneeFin'];


            if(!empty($_POST['boxFiltre'])){
               foreach ($_POST['boxFiltre'] as $c => $v){
                if ($v!=null or $v!=0 or $v!=''){
                  $tabCheckedG[]=$v;
                }
              }
            }


            if (isset($_POST['auteurComp']) and $_POST['auteurComp']!=null)
              $check5G = $_POST['auteurComp'];


            if (isset($_POST['dateADebut']) and $_POST['dateADebut']!=null)
              $check6G = $_POST['dateADebut'];

            if (isset($_POST['dateAFin']) and $_POST['dateAFin']!=null)
              $check7G = $_POST['dateAFin'];



            $tab_2 = $conn->getResearchGenre($check1G,$check2G,$check3G,$tabCheckedG,$check5G,$check6G,$check7G);



//Deuxième partie pour le Materiel
      $check1M=null;
      $check2M=null;
      $check2MBis=null;
      $check3M=null;
      $check4M=null;
      $check5M=null;
      $tabCheckedM=array();
      $tabChecked2M=array();
//Première partie pour la Presentation
      if(isset($_POST['support']) and $_POST['support']!=null)
        $check1M = $_POST['support'];

      if (isset($_POST['yearParutionDebut']) and $_POST['yearParutionDebut']!=null)
        $check2M = $_POST['yearParutionDebut'];

      if (isset($_POST['yearParutionFin']) and $_POST['yearParutionFin']!=null)
        $check2MBis = $_POST['yearParutionFin'];

      if(!empty($_POST['boxFil'])){
         foreach ($_POST['boxFil'] as $c => $v){
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedM[]=$v;
          }
        }
      }

      if(!empty($_POST['boxFil'])){
         foreach ($_POST['boxFil'] as $c => $v){
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedM[]=$v;
          }
        }
      }

      if(!empty($_POST['boxC'])){
         foreach ($_POST['boxC'] as $c => $v){
          if ($v!=null or $v!=0 or $v!=''){
            $tabChecked2M []=$v;
          }
        }
      }

      if (isset($_POST['nomIllus']) and $_POST['nomIllus']!=null)
        $check3M = $_POST['nomIllus'];


      if (isset($_POST['langueTrad']) and $_POST['langueTrad']!=null)
        $check4M = $_POST['langueTrad'];


      if (isset($_POST['natureAdaptation']) and $_POST['natureAdaptation']!=null)
        $check5M = $_POST['natureAdaptation'];


      $tab_3 = $conn->getResearchMaterial($check1M,$check2M,$check2MBis,$tabCheckedM,$tabChecked2M,$check3M,$check4M,$check5M);


      $check1P=null;
      $check2P=null;
      $check2PBis=null;
      $check3P=null;
      $check4P=null;
      $check5P=null;
      $tabCheckedP=array();
      $tabCheckedP2=array();
      $tabCheckedP3=array();
      $tabCheckedP4=array();
      $tabCheckedP5=array();
      $tabCheckedP6=array();
      $check6P=null;

//Première partie pour la Presentation

      if(!empty($_POST['boxNaration'])){
        foreach ($_POST['boxNaration'] as $c => $v){
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedP[]=$v;
          }
        }
      }

      //print_r($tabCheckedPoete1);

      if(isset($_POST['cadreSpatial']) and $_POST['cadreSpatial']!=null)
        $check1P = $_POST['cadreSpatial'];

      if (isset($_POST['dateHistoireDebut']) and $_POST['dateHistoireDebut']!=null)
        $check2P = $_POST['dateHistoireDebut'];

      if (isset($_POST['dateHistoireFin']) and $_POST['dateHistoireFin']!=null)
        $check2PBis = $_POST['dateHistoireFin'];


        if(!empty($_POST['boxNaration2'])){
          foreach ($_POST['boxNaration2'] as $c => $v){
            if ($v!=null or $v!=0 or $v!=''){
              $tabCheckedP2[]=$v;
            }
          }
        }

        if(!empty($_POST['boxNaration3'])){
          foreach ($_POST['boxNaration3'] as $c => $v){
            if ($v!=null or $v!=0 or $v!=''){
              $tabCheckedP3[]=$v;
            }
          }
        }


      if (isset($_POST['referencesInter']) and $_POST['referencesInter']!=null and (strlen($_POST['referencesInter'])>0))
        $check3P = $_POST['referencesInter'];

        if (isset($_POST['persoScientifique']) and $_POST['persoScientifique']!=null)
          $check4P = $_POST['persoScientifique'];

      if (isset($_POST['profession']) and $_POST['profession']!=null)
        $check5P = $_POST['profession'];


      if(!empty($_POST['boxNaration4'])){
        foreach ($_POST['boxNaration4'] as $c => $v){
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedP4[]=$v;
          }
        }
      }

      if(!empty($_POST['boxNaration5'])){
        foreach ($_POST['boxNaration5'] as $c => $v){
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedP5[]=$v;
          }
        }
      }

      if (isset($_POST['caracteristiques']) and $_POST['caracteristiques']!=null)
        $check6P = $_POST['caracteristiques'];

      if(!empty($_POST['boxNaration6'])){
        foreach ($_POST['boxNaration6'] as $c => $v){
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedP6[]=$v;
          }
        }
      }


      if (isset($_POST['selectPoet']) and $_POST['selectPoet']!=null)
        $check7P = $_POST['selectPoet'];
 //FAIRE AUSSI LE DERNIER !!!!!

      $tab_4 = $conn->getResearchPoet($tabCheckedP, $check1P, $check2P,$check2PBis,$tabCheckedP2,$tabCheckedP3,$check3P,$check4P,$check5P,$tabCheckedP4,$tabCheckedP5,$check6P,$tabCheckedP6,$check7P);










      $tabCheckedS=array();
      $tabCheckedS2=array();
      $tabCheckedS3=array();
      $tabCheckedS4=array();
      $tabCheckedS5=array();
      $tabCheckedSAlt=array();
      $tabCheckedS6=array();
      $tabCheckedS7=array();
      $tabCheckedS8=array();
      $tabCheckedS9=array();
      $tabCheckedS10=array();
      $check1S=null;
      $check2S=null;
      $tabCheckedS11=array();
      $tabCheckedS12=array();
      $tabCheckedS13=array();
      $tabCheckedS14=array();
      $tabCheckedS15=array();
      $tabCheckedS16=array();
      $tabCheckedSAlt2=array();
      $tabCheckedSAlt3=null;
      $check3S=null;

      $check4S=null;
      $check5S=null;
      $check6S=null;
//Première partie pour la Presentation

      if(!empty($_POST['boxScience'])){
         foreach ($_POST['boxScience'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience1'])){
         foreach ($_POST['boxScience1'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS2[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience2'])){
         foreach ($_POST['boxScience2'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS3[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience3'])){
         foreach ($_POST['boxScience3'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS4[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience4'])){
         foreach ($_POST['boxScience4'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS5[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScienceAlt'])){
         foreach ($_POST['boxScienceAlt'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedSAlt[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience5'])){
         foreach ($_POST['boxScience5'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS6[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience6'])){
         foreach ($_POST['boxScience6'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS7[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience7'])){
         foreach ($_POST['boxScience7'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS8[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience8'])){
         foreach ($_POST['boxScience8'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS9[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience9'])){
         foreach ($_POST['boxScience9'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS10[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience10'])){
         foreach ($_POST['boxScience10'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS11[]=$v;
          }
        }
      }

      if (isset($_POST['theorie']) and $_POST['theorie']!=null)
        $check1S = $_POST['theorie'];

      if (isset($_POST['personaliteScientifique']) and $_POST['personaliteScientifique']!=null)
        $check2S = $_POST['personaliteScientifique'];

      if(!empty($_POST['boxScience11'])){
          foreach ($_POST['boxScience11'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS12[]=$v;
          }
        }
      }

      if(isset($_POST['boxScience12'])){
          foreach ($_POST['boxScience12'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS13[]=$v;
          }
        }
      }



      if (isset($_POST['termeDescription']) and $_POST['termeDescription']!=null)
        $check4S = $_POST['termeDescription'];

      if (isset($_POST['inventionsTechniques']) and $_POST['inventionsTechniques']!=null)
        $check5S = $_POST['inventionsTechniques'];

      if (isset($_POST['voyages']) and $_POST['voyages']!=null)
        $check6S = $_POST['voyages'];


      if(!empty($_POST['boxScience13'])){
          foreach ($_POST['boxScience13'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS14[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience14'])){
          foreach ($_POST['boxScience14'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS15[]=$v;
          }
        }
      }

      if(!empty($_POST['boxScience15'])){
          foreach ($_POST['boxScience15'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedS16[]=$v;
          }
        }
      }


      if (isset($_POST['selectSoc']) and $_POST['selectSoc']!=null)
        $check3S = $_POST['selectSoc'];

      if(!empty($_POST['boxScienceAlt2'])){
          foreach ($_POST['boxScienceAlt2'] as $c => $v){ //A voir ce qu'il faut mettre
          if ($v!=null or $v!=0 or $v!=''){
            $tabCheckedSAlt2[]=$v;
          }
        }
      }

      if (isset($_POST['boxScienceAlt3']) and $_POST['boxScienceAlt3']!=null and !empty($_POST['boxScienceAlt3']))
        $tabCheckedSAlt3= $_POST['boxScienceAlt3'];


      $tab_5 = $conn->getResearchScience($tabCheckedS,$tabCheckedS2,$tabCheckedS3,$tabCheckedS4,$tabCheckedS5,$tabCheckedSAlt,$tabCheckedS6,$tabCheckedS7,$tabCheckedS8,$tabCheckedS9,$tabCheckedS10,$tabCheckedS11, $check1S,$check2S,$tabCheckedS12,$tabCheckedS13,$tabCheckedS14,$tabCheckedS15,$tabCheckedS16,$check3S,$check4S,$check5S,$check6S,$tabCheckedSAlt2,$tabCheckedSAlt3);


      if ($tab_1==null)
        $tab_1 = array();

      if ($tab_2==null)
        $tab_2 = array();

      if ($tab_3==null)
        $tab_3 = array();

      if ($tab_4==null)
        $tab_4 = array();

      if ($tab_5==null)
        $tab_5 = array();

      //print_r($tab_1);

      $tab_list = array($tab_1,$tab_2,$tab_3,$tab_4,$tab_5);
      $tab_all = array();
      $res = array();

      foreach($tab_list as $c => $v){
        $res = array_merge($res, $v);
      }
      
      $res = array_values($res);
      echo json_encode($res);

?>