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
          include("cookies.php");
          include('jeu.php');
      ?>
      
      <section id = "first">
      
        <?php 
          $jeu=$_GET['jeu'];
          $succes = 0;
          
          //##############FONCTIONS#############
          function calculAge($anniv) {
            $lst_anniv = explode("-", $anniv);
            $annee = date("Y") - $lst_anniv[0];
            $mois = date("m") - $lst_anniv[1];
            $jour = date("d") - $lst_anniv[2];
            
            if ($jour < 0 && $mois == 0){
              $annee--;
            }
            if ($jour < 0 && $mois < 0) {
              $annee--;
            }
            return $annee;
          }
          
          function effectuerAchat($j, $nom_jeu, $cnx, $prix_jeu) {
            
            //ajouter dans la table acheter
            $pseudo = $j['pseudo'];
            $titre = $nom_jeu;
            $date_achat = date("Y-m-d");
            
            $result_reg = "INSERT INTO acheter VALUES ('$pseudo', '$titre', null, null, '$date_achat')";
            $results1 = $cnx -> exec($result_reg);
            
            if ($results1){
                echo 'Vous avez acheté avec succès !<br>';
                header("Refresh:0");
            } else {
                echo 'ERREUR';
                
              
            }

            //soustraire argent
            
            $argent = $j['argent'] - $prix_jeu;
            //echo"porte monnaie: ".$argent."€<br> pseudo=".$pseudo."<br>";
            
            $result_modif = "UPDATE joueur SET argent=$argent WHERE pseudo='$pseudo';";  
            
		        $results2 = $cnx -> exec($result_modif);
            echo"porte monnaie: ".$argent."€<br>";
            
            if ($results2){
                echo "L'argent a bien été pris !<br>";
            } else {
                echo 'ERREUR';
            }
          }
          //#####################################
          
          
          if(isset($_SESSION['pseudo'])){
            //echo'test:connecté'.$_SESSION['pseudo'].'!!!';

            $reqverif_achat = "SELECT count(*) AS c FROM acheter WHERE pseudo=? and titre=?;";
            
            $res = $cnx->prepare($reqverif_achat);
            $res->execute(array($_SESSION['pseudo'], $jeu));
            $result = $res->fetch(PDO::FETCH_ASSOC);
            
            //echo 'test0: '.$result.'<br>';
            //echo 'test1: '.$result['c'].'<br>';
            //print_r($result);
            
            
            if($result['c'] == 0){
              //echo'pas acheté';
              $text='Acheter';
              $affiche_achat = '<form method ="POST" id="bouton-acheter"><input type="submit" value="Acheter" name="acheter"></form>';
            }
            else {
              //echo'deja acheté';
              $affiche_achat = '<div id="bouton-achat">Déjà acheté</div>';
              $succes = 1;
            }
          }
          else{
            //echo'test:pas connecté';
           $affiche_achat = '<a href="login.php"><div id="bouton-achat">Acheter</div></a>';
          }

          if (isset($res)){
              $res->closeCursor();
          }
          
          
          //données du jeu
          $reqjeu="SELECT * FROM jeux WHERE titre=?";
          $res1 = $cnx->prepare($reqjeu);
          $res1->execute(array($jeu));
          $valeur_jeu = $res1->fetch(PDO::FETCH_ASSOC);
          
          //prix
          $prix = $valeur_jeu['prix'];
          if ($prix == 0){
            $prix_affiche = "Gratuit";
          }
          else{
            
            $prix_affiche = $prix."€";
          }
          $age = $valeur_jeu['age_req'];
          
          
          // AFFICHAGE JEU
          echo'
              <h1 style = "color : aliceblue; margin-left:10px;">'.$valeur_jeu['titre'].'</h1>
              <div id = "box-jeu">
                <table>
                  <tr>
                    <td> 
                      <img src = "assets/jeux/'.$valeur_jeu['titre'].'.jpg" id = "img-jeu">
                    </td>
                    <td style="text-align:left; vertical-align:top;" >
                      <div style="color:aliceblue;">
                      Age requis: '.$age.'<br>
                      Date de sortie: '.$valeur_jeu['d_sortie'].'<br>
                      Développeur: '.$valeur_jeu['nom_dev'].'<br>
                      Editeur: '.$valeur_jeu['nom_edit'].'<br><br>
                      Description: '.$valeur_jeu['desc_jeux'].'<br><br>
                      </div>
                      <div id="div-prix">
                        '.$prix_affiche.'
                        <br>
                        '.$affiche_achat.' 
                      </div>
                    </td>
                  </tr>
                </table>
                
              </div>';
              
          $res1->closeCursor();
          //clic sur acheter
          if (isset( $_POST['connecter'])){
            header("Location: login.php");
          }
          if (isset( $_POST['acheter'])) {
            
            $reqjoueur="SELECT * FROM joueur WHERE pseudo=?;"; 
            $res4 = $cnx->prepare($reqjoueur);
            $res4->execute(array($_SESSION['pseudo']));
            $joueur = $res4->fetch(PDO::FETCH_ASSOC);
            //print_r($joueur);
            
            $age_joueur = calculAge($joueur['d_nais']);
            if ($joueur['argent'] >= $prix && $age_joueur >= $age){
              
              if (isset($res4)){
              $res4->closeCursor();
              }
              effectuerAchat($joueur, $jeu, $cnx, $prix);
            }
            else {
              echo"achat impossible: <br> 
              votre argent:".$joueur['argent'].")<br>
              votre age:".$age_joueur."<br>";
            }
            if (isset($res4)){
              $res4->closeCursor();
            }
          }
          

          // NOTE MOYENNE
          $reqavg="SELECT avg(note) AS note FROM acheter WHERE titre=?;"; 
          $res2 = $cnx->prepare($reqavg);
          $res2->execute(array($jeu));
          $valeur_avg = $res2->fetch(PDO::FETCH_ASSOC);

          echo '<div style="border: 1px solid #000000; margin: 10px 10px 10px 10px; background: #000000; color : aliceblue;">
          <h2 style = "margin-left:10px;" >Commentaires:  &#9733; '.round($valeur_avg['note'], 1).'</h2>';
          
          $res2->closeCursor();
          
          //LISTE COMMENTAIRES
          $reqcom="SELECT * FROM acheter WHERE titre=?";
          $res3 = $cnx->prepare($reqcom);
          $res3->execute(array($jeu));
          foreach($res3 as $valeur_acheter){
            //print_r($valeur_acheter);
            echo'
                <div style="margin: 1px 1px 1px 1px; padding: 2px 2px 2px 2px; background: #404446;">
                <table>
                  <tr>
                    <td width=100px;>
                      <b>'.$valeur_acheter['pseudo'].'</b>
                    </td>
                    <td>
                      <b>&#9733 '.$valeur_acheter['note'].'</b>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-size: 10px;">
                      '.$valeur_acheter['date_achat'].'
                    </td>
                    <td>
                      '.$valeur_acheter['commentaire'].'
                    </td>
                  </tr>
                </table>
                </div>
                
              ';
          }
          
          echo '</div>';
          $res3->closeCursor();
          
          //LISTE SUCCES
          if ($succes == 1) {
            echo '<div style="border: 1px solid #000000; margin: 10px 10px 10px 10px; background: #000000; color : aliceblue;">
            <h2 style = "margin-left:10px;" >Succès:</h2>';
            
            //succes débloqués
            $reqsucces1="SELECT * FROM succes NATURAL JOIN atteindre WHERE titre=? AND pseudo=?;";
            $res5 = $cnx->prepare($reqsucces1);
            $res5->execute(array($jeu, $_SESSION['pseudo']));
            
            echo'<b style = "margin-left:10px;">Débloqués:</b><br>';
            foreach($res5 as $info_succes){
              echo'
                <div style="margin: 1px 1px 1px 1px; padding: 2px 2px 2px 2px; background: #404446;">
                  <table>
                    <tr>
                      <td width=100px;>
                        <b>'.$info_succes['code'].'</b>
                      </td>
                      <td>
                        <b>'.$info_succes['intitule'].'</b>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        '.$info_succes['d_atteint'].'
                      </td>
                      <td>
                        '.$info_succes['texte'].'
                      </td>
                    </tr>
                    
                  </table>
                </div>';
            }
            
            $res5->closeCursor();

            
            //succes a obtenir
            $reqsucces2="SELECT * FROM succes WHERE code NOT IN
            (SELECT code FROM succes NATURAL JOIN atteindre WHERE pseudo=?) AND titre=?;";
            $res6 = $cnx->prepare($reqsucces2);
            $res6->execute(array($_SESSION['pseudo'], $jeu));
            
            echo'<br><b style = "margin-left:10px;">A obtenir:</b><br>';
            foreach($res6 as $info_succes){
              echo'
                <div style="margin: 1px 1px 1px 1px; padding: 2px 2px 2px 2px; background: #404446;">
                  <table>
                    <tr>
                      <td width=100px;>
                        <b>'.$info_succes['code'].'</b>
                      </td>
                      <td>
                        <b>'.$info_succes['intitule'].'</b>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        &nbsp;
                      </td>
                      <td>
                        '.$info_succes['texte'].'
                      </td>
                    </tr>
                    
                  </table>
                </div>';
            }
            
            $res6->closeCursor();
            echo '</div>';
          }

        ?>
      </section>

        
    </body>
</html>