<?php
	require_once '../../../Model.php';
	$model = Model::get_model();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>chart.js</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <style>
        li { font-size:2rem }
    </style>
</head>
<body>
    <canvas id="barChart" width="1000" height="500"></canvas> <!-- chart.js utilise un canvas pour dessiner. -->
    <canvas id="lineChart" width="1000" height="500"></canvas> <!-- chart.js utilise un canvas pour dessiner. -->
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
            $tableauDonnee[] = ["annee" => strval($annee) . "-01-01T00:00:00.000Z", // Transformer en string, et mettre en format ISO
                                "nombre" => $nbPublication];
        }
        ?>
        const data = <?php echo json_encode($tableauDonnee) . ";"; ?>
    </script>
    <script src="graph.js"></script> <!-- Notre code -->
</body>
</html>