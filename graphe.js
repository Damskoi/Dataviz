export default function graphe(data) {
console.log(data);

const margin = 60;
const width = 1000 - 2 * margin;
const height = 600 - 2 * margin;

const svg = d3.select('#graph');

const chart = svg.append('g')
    .attr('transform', `translate(${margin}, ${margin})`);

var nombres = data.map((d) => d.nombre)
// On obtient chaque nombre du tableau,
// et on le stocke dans un autre tableau [123, 124, 125..]
var nombreMax = Math.max(...nombres)
// Obtenir le maximal pour faire l'axe Y de notre tableau

const yScale = d3.scaleLinear()
    .range([height, 0])
    .domain([0, nombreMax]);

chart.append('g')
    .call(d3.axisLeft(yScale));

const xScale = d3.scaleBand()
    .range([0, width])
    .domain(data.map((d) => d.annee))
    .padding(0.1);

var sequentialScale = d3.scaleSequential()
    .domain([0, data.length])
    .interpolator(d3.interpolateInferno);

chart.append('g')
    .attr('transform', `translate(0, ${height})`)
    .call(d3.axisBottom(xScale));

chart.append("text")
    .attr("transform", "rotate(-90)")
    .attr("y", 0 - margin)
    .attr("x",0 - (height / 2))
    .attr("dy", "1em")
    .style("text-anchor", "middle")
    .text("Nombre de livres");

chart.append("text")
 .attr("transform",
       "translate(" + (width/2) + " ," +
                      (height + margin) + ")")
 .style("text-anchor", "middle")
 .text("Date");


chart.selectAll()
    .data(data)
    .enter()
    .append('rect')
    .attr('x', (d) => xScale(d.annee)) // Valeurs par défault
    .attr('y', height)
    .attr('width', xScale.bandwidth())
    .on("mouseover",function()
    {
      tooltip.style("display",null)
    })
    .on("mouseout",function()
    {
      tooltip.style("display","none")
    })
    .on("mousemove",function(d)
    {
      var xPos=d3.mouse(this)[0]+20;
      var yPos=d3.mouse(this)[1];
      tooltip.style("left", xPos + "px");
      tooltip.style("top", yPos + "px");
      tooltip.selectAll("text").text("Date : " +d.annee);
    });

    var tooltip = d3.select('#graph-div').append("div")
        .attr("class", "tooltip")
        .style("z-index", 10)
        .style("position", "absolute")

    tooltip.append("text")
        .attr("x", 30)
        .attr("dy", "1.7em")
        .style("text-anchor", "middle")
        .attr("font-size", "20px")
        .attr("font-weight", "bold")
        .attr("width", 60)
        .attr("height", 20)
        .attr("fill", "white")
        .style("border", "solid black 2px")
        .style("opacity", 1)
        .style("border-radius", "5px")
        .style("color", "white")
        .style("padding", "10px")
        .style("background-color", "black");



// Pour faire une transition des val par default vers les val transitionée

chart.selectAll('rect')
    .transition()
    .duration(2000)
    .delay( (d,i) => ( i * 100 )) // Chaque nombre va attendre 40ms le précédent avant de faire sa propre transition
    .ease(d3.easeCubic)
    .attr('y', (d) => yScale(d.nombre))
    .attr('height', (d) => height - yScale(d.nombre))
    .style('fill', (d,i) => sequentialScale(i))

console.log(data.length)

// Valeurs de base
chart.selectAll()
   .data(data)
   .enter()
   .append('text')
   .text('0')
   .attr('class', 'bar')
   .attr("x", function(d, i) {
        return xScale(d.annee) + (xScale.bandwidth() / 2);  // +5
   })
   .attr('y', height)
   .attr("font-family", "sans-serif")
   .attr("font-size", "30px")
   .attr("fill", (d,i) => sequentialScale(i))
   .attr("text-anchor", "middle")
   .style('opacity', '0');


// Transition
chart.selectAll('text').filter('.bar')
    .transition()
    .duration(2000)
    .ease(d3.easeCubic)
    .tween("text", function(d) {
        var i = d3.interpolate(this.textContent, d.nombre) // Fonction qui interpole le nombre

        return function(t) {
            this.textContent = Math.round(i(t)); // Arrondir au plus proche nombre entier
        };
    })
    .attr("y", function(d) {
         return yScale(d.nombre) - height/40              // +15
     })
    .style("opacity", "1")
    .delay( (d,i) => ( i * 100 )) // Chaque nombre va attendre 40ms le précédent avant de faire sa propre transition
}