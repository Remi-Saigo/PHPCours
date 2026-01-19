<h1>Modification Catégorie</h1>
<?php
$categorie=NULL;
if(isset(($_GET)["categorie"])){
    $categorie=$_GET['categorie'];
}
if($categorie){
    $sql="SELECT id, name FROM Categorie WHERE id=:id";
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':id', $categorie, PDO::PARAM_INT);
    $sql->execute();
    $row = $sql->fetch();
    // si la ligne est nulle c'est que la catégorie n'existe pas
    if ($row == null) {
        // Alors , on écrit qu'il n'as pas les bons identifiants
        echo "Identifiants Incorrects";
    }
    else{
        echo '<form action="index.php?page=modifcategorie" method="post">
      <div>
        <label for="exampleInputArticle" class="form-label mt-4">Categorie</label>
        <textarea type="text" autocomplete="off" class="form-control" id="exampleArticle" aria-describedby="CategorieHelp" placeholder="Enter Categorie" 
        name="Categorie" value="'.$row['name'].'" required></textarea>
        <input name="id" value="'.$row['id'].'" type="hidden"/>
      </div>
      <button type="submit" class="btn btn-primary m-4" name="Valider">Soumettre</button>
</form>';
    }
}
else {
    if(isset($_POST["Valider"])) {
        $categorie=$_POST['Categorie'];
        $id=$_POST['id'];
        echo $id;
        echo $categorie;
        $sql="UPDATE Categorie SET name=:name WHERE id=:id";
        $sql = $dbh->prepare($sql);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->bindParam(':name', $categorie, PDO::PARAM_STR);
        $sql->execute();
        $row = $sql->fetch();
        header('Location:index.php?page=ListeCategories');
        if ($row == null) {
        echo "Erreur";
    }
        echo'Formulaire envoyé';
    }
    else{
    echo'La catégorie n\'existe pas.';}
}
?>  