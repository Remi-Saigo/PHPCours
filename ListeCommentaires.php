<h1 class = "text-danger text-center">Commentaires</h1>
<?php
$sql = 'SELECT Titre, Contenu, DatePublication, Modere FROM Commentaire';
echo "<table> <tr> <th>Titre</th> <th>Contenu</th> <th>Date de Publication</th> <th>Etat de la moderation</th> </tr>";
foreach ($dbh->query($sql) as $row) {
    echo "<tr><td>";
    echo $row['Titre'] . "\t";
    echo "</td><td>";
    echo $row['Contenu'] . "\t";
    echo "</td><td>";
    echo $row['DatePublication'] . "\t";
    echo "</td><td>";
    echo $row['Modere'] . "\t";
    echo "</td></tr>";
}
echo"</table>";
?>