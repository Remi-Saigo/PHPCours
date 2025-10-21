<?php
//essaye de faire le code qui est dans le bloc try
try {
    // se connecte à la BD et stocke la connexion dans  $dbh
    $dbh = new PDO('mysql:host=localhost;dbname=PHPCours', 'login4439', 'HNLCQSaIAXkvUJo');
} catch (PDOException $e) {
    //comme la connexion n'a pas fonctionnée , je stocke NULL dans $dbh
    $dbh=null;
}
?>