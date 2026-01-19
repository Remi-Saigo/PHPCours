<h1 class = "text-danger text-center">Liste des Commentaires</h1>
<?php
$sql = 'SELECT Titre, Contenu, DatePublication FROM Commentaire ORDER BY DatePublication desc';
echo "<table> <tr> <th>Sujet</th> <th>Date De Publication</th> </tr>";
foreach ($dbh->query($sql) as $row) {
    echo "<tr><td>";
    echo $row['Titre'] . "\t";
    echo "</td><td>";
    echo $row['Contenu'] . "\t";
    echo "</td><td>";
    echo $row['DatePublication'] . "\t";
    echo "</td></tr>";
}
echo"</table>";
?>