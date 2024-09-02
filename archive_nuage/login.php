<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8">
        <title>Connexion</title>
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>

        <?php 

            if ($_SESSION['pseudo']){
                header("Location: profil.php");
                die();
            }

            include("premakes/header.html"); 
            include("connexion.inc.php");
            include("cookies.php");
        ?>
        
        <div id="box">
            <form method ="POST", id='formu'>
                <h1 style = "color : aliceblue">Connexion</h1>
                    <label style = "color : aliceblue"><b>Pseudo</b></label>
                        <input type="text" placeholder="Entrer votre Pseudo" name="username" required>
                    <label style = "color : aliceblue"><b>Mot de passe</b></label>
                        <input type="password" placeholder="Entrer le mot de passe" name="password" required>
                    <input type="submit" name="login">
                <a href="register.php" style = "color : aliceblue">Inscrivez-vous</a>
                <a href="pass_perdu.php" style = "margin-left: 210px; color : aliceblue">Mot de passe oublié ?</a>
            </form>

        <?php

        if (isset( $_POST['login'])){

            $pseudo = $_POST['username'];
            $mdp = hash('sha256',$_POST['password']);
            $result_cnx = "SELECT * FROM joueur WHERE pseudo = '$pseudo' and mdp = '$mdp'";
            $results= $cnx -> query($result_cnx);
            $results->setFetchMode(PDO::FETCH_ASSOC);

            if ($results){
                foreach ($results as $r){

                    if ($r){

                        $_SESSION['pseudo'] = $pseudo;
                        header("Location: profil.php");
                        die();
                    }
                }
            }
        }
        ?>
        </div>
    </body>
</html>