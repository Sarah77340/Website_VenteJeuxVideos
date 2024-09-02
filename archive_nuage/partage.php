<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8">
        <title>Profil</title>
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>


        <?php 
        	include("premakes/header.html"); 
        	include("connexion.inc.php");
        	include("cookies.php");

        	if(!isset($_SESSION['pseudo'])){
        		header("Location: login.php");
                die();
        	}
        ?>

        
    <div id ="boxpro">
		<div id="box-profil">

       		<form method = "POST">
        	
	        	<?php

                if ($results)
                    echo"test";


		        	echo "<h2 style = 'color : aliceblue'>Partage de ".$_GET['jeu']." à ".$_GET['pseudo2']."</h2>";
					echo "<select name='select'>
                          <option selected='selected'>-- O / N --</option>
                          <option value='oui'>Oui</option>
                          <option value='non'>Non</option></select><br>";
	        	?>

	        	<input type='submit' name='modif'>

        	</form>

        	<?php

                $pseudo = $_SESSION['pseudo'];
                $pseudo2 = $_GET['pseudo2'];
                $titre = $_GET['jeu'];

                $result_partage = "SELECT COUNT(*) FROM partager WHERE pseudo = '$pseudo' AND titre = '$titre' AND pseudo_ami = '$pseudo2'";
                $result_partage_2 = "SELECT pseudo_ami FROM partager WHERE pseudo = '$pseudo' AND titre = '$titre'";
                $results = $cnx -> query($result_partage);      
                $results_2 = $cnx -> query($result_partage_2);      
                $results->setFetchMode(PDO::FETCH_ASSOC); 
                $results_2->setFetchMode(PDO::FETCH_ASSOC); 

                $text = "Vous pouvez partager ce jeu avec cet ami.";

                foreach($results as $list){
                    foreach($list as $count){
                        if ($count != 0){
                            $text = "Ce jeu est déjà partagé avec ce joueur";
                            break;
                        }else{
                            foreach($results_2 as $list){
                                foreach($list as $partage){
                                    if ($partage){
                                        $text = "Vous partagez déjà ce jeu avec ".$partage." !";
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                echo $text;

        		if (isset($_POST['modif'])){


                    if ($_POST['select'] == 'oui'){

                        $result_modif = "INSERT INTO partager VALUES ('$pseudo', '$titre', '$pseudo2')";
                        $cnx -> exec($result_modif);
                        header("Location: profil.php");
                        die();
                    }else{
                        $result_modif = "DELETE FROM partager WHERE pseudo = '$pseudo' AND titre = '$titre' AND pseudo_ami = '$pseudo2'";
                        $cnx -> exec($result_modif);
                        header("Location: profil.php");
                        die();
                    }
	   			}

        	?>

	 	
	</body>
</html>