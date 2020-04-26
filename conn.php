<html>
    <head>
        <title>BDD request for Dataviz</title>

    </head>
<body>

<h1>jQuery post form data using .ajax() method</h1>
<div>Fill out and submit the form below to get response.</div>

<!-- our form -->
<form id='userForm'>
  <fieldset>
    <h3>Presentation</h3>
    <label>titre</label><br/>
    <input type="textarea" name="titre" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
    <label>Nom</label><br/>
    <input type="textarea" name="name" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
<!--  <label>Genre<input type="textarea" name="type" /></label> <!--natureTxt , int-->
  <label>Date de première mise en circulation</label><br/>
  <input type="textarea" name="dateTot" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
  <label>Date de dernière mise en circulation</label><br/>
  <input type="textarea" name="dateTard" /><br/>
  <table>
  <tr>
    <td><input type="checkbox" name="boxPr[]" value='R'>Roman</td>
    <td><input type="checkbox" name="boxPr[]" value='RC'>Réit court</td>
    <td><input type="checkbox" name="boxPr[]" value='BD'>BD</td>
  </tr>
</table>

</fieldset>
<br/>
<br/>

<fieldset>
  <h3>Etude du genre</h3>
  <label>Désignations génériques</label><br/>
  <input type="textarea" name="designation" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
  <label>Année de(s) designation(s)</label><br/>
  <input type="textarea" name="AnneeDebut" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
  <input type="textarea" name="AnneeFin" /><br/> <!--auteurPrenom,auteurPrenomReel,auteurPrenom2, auteurPrenomReel2, auteurPrenom3, auteurPrenomReel3 -->
<!--  <label>Genre<input type="textarea" name="type" /></label> <!--natureTxt , int-->
  <label>Filtrage sur les types de designations</label>
  <table>
  <tr>
    <td><input type="checkbox" name="boxCFiltre[]" value='Discours auctorial'>Discours auctorial</td>
    <td><input type="checkbox" name="boxCFiltre[]" value='Dispositif éditorial'>Dispositif éditorial</td>
    <td><input type="checkbox" name="boxCFiltre[]" value='Réception critique'>Réception critique</td>
  </tr>
</table>

  <label>auteur Comparés</label><br/>
  <input type="textarea" name="auteurComp" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
  <label>Date du lien avec l'auteur</label><br/>
  <input type="textarea" name="dateADebut" /><br/>
  <input type="textarea" name="dateAFin" /><br/>
</fieldset>

<br/>
<br/>

<fieldset>
  <h3>Matériel</h3>
  <label>Support de publication</label><br/>
  <input type="textarea" name="support" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
  <label>Année de parution</label><br/>
  <input type="textarea" name="yearParutionDebut" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
  <input type="textarea" name="yearParutionFin" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
  <label>Filtrage</label><br/>
  <table>
  <tr>
    <td><input type="checkbox" name="boxFil[]" value='V'>Volume</td>
    <td><input type="checkbox" name="boxFil[]" value='P'>¨Periodique</td>
    <td><input type="checkbox" name="boxFil[]" value='L'>Livraison</td>
  </tr>
</table>
  <label>Catégorie</label><br/>
  <table>
  <tr>
    <td><input type="checkbox" name="boxC[]" value='273'>Anticipation</td>
    <td><input type="checkbox" name="boxC[]" value='269'>Jeunesse</td>
    <td><input type="checkbox" name="boxC[]" value='278'>Sentimental</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxC[]" value='275'>Aventure</td>
    <td><input type="checkbox" name="boxC[]" value='272'>Littérature générale</td>
    <td><input type="checkbox" name="boxC[]" value='274'>SF</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxC[]" value='271'>Edition de luxe/bibliophilie</td>
    <td><input type="checkbox" name="boxC[]" value='276'>Policier</td>
    <td><input type="checkbox" name="boxC[]" value='279'>Autre</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxC[]" value='277'>Fantastique</td>
    <td><input type="checkbox" name="boxC[]" value='270'>Populaire</td>
    <td><input type="checkbox" name="boxC[]" value='280'>Rien</td>
  </tr>
