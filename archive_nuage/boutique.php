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
      ?>
      
      
      <!-- TRIER jeux -->
      <section id = "first">
        <div>
        
        <form id="form-trier-jeu" action="boutique.php" method="POST" onchange="this.submit()">
          <h1 style = "color : aliceblue; margin-left:10px;">JEUX</h1>
          <p style="margin-left:10px;">
            <select name="choix_trie">
              <option value="rien" selected="selected">Trier</option>
              <option value="date">parution récente</option>
              <option value="vente">meilleure vente</option>
              <option value="note">meilleure note</option>
            </select>
          </p>
        </form>
        </div>
        
      
        <?php 
          include("connexion.inc.php");
          
          

          $choix = $_POST['choix_trie'];

          
          if ($choix == "date") {
            $reqselect="SELECT titre FROM jeux ORDER BY d_sortie DESC;" ;
          }
          else if ($choix == "note") {
            $reqselect="SELECT n.titre FROM 
                        (
                          (SELECT titre, avg(note) 
                          FROM acheter WHERE note IS NOT NULL
                          GROUP BY titre
                          ORDER BY avg)
                          UNION
                          (SELECT jeux.titre, 0 
                          FROM jeux LEFT JOIN acheter ON jeux.titre = acheter.titre WHERE acheter.note IS NULL)
                          ORDER BY avg DESC
                        ) n ";
          }
          else if ($choix == "vente") {
            $reqselect="SELECT titre FROM 
                        (
                          (SELECT titre, COUNT(titre) 
                          FROM acheter GROUP BY titre) 
                          UNION 
                          (SELECT jeux.titre, 0 
                          FROM jeux LEFT JOIN acheter ON jeux.titre = acheter.titre WHERE acheter.titre IS NULL) 
                          ORDER BY count DESC
                        ) v;";
          }
          else {
            $reqselect="SELECT titre FROM jeux;" ;
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