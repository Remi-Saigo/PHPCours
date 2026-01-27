<h1 class = "text-danger text-center">Modification Des Catégories</h1>
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

        $categorie = null;
//Vérifie l'existence de la clef catégorie dans le tableau $_GET (URL)
        if (isset(($_GET)["categorie"])) {
            //récupère la clef et sa valeur dans $categorie
            $categorie = $_GET['categorie'];
        }

//Si $categorie n'est pas null , lance ls script
        if ($categorie) {
            //déclare la requête SQL permettant de chercher une catégorie
            $sql = "SELECT id, name FROM Categorie WHERE id=:id";
            //Prépare la requête , en protégeant les paramètres et en vérifiant leur type
            $sql = $dbh->prepare($sql);
            //On associe la variable PHP à la variable SQL
            $sql->bindParam(':id', $categorie, PDO::PARAM_INT);
            //On exécute la requête
            $sql->execute();
            //On récupère la ligne corresspondant à la réponse de la requête
            $row = $sql->fetch();
            // si la ligne est nulle c'est que la catégorie n'existe pas
            if ($row == null) {
                // Alors , on écrit qu'il n'as pas les bons identifiants
                echo "Cette catégorie n\'existe pas";
            } else {
                echo '<form action="index.php?page=modifcategorie" method="post">
      <div>
        <label for="exampleInputArticle" class="form-label mt-4">Categorie</label>
        <input type="text" autocomplete="off" class="form-control" id="exampleArticle" aria-describedby="CategorieHelp" placeholder="Enter Categorie"
        name="Categorie" value="' . $row['name'] . '" required></input>
        <input name="id" value="' . $row['id'] . '" type="hidden"/>
      </div>
      <button type="submit" class="btn btn-primary m-4" name="Valider">Soumettre</button>
</form>';
            }
        } else {
            if (isset($_POST["Valider"])) {
                $categorie = $_POST['Categorie'];
                $id = $_POST['id'];
                echo $id;
                echo $categorie;
                $sql = "UPDATE Categorie SET name=:name WHERE id=:id";
                $sql = $dbh->prepare($sql);
                $sql->bindParam(':id', $id, PDO::PARAM_INT);
                $sql->bindParam(':name', $categorie, PDO::PARAM_STR);
                $sql->execute();
                $row = $sql->fetch();
                header('Location:index.php?page=ListeCategories');
                if ($row == null) {
                    echo "Erreur";
                }
                echo 'Formulaire envoyé';
            } else {
                echo 'La catégorie n\'existe pas./Manque d\'id';
            }
        }} else {
        echo 'Veuillez vous connecter pour voir cette page<br>';

    }
}
?>