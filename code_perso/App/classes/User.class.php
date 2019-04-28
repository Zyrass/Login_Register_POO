<?php

include_once 'Session.class.php';
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

		$name 			= $data_post['name'];
		$pseudo 		= $data_post['pseudo'];
		$email 			= $data_post['email'];
		$password 		= md5($data_post['password']);

		// Initialisation de la méthode emailCheck qui permet de vérifier si le mail existe ou pas.
		$check_email = $this->emailCheck($email);

		// CONDITION POUR TOUT LES CHAMPS
		if ($name == "" OR $email == "" OR $password == "") {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Erreur,</strong> tous les champs ne doivent pas être vide!
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
  			';
			return $message;

		}

		// PSEUDO CONDITION
		if (strlen($pseudo) > 0 AND strlen($pseudo) <= 5) {

			$message = '
				<div class="alert alert-info alert-dismissible fade show">
					<strong>Erreur,</strong> le champ pseudo est trop court!
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		} elseif ($pseudo == "") {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Erreur,</strong> le champ pseudo ne peut-être vide...
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		} elseif (preg_match('/[^a-z0-9_-]+$i/', $pseudo)) {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Erreur,</strong> les caractères possible sont uniquement des alphas du numérique et le tirt " - " du 6 sur un clavier AZERTY.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		}

		// EMAIL CONDITION
		if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Erreur,</strong> l\'email saisit n\'est pas valide...
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		}

		// VERIFICATION DES EMAILS
		if ($check_email == true) {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Erreur,</strong> l\'email saisit existe déjà dans la base de donnée...
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
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

		// Condition permettant d'afficher un résultat de succès lors de la soumission de vos informations.
		if ($result) {

			$message = '
				<div class="alert alert-success alert-dismissible fade show">
					<strong>félicitation,</strong> vos données ont bien été envoyé au serveur.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		} else {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Error,</strong> Un soucis à été rencontré lors de l\'insertion de vos données...
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
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
	
	/**
	 * [getLoginUser Méthode permettant de récupérer l'intégralité des champs de la table "users"]
	 * @param  [type string] $email    [E-mail de l'utilisateur]
	 * @param  [type string] $password [Password de l'utilisateur]
	 * @return [type variable]         [Retourne le résultat de la requête SQL exécuté]
	 */
	public function getLoginUser($email, $password) {

		// Requête SQL
		$sql = 'SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1';

		// Méthode preprare avec un paramètre nommé :email
		$requete = $this->db->pdo->prepare($sql);
		$requete->bindValue(':email', $email, PDO::PARAM_STR);
		$requete->bindValue(':password', $password, PDO::PARAM_STR);
		$requete->execute();

		$result = $requete->fetch();

		return $result;

	} // Fin getLoginUser()

	// ----------------------------------------------------------------------------------------------------------------------------

	/**
	 * [userLogin Méthode permettant de controller l'email et le password saisit par l'utilisateur.]
	 * @param  [type string] $data_post [E-mail récupéré via la superglobal POST]
	 * @return [type]            [description]
	 */
	public function userLogin($data_post) {

		$email 			= $data_post['email'];
		$password 		= md5($data_post['password']);

		// Initialisation de la méthode emailCheck qui permet de vérifier si le mail existe ou pas.
		$check_email = $this->emailCheck($email);

		// CONDITION POUR TOUT LES CHAMPS
		if ($email == "" OR $password == "") {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Erreur,</strong> tous les champs ne doivent pas être vide!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		}

		// EMAIL CONDITION
		if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Erreur,</strong> veuillez saisir un email valide...
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		}

		// VERIFICATION DE L'EMAIL SI IL EXISTE DANS LA BASE DE DONNEE
		if ($check_email == false) {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Erreur,</strong> votre adresse E-mail est déjà existant dans la base de donnée...
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		}

		// Via la méthode getLoginUser, nous récupérons tous les champs.
		$result = $this->getLoginUser($email, $password);

		// Condition permettant d'initialiser les SESSIONS si le retour de la méthode getLoginUser est valide
		if ($result) {
			
			Session::initSession();
			Session::set("login", true);
			Session::set("id", $result->id); // POUR FETCH_ASSOC -> Session::set("id", $result['id']);
			Session::set("name", $result->name); // POUR FETCH_ASSOC -> Session::set("name", $result['name']);
			Session::set("pseudo", $result->pseudo); // POUR FETCH_ASSOC -> Session::set("pseudo", $result['pseudo']);
			Session::set("email", $result->email); // POUR FETCH_ASSOC -> Session::set("email", $result['email']);
			Session::set("loginMessage", '
				<div class="alert alert-success alert-dismissible fade show">
					<strong>Félicitation,</strong> vous êtes connecté!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close>
	    				<span aria-hidden="true">&times;</span>
	  				</button>
	  			</div>
	  		');

			header("Location:index.php");

		} else {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Désolé,</strong> aucun utilisateur n\'a été trouvé dans notre base de donnée...
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		}

	} // Fin userLogin()



	public function getUserData() {

		// Requête SQL
		$sql = 'SELECT * FROM users ORDER BY id DESC';

		// Méthode preprare avec un paramètre nommé :email
		$requete = $this->db->pdo->prepare($sql);
		$requete->execute();

		$result = $requete->fetchAll();

		return $result;

	}


	public function getUserById($id) {

		// Requête SQL
		$sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';

		// Méthode preprare avec un paramètre nommé :email
		$requete = $this->db->pdo->prepare($sql);
		$requete->bindValue(':id', $id, PDO::PARAM_INT);
		$requete->execute();

		$result = $requete->fetch();

		return $result;

	}


	public function userUpdate($userId, $data_post) {

		$name 			= $data_post['name'];
		$pseudo 		= $data_post['pseudo'];
		$email 			= $data_post['email'];

		// Initialisation de la méthode emailCheck qui permet de vérifier si le mail existe ou pas.
		$check_email = $this->emailCheck($email);

		// CONDITION POUR TOUT LES CHAMPS
		if ($name == "" OR $pseudo == "" OR $email == "") {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Erreur,</strong> tous les champs ne doivent pas être vide!
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
  			';
			return $message;

		}

		// SI TOUTES LES VERIFICATIONS SONT CONCLUENTE, ON AJOUTE DANS LA BDD LES DATA DE L'UTILISATEUR
		$sql = "UPDATE users set name = :name, pseudo = :pseudo, email = :email WHERE id = :id";

		$requete = $this->db->pdo->prepare($sql);
		$requete->bindValue(':name', $name, PDO::PARAM_STR);
		$requete->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
		$requete->bindValue(':email', $email, PDO::PARAM_STR);
		$requete->bindValue(':id', $userId);

		$result = $requete->execute();

		// Condition permettant d'afficher un résultat de succès lors de la soumission de vos informations.
		if ($result) {

			$message = '
				<div class="alert alert-success alert-dismissible fade show">
					<strong>félicitation,</strong> mise à jour réussie des données utilisateur.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		} else {

			$message = '
				<div class="alert alert-danger alert-dismissible fade show">
					<strong>Error,</strong> Un soucis à été rencontré lors de la mise à jour de vos données...
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    				<span aria-hidden="true">&times;</span>
	  				</button>
				</div>
			';
			return $message;

		}

	} // Fin méthode userRegistration()

} // Fin class USER
