<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8">
        <title>Jeux</title>
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>

      <?php 
        include("premakes/header.html"); 
        include("connexion.inc.php");
      ?>
        
      <section id = "first">
      <?php 
        $recherche=$_GET['recherche'];
        $type=$_GET['type'];
        
        //echo'recherche: '.$recherche.' type:'.$type.'';

          if ($type == "genre") {
            $reqselect="SELECT titre FROM appartient WHERE type_jeux = '$recherche';";
          }
          elseif ($type == "edit") {
            $reqselect="SELECT titre FROM jeux WHERE nom_edit = '$recherche';";
          }
          elseif ($type == "dev") {
            $reqselect="SELECT titre FROM jeux WHERE nom_dev = '$recherche';";
          }

          $res = $cnx->query($reqselect);
          while($results = $res->fetch(PDO::FETCH_ASSOC)){
            foreach($results as $valeur){
                include("affiche_jeu.php"); 
            }
          }
        ?>
      
      </section>
    </body>
</html>