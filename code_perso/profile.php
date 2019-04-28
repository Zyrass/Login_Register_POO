<?php 
    
    // inclusion du header
    include 'partials/_head.php';
?>

<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>User Profile  <span class="float-lg-right"><a class="btn btn-outline-info" href="index.php">Back </a></span></h2>
        </div> <!-- End card-header -->

        <div class="card-body">
            <div style="max-width: 600px; margin: 0 auto">
        
            <form action="" method="post">
                <div class="form-group">
                    <label for="firstname">Your Firstname</label>
                    <input type="text" id="firstname" class="form-control" value="TOTO-TOTO Toto">
                </div>

                <div class="form-group">
                    <label for="lastname">Your Lastname</label>
                    <input type="text" id="lastname" class="form-control" value="toto">
                </div>

                <div class="form-group">
                    <label for="email">Your E-mail</label>
                    <input type="email" id="email" class="form-control" value="TOTO-TOTO Toto">
                </div>

                <button type="submit" name="update" class="btn btn-outline-success">Update your data</button>
            </form>
            
            </div> <!-- End style -->
        </div> <!-- End card-body -->
    </div> <!-- End card-default -->

</div>
<?php 
    
    // inclusion du footer
    include 'partials/_footer.php';
?>