// Metadata: titre...
export default function graph(data, metadata) {
    console.log(data)
    const xaxis = data.map(d => d.x)
    const yaxis = data.map(d => d.y)
    console.log(xaxis)
    console.log(yaxis)

    const graphData = [
        {
            x: xaxis,
            y: yaxis,
            mode: 'lines',
            type: 'line',
            text: yaxis,
        }
    ]

    const layout = {
        title: metadata['title'],
        xaxis: {
            tickangle: -45,
        },
        yaxis: {
            title: 'Nombre de fiches',
            titlefont: {
              size: 16,
              color: 'rgb(107, 107, 107)'
            },
            tickfont: {
              size: 14,
              color: 'rgb(107, 107, 107)'
            }
          },
        barmode: 'group'
      };
    Plotly.newPlot('graph', graphData, layout);
}
