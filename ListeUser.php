<h1 class = "text-danger text-center">Liste Des Utilisateurs</h1>
<?php
$sql = 'SELECT name, surname, email, role FROM User';
echo "<table> <tr> <th>Nom</th> <th>Prénom</th> <th>Email</th> <th>Rôle</th></tr>";
foreach ($dbh->query($sql) as $row) {
    echo "<tr><td>";
    echo $row['name'] . "\t";
    echo "</td><td>";
    echo $row['surname'] . "\t";
    echo "</td><td>";
    echo $row['email'] . "\t";
    echo "</td><td>";
    echo $row['role'] . "\t";
    echo "</td></tr>";
}
echo"</table>";
?>