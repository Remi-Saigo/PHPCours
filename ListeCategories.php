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
        

        $sql = 'SELECT name, publishdate, id FROM Categorie';
        echo "<table> <tr> <th>Nom</th> <th>Date de Publication</th> <th>ID</th></tr>";
        foreach ($dbh->query($sql) as $row) {
            echo "<tr><td>";
            echo $row['name'] . "\t";
            echo "</td><td>";
            echo $row['publishdate'] . "\t";
            echo '<td><a href=index.php?page=modifcategorie&categorie=' . $row['id'] . '>modifier</a></td>';
            echo "</td><tr>";
        }
        echo "</table>";} else {
        echo 'Vous n\'avez pas les permsssions administrateur<br>';
    }

} else {
    echo 'Veuillez vous connecter pour voir cette page<br>';
}

?>