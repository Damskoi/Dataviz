<?php
	require_once '../../../Model.php';
	$model = Model::get_model();
?>
<html>
<head>
    <title>highcharts</title>
    <meta charset="utf-8">
</head>
<body>
  <script src="https://code.highcharts.com/highcharts.src.js"></script>
  <div id="container" style="max-width: 800px; height: 400px; margin: 1em auto"></div>
  <script> // Injection du dataset en PHP
      <?php
      $anneeMinMax = $model->getNbAnnee();
      $anneeMin = $anneeMinMax['dateMin'];
      $anneeMax = explode('-', $anneeMinMax['dateMax']);
      $anneeMax = $anneeMax[2];
      $tableauDonnee= array();
      for($annee= $anneeMin; $annee< $anneeMax; $annee+=1){
          $nbPublication= $model->getNbPublicationsPeriodes($annee, $annee+1);
          $nbPublication = intval($nbPublication); // Transformer en int
          $tableauDonnee[] = ["annee" => strval($annee),
                              "nombre" => $nbPublication];
      }
      ?>
      const data = <?php echo json_encode($tableauDonnee) . ";"; ?>
  </script>
  <script src="graph.js"></script>
</body>
</html>
