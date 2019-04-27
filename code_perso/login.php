<?php 
	
	// inclusion du header
	include 'partials/_head.php';
?>


<div class="card">
	<div class="card-header">
		<h2>User Login </h2>
	</div> <!-- End card-header -->

	<div class="card-body">
		<div style="max-width: 600px; margin: 0 auto">

			// PHP A VENIR

			<form action="" method="POST">

				<div class="form-group">
					<label for="email"> Email Address </label>
					<input type="text" id="email" name="email" class="form-control" />
				</div> <!-- End form-group -->
				<div class="form-group">
					<label for="password"> Password </label>
					<input type="password" id="password" name="password" class="form-control"/>
				</div> <!-- End form-group -->
				<button type="submit" name="login" class="btn btn-success"> Login</button>
			</form>
		</div> <!-- End style... -->
	</div> <!-- End card-body -->
</div> <!-- End card -->

<?php 
	
	// inclusion du footer
	include 'partials/_footer.php';
?>