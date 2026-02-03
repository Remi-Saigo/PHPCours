<h1 class = "text-danger text-center">Liste des Articles</h1>
<?php
$sql = 'SELECT id, subject, content, publishdate FROM Article ORDER BY publishdate desc';
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') {
    echo "<table> <tr> <th>Sujet</th> <th>Date De Publication</th> <th>Actions</th> </tr>";
} else {
    echo "<table> <tr> <th>Sujet</th> <th>Date De Publication</th> </tr>";
}
foreach ($dbh->query($sql) as $row) {
    echo "<tr><td>";
    echo $row['subject'] . "\t";
    echo "</td><td>";
    echo $row['publishdate'] . "\t";
    echo "</td>";
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') {
        echo "<td>";
        echo '<a class="btn btn-sm btn-outline-primary" href="index.php?page=ModifierArticle&article=' . $row['id'] . '">Modifier</a>';
        echo "</td>";
    }
    echo "</tr>";
}
echo"</table>";
?>
