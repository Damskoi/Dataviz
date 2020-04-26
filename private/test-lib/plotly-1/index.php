<?php
	require_once '../../../Model.php';
	$model = Model::get_model();
?>
<html>
    <head>
        <title>Test Plotly</title>
        <meta charset="utf-8"/>
</head>
<body>
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
  <div id="container" style="max-width: 1000px; height: 600px; margin: 2em auto"></div>
  <script type="module">
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

  var trace1 = {
    type: "scatter",
    mode: "markers",
    x: data.map(d => d.annee),
    y: data.map(d => d.nombre),
    marker: {
      color: 'rgba(165, 196, 50, 0.5)',
      line: {
        color: 'rgba(165, 196, 50, 1)',
        width: 1,
      },
      symbol: 'circle',
      size:  data.map(d => d.nombre) ,
    }
  };

var donnees = [trace1];

var layout = {
  title: 'Evolution du nombre de publications',
  showlegend: false,
};

Plotly.newPlot('container', donnees, layout);

  </script>
</body>
</html>