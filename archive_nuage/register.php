<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8">
        <title>Inscription</title>
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>
        
        <?php 
        include("premakes/header.html"); 
        include("connexion.inc.php");
        ?>
          
        <div id="box">
            
            
            <form method ="POST" id="formu">
                <h1 style = "color : aliceblue">Inscription</h1>

                <label style = "color : aliceblue"><b>Pseudo</b></label>
                <input type="text" placeholder="Entrer votre Pseudo" name="pseudo" required>

                <label style = "color : aliceblue"><b>Nom</b></label>
                <input type="text" placeholder="Entrer votre Nom" name="nom" required>

                <label style = "color : aliceblue"><b>Prénom</b></label>
                <input type="text" placeholder="Entrer votre Prénom" name="prenom" required>

                <label style = "color : aliceblue"><b>E-mail</b></label>
                <input type="email" placeholder="Entrer votre E-mail" name="email" required>

                <label style = "color : aliceblue"><br><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer votre Mot de passe" name="password" required>

                <label style = "color : aliceblue"><b>Date de naissance</b></label>
                <input type="date" placeholder="JJ-MM-AAAA" name="d_naissance" required></input>

                <input type="submit" name = "register">

                <a href="login.php" style = "color : aliceblue">Connectez-vous</a>

            </form>

            <?php

            if (isset( $_POST['register'])){
                $pseudo = $_POST['pseudo'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $mdp = hash('sha256',$_POST['password']);
                $d_naissance = $_POST['d_naissance'];

                $result_reg = "INSERT INTO joueur VALUES ('$pseudo', '$mdp', '$nom', '$prenom', '$email', 0, '$d_naissance')";
                $results = $cnx -> exec($result_reg);
                if ($results){
                    echo 'Vous êtes inscrit avec succès !';
                } else
                    echo 'ERREUR';
            }
            ?>
        </div>
    </body>
</html>