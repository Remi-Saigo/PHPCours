<h1 class = "text-danger text-center">Liste Des Catégories</h1>
<?php
if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'Admin') {;
        if ((isset($_SESSION['role'])) && (isset($_SESSION['user']))) {
            if ($_SESSION['role'] == 'Admin') {
                $r = 'User';
            } else {
                $r = 'Admin';
            }

        }
        if ((isset($_GET['action'])) && (isset($_GET['categorie']))) {
            //faire requête sql delete
            if ($_GET['action'] == 'supprimer') {
                $sql = $dbh->prepare("DELETE FROM Categorie where id  = :id");
                $sql->bindParam(':id', $_GET['categorie'], PDO::PARAM_INT);
                $r = $sql->execute();
            }
        }
        

        $sql = 'SELECT name, publishdate, id FROM Categorie';
        echo "<table> <tr> <th>Nom</th> <th>Date de Publication</th> <th>ID</th></tr>";
        foreach ($dbh->query($sql) as $row) {
            echo "<tr><td>";
            echo $row['name'] . "\t";
            echo "</td><td>";
            echo $row['publishdate'] . "\t";
            echo "<td><a class=\"btn btn-outline-primary\" href=index.php?page=modifcategorie&categorie=" . $row['id'] . '>modifier</a></td>';
            echo "</a></td><td><a class=\"btn btn-outline-primary\" href=index.php?page=ListeCategories&categorie=" . $row['id'] . "&action=supprimer\"> Supprimer</a></td></tr>";
            echo "</td><tr>";
        }
        echo "</table>";} else {
        echo 'Vous n\'avez pas les permsssions administrateur<br>';
    }

} else {
    echo 'Veuillez vous connecter pour voir cette page<br>';
}

?>