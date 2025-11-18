<h1 class = "text-danger text-center">Liste Des Contact</h1>
<?php
$sql = 'SELECT subject, email, content FROM Contact';
echo "<table> <tr> <th>Sujet</th> <th>Expéditeur</th> </tr>";
foreach ($dbh->query($sql) as $row) {
    echo "<tr><td>";
    echo $row['subject'] . "\t";
    echo "</td><td>";
    echo $row['email'] . "\t";
    echo "</td></tr>";
}
echo"</table>";
?>