</table>
<!--  <label>Genre<input type="textarea" name="type" /></label> <!--natureTxt , int-->
<label>Nom de l'illustrateur</label><br/>
<input type="textarea" name="nomIllus" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->
<label>Langue de traduction</label><br/>
<input type="textarea" name="langueTrad" /><br/>
<label>Nature d'adaptation</label><br/>
<select name="natureAdaptation">
  <option class="text-left" value="null" selected>--- Sélectionnez un élément de la liste---</option>
  <option value="BD">BD</option>
  <option value="Danse">Danse</option>
  <option value="Film">Film</option>
  <option value="Livre Audio">Livre Audio</option>
  <option value="Musique">Musique</option>
  <option value="Pièce radiophonique">Pièce radiophonique</option>
  <option value="Radio">Radio</option>
  <option value="Théâtre">Théâtre</option>
</select>
</fieldset>

<br/>
<br/>


<fieldset>
<h3>Poétique, temps, espace, personnage et esthétique </h3>
<label>Poétique</label><br/>
<table>
  <tr>
    <td><input type="checkbox" name="boxNaration[]" value='1st'>Naration à la 1ère personne</td>
    <td><input type="checkbox" name="boxNaration[]" value='3rd'>Naration à la 3ème personne</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxNaration[]" value='multiple'>Naration multiple</td>
    <td><input type="checkbox" name="boxNaration[]" value='enchassee'>Naration enchâssée</td>
  </tr>
</table>
<label>Cadre spatial</label><br/>
<input type="textarea" name="cadreSpatial" /><br/> <!--auteurNom,auteurNom2, auteurNomReel2, auteurNom3, auteurNomReel3-->

<label>Date de l'histoire</label><br/>
<input type="textarea" name="dateHistoireDebut" /><br/>
<input type="textarea" name="dateHistoireFin" /><br/>

<label>Écart temporel</label><br/>
<table>
  <tr>
    <td><input type="checkbox" name="boxNaration2[]" value='passeLointain'>Passé lointain (+50 ans)</td>
    <td><input type="checkbox" name="boxNaration2[]" value='passeProche'>Passé proche (-50 ans)</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxNaration2[]" value='present'>Présent</td>
    <td><input type="checkbox" name="boxNaration2[]" value='futurProche'>Futur proche (-50 ans)</td>
    <td><input type="checkbox" name="boxNaration2[]" value='futurLointain'>Futur lointain (+50 ans)</td>
  </tr>
</table>


<label>Rapport au temps</label><br/>
<table>
  <tr>
    <td><input type="checkbox" name="boxNaration3[]" value='ageOr'>Âge d'or</td>
    <td><input type="checkbox" name="boxNaration3[]" value='decadence'>Décadence</td>
    <td><input type="checkbox" name="boxNaration3[]" value='eschatologie'>Eschatologie</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxNaration3[]" value='evolutionnisme'>Évolutionnisme</td>
    <td><input type="checkbox" name="boxNaration3[]" value='histoireCyclique'>Histoire cyclique</td>
    <td><input type="checkbox" name="boxNaration3[]" value='progres'>Progrès</td>
  </tr>
</table>

<label>Références intertextuelles (oeuvre ou auteur)</label><br/>
<input type="textarea" name="referencesInter" /><br/>

<label>Personnage scientifique</label><br/>
<input type="textarea" name="persoScientifique" /><br/>

<label>Profession</label><br/>
<input type="textarea" name="profession" /><br/>

<label>Genre</label><br/>
<table>
  <td><input type="checkbox" name="boxNaration4[]" value='masculin'>Masculin</td>
  <td><input type="checkbox" name="boxNaration4[]" value='feminin'>Féminin</td>
  <td><input type="checkbox" name="boxNaration4[]" value='indetermine'>Indéterminé</td>
</table>

<label>Valorisation</label><br/>
<table>
  <td><input type="checkbox" name="boxNaration5[]" value='positif'>Positif</td>
  <td><input type="checkbox" name="boxNaration5[]" value='negatif'>Negatif</td>
  <td><input type="checkbox" name="boxNaration5[]" value='problematique'>Probématique</td>
  <td><input type="checkbox" name="boxNaration5[]" value='neutre'>Neutre</td>
</table>

<label>caractéritique</label><br/>
<input type="textarea" name="caracteristiques" /><br/>

