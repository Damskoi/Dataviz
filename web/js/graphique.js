var allCharts = [
  "graphique-type1",
  "graphique-type2",
  "graphique-type3",
  "graphique-type4",
  "graphique-type5",
  "graphique-type6",
  "graphique-type7",
  "graphique-type8"];
var selectedChart = null;

addAllEventListener();
iniPalette();
var allPalettes = window.config;
popoverDismiss();

/**
 * Initialise la palette de couleur à partir d'un fichier défini dans la fonction.
 */
function iniPalette() {
  var requestURL = './config.json';
  var request = new XMLHttpRequest();
  request.open('GET', requestURL);
  request.responseType = 'json';
  request.send();
  request.onload = function() {
    window.config = request.response;
  }
}

function popoverDismiss() {
  $('.popover-dismiss').popover({
    trigger: 'focus'
  })
}

/**
 * Créer les options de la palette.
 * @param txt Nom de la palette
 */
function addFormPalette(txt) {
  var select = document.getElementById('palette');
  select.options[select.options.length] = new Option(txt, 'value');
}


function checkPertinence() {

}

/**
 * Selon l'état de l'élément portant l'id "display", l'affiche ou le cache.
 */
function displayInfoDiv() {
  var x = document.getElementById("display");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

/**
 * Change le graphique actuellement selectionné.
 */
function changeChartPalette() {
  var currentPalette = getFormPalette();
  if (selectedChart != null) {
    generateChosenChart(selectedChart)
  }
}

/**
 * Renvoie la valeur du choix sélectionné dans la palette.
 */
function getFormPalette() {
  return document.getElementById("palette").value;
}

/**
 * Ajoute tout les écouteurs.
 */
function addAllEventListener() {
  addChartEventListener();
  addPaletteEventListener();
}

/**
 * Ajoute des écouteurs sur les boites permettant le choix des graphiques.
 */
function addChartEventListener() {
  for (var i = 0; i < allCharts.length; i++) {
    document.getElementById(allCharts[i]).addEventListener('click', function(e){processChart(e);});
  }
}

/**
 * Rajoute le choix pour les palettes.
 */
function addPaletteEventListener() {
  document.getElementById("palette").addEventListener('change', function(e){changeChartPalette();});
}


/**
 * Génère le graphique à partir de la chaine de caractère passé en paramètre.
 */
function generateChosenChart(char) {
  // Il faut intégrer lors de l'assemblage le swap du display info si la requête donne peu de résultats
  // checkPertinence();
  switch(char) {
    case allCharts[0]:
      // globalData : défini par le premier ajax du formulaire,
      // voir formulaire_graphique.php 
      makebar(globalData);
      break;
    case allCharts[1]:
      makeCirculaire();
      break;
    case allCharts[2]:
      makeplot2();
      break;
    case allCharts[3]:
      makeplot2();
      break;
    case allCharts[4]:
      makeNuageDeMots();
      break;
    case allCharts[5]: //On désactive le clique sur la palette
      makenetwork(globalData);
      break;
    case allCharts[6]:
      makeplot2()
      break;
    case allCharts[7]:
      makebubble(globalData);
      break;
    default:
      alert("Graphique non défini !");
  }
}

function makeNuageDeMots() {
  blockPalette();
  makeplot2();
}

function makeReseau() {
  blockPalette();
  makeplot2();
}

/**
 * Bloque la possibilité d'utiliser la palette.
 */
function blockPalette() {
  document.getElementById("palette").disabled = true;
}

/**
 * Débloque la possiblité d'utiliser la palette.
 */
function unblockPalette() {
  document.getElementById("palette").disabled = false;
}

/**
 * Renvoie la valeur d'un élément passé en paramètre.
 */
function getState(id) {
  return document.getElementById(id).value == "true";
}


/**
 * Processus de création d'un graphique :
 * - on débloque l'utilisation de la palette,
 * - on met à jour le graphique sélectionné,
 * - on envoie à la fonction de génération le type de graphique qu'il doit généré.
 */
function processChart(e) {
  var charType = e.currentTarget.id;
  unblockPalette();
  updateSelectedChart(charType);
  generateChosenChart(charType);
  setTimeout(function() { // Dirige l'utilisateur vers le graphique générer, délai de 5ms pour laisser le temps à plotly de générer le graphique.
    jump('generation-graphique');
  }, 5);
}

/**
 * Sélectionne le graphique.
 */
function selectChart(chart) {
  selectedChart = chart;
  document.getElementById(chart).classList.add("selected")
}

/**
 * Désélectionne le graphique passé en paramètre.
 */
function unselectChart(chart) {
  document.getElementById(chart).classList.remove("selected")
}

/**
 * On désélectionne tous les graphiques.
 */
function unselectAllCharts() {
  for (i=0; i < allCharts.length; i++) {
    unselectChart(allCharts[i]);
  }
}

/**
 * On met à jour le graphique sélectionné.
 */
function updateSelectedChart(chart) {
  unselectAllCharts();
  selectChart(chart);
}

/**
 * Dirige l'utilisateur vers le graphique généré.
 */
function jump(h){ //http://jsfiddle.net/DerekL/rEpPA/
    var top = document.getElementById(h).offsetTop;
    window.scrollTo(0, top);
}

/**
 * Ajoute un bouton dans une barre de menu.
 */
function addButton(bar, button, index) {
  bar.splice(index, 0, button);
}

/**
 * Créer un bouton de sauvegarde.
 */
function createSaveAsButton(name, icon, format) {
  var newButton = {
    name: name,
    icon: icon,
    click: function(gd) {
      Plotly.downloadImage(gd, {format: format})
    }
  }
  return newButton;
}

/**
 * Initialise la barre menu de plot.ly.
 */
function barInit() {
  var barButtons = ['toImage', 'select2d', 'lasso2d', 'toggleSpikelines', 'hoverClosestCartesian', 'hoverCompareCartesian']; // all of the native options that will be dispayed, original list here : https://github.com/plotly/plotly.js/blob/master/src/components/modebar/buttons.js

  var newSaveAsButtons = createSaveAsButton("Télécharger le graphique en fichier SVG", Plotly.Icons.camera, 'svg');
  addButton(barButtons, newSaveAsButtons, 1)

  var config = {
    locale: 'fr',
    responsive: true,
    displaylogo: false,
    modeBarButtons: [barButtons]
  }

  return config;
}


/**
 * Renvoie des paramètres pour la désactivation de zoom plot.ly.
 */
function getLayoutZoomState(stateX, stateY) { // state is a boolean, return an array that contain information about the state of fixed ranges of yaxis and xaxis
  return {
    yaxis: {
      fixedrange: stateY
    },
    xaxis : {
      fixedrange: stateX
    }
  };
}

/**
 * Renvoi les couleurs à utiliser.
 */
function getLayoutColors() {
  return window.config.palette[getFormPalette()];
}

/**
 * Renvoie le layout de plot.ly.
 */
function getLayout() {
  var layout = getLayoutZoomState(true, true);
  var color = {colorway: getLayoutColors()};
  var layout = Object.assign(layout, color);
  return layout;
}

/**
 * Prends un layout et modifie l'occurence des valeurs sur les axes.
 */
function setLayout_tick(oldLayout, new_dtickX, new_dtickY) {
  var newLayout = {
    xaxis: {dtick: new_dtickX},
    yaxis: {dtick: new_dtickY}
  };

  oldLayout["xaxis"] = Object.assign(oldLayout["xaxis"], newLayout["xaxis"]);
  oldLayout["yaxis"] = Object.assign(oldLayout["yaxis"], newLayout["yaxis"]);

  return oldLayout;
}

//***************************************
// Function de test pour l'interface
//***************************************

// On passe les données global
function makebar(donnes) {
  // Objet qu'on va envoyer en ajax
  // Deux champs: la requete et le type de données
  var obj = {
    data: donnes,
    typeGraphe: "bar"
  }

  console.log(obj);
  // Requête ajax pour générer la bonne structure
  $.ajax({
    type: 'POST',
    url: './genGraph.php',
    data: obj,
    dataType: "json"
  })
  .done(function(data) {
    console.log(data);
    const xaxis = data.map(d => d.x)
    const yaxis = data.map(d => d.y)

    var donneesBar = [
        {
            x: xaxis,
            y: yaxis,
            type: 'bar',
        }
    ]

    var graphData = donneesBar;
    console.log(graphData);

    var layoutA = {barmode: 'group'};
    var layoutB = getLayout();
    var layout = Object.assign(layoutA, layoutB)
    var layout = setLayout_tick(layout, 1, 1);

    Plotly.newPlot('generation-graphique', graphData, layout, barInit());
  })
  .fail(function() {
    alert( "Erreur de génération du graphe." );
  });
}

function makebubble(donnes) {
  // Objet qu'on va envoyer en ajax
  // Deux champs: la requete et le type de données
  var obj = {
    data: donnes,
    typeGraphe: "bubble"
  }

  console.log(obj);
  // Requête ajax pour générer la bonne structure
  $.ajax({
    type: 'POST',
    url: './genGraph.php',
    data: obj,
    dataType: "json"
  })
  .done(function(data) {
    var trace1 = {
      type: "scatter",
      mode: "markers",
      // x nombre
      // y annee
      x: data.map(d => d.x),
      y: data.map(d => d.y),
      marker: {
        line: {
          width: 1,
        },
        symbol: 'circle',
        size: data.map(d => (d.y * 3)),
      }
    };
  
    var graphData = [trace1];

    var layoutA = {barmode: 'group'};
    var layoutB = getLayout();
    var layout = Object.assign(layoutA, layoutB);
    var layout = setLayout_tick(layout, 1, 1); //Il faudrait faire en sorte d'appeler cette fonction avec les paramètres 1, 1 quand des années sont impliqués et que le nombre d'oeuvre     n'est pas trop important

    Plotly.newPlot('generation-graphique', graphData, layout, barInit());
  })
  .fail(function() {
    alert( "Erreur de génération du graphe." );
  });
}

// On passe les données global
function makenetwork(donnes) {
  // Objet qu'on va envoyer en ajax
  // Deux champs: la requete et le type de données
  var obj = {
    data: donnes,
    typeGraphe: "network"
  }

  console.log(obj);
  // Requête ajax pour générer la bonne structure
  $.ajax({
    type: 'POST',
    url: './genGraph.php',
    data: obj,
    dataType: "json"
  })
  .done(function(data) {
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
    chart.container("generation-graphique");

    // initiate drawing the chart
    chart.draw();
  })
  .fail(function() {
    alert( "Erreur de génération du graphe." );
  });
}

function makeplot2() {
    var data = [
      {
        x: ['giraffes', 'orangutans', 'monkeys'],
        y: [20, 14, 23],
        type: 'bar'
      }
    ];
    var layout = getLayout();
    Plotly.newPlot('generation-graphique', data, layout, barInit());
};

function makeCirculaire() {
    var data = [{
      values: [19, 26, 55],
      labels: ['Residential', 'Non-Residential', 'Utility'],
      type: 'pie'
    }];

    var layout = getLayout();


    Plotly.newPlot('generation-graphique', data, layout, barInit());
};
