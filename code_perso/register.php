<?php 
	
	// inclusion du header
	include 'partials/_head.php';

	// inclusion de ma classe USER qui devrait être inclut dans le model.
	include 'App/classes/User.class.php';
?>


<?php 
	
	// Ce contrôle sur cette page devrait se trouver dans le controller...
	$user = new User();

	// Condition permettant de vérifier que nous utilisons bien la méthode post et on s'assure qu'elle existe via notre button de type submit avec comme nom 'register'
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
		
		// méthode utilisé dans la class USER qui permet de vérifier le contenu de ma superglobal POST
		$userRegister = $user->userRegistration($_POST);

	}

?>

<div class="card">
	<div class="card-header">
		<h2>User Registration </h2>
	</div> <!-- End card-header -->

	<div class="card-body">
		<div style="max-width: 600px; margin: 0 auto">
	
			<?php

				// Condition permettant de voir si le(s) message(s) d'erreur(s) existe.
				if (isset($userRegister)) {

					// Si oui, on affiche le message d'erreur adéquat.
					echo $userRegister;

				}

			?>

			<form action="" method="POST">
				<div class="form-group">
					<label for="name"> Your Name </label>
					<input type="text" id="name" name="name" class="form-control"   />
				</div> <!-- End form-group -->
				<div class="form-group">
					<label for="pseudo"> User Name </label>
					<input type="text" id="pseudo" name="pseudo" class="form-control"  />
				</div> <!-- End form-group -->
				<div class="form-group">
					<label for="email"> Email Address </label>
					<input type="text" id="email" name="email" class="form-control"   />
				</div> <!-- End form-group -->
				<div class="form-group">
					<label for="password"> Password </label>
					<input type="password" id="password" name="password" class="form-control"  />
				</div> <!-- End form-group -->
				<button type="submit" name="register" class="btn btn-outline-success"> Submit </button>
			</form>
		</div> <!-- End style -->
	</div> <!-- End card-body -->
</div> <!-- End card -->

<?php 
	
	// inclusion du footer
	include 'partials/_footer.php';
?>