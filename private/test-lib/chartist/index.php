<?php
	require_once '../../../Model.php';
	$model = Model::get_model();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <style>
    .ct-label .ct-horizontal {
      transform: rotate(-90deg);
    }

    .ct-label.ct-horizontal.ct-end {
       white-space:nowrap;
       writing-mode:vertical-rl;
     }

    .ct-series-a .ct-area {
      fill-opacity: .5;
      fill: #252b5e;
    }

    .ct-line {
     stroke-width: 2px;
    }
    </style>
  </head>
  <body>
    <div class="ct-chart ct-minor-seventh" id="c1"></div>
    <script>
    <?php
          $anneeMinMax = $model->getNbAnnee();
          $anneeMin = $anneeMinMax['dateMin'];
          $anneeMax = explode('-', $anneeMinMax['dateMax']);
          $anneeMax = $anneeMax[2];
          $tableauDonnee= array();
          for($annee= $anneeMin; $annee< $anneeMax; $annee+=1){
              $nbPublication= $model->getNbPublicationsPeriodes($annee, $annee+1);
              $nbPublication = intval($nbPublication); // Transformer en int
              $tableauDonnee[] = ["annee" => strval($annee), // Transformer en string, et mettre en format ISO
                                  "nombre" => $nbPublication];
          }
          ?>
          const data = <?php echo json_encode($tableauDonnee) . ";"; ?>
    var datum = {
      // A labels array that can contain any sort of values
      labels: data.map(d => d.annee),
      // Our series array that contains series objects or in this case series data arrays
      series: [{
        name: 'series-1',
        data: data.map(d => d.nombre),
      }]
     };

    var options = {
      series: {
          'series-1': {
            showArea: true
          },
      },
      // X-Axis specific configuration
      axisX: {
      },
      // Y-Axis specific configuration
      axisY: {
        // Lets offset the chart a bit from the labels
        offset: 60,
        // The label interpolation function enables you to modify the values
        // used for the labels on each axis. Here we are converting the
        // values into million pound.
        labelInterpolationFnc: function(value) {
          return Math.round(value) ;
        }
      }
    };

    // Create a new line chart object where as first parameter we pass in a selector
    // that is resolving to our chart container element. The Second parameter
    // is the actual data object.
    var chart = new Chartist.Line('#c1', datum, options);

    var seq = 0;

    chart.on('draw', function(data) {
    if(data.type === 'line' || data.type === 'area') {
      data.element.animate({
        d: {
          begin: 0,
          dur: 1500,
          from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
          to: data.path.clone().stringify(),
          easing: Chartist.Svg.Easing.easeOutQuint
        },
        opacity: {
            // The delay when we like to start the animation
            begin: 0,
            // Duration of the animation
            dur: 500,
            // The value where the animation should start
            from: 0,
            // The value where it should end
            to: 1
          },
      });
    }
    });

    chart.on('draw',
    function(data) {
      if(data.type === 'point') {
        // If the drawn element is a line we do a simple opacity fade in. This could also be achieved using CSS3 animations.
        data.element.animate({
          opacity: {
            // The delay when we like to start the animation
            begin: 0,
            // Duration of the animation
            dur: 500,
            // The value where the animation should start
            from: 0,
            // The value where it should end
            to: 1
          },
          x1: {
            begin: 0,
            dur: 500,
            from: data.x - 100,
            to: data.x,
            // You can specify an easing function name or use easing functions from Chartist.Svg.Easing directly
            easing: Chartist.Svg.Easing.easeOutQuart
          }
        })
      }});

    </script>
  </body>
</html>