<h1 class = "text-danger text-center">Liste Des Utilisateurs</h1>
<?php
if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'Admin') {;
        if ((isset($_GET['role'])) && (isset($_GET['user']))) {
            if ($_GET['role'] == 'Admin') {
                $r = 'User';
            } else {
                $r = 'Admin';
            }
            $sql = $dbh->prepare("UPDATE User set role= :role where id  = :id");
            $sql->bindParam(':role', $r, PDO::PARAM_STR);
            $sql->bindParam(':id', $_GET['user'], PDO::PARAM_INT);
            $r = $sql->execute();
        }
        if ((isset($_GET['action'])) && (isset($_GET['user']))) {
            //faire requête sql delete
            if ($_GET['action'] == 'supprimmer') {
                $r = 'User';
            } else {
                $r = 'Admin';
            }
            $sql = $dbh->prepare("DELETE FROM User where id  = :id");
            $sql->bindParam(':id', $_GET['user'], PDO::PARAM_INT);
            $r = $sql->execute();
        }
        

        $sql = 'SELECT name, surname, email,role,id FROM User';
        echo "<table> <tr> <th>Nom</th> <th>Prénom</th> <th>Email</th> <th>Rôle</th> <th>Modifier</th><th>Delete</th></tr>";
        foreach ($dbh->query($sql) as $row) {
            echo "<tr><td>";
            echo $row['name'] . "\t";
            echo "</td><td>";
            echo $row['surname'] . "\t";
            echo "</td><td>";
            echo $row['email'] . "\t";
            echo "</td><td> <a href=\"index.php?page=ListeUser&user=" . $row['id'] . "&role=" . $row['role'] . "\">";
            echo $row['role'] . "\t";
            echo '<td><a href=index.php?page=ModifierUser&utilisateur=' . $row['id'] . '>modifier</a></td>';
            echo "</a></td><td><a href=\"index.php?page=ListeUser&user=" . $row['id'] . "&action=supprimmer\"> Supprimer</a></td></tr>";
        }
        echo "</table>";} else {
        echo 'Vous n\'avez pas les permsssions administrateur<br>';
    }

} else {
    echo 'Veuillez vous connecter pour voir cette page<br>';
}

?>
