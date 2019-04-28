<header>
	<div class="container">
			
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

			<div class="container">

				<a href="index.php" class="navbar-text">à éditer</a>
	  			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    			<span class="navbar-toggler-icon"></span>
	  			</button>

	  			<div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNav">
	    			<ul class="navbar-nav">

	    				<?php 

	    					$id = Session::get("id");

	    					$userLogin = Session::get('login');

	    					// Condition permettant de savoir si nous sommes connecté Si oui nous affichons HOME / Profile / Logout
	    					// Si non nous affichons Register et Login seulement.
	    					if ($userLogin == true) : ?>
	    						
			    				<li class="nav-item active">
							    	<a class="nav-link" href="./index.php">Home</a>
							    </li>
							    <li class="nav-item">
							    	<a class="nav-link" href="./profile.php">Profile</a>
							    </li>
							    <li class="nav-item">
							    	<a class="nav-link" href="?action=logout">Logout</a>
							    </li>

							<?php else : ?>

					    		<li class="nav-item">
							    	<a class="nav-link" href="./register.php">Register</a>
							    </li>
							    <li class="nav-item">
					    			<a class="nav-link" href="./login.php">Login</a>
					    		</li>

					    	<?php endif; 

					    ?>
	    			</ul>
	  			</div>
					
			</div>
		</nav>
	</div>
</header>