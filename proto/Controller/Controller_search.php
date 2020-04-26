<?php
class Controller_search extends Controller{

    /** 
     * Table de hash qui contient toutes les requêtes possibles.
     * On utilisera cette table pour dispatcher les propriétés nécéssaires.
     * Une table pour les bar graph.
     */
    private $table_bar = [
        'auteurFiche' => 
            ['type_x' => 'auteurFiche',
             'title' => "Nombres d'auteurs de fiche par année",
            'order' => 'desc'],
        'oeuvres' => 
            ['type_x' => 'anneePE',
            'title' => "Nombre d'oeuvres par année"],
        'auteur' => 
            ['type_x' => 'auteurNom',
            'title' => "Nombre d'oeuvres par auteur",
            'order' => 'desc'],
    ];

    public function action_search() {
        $this->render('search', []);
    }

    public function action_results() {
        // On récupère uniquement les noms dispo
        $table_bar_noms = array_keys($this->table_bar);
        $type_x = $_GET['g']; // Type de la donnée a mettre en relation

        // Est-ce que le param est dans la table?
        if (! isset($type_x) or ! in_array($type_x, $table_bar_noms)) { 
            $this->action_error(
                'Erreur',
                "Il n'y a pas de graphe pour cette donnée");
        }

        // Choix de la bonne méthode du modèle
        $m = Model::getModel();
        $plist = $this->table_bar[$type_x]; // Liste de propriétés a passer pour changer le comportement
        $json_req = $m->graphBar($plist);

        $this->render('results', [
            // Titre du graphique
           'title' => $plist['title'],
           'json_req' => $json_req
        ]);
    }

    public function action_default() {
        $this->action_search();
    }
}