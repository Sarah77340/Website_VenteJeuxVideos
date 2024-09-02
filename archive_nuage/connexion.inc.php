<?php
$user = 'dilien.oeuvrard';
$pass = '230602';
try {
    $cnx = new PDO('pgsql:host=sqletud.u-pem.fr;port=5432;dbname=dilien.oeuvrard_db',$user, $pass);  
} catch (PDOException $e) {
    echo "ERREUR : La connexion a échouée $e";
}
?>