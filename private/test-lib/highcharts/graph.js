 Highcharts.chart('container', {
      title: {
          text: 'test'
      },
      xAxis: {
          title: { text: 'Date' },
          categories: data.map(d => d.annee)
      },
      yAxis: [{
          min : 0,
          title: { text: 'Nombre de livres ' }
      }],

      tooltip: {
         headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
         pointFormat: '<tr><td style="color:{series.color};padding:0">Nombre de livres </td>' +
             '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
         footerFormat: '</table>',
         shared: true,
         useHTML: true
     },
      labels: {

          items: [{
              html: 'Nombre  de livres par année',
              style: {
                  left: '50px',
                  top: '18px',
                  color: ( // theme
                      Highcharts.defaultOptions.title.style &&
                      Highcharts.defaultOptions.title.style.color
                  ) || 'black'
              }
          }]
      },
      series: [{
          type: 'column',
          name: 'Nombre de livres',
          data: data.map(d => d.nombre)
      },

      {
          type: 'pie',
          name: 'Nombre de livres',
          data: data.map(d => d.nombre),
          center: [100 , 80],
          size: 100,
          showInLegend: false,
          dataLabels: {
              enabled: false
          }
      }]
  });