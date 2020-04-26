<?php
class Model{
	private $bdd;
	private static $instance= NULL;

	private function __construct(){
		try {
			require_once 'creds.php'; // Login, mot de passe a changer au besoin
			$this->bdd = new PDO($dsn, $user, $pass,
			array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
		} catch (Exception $e) {
			die('<p> La connexion à echoué : '. $e->getCode() .', ' . $e->getMessage() .'</p>');
		}
	}

	public static function getModel(){
		if(is_null(self::$instance)) self::$instance= new Model();
		return self::$instance;
	}

	/**
	 * Donnée un tableau avec des propriétés, 
	 * construire une requète adaptée à un graphe.
	 * @param p Liste de propriétés:
	 * - quel type de données?
	 * - comment ordonner? (ascendant/descendant)
	 */
	public function graphBar($p) { 
		// Un grapheBar est fait selon une propriété.
		$type_x = $p['type_x'];
		$sql =
'SELECT '.$type_x.' as x, count(*) as y 
from oeuvres
group by '.$type_x.
' order by y';

		if (isset($p['order']) and $p['order'] === 'desc') {
			$sql .= ' desc'; // Mettre dans l'ordre descendant
		}
		return $this->executeGraphBar($sql);
	}

	/**
	 * Execute une requête préparee.
	 * @param sql Requête préparée par une fonction de génération de graph.
	 */
	public function executeGraphBar($sql) {
		$req = $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
		$result = $req->fetchAll();
		$req->closeCursor();
		return $result;
	}

	public function getAllAuteurNbFiche() {
		$sql = 
'SELECT auteurFiche as x, count(*) as y
from oeuvres 
where auteurFiche != ""
group by auteurFiche
order by y desc;
		';
		$req = $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
		$result = $req->fetchAll();
		$req->closeCursor();
		return $result;
	}

	public function getAllAnneeNbOeuvres() {
		$sql = 
'SELECT anneePE as x, count(*) as y
from oeuvres 
group by anneePE
order by anneePE asc;
		';
		$req = $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
		$result = $req->fetchAll();
		$req->closeCursor();
		return $result;
	}
}
?>