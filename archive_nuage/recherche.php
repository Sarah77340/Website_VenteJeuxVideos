<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8">
        <title>Recherche</title>
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>


        <?php 
        	include("premakes/header.html"); 
        	include("connexion.inc.php");
        ?>


        <div id ="boxpro">
          <div id="box-profil">
	           
	          <form method ="POST">
	            <h1 style = 'color : aliceblue'>Page de recherche</h1>
              <input type="text" placeholder="Recherche" name="recherche" required>

              <h2 style = 'color : aliceblue'>Type de recherche</h2>

              <select name="select">
                <option value="titre" selected="selected">Titre</option>
                <option value="genre">Genre</option>
                <option value="edit">Editeur</option>
                <option value="dev">Developpeur</option>
              </select>

              <br>

              <input type="submit" name="envoyer">
            </form>
	      </div>
		</div>

		<?php
			if(isset($_POST['envoyer']) AND !empty($_POST['recherche'])) {
        
        $search_1 = strtolower($_POST['recherche']);
				$search_2 = ucwords($search_1); 

			  if ($_POST['select'] == 'titre'){
					
          $req_recherche1 = "SELECT titre FROM jeux WHERE titre LIKE '%".$search_1."%';";
					$results=$cnx->query($req_recherche1);
					$results->setFetchMode(PDO::FETCH_ASSOC);

					$req_recherche2 = "SELECT titre FROM jeux WHERE titre LIKE '%".$search_2."%';";
					$results_2=$cnx->query($req_recherche2);
					$results_2->setFetchMode(PDO::FETCH_ASSOC);
					
					if ($results){
						foreach($results as $r){
							foreach($r as $r2){
								$titre = $r2;
							}
						}
					}if ($results_2){
						foreach($results_2 as $r){
							foreach($r as $r2){
								$titre = $r2;
							}
						}
					}

					if ($results && $titre){
		            	header("Location: page_jeu.php?jeu=".$titre."");
                        die();
		        	}				
				}
        //
        
        elseif ($_POST['select'] == 'genre'){
          echo"<div>1)</div>";
          $req_recherche1 = "SELECT type_jeux FROM appartient WHERE type_jeux LIKE '%".$search_1."%';";
          $req_recherche2 = "SELECT type_jeux FROM appartient WHERE type_jeux LIKE '%".$search_2."%';";
        }
        
        elseif ($_POST['select'] == 'edit'){
          echo"<div>2)</div>";
          $req_recherche1 = "SELECT nom_edit FROM jeux WHERE nom_edit LIKE '%".$search_1."%';";
          $req_recherche2 = "SELECT nom_edit FROM jeux WHERE nom_edit LIKE '%".$search_2."%';";
        }
        
        elseif ($_POST['select'] == 'dev'){
          echo"<div>3)</div>";
          $req_recherche1 = "SELECT nom_dev FROM jeux WHERE nom_dev LIKE '%".$search_1."%';";
          $req_recherche2 = "SELECT nom_dev FROM jeux WHERE nom_dev LIKE '%".$search_2."%';";
        }
        
        $res_recherche =$cnx->query($req_recherche1);
        $res_recherche->setFetchMode(PDO::FETCH_ASSOC);
        
        $res_recherche2 =$cnx->query($req_recherche2);
        $res_recherche2->setFetchMode(PDO::FETCH_ASSOC);
        
        if ($res_recherche){
						foreach($res_recherche as $r){
							foreach($r as $r2){
								$titre = $r2;
							}
						}
        }
        
        if ($res_recherche2){
						foreach($res_recherche2 as $r){
							foreach($r as $r2){
								$titre = $r2;
							}
						}
        }
        
        if ($res_recherche && $titre){
              header("Location: result_recherche.php?recherche=".$titre."&type=".$_POST['select']."");
              die();
        }	
        else {
        echo'<div>pas de résultat pour cette recherche</div>';
        }
			}
      
		?>

        
    </body>
</html>