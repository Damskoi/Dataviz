<?php
	require_once '../../../Model.php';
	$model = Model::get_model();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://d3js.org/d3.v3.js"></script>
	<script src='uvcharts.min.js'></script>
	<title>uvcharts</title>
</head>
<body>

	<?php 
	//	 echo json_encode($sampleArray);


		$nbouvre= $model->getNbOeuvre();

		$anneeMinMax = $model->getNbAnnee();
		$anneeMin = $anneeMinMax['dateMin'];
		$anneeMax = explode('-', $anneeMinMax['dateMax']);
		$anneeMax = $anneeMax[2];

		$tableauDonnee= array(); $i=0;
		$anneeMin = intval($anneeMin); // Transformer les valeurs en nombres
		$anneeMax = intval($anneeMax);
		for($annee= $anneeMin; $annee< $anneeMax; $annee+=1){
			$nbPublication= $model->getNbPublicationsPeriodes($annee, $annee+1);
			$nbPublication = intval($nbPublication); // Transformer en int
			// Tableau imbriqué
			$tableauDonnee[] = ["name" => $annee, "value" => $nbPublication];
		}

		$nbDateNull= $model->getNbDateNull();
		?>
		<script type="module">
import graph from "./graph.js";
var data = <?php echo json_encode($tableauDonnee) . ";"; ?>
graph(data);
		</script>
	<div id="uv-div" style="position: relative">
    </div>
</body>
</html>
