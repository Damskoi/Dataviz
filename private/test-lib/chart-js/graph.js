function interpolate(context) {
    const index = context.dataIndex;
    const value = context.dataset.data[index];

    const colorMin = 'rgb(255,215,224)';
    const colorMax = 'rgb(255,35,120)';

    const delta = nombreMax - nombreMin;

    // Interpolation du bled (normalement fonction a faire)
    const a1 = 215;
    const a2 = 35;
    const deltaA = Math.abs(a2 - a1);
    const b1 = 224;
    const b2 = 120;
    const deltaB = Math.abs(b2 - b1);

    var ratio = value / delta // Calcul du ratio d'interpolation
    var a = a2 + deltaA * (1 - ratio); // 1 - ratio parce que couleurs plus faibles d'abord
    var b = b2 + deltaB * (1 - ratio);

    return 'rgb(255,' + a + ',' + b + ")";
}

var ctx = document.getElementById('barChart').getContext('2d');
// L'élement data est dans le contexte global par PHP.
// data.annee, data.nombre
const nombres = data.map(d => d.nombre);
const nombreMin = Math.min(...nombres);
const nombreMax = Math.max(...nombres);
var barChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: data.map(d => d.annee),
        datasets: [
            {
                label: 'Nombre d\'oeuvres',
                data: data.map(d => d.nombre),
                backgroundColor: interpolate, // On passe la fonction interpolate
                borderColor: 'black',
                borderWidth: 1
            }],
    },
    options: {
        scales: {
            xAxes: [{ // Comment décrire l'axe X?
                type: 'time',
                distribution: 'series',
                time: {
                    unit: 'year'
                }
            }],
            yAxes: [{ // Comment décrire l'axe Y?
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var ctx = document.getElementById('lineChart').getContext('2d');
var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: data.map(d => d.annee),
        datasets: [
            {
                label: 'Nombre d\'oeuvres',
                data: data.map(d => d.nombre),
                pointBackgroundColor: interpolate, // On passe la fonction interpolate
                borderColor: 'black',
                borderWidth: 1
            }],
    },
    options: {
        scales: {
            xAxes: [{ // Comment décrire l'axe X?
                type: 'time',
                distribution: 'series',
                time: {
                    unit: 'year'
                }
            }],
            yAxes: [{ // Comment décrire l'axe Y?
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});