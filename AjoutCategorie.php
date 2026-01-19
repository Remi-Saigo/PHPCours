<h1 class = "text-danger text-center">Nouvelle Categorie</h1>
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

if (isset($_POST["Valider"])) {
    //var_dump($_POST);
    $categorie =nl2br($_POST["Categorie"]);

    if (!empty($categorie)) {

        $publishdate = date("Y-m-d H:i:s");
        //Prépare l'insersion dans la BD
        $sql = $dbh->prepare("INSERT INTO Categorie(`name`, `publishdate` ) VALUES (:name , :publishdate)");
        // Lie la valeur dans la BD nommée "name" à $categorie
        $sql->bindParam(':name', $categorie, PDO::PARAM_STR);
        $sql->bindParam(':publishdate', $publishdate, PDO::PARAM_STR);
        //execute la requête
        $r = $sql->execute();
        // Succès
        if ($r) {
            echo "Categorie Posté";
        } 
        //Echec
        else {
            echo "Echec de L'ajout";
        }
    }
}

?>

<form action="index.php?page=AjoutCategorie" method="post">
      <div>
        <label for="exampleInputArticle" class="form-label mt-4">Categorie</label>
        <textarea type="text" autocomplete="off" class="form-control" id="exampleArticle" aria-describedby="CategorieHelp" placeholder="Enter Categorie" 
        name="Categorie" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary m-4" name="Valider">Soumettre</button>
</form>

<?php
}
else {
    echo 'Vous n\'avez pas les permsssions administrateur<br>';
}
}
else {
    echo 'Veuillez vous connecter pour voir cette page<br>';
} 
?>
