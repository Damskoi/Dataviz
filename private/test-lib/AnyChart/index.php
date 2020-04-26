<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-graph.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">

  <style type="css.css"></style>
</head>
<body>
  <div id="container" style="width: 500px; height: 400px;"></div>

  <script>

  anychart.onDocumentReady(function () {

      // create data
      var data = {
        nodes: [
          {id: "Richard"},
          {id: "Larry"},
          {id: "Marta"},
          {id: "Jane"},
          {id: "Norma"},
          {id: "Frank"},
          {id: "Brett"}
        ],
        edges: [
          {from: "Richard", to: "Larry"},
          {from: "Richard", to: "Marta"},
          {from: "Larry",   to: "Marta"},
          {from: "Marta",   to: "Jane"},
          {from: "Jane",    to: "Norma"},
          {from: "Jane",    to: "Frank"},
          {from: "Jane",    to: "Brett"},
          {from: "Brett",   to: "Frank"}
        ]
      };


      // create a chart and set the data
			var chart = anychart.graph(data);


			var nodes = chart.nodes();
			nodes.normal().fill("#A01816");
			nodes.stroke('2 #CE2C1C');	// contour des nodes
			nodes.hovered().height(10).width(10).stroke('2 #A52317'); // countour des nodes quand hovered
			nodes.hovered().fill("white");
			nodes.selected().fill("#911A14");
			nodes.selected().height(10).width(10).stroke('2 #B52319'); // contour des nodes quand sélectioné

			var edges = chart.edges();
			edges.stroke('2 #CE2C1C'); // lignes
			edges.hovered().stroke('2 #A52317'); // lignes hovered
			edges.selected().stroke('2 #B52319'); // lignes sélectionnés


      // set the chart title
      chart.title("Network Graph: Basic Sample");

      // set the container id
      chart.container("container");

      // initiate drawing the chart
      chart.draw();
  });


  </script>
</body>
</html>
