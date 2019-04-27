<?php

class Database {

	private $host_db 	= "localhost";
	private $name_db 	= "db_login";
	private $charset_db = "UTF8";
	private $user_db 	= "zyrass";
	private $pass_db 	= "";

	public $pdo;

	public function  __construct() {
		
		if (!isset($this->pdo)) {
			
			try {

				$link = new PDO("mysql:host=" . $this->host_db . ";dbname=" . $this->name_db . ";charset=". $this->charset_db, $this->user_db, $this->pass_db);

				$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				// $link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				// $link->exec("SET CHARACTER SET utf8");

				$this->pdo = $link;

			} catch(PDOExeption $e) {

				die('Erreur de connexion avec la base de donnée...' . $e->getMessage());

			}

		}

	}

}
