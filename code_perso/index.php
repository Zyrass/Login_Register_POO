<?php 
	
	// inclusion du header
	include 'partials/_head.php';

	// inclusion de ma classe USER qui devrait être inclut dans le model.
	include 'App/classes/User.class.php';

	// Méthode statique permettant de vérifier si nous ne sommes pas connecté, et donc nous devons rediriger vers la page login.php
	Session::checkSession();
?>


<div class="container">

	<?php 
		
		// Via la méthode statique 'get', nous récupérons le message de confirmation comme quoi la connexion a belle et bien été établie.
		$loginMessage = Session::get("loginMessage");

		// Condition permettant de vérifier l'existance de la méthode get précédemment cité.
		if (isset($loginMessage)) {
			
			// Affichage du message.
			echo '<br />' . $loginMessage;

		}
	
	?>
		
	<div class="card">
		<div class="card-header">
			<h2>User List 
				<span class="float-lg-right">Welcome
	                <strong>

	                   <?php 
	                   		// Via la méthode statique 'get', nous récupérons le pseudo.
		                   	$pseudo = Session::get("pseudo");

		                   	// Condition permettant de vérifier l'existance de la méthode get précédemment cité.
		                   	if (isset($pseudo)) {
		                   		
		                   		// Affichage du pseudo
		                   		echo  '<span class="text-info">' . ucfirst($pseudo) . '</span>';

		                   	}

	                   ?>

	                </strong>
				</span>
			</h2>
		</div> <!-- End card-header -->
		<div class="card-body">

			<table class="table table-striped">
	            <thead>
	                <th width="20%"> Serial </th>
	                <th width="20%"> Nom de l'utilisateur </th>
	                <th width="20%"> Pseudo </th>
	                <th width="20%"> Adresse E-mail</th>
	                <th width="20%"> Action </th>
	            </thead>
	            
	            <tbody>
					
					<?php 

						// Création d'une nouvelle instance de la classe 'User'
						$user = new User();

						$userData = $user->getUserData();

						if ($userData) {

							$numero_ligne = 0;
							
							foreach ($userData as $data) : 
								
								$numero_ligne++; ?>

								<tr>
									<th><?= '#'.$numero_ligne ?></th>
									<td><?= $data->name ?></td>
									<td><?= $data->pseudo ?></td>
									<td><?= $data->email ?></td>
									<td><a href="profile.php?id=<?= $data->id ?>" class="btn btn-outline-primary">Voir</a></td>
								</tr>

							<?php endforeach;

						} else { ?>

								<tr>
									<th colspan="5" class="text-center"> <span class="text-danger">Aucun utilisateur inscrit !!</span></th>
								</tr>

						<?php } // Fin condition $userData

					?>				

	            </tbody>
			</table>
		</div> <!-- End card-body -->
	</div> <!-- End card -->

</div>

<?php 
	
	// inclusion du footer
	include 'partials/_footer.php';
?>