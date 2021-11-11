<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="Orion_XVIII"/>
            <link rel="icon" href="globe.ico" />
            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
            <title>Connexion</title>
        </head>
        <body>

        <div class="login-form">
             <?php
                if(isset($_GET['login_err']))
                {
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {
                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe incorrect
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email incorrect
                            </div>
                        <?php
                        break;

                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> compte non existant
                            </div>
                        <?php
                        break;
                    }
                }
                ?>
                        <div >

                                <h4 class="card-title text-center mb-4 mt-1">Sign in</h4>
                                <form action="/utilisateur/connexion.php" method="post">
                                <div class="form-group">
                                <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                         </div>
                                        <input type="text" name="email" class="form-control" placeholder="Email" required="required" autocomplete="on">
                                </div> <!-- input-group.// -->
                                </div> <!-- form-group// -->
                                <div class="form-group">
                                <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                         </div>
                                    <input type="password" name="password" class="form-control" placeholder="******" required="required" autocomplete="on">
                                </div> <!-- input-group.// -->
                                </div> <!-- form-group// -->
                                <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                                </div> <!-- form-group// -->
                                <p class="text-center"><a href="/utilisateur/inscription.php" class="btn">Inscription</a></p>
                                </form>

                        </div> <!-- card.// -->
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
        </body>
</html>
