<h1 class = "text-danger text-center">Liste des Articles</h1>
<?php
$sql = 'SELECT subject, content, publishdate FROM Article ORDER BY publishdate desc';
echo "<table> <tr> <th>Sujet</th> <th>Date De Publication</th> </tr>";
foreach ($dbh->query($sql) as $row) {
    echo "<tr><td>";
    echo $row['subject'] . "\t";
    echo "</td><td>";
    echo $row['publishdate'] . "\t";
    echo "</td></tr>";
}
echo"</table>";
?>