<label>Figure de l'altérité</label><br/>
<table>
  <tr>
    <td><input type="checkbox" name="boxNaration6[]" value='europe'>Européenne</td>
    <td><input type="checkbox" name="boxNaration6[]" value='extra-europe'>Extra-européenne</td>
    <td><input type="checkbox" name="boxNaration6[]" value='extra-terrestre'>Extra-terrestre</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxNaration6[]" value='creature-artificielle'>Créature artificielle</td>
    <td><input type="checkbox" name="boxNaration6[]" value='mutante'>Mutante</td>
    <td><input type="checkbox" name="boxNaration6[]" value='autre'>Autre</td>
  </tr>
</table>

<label>Esthétique</label><br/>
<select name='selectPoet'>
  <option class="text-left" value="null" selected>--- Sélectionnez un élément de la liste---</option>
  <option value="29">Aucun</option>
  <option value="21">Aventure</option>
  <option value="244">Conte philosophique</option>
  <option value="5">Didactique</option>
  <option value="12">Dystopie</option>
  <option value="7">Épique</option>
  <option value="25">Érotique</option>
  <option value="177">Ésotérique</option>
  <option value="227">étiologique</option>
  <option value="8">Fantastique</option>
  <option value="293">historique </option>
  <option value="10">Horreur</option>
  <option value="17">Humoristique</option>
  <option value="15">Ironique</option>
  <option value="28">Journalistique</option>
  <option value="209">Lyrique</option>
  <option value="9">Merveilleux</option>
  <option value="217">Mystérieux</option>
  <option value="18">Parodique</option>
  <option value="6">Pathétique</option>
  <option value="249">patriotique</option>
  <option value="26">Philosophie</option>
  <option value="27">Poésie</option>
  <option value="19">Policier</option>
  <option value="23">Post-apocalyptique</option>
  <option value="221">Psychologique</option>
  <option value="24">Religieux</option>
  <option value="22">Robinsonnade</option>
  <option value="308">roman d'apprentissage</option>
  <option value="220">Roman de moeurs</option>
  <option value="243">Roman philosophique</option>
  <option value="283">Roman préhistorique</option>
  <option value="16">Satirique</option>
  <option value="20">Sentimental</option>
  <option value="178">Tragique</option>
  <option value="13">Uchronie</option>
  <option value="11">Utopie</option>
</select>

</fieldset>

<br/>
<br/>

<fieldset>
<h3> Sciences et sociétés </h3>
<label>Agronomie</label><br/>
<table>
  <td><input type="checkbox" name="boxScience[]" value='agriculture'>Agriculture</td>
  <td><input type="checkbox" name="boxScience[]" value='veterinaire'>Arts Vetérinaires</td>
  <td><input type="checkbox" name="boxScience[]" value='diet'>Diététique</td>
</table>
<!--Y A UN TRUC ICI OUBLIE PAS HARRY-->
<label>Chimie</label><br/>
<table>
  <tr>
  <td><input type="checkbox" name="boxScienceAlt2[]" value='anthropologie'>anthropologie</td>
  <td><input type="checkbox" name="boxScienceAlt2[]" value='archeologie'>archeologie</td>
  <td><input type="checkbox" name="boxScienceAlt2[]" value='armement'>armement</td>
  <td><input type="checkbox" name="boxScienceAlt2[]" value='construction'>construction</td>
</tr>
<tr>
  <td><input type="checkbox" name="boxScienceAlt2[]" value='astronomie'>Astronomie</td>
</tr>
</table>

<table>
  <td><input type="checkbox" name="boxScience1[]" value='chimieAnalytique'>Chimie analytique</td>
  <td><input type="checkbox" name="boxScience1[]" value='chimieIndustrielle'>Chimie industrielle</td>
  <td><input type="checkbox" name="boxScience1[]" value='chimieOrganique'>Chimie organique</td>
  <td><input type="checkbox" name="boxScience1[]" value='chimieOrganique'>Chimie organique</td>
</table>

<label>Énergie</label><br/>
<table>
  <tr>
    <td><input type="checkbox" name="boxScience2[]" value='atomique'>Atomique</td>
    <td><input type="checkbox" name="boxScience2[]" value='electricite'>Électricité</td>
    <td><input type="checkbox" name="boxScience2[]" value='eolienne'>Éolienne</td>
    <td><input type="checkbox" name="boxScience2[]" value='ether'>Éther/solaire</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxScience2[]" value='geothermique'>Géothermique</td>
    <td><input type="checkbox" name="boxScience2[]" value='hydraulique'>Hydraulique</td>
    <td><input type="checkbox" name="boxScience2[]" value='magnetisme'>Magnétisme</td>
    <td><input type="checkbox" name="boxScience2[]" value='thermodynamique'>Thermodynamique</td>
  </tr>
