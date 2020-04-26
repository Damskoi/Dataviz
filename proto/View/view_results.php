<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Datavis</title>
</head>
<body>
	<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
	<h1>Dataviz</h1>
	<p>Test recherche</p>
	<script type="module">
        import graph from "./graphBar.js";
		var json_req = <?php echo json_encode($json_req) ?>;
		var metadata = {};
		metadata['title'] = <?php echo json_encode($title) ?>;
		graph(json_req, metadata)
	</script>
	<div id="graph"></div>
</body>
</html>
