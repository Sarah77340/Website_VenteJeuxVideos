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
		        	echo "<h2 style = 'color : aliceblue'>Commentaire de ".$_GET['jeu']."</h2>";
					echo "<input type='number' min = '0' max = '20'placeholder='Note' name='note'>".'<br>'.
	                   "<input type='text' max = '1000' placeholder='Commentaire' name='comment'>".'<br>';

	                  
	        	?>

	        	<input type='submit' name='modif'>

        	</form>

        	<?php
            
                $text = "<br>Dernier commentaire : ";
                $pseudo = $_SESSION['pseudo'];
                $titre = $_GET['jeu'];

                $result_partage = "SELECT commentaire, note FROM acheter WHERE pseudo = '$pseudo' AND titre = '$titre'";
                $results = $cnx -> query($result_partage);
                $results->setFetchMode(PDO::FETCH_ASSOC); 

                foreach($results as $list){
                    foreach($list as $com){
                        echo $text;
                        $text = "Dernière Note : ";
                        echo "<br><p style = 'color : aliceblue'>".$com."</p>";
                    }
                }

        		if (isset($_POST['modif'])){
        			$pseudo = $_SESSION['pseudo'];
        			$titre = $_GET['jeu'];
        			if (isset ( $_POST['note'])){
						$note = $_POST['note'];
						$result_modif = "UPDATE acheter SET note = '$note' WHERE pseudo = '$pseudo' and titre = '$titre'"; 
	   					$results = $cnx -> exec($result_modif);
					}
                    if (isset ( $_POST['comment']) && $_POST['comment'] != NULL){
						$comment = $_POST['comment'];
						$result_modif = "UPDATE acheter SET commentaire = '$comment' WHERE pseudo = '$pseudo' and titre = '$titre'"; 
	   					$results = $cnx -> exec($result_modif);
	   					
	   				}
	   				header("Location: profil.php");
                    die();
	   			}

        	?>

	 	
	</body>
</html>