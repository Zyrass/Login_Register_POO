<?php

class Session {

	/**
	 * [initSession Méthode statique permettant de démarrer une session selon le type de version de php utilisé]
	 * @return [type function] [Retourne en résultat un session_start()]
	 */
	public static function initSession() {

		// Condition permettant de savoir si la version est supérieur ou égale à la 7.1.0
		if (version_compare(phpversion(), '7.1.0', '>=')) {
			
			// Si la session est vide on la démarre
			if (session_id() == '') {	

				session_start();

			} else {

				// session_status 	-> 	est utilisée pour connaitre l'état de la session courante.
				// PHP_SESSION_NONE -> 	si les sessions sont activées, mais qu'aucune n'existe.
				if (session_status() == PHP_SESSION_NONE) {
					
					session_start();

				}

			} // Fin session_id()

		} // Fin version_compare(...)

	} // Fin initSession()

	
	/**
	 * [set Setter permettant d'édter la SESSION]
	 * @param [type array] $key [$key correspond à l'indice du tableau SESSION.]
	 * @param [type int / string] $value [retourne la valeur correspondante à l'indice]
	 */
	public static function set($key, $value) {

		$_SESSION[$key] = $value;

	} // Fin Set()

	/**
	 * [get getter permettant de récupérer l'indice de la SESSION]
	 * @param  [type string] $key [Chaine de caractère représentant le nom de l'indice]
	 * @return [type string]      [Retourne le nom donné à l'indice du tableau SESSION]
	 */
	public static function get($key) {

		// Condition permettant de savoir si il existe un indice dans mon tableau SESSION
		if (isset($_SESSION[$key])) {
			
			return $_SESSION[$key];

		} else {

			return false;

		} 

	} // Fin get()


	/**
	 * [checkSession Méthode permettant de vérifier l'existance d'une Session.]
	 * @return [type] [retourne une redirection vers la page login.php si la condition de la méthode get('login') renvoie false]
	 */
	public static function checkSession() {

		if (self::get('login') == false) {
			
			self::destroy();
			header("Location: login.php");
		}

	} // Fin checkSession()

	/**
	 * [checkLogin Méthode permettant de vérifier l'existance d'un Login.]
	 * @return [type] [retourne une redirection vers la page index.php si la condition de la méthode get('login') renvoie true]
	 */
	public static function checkLogin() {

		if (self::get('login') == true) {
			
			header("Location: index.php");
		}

	} // Fin checkLogin()

	/**
	 * [destroy Méthode permettante de détruire la session]
	 * @return [type] [Retourne une redirection vers la page login.php]
	 */
	public static function destroy() {

		session_destroy();
		session_unset();

		header("Location: login.php");

	} // Fin destroy()

}
