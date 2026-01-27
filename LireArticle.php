<div class="container">
<div class="row justify-content-center">
<div class="col-12 col-md-10">

<?php
$article = null;
$commentaire = null;
if (isset(($_GET)["article"])) {
    $article = $_GET['article'];
}

if ($article) {
    $sql = "SELECT subject, content, publishdate, images, id FROM Article WHERE id=:id";
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':id', $article, PDO::PARAM_INT);
    $sql->execute();
    $row = $sql->fetch();
    if ($row == null) {
        echo 'Cet article n\'existe pas';
    }

    $sql = "SELECT id,Titre,Contenu FROM Commentaire WHERE id=:id";
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':id', $commentaire, PDO::PARAM_INT);
    $sql->execute();
    $row1 = $sql->fetch();
    if ($row == null) {
        echo 'Cet article n\'existe pas';
    }


    if ($article) {
        echo '<h1>' . $row['subject'] . '</h1>';
        echo '<div class="card" >
        <img src="images/' . $row['images'] . '" class="card-img-top" alt="...">
        <div class="card-body">
        <p class="card-text">' . $row['content'] . '</p>
        </div>';
        if (isset($_SESSION['login'])) {
            echo'<p>
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
    Ajouter un Commentaire
  </button>
</p>
<div style="min-height: 120px;">
  <div class="collapse collapse-horizontal" id="collapseWidthExample">
    <div class="card card-body" style="width: 300px;">
    <form action="index.php?page=AjoutCommentaire" method="post">
    <div>
      <label for="exampleInputTitre" class="form-label mt-4">Titre</label>
      <input type="text" class="form-control" id="exampleTitre" aria-describedby="TitreHelp" placeholder="Enter Titre" name="Titre" maxlength = 50 required>
    </div>
    <div>
      <label for="exampleInputCommentaire" class="form-label mt-4">Commentaire</label>
      <textarea type="text" autocomplete="off" class="form-control" id="exampleCommentaire" aria-describedby="Commentaire" placeholder="Enter Commentaire" name="Commentaire" rows="20" cols="30" required></textarea>
    </div>
    <a class=\"btn btn-outline-primary\" href=index.php?page=LireArticle&Commentaire=' . $row['id'] . '>Soumettre</a>
</form>
    </div>
  </div>
</div>
        <div class="card-footer">
        ' . $row['publishdate'] . '
  </div>';
        }
        if ($commentaire) {
            echo '<div class="card" >
        <p class="card-text">' . $row1['Contenu'] . '</p>';
        }
        if (isset($_POST["Valider"])) {
            $Titre = ($_POST["Titre"]);
            $Commentaire = ($_POST["Commentaire"]);
            $Modere = false;
    
            $DatePublication = date("Y-m-d H:i:s");
            $sql = $dbh->prepare("INSERT INTO Commentaire(`Titre`, `Contenu`, `DatePublication`, `Modere` ) VALUES (:Titre, :Contenu, :DatePublication, :Modere)");
            $sql->bindParam(':Titre', $Titre, PDO::PARAM_STR);
            $sql->bindParam(':Contenu', $Commentaire, PDO::PARAM_STR);
            $sql->bindParam(':DatePublication', $DatePublication, PDO::PARAM_STR);
            $sql->bindParam(':Modere', $Modere, PDO::PARAM_BOOL);
            $r = $sql->execute();
            if ($r) {
                echo "Commentaire Posté";
            } else {
                echo "Echec de L'ajout";
            }
        }
    }

}
?>
</div>
<div class="col-12 col-md-4 text-center">PUB
</div>
</div>
</div>
