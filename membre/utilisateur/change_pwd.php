<?php 
    session_start();
    require_once '../../config.php'; // ajout connexion bdd 
   // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:../../index.php');
        die();
    }

    // On récupere les données de l'utilisateur
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();

    if($data['active'] == 1){
        header('Location: ../../index.php');
        die();

        }

?>

<!DOCTYPE html>
    <html lang="en">
        <head>
	    <link rel="icon" href="../../globe.ico" />
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="Orion_XVIII"/>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            <title>Change your password</title>
        </head>
        <body>
            <div class="login-form">
                <form action="layouts/change_password.php" method="POST">
                    <label class="text-center" for='current_password'>Current password</label>
                    <div class="form-group">
                        <input type="password" id="current_password" name="current_password" class="form-control" required/>
                    <br />
                    <label class="text-center" for='new_password'>New password</label>
                    <div class="form-group">
                        <input type="password" id="new_password" name="new_password" class="form-control" required/>
                    <br />
                    <label class="text-center" for='new_password_retype'>Re-type new password</label>
                    <div class="form-group">
                        <input type="password" id="new_password_retype" name="new_password_retype" class="form-control" required/>
                    <br />
                    <div class="form-group">
                    <button type="submit" class="btn btn-success">Save</button>
		    <button type="button" class="btn btn-danger" onclick="document.location='../dashboard/dashboard_membre.php'">Cancel</button>
                </div>
            </div>
        </div>
    </div>


        <style>
            .login-form {
                width: 340px;
                margin: 50px auto;
            }
            .login-form form {
                margin-bottom: 15px;
                background: #f7f7f7;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }
            .login-form h2 {
                margin: 0 0 15px;
            }
            .form-control, .btn {
                min-height: 38px;
                border-radius: 2px;
            }
            .btn {        
                font-size: 15px;
                font-weight: bold;
            }
        </style>
            </form>
        </body>
</html>