</table>

<label>Inventions/innovations techniques</label><br/>
<table>
  <td><input type="checkbox" name="boxScience3[]" value='eclairage'>Éclairage</td>
  <td><input type="checkbox" name="boxScience3[]" value='steampunk'>Machines à vapeur/moteurs életriques</td>
  <td><input type="checkbox" name="boxScience3[]" value='photo'>Photographie, cinématographie, phonographie</td>
  <td><input type="checkbox" name="boxScience3[]" value='tele'>Télégraphie, téléphone, radio</td>
</table>

<table>
  td><input type="checkbox" name="boxScienceAlt3" value='math'>math</td>
</table>

<label>Médecine</label><br/>
<table>
  <tr>
    <td><input type="checkbox" name="boxScience4[]" value='anatomie'>Anatomie</td>
    <td><input type="checkbox" name="boxScience4[]" value='chirurgie'>Chirurgie</td>
    <td><input type="checkbox" name="boxScience4[]" value='histologie'>Histologie</td>
    <td><input type="checkbox" name="boxScience4[]" value='homeopathie'>Homéopathie</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxScience4[]" value='hygiene'>Hygiène publique</td>
    <td><input type="checkbox" name="boxScience4[]" value='pathologie'>Pathologies</td>
    <td><input type="checkbox" name="boxScience4[]" value='physiologie'>Physiologie</td>
    <td><input type="checkbox" name="boxScience4[]" value='psychologie'>Psychologie</td>
    <td><input type="checkbox" name="boxScience4[]" value='therapeute'>Thérapeute</td>
  </tr>
</table>
<input type="checkbox" name="boxScienceAlt" value='paleon'>Paléontologie, préhistoire
<label>Physique</label><br/>
<table>
  <tr>
    <td><input type="checkbox" name="boxScience5[]" value='acoustique'>Acoustique</td>
    <td><input type="checkbox" name="boxScience5[]" value='electriciteMagn'>Électricité, magnétisme</td>
    <td><input type="checkbox" name="boxScience5[]" value='mecanique'>Mécanique, hydraulique</td>
    <td><input type="checkbox" name="boxScience5[]" value='optique'>Optique</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxScience5[]" value='physiqueAtome'>Physique atomique, rayonnements</td>
    <td><input type="checkbox" name="boxScience5[]" value='thermodynamique'>Thermodynamique (chaleur)</td>
  </tr>
</table>
<label>Sciences biologiques</label><br/>
<table>
  <td><input type="checkbox" name="boxScience6[]" value='bacteriologie'>Bactériologie</td>
  <td><input type="checkbox" name="boxScience6[]" value='genetique'>Génétique/héréditarisme</td>
  <td><input type="checkbox" name="boxScience6[]" value='microbiologie'>Microbiologie/biochimie</td>
</table>
<label>Sciences naturelles</label><br/>
<table>
  <td><input type="checkbox" name="boxScience7[]" value='botanique'>Botanique</td>
  <td><input type="checkbox" name="boxScience7[]" value='entomologie'>Entomologie</td>
  <td><input type="checkbox" name="boxScience7[]" value='mycologie'>Mycologie</td>
  <td><input type="checkbox" name="boxScience7[]" value='zoologie'>Zoologie</td>
</table>
<label>Sciences de la terre</label><br/>
<table>
  <tr>
    <td><input type="checkbox" name="boxScience8[]" value='catastrophe'>Catastrophe naturelles</td>
    <td><input type="checkbox" name="boxScience8[]" value='ethnologie'>Ethnologie</td>
    <td><input type="checkbox" name="boxScience8[]" value='geographie'>Géographie, géodésie (voyages scientifiques d’exploration, expéditions)</td>
    <td><input type="checkbox" name="boxScience8[]" value='geologie'>Géologie / Minéralogie</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxScience8[]" value='meteorologie'>Météorologie (ex : inondations)</td>
    <td><input type="checkbox" name="boxScience8[]" value='oceanologie'>Océanographie </td>
  </tr>
