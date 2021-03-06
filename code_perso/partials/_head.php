<?php 

	$filepath = realpath(dirname(__FILE__));
	
	// inclusion de ma classe USER qui devrait être inclut dans le model.
	include $filepath.'/../App/classes/Session.class.php';

	Session::initSession();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>POO - Register/Login</title>

	<?php 

		// Condition permetant de vérifier si il existe un paramètre GET action passé dans l'url via la déconnexion (logout) 
		if (isset($_GET['action']) && $_GET['action'] == 'logout') {
			
			// Destruction de la session via la méthode statique destroy() de la class SESSION
			Session::destroy();

		}

	?>

	<!-- CSS BOOTSTRAP 4.3.1 -->
	<link rel="stylesheet" href="./vendors/bootstrap/css/bootstrap.min.css">

	<!-- MY CSS -->
	<link rel="stylesheet" href="./assets/styles/css/default.css">
</head>
<body>
	<?php 

		// Include Header
		include '_header.php';
	?>
	<main>