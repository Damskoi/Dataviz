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
	<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
	 <div id="container" style="width:100%; height: 500px;"></div>
</head>
<body>
	<h1>Dataviz</h1>


	<?php
  $listauteur= $model->getNbOeuvreWithAuteur();
print_r($listauteur);
print("<br><br>");
  		$liste= [];
  		foreach($listauteur as $v){
  		    $liste[] = ['x'=> $value['x'],'y'=> $value['y'] ];
  		}
  		
  		print_r($liste);
  	 ?>
  <script>
 const data = <?php echo json_encode($liste) . ";"; ?>
   var donnee = [{"titre":"Paul Eluard","nombre":"10"},{"titre":"Alexandre Dumas","nombre":"5"},{"titre":"Victor Hugo","nombre":"5"},{"titre":"Edmond Malone","nombre":"13"},{"titre":"Christine de Pisan","nombre":"5"},{"titre":"George Sand","nombre":"7"},{"titre":"Hector Servadac","nombre":"3"},{"titre":"Marguerite Audoux","nombre":"1"},{"titre":"Edgar Allan Poe","nombre":"6"},{"titre":"Honoré de Balzac","nombre":"13"}];
 var donnee = [{
   type: 'scatterpolar',
     r: donnee.map((d) => d.nombre),
    theta: donnee.map((d) => d.titre),
   fill: 'toself'
 },
 ]

 var layout = {
   polar: {
     radialaxis: {
       visible: true,
       range:donnee.map((d) => d.nombre),
     }
   },
   showlegend: false
 }

 Plotly.plot("container", donnee, layout)

   </script>	

	

</body>
</html>
