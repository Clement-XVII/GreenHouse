<?php 
    session_start(); // Démarrage de la session
    require_once '../config.php'; // On inclut la connexion à la base de données

    if(!empty($_POST['email']) && !empty($_POST['password'])) // Si il existe les champs email, password et qu'il sont pas vident
    {
        // Patch XSS
        $email = htmlspecialchars($_POST['email']); 
        $password = htmlspecialchars($_POST['password']);

        $email = strtolower($email); // email transformé en minuscule

        // On regarde si l'utilisateur est inscrit dans la table utilisateurs
        $check = $bdd->prepare('SELECT pseudo, email, password, token, droit FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();



        // Si > à 0 alors l'utilisateur existe
        if($row > 0)
        {
            // Si le mail est bon niveau format
            if(filter_var($email, FILTER_VALIDATE_EMAIL) or $email == "admin")
            {
         // Si le mot de passe est le bon
                if(password_verify($password, $data['password']))
                {
                    if($email == "admin" or $data['droit'] == 1 ){
                         // On créer la session et on redirige sur landing.php
                        $_SESSION['user'] = $data['token'];
                        $bdd->prepare("UPDATE utilisateurs SET last_activity = NOW() WHERE token = ?")->execute([$data['token']]);
                        header('Location: ../dashboard/index.php');
                        die();
                    }
                    else {
                        // On créer la session et on redirige sur landing_admin.php
                        $_SESSION['user'] = $data['token'];
                        $bdd->prepare("UPDATE utilisateurs SET last_activity = NOW() WHERE token = ?")->execute([$data['token']]);
                        header('Location: ../membre/dashboard/dashboard.php');           //*****************************************************************-----------------------------------------*****************************************
                        die();
                    }
                }
                else //le mot de passe pas bon
                    { 
                        header('Location: ../index.php?login_err=password');
                        die();
                    }
            }
            else // Email pas mauvais format 
                { 
                    header('Location: ../index.php?login_err=email');
                    die();
                }
        }
        else //Utilisateur non creer
            { 
                header('Location: ../index.php?login_err=already');
                die();
            }
    }
    else // si le formulaire est envoyé sans aucune données
    { 
        header('Location: ../index.php'); 
        die();
    }   
?>
