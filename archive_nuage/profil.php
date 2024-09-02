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
	           	<form method ="POST">
	                
	                <?php echo "<h1 style = 'color : aliceblue'>Profil de ".$_SESSION['pseudo']."</h1>" ?>
	                
	                <h2 style = 'color : aliceblue'>Mes Jeux</h2>

	                <?php

	                $jeu = array();

					$req_select_1 = "SELECT titre FROM acheter WHERE pseudo = '{$_SESSION['pseudo']}'";
					$results=$cnx->query($req_select_1);
					$results->setFetchMode(PDO::FETCH_ASSOC);

					foreach($results as $ligne){

						$req_select_2 = "SELECT COUNT(*) FROM atteindre NATURAL JOIN succes WHERE titre = '{$ligne['titre']}' AND pseudo = '{$_SESSION['pseudo']}'";
						$results_2 = $cnx->query($req_select_2);
						$results_2->setFetchMode(PDO::FETCH_ASSOC);
						

						$req_select_3 = "SELECT COUNT(*) FROM succes WHERE titre = '{$ligne['titre']}'";
						$results_3 = $cnx->query($req_select_3);
						$results_3->setFetchMode(PDO::FETCH_ASSOC);


						foreach($results_2 as $ligne1){
							foreach($results_3 as $ligne2){
								foreach($ligne1 as $l1){
									foreach($ligne2 as $l2){
										echo "<h5 style = 'color : aliceblue'>".$ligne['titre']."</h5>"."<p style = 'color : aliceblue'>Taux de succès accomplis ".$l1." / ".$l2." </p>";
										$jeu = $ligne['titre'];
										echo "<a href='commentaire.php?jeu=$jeu' style = color : 'aliceblue'>Commentaire</a>";

									}
								}
								
							}
						}
						$results_2->closeCursor();
						$results_3->closeCursor();
					}

					$results->closeCursor();
					?>

					<h2 style = 'color : aliceblue'>Mes Partages</h2>

					<?php

					$req_select = "SELECT * FROM partager WHERE pseudo_ami = '{$_SESSION['pseudo']}'";
					$results=$cnx->query($req_select);
					$results->setFetchMode(PDO::FETCH_ASSOC);

					foreach($results as $ligne){
							echo $ligne['titre'].' partagé par '. $ligne['pseudo'].'<br>';
					}

					$results->closeCursor();
					?>

					<h2 style = 'color : aliceblue'>Recharge d'argent</h2>

					<form>

						<input type='number' min = '0' max = '1000' placeholder='argent' name='argent'>

						<h2 style = 'color : aliceblue'>Ajouter un Ami</h2>

						<input type='text' placeholder='Pseudo' name='pseudo'>

						<h2 style = 'color : aliceblue'>Mes Amis</h2>

						<?php

							$pseudo = $_SESSION['pseudo'];
							$req_select_ami = "SELECT pseudo2 FROM ami WHERE pseudo1 = '$pseudo'";
							$results_select_ami = $cnx->query($req_select_ami);
							$results_select_ami->setFetchMode(PDO::FETCH_ASSOC);
							foreach($results_select_ami as $list_ami){
								foreach($list_ami as $ami){

									echo "<h3 style = 'color : aliceblue'>".$ami."</h3>"."<p style = 'color : aliceblue'>Partager un jeu :</p>";
									$_SESSION['j2'] = $ami;

									$req_select_1 = "SELECT titre FROM acheter WHERE pseudo = '{$_SESSION['pseudo']}'";
									$results=$cnx->query($req_select_1);
									$results->setFetchMode(PDO::FETCH_ASSOC);
									foreach($results as $ligne){
										echo "<p style = 'color : aliceblue'>".$ligne['titre']."<br></p>";
										$_SESSION['jeu'] = $ligne['titre'];
										$jeu = $ligne['titre'];

										echo "<a href='partage.php?pseudo2=$ami&jeu=$jeu' style = color : 'aliceblue'>Partage</a>";
									}
									$results->closeCursor();
								}
							}
							$results_select_ami->closeCursor();
						?>

						<input type='submit' name='modif'>

					</form>

					<?php

						if (isset($_POST['modif'])){

							$pseudo = $_SESSION['pseudo'];
							if (isset ( $_POST['argent'])){
									$argent = $_POST['argent'];
									$result_modif = "UPDATE joueur SET argent = '$argent' WHERE pseudo = '$pseudo'"; 
		           					$results = $cnx -> exec($result_modif);
		           			} 
						
							
							if (isset ( $_POST['pseudo'])){
								$pseudo2 = $_POST['pseudo'];
								$result_ami1 = "INSERT INTO ami VALUES ('$pseudo', '$pseudo2')";
								$cnx -> exec($result_ami1);

								$result_ami2 = "INSERT INTO ami VALUES ('$pseudo2', '$pseudo')";
								$cnx -> exec($result_ami2);
							}
						}

					?>

					<br>

	                <a href="logout.php" style = "margin-left: 635px; color : aliceblue">Se Déconnecter</a>

	            </form>
	        </div>
		</div>

        
    </body>
</html>