</table>
<label>Sociabilités scientifiques </label><br/>
<table>
  <td><input type="checkbox" name="boxScience9[]" value='mondeSavant'>Monde savant, communauté scientifique (académies, sociétés savantes, université)</td>
  <td><input type="checkbox" name="boxScience9[]" value='spectacles'>Spectacles scientifiques (expositions universelles, conférences et démonstrations publiques) </td>
</table>
<label>Transports</label><br/>
<table>
  <td><input type="checkbox" name="boxScience10[]" value='aerostats'>Aérostats, appareils aériens</td>
  <td><input type="checkbox" name="boxScience10[]" value='transportMaritime'>Transport maritime (bateaux à vapeur, sous-marins…)</td>
  <td><input type="checkbox" name="boxScience10[]" value='transportSouterrain'>Transport souterrain (métro…)</td>
  <td><input type="checkbox" name="boxScience10[]" value='transportTerrestre'>Transport terrestre (automobiles, chemin de fer…)</td>
</table>

<br/>

<h4>Références à des éléments scientifiques réels</h4>
<label>Théorie ou invention</label><br/>
<input type="textarea" name="theorie" /><br/>
<label>Personnalité scientifique</label><br/>
<input type="textarea" name="personaliteScientifique" /><br/>
<label>Discipline</label><br/>
<table>
  <tr>
    <td><input type="checkbox" name="boxScience11[]" value='scienceVie'>Sciences de la vie (inclut biologie, botanique, zoologie)</td>
    <td><input type="checkbox" name="boxScience11[]" value='scienceMedicale'>Sciences médicales</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxScience11[]" value='scienceTerre'>Sciences de la terre et de l’espace (astronomie, géologie, géographie)</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="boxScience11[]" value='sciencePhysique'>Physique, chimie et mathématiques</td>
    <td><input type="checkbox" name="boxScience11[]" value='ingenieurie'>Ingénierie et technique</td>
    <td><input type="checkbox" name="boxScience11[]" value='autree'>Autre</td>
  </tr>
</table>
<label>Modalité</label><br/>
<table>
  <td><input type="checkbox" name="boxScience12[]" value='serieux'>Sérieux</td>
  <td><input type="checkbox" name="boxScience12[]" value='satire'>Satire</td>
  <td><input type="checkbox" name="boxScience12[]" value='hommage'>Hommage</td>
  <td><input type="checkbox" name="boxScience12[]" value='refutation'>Réfutation</td>
</table>
<h4>Références à des éléments scientifiques imaginaires</h4>
<label>Termes utilisés dans la description</label><br/>
<input type="textarea" name="termeDescription" /><br/>
<label>Domaine des inventions techniques</label><br/>
<select name="inventionsTechniques" />
  <option class="text-left" value="null" selected>--- Sélectionnez un élément de la liste---</option>
  <option value="258">Armes</option>
  <option value="259">Communications, image/son</option>
  <option value="250">Corps humain, pouvoirs psychiques, vie/mort</option>
  <option value="254">Espace</option>
  <option value="251">Formes de vie inconnue</option>
  <option value="252">Modifications de la nature</option>
  <option value="256">Sources d'énergie</option>
  <option value="253">Temps</option>
  <option value="260">Théories scientifiques</option>
  <option value="257">Transports</option>
  <option value="255">Vie quotidienne</option>
</select>
<label>Voyage(s)</label><br/>
<select name="voyages" />
  <option class="text-left" value="null" selected>--- Sélectionnez un élément de la liste---</option>
  <option value="81">Sur la Terre</option>
  <option value="82">À l'intérieur de la Terre</option>
  <option value="83">Dans l'espace</option>
  <option value="84">Sur une autre planète</option>
  <option value="85">Rêvé (par le personnage)</option>
  <option value="86">Temporel</option>
  <option value="87">À l’intérieur du corps humain</option>
  <option value="223">Mondes parallèles et autres dimensions</option>
<option value="88">Aucun</option>
</select>

<h4>Représentation de la société</h4>

<label>Représentation d'une société imaginaire</label><br/>  <!--IL FAUT VOIR COMMENT CA MARCHE DANS LA BDD-->
<table>
  <td><input type="checkbox" name="boxScience13[]" value='presentTemp'>Présente</td>
  <td><input type="checkbox" name="boxScience13[]" value='absentTemp'>Absente</td>
  <td><input type="checkbox" name="boxScience13[]" value='plusieursTemp'>Plusieurs</td>
</table>
<label>Degré de technologie</label><br/>
<table>
  <td><input type="checkbox" name="boxScience14[]" value='fortDegre'>Fort</td>
  <td><input type="checkbox" name="boxScience14[]" value='neutreDegre'>Neutre</td>
  <td><input type="checkbox" name="boxScience14[]" value='faibleDegre'>Faible</td>
  <td><input type="checkbox" name="boxScience14[]" value='indetermiteDegre'>Indéterminé</td>
</table>
<label>Valeur</label><br/>
<table>
  <td><input type="checkbox" name="boxScience15[]" value='positifValeur'>Positive</td>
  <td><input type="checkbox" name="boxScience15[]" value='negatifValeur'>Négative</td>
  <td><input type="checkbox" name="boxScience15[]" value='neutreValeur'>Neutre</td>
  <td><input type="checkbox" name="boxScience15[]" value='ambivalenteValeur'>Ambivalente</td>
  <td><input type="checkbox" name="boxScience15[]" value='indetermineValeur'>Indéterminée</td>
</table>
<label>Traits spécifiques de la société imaginaire</label><br/>
<select name='selectSoc'>
 <option value="null" selected>--- Sélectionnez un élément de la liste---</option>
 <option value="39">Anarchisme</option>
 <option value="37">Aristocratie</option>
 <option value="38">Démocratie</option>
 <option value="34">Dictature</option>
 <option value="35">Monarchie</option>
 <option value="36">Ploutocratie</option>
 <option value="33">Politique</option>
 <option value="205">République</option>
 <option value="204">Révolution</option>
 <option value="43">Capitalisme</option>
 <option value="40">Économie</option>
 <option value="42">Marxisme</option>
 <option value="41">Socialisme</option>
 <option value="245">Géopolitique</option>
 <option value="44">Guerre</option>
 <option value="45">Religion</option>
 <option value="50">Positivisme</option>
 <option value="53">Agriculture</option>
 <option value="54">Commerce</option>
 <option value="52">Écologie</option>
 <option value="55">Justice</option>
 <option value="186">Presse</option>
 <option value="213">habitat</option>
 <option value="56">Industrie</option>
 <option value="175">Langues</option>
 <option value="58">Moyens de communication</option>
 <option value="57">Transport</option>
 <option value="59">Urbanisme</option>
 <option value="63">Musique</option>
 <option value="62">Peinture</option>
 <option value="60">Poésie/littérature</option>
 <option value="61">Sculpture</option>
 <option value="68">Alimentation</option>
 <option value="192">Climat</option>
 <option value="64">Éducation</option>
 <option value="67">Famille</option>
 <option value="69">Habillement</option>
 <option value="72">Loisirs</option>
 <option value="66">Mariage</option>
 <option value="70">Mort</option>
 <option value="71">Santé</option>
 <option value="65">Sexualité</option>
 <option value="75">Classes sociales</option>
 <option value="74">Colonialisme</option>
 <option value="78">Handicap</option>
 <option value="73">Place des femmes</option>
 <option value="76">Races</option>
 <option value="77">Vieillesse</option>
 <option value="188">Animaux</option>
 <option value="248">Science</option>
</select>
</fieldset>
    <div><input type='submit' value='Submit' /></div>
</form>

<!-- where the response will be displayed -->
<div id='response'></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js "></script>
<script>
$(document).ready(function(){
    $('#userForm').submit(function(){

        // show that something is loading
        $('#response').html("<b>Loading response...</b>");

        /*
         * 'post_receiver.php' - where you will pass the form data
         * $(this).serialize() - to easily read form data
         * function(data){... - data contains the response from post_receiver.php
         */
        $.ajax({
            type: 'POST',
            url: 'searchBase.php',
            data: $(this).serialize()
        })
        .done(function(data){

            // show the response
            $('#response').html(data);

        })
        .fail(function() {

            // just in case posting your form failed
            alert( "Posting failed." );

        });

        // to prevent refreshing the whole page page
        return false;

    });
});
</script>

</body>
</html>