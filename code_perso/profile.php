<?php 
    
    // inclusion du header
    include 'partials/_head.php';

    // inclusion de ma classe USER qui devrait être inclut dans le model.
    include 'App/classes/User.class.php';

    // Méthode statique permettant de vérifier si nous ne sommes pas connecté, et donc nous devons rediriger vers la page login.php
    Session::checkSession();
?>


<?php 

    if (isset($_GET['id'])) {
        
        $userId = (int)$_GET['id'];

    }

    $user = new User();

    // Condition permettant de vérifier que nous utilisons bien la méthode post et on s'assure qu'elle existe via notre button de type submit avec comme nom 'login'
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
        
        // méthode utilisé dans la class USER qui permet de vérifier le contenu de ma superglobal POST
        $userUpdate = $user->userUpdate($userId, $_POST);

    }

?>

<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>User Profile  <span class="float-lg-right"><a class="btn btn-outline-info" href="index.php">Back </a></span></h2>
        </div> <!-- End card-header -->

        <div class="card-body">
            <div style="max-width: 600px; margin: 0 auto">

            <?php 

                if (isset($userUpdate)) {

                    echo $userUpdate;

                }

            ?>


            <?php 

                $userData = $user->getUserById($userId);

                if ($userData) : ?>
                         
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?= $userData->name ?>">
                        </div>

                        <div class="form-group">
                            <label for="pseudo">Pseudo</label>
                            <input type="text" id="pseudo" name="pseudo" class="form-control" value="<?= $userData->pseudo ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= $userData->email ?>">
                        </div>

                        <?php 

                            $sessionId = Session::get('id');

                            if ($userId == $sessionId) : ?>
                                
                                <button type="submit" name="update" class="btn btn-outline-success">Update your data</button>

                            <?php endif 

                        ?>

                    </form>

                <?php endif

            ?>
            
            </div> <!-- End style -->
        </div> <!-- End card-body -->
    </div> <!-- End card-default -->

</div>
<?php 
    
    // inclusion du footer
    include 'partials/_footer.php';
?>