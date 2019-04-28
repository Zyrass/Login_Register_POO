<?php

include_once 'Session.classe.php';
include 'Database.class.php';

class User {

	private $db;

	// ----------------------------------------------------------------------------------------------------------------------------

	public function  __construct() {
		
		$this->db = new Database;
	}

	// ----------------------------------------------------------------------------------------------------------------------------

	/**
	 * [userRegistration Méthode permettant de faire toutes les vérifications nécessaire lors d'un nouvel enregistrement]
	 * @param  [type array] $data_post [Coorespond à la super globale $_POST]
	 * @return [type string]           [Retourne un message d'erreur contenu dans une alerte]
	 */
	public function userRegistration($data_post) {

		$name 		= $data_post['name'];
		$pseudo 	= $data_post['pseudo'];
		$email 		= $data_post['email'];
		$password 	= password_hash($data_post['password'], PASSWORD_DEFAULT);

		// Initialisation de la méthode emailCheck qui permet de vérifier si le mail existe ou pas.
		$check_email = $this->emailCheck($email);

		// NAME CONDITION
		if ($name == "" OR $email == "" OR $password == "") {

			$message = "<div class='alert alert-danger'><strong>Erreur,</strong> tous les champs ne doivent pas être vide!</div>";
			return $message;

		}

		// PSEUDO CONDITION
		if (strlen($pseudo) > 0 AND strlen($pseudo) < 5) {

			$message = "<div class='alert alert-danger'><strong>Erreur,</strong> le champ pseudo est trop court!</div>";
			return $message;

		} elseif ($pseudo == "") {

			$message = "<div class='alert alert-danger'><strong>Erreur,</strong> le champ pseudo ne peut-être vide...</div>";
			return $message;

		} elseif (preg_match('/[^a-z0-9_-]+$i/', $pseudo)) {

			$message = "<div class='alert alert-danger'><strong>Erreur,</strong> les caractères possible sont uniquement des alphas du numérique et le tirt ' - ' du 6 sur un clavier AZERTY.</div>";
			return $message;

		}
		
		// EMAIL CONDITION
		if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {

			$message = "<div class='alert alert-danger'><strong>Erreur,</strong> l'email saisit n'est pas valide...</div>";
			return $message;

		}

		// VERIFICATION DES EMAILS
		if ($check_email == true) {

			$message = "<div class='alert alert-danger'><strong>Erreur,</strong> l'email saisit existe déjà dans la base de donnée...</div>";
			return $message;

		}

		// SI TOUTES LES VERIFICATIONS SONT CONCLUENTE, ON AJOUTE DANS LA BDD LES DATA DE L'UTILISATEUR
		$sql = "INSERT INTO users (name, pseudo, email, password) VALUES (:name, :pseudo, :email, :password)";

		$requete = $this->db->pdo->prepare($sql);
		$requete->bindValue(':name', $name, PDO::PARAM_STR);
		$requete->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
		$requete->bindValue(':email', $email, PDO::PARAM_STR);
		$requete->bindValue(':password', $password, PDO::PARAM_STR);

		$result = $requete->execute();

		if ($result) {

			$message = "<div class='alert alert-success'><strong>félicitation,</strong> vos données ont bien été envoyé au serveur.</div>";
			return $message;

		} else {

			$message = "<div class='alert alert-danger'><strong>Error,</strong> Un soucis à été rencontré lors de l'insertion de vos données...</div>";
			return $message;

		}

	} // Fin méthode userRegistration()

	// ----------------------------------------------------------------------------------------------------------------------------

	/**
	 * [emailCheck Méthode permettant de récupérer les emails de la table users afin de savoir si elle existe ou non]
	 * [emailCheck est initialisé dans la méthode userRegistration()]
	 * @param  [type array] 	$email 		[Correspond à la variable $_POST['email'] contenu dans la méthode userRegistration()]
	 * @return [type boolean]        		[Renvoie 'true' si une ligne existe ou 'false' le cas contraire]
	 */
	public function emailCheck($email) {

		// Requête SQL
		$sql = 'SELECT email FROM users WHERE email = :email';

		// Méthode preprare avec un paramètre nommé :email
		$requete = $this->db->pdo->prepare($sql);
		$requete->bindValue(':email', $email, PDO::PARAM_STR);
		$requete->execute();

		// Condition permettant de définir si nous disposons d'une ligne au minimum
		if ($requete->rowCount() > 0) {			
			return true;
		} else {
			return false;
		}

	} // Fin méthode emailCheck()

	// ----------------------------------------------------------------------------------------------------------------------------

} // Fin class USER
