export default function graphe(width) {
    d3
    .select(".target")  // select the elements that have the class 'target'
    .style("stroke-width", width) // change their style: stroke width is not equal to 8 pixels
}
