export default function graph(data) {

var graphdef = {
    categories : ['Nombre de livres'],
    dataset : {
        'Nombre de livres': data

    }
}
    var chart = uv.chart('Line', graphdef);

}