<?php
	require_once 'Model.php'; 
	$model = Model::get_model();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://d3js.org/d3.v5.js"></script>
	<title>Datavis</title>
</head>
<body>
	<h1>Dataviz</h1>
	<p>wesh soumeya :)</p>
	 
	Liens utiles :
	<ul>
		<li>Prototype : <a href="proto">vps730707.ovh.net/web</a></li>
	    <li>Accès au site web originel : <a href="web">vps730707.ovh.net/web</a></li>
        <li>Accès a notre partie privée : <a href="private/test-lib/">vps730707.ovh.net/private/test-lib</a></li>
	</ul>

	<?php
	//	 echo json_encode($sampleArray);


		$nbouvre= $model->getNbOeuvre();
		echo "<p> Il y a ". $nbouvre ." dans la base de donnee </p>";

		$anneeMinMax = $model->getNbAnnee();
		$anneeMin = $anneeMinMax['dateMin'];
		$anneeMax = explode('-', $anneeMinMax['dateMax']);
		$anneeMax = $anneeMax[2];
		echo "<p> Date de publications de la première oeuvre = ". $anneeMin ."</p>";
		echo "<p> Date de publications de la dernière oeuvre = ". $anneeMax ."</p>";

		$tableauDonnee= array(); $i=0;
		$anneeMin = intval($anneeMin); // Transformer les valeurs en nombres
		$anneeMax = intval($anneeMax);
		for($annee= $anneeMin; $annee< $anneeMax; $annee+=10){
			$nbPublication= $model->getNbPublicationsPeriodes($annee, $annee+10);
			$nbPublication = intval($nbPublication); // Transformer en int
			echo "<p> Entre <b>". $annee."</b> et <b>". ($annee+10) ."</b> il y a eu <b> ".$nbPublication."</b> publications.</p>";
			// Tableau imbriqué
			$tableauDonnee[] = ["annee" => $annee, "nombre" => $nbPublication];
		}

		$nbDateNull= $model->getNbDateNull();
		echo "<br><p> Nombre de donnee non pris en compte dans l'echantillonage = $nbDateNull  </p>";

		echo "<br><p> Tableau de donnee: </p>";?>
		<script type="module">
import graph from "./graphe.js";
var data = <?php echo json_encode($tableauDonnee) . ";"; ?>
graph(data);
		</script>
	<div id="graph-div" style="position: relative">
        <svg id="graph" style="height: 1000px; width: 1000px;"></svg>
    </div>
</body>
</html>
