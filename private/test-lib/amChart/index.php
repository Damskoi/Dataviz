<?php
	require_once '../../Model.php'; 
	$model = Model::get_model();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dataviz</title>
	<!-- Resources -->
	<script src="https://www.amcharts.com/lib/4/core.js"></script>
	<script src="https://www.amcharts.com/lib/4/charts.js"></script>
	<script src="https://www.amcharts.com/lib/4/plugins/wordCloud.js"></script>
	<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
</head>
<body>
	<h1>Dataviz</h1>

	<?php 

		$listnom= $model->getAuteurNom();
	
		$liste= [];
		foreach ($listnom as $value) {
			$liste[] = $value['auteurNom'];
		}

		$chaineListe = implode(' ', array_values($liste));
		
	 ?>


	<script>
		var liste = <?php echo json_encode($chaineListe) ?>;
		am4core.ready(function() {

		am4core.useTheme(am4themes_animated);

		var chart = am4core.create("chartdiv", am4plugins_wordCloud.WordCloud);
		var series = chart.series.push(new am4plugins_wordCloud.WordCloudSeries());

		series.accuracy = 4;
		series.step = 15;
		series.rotationThreshold = 0.7;
		series.maxCount = 200;
		series.minWordLength = 2;
		series.labels.template.margin(4,4,4,4);
		series.fontFamily = "Courier New";
		series.maxFontSize = am4core.percent(30);

		series.text = liste; 

		series.colors = new am4core.ColorSet();
		series.colors.passOptions = {};

		//series.labelsContainer.rotation = 45;
		series.angles = [0,-90];
		series.fontWeight = "700"

//		var subtitle = chart.titles.create();
//		subtitle.text = "(click to open)";

		var title = chart.titles.create();
		title.text = "Nuage d'Auteurs";
		title.fontSize = 20;
		title.fontWeight = "800";

		}); 
	</script>	

	 <div id="chartdiv" style="width:100%; height: 500px;"></div>

</body>
</html>
