<?php
	class Model{
		private $bdd;
		private static $instance= NULL;


		private function __construct(){
			try {
				$this->bdd = new PDO('mysql:host=localhost;dbname=anticipation;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
	//			echo '<h3> Connexion Reussi à la Base </h3>';
			}
			catch (Exception $e) {
		        die('<p> La connexion à echoué : '. $e->getCode() .', ' . $e->getMessage() .'</p>');
			}
		}

		public static function get_model(){
			if(is_null(self::$instance)) self::$instance= new Model();
			return self::$instance;
		}

		/*
			return le nombre de oeuvress
		*/
		public function getNbOeuvre(){
			$sql= 'SELECT COUNT(*) AS nbOeuvre FROM oeuvres';
			$req= $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
			$res= $req->fetch();
			$nbOeuvre= $res['nbOeuvre'];
			$req->closeCursor();
			return $nbOeuvre;
		}

		public function getNbDateNull(){
			$sql= 'SELECT COUNT(*) AS nbDateNull FROM oeuvres WHERE anneePE is null';
			$req= $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
			$res= $req->fetch();
			$nbOeuvre= $res['nbDateNull'];
			$req->closeCursor();
			return $nbOeuvre;
		}

		/*
			return les date min et max
		*/
		public function getNbAnnee(){
			$sql= 'SELECT MIN(anneePE) as dateMin, MAX(anneePE) as dateMax from oeuvres WHERE anneePE!=""';
			$req= $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
			$res= $req->fetch();
			$req->closeCursor();
			return $res;
		}

		public function getNbPublicationsPeriodes($anneeD, $anneeF){
			$sql= 'SELECT COUNT(*) as nbOeuvre FROM `oeuvres` WHERE anneePE BETWEEN :anneeD AND :anneeF';
			$req= $this->bdd->prepare($sql) or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				':anneeD' => htmlspecialchars($anneeD),
				':anneeF' => htmlspecialchars($anneeF)
			));
			$res= $req->fetch();
			$nbOeuvre= $res['nbOeuvre'];
			$req->closeCursor();
			return $nbOeuvre;
		}


		/*			REQUETE PLOTLY 2		*/

		public function getListesAnnesTrad(){
			$sql= 'SELECT dDate as annee from traductions ORDER BY dDate';
			$req= $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
			$res= $req->fetchALL();
			$req->closeCursor();
			return $res;
		}

		public function getNbTrad($annee){
			$sql= 'SELECT COUNT(*) as nbTrad FROM traductions WHERE dDate = :annee';
			$req= $this->bdd->prepare($sql) or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				':annee' => htmlspecialchars($annee),
			));
			$res= $req->fetch();
			$nbOeuvre= $res['nbTrad'];
			$req->closeCursor();
			return $nbOeuvre;
		}

		public function getListesOeuvreAdaptee(){
			$sql= 'SELECT DISTINCT titrePE FROM adaptations INNER JOIN oeuvres on adaptations.idOeuvre = oeuvres.idOeuvre ORDER BY anneePE ASC';
			$req= $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
			$res= $req->fetchALL();
			$req->closeCursor();
			return $res;
		}

		public function getNbAdaptations($titre){
			$sql= 'SELECT COUNT(*) as nbAdapation FROM adaptations WHERE idOeuvre in (SELECT idOeuvre from oeuvres WHERE titrePE = :titre)';
			$req= $this->bdd->prepare($sql) or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				':titre' => htmlspecialchars($titre),
			));
			$res= $req->fetch();
			$nbOeuvre= $res['nbAdapation'];
			$req->closeCursor();
			return $nbOeuvre;
		}
		
		public function getNbOeuvreWithAuteur(){
			$sql= 'SELECT auteurNom as x, count(*) as y from oeuvres where auteurFiche != "" group by auteurFiche ';
			$req= $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
			$res= $req->fetchALL();
			$req->closeCursor();
			return $res;
		}

		/*		FIN	REQUETE PLOTLY 2		*/


		/* nuages */

		public function getAuteurNom(){
			$sql= 'SELECT auteurNom FROM oeuvres';
			$req= $this->bdd->query($sql) or die(print_r($bdd->errorInfo()));
			$res= $req->fetchALL();
			$req->closeCursor();
			return $res;
		}


	}

?>


 
