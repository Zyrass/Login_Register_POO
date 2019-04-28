<?php 
	
	// inclusion du header
	include 'partials/_head.php';

	// inclusion de ma classe USER qui devrait être inclut dans le model.
	include 'App/classes/User.class.php';

	// Méthode statique permettant de vérifier si nous ne sommes pas connecté, et donc nous devons rediriger vers la page login.php
	Session::checkSession();

	// Création d'une nouvelle instance de la classe 'User'
	$user = new User();
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
	                <th width="20%"> Name </th>
	                <th width="20%"> Username </th>
	                <th width="20%"> Email Address </th>
	                <th width="20%"> Action </th>
	            </thead>
	            
	            <tbody>

					<tr>
						<th>1</th>
						<td>TOTO-TOTO</td>
						<td>Toto</td>
						<td>toto.@outlook.fr</td>
						<td><a href="profile.php?id=1" class="btn btn-outline-primary">View</a></td>
					</tr>
	            	
	            	<tr>
						<th>2</th>
						<td>TATA-TATA</td>
						<td>Tata</td>
						<td>tata@outlook.fr</td>
						<td><a href="profile.php?id=2" class="btn btn-outline-primary">View</a></td>
					</tr>
	            	
	            	<tr>
						<th>3</th>
						<td>TITI-TITI</td>
						<td>Titi</td>
						<td>titi@outlook.fr</td>
						<td><a href="profile.php?id=3" class="btn btn-outline-primary">View</a></td>
					</tr>

	            	<tr>
						<th>4</th>
						<td>TUTU-TUTU</td>
						<td>Tutu</td>
						<td>tutu@outlook.fr</td>
						<td><a href="profile.php?id=4" class="btn btn-outline-primary">View</a></td>
					</tr>	

	            </tbody>
			</table>
		</div> <!-- End card-body -->
	</div> <!-- End card -->

</div>

<?php 
	
	// inclusion du footer
	include 'partials/_footer.php';
?>