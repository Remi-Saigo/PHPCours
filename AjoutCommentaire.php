<h1 class = "text-danger text-center">Ajout Commentaire</h1>
<?php
if (isset($_POST["Valider"])) {
    //var_dump($_POST);
    $Titre =htmlentities($_POST["Titre"]);
    $Commentaire =nl2br($_POST["Commentaire"]);
    $Modere = false;

        if(strlen($Titre)>50){
            echo'diminuez la taille de votre sujet';
            $validTitre = false;
        }else $validTitre = true;

    if ($validsubjec = true||!empty($Commentaire)) {

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
?>

<form action="index.php?page=AjoutCommentaire" method="post">
      <div>
        <label for="exampleInputTitre" class="form-label mt-4">Titre</label>
        <input type="text" class="form-control" id="exampleTitre" aria-describedby="TitreHelp" placeholder="Enter Titre" name="Titre" maxlength = 50 required>
      </div>
      <div>
        <label for="exampleInputCommentaire" class="form-label mt-4">Commentaire</label>
        <textarea type="text" autocomplete="off" class="form-control" id="exampleCommentaire" aria-describedby="Commentaire" placeholder="Enter Commentaire" name="Commentaire" rows="20" cols="30" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary m-4" name="Valider">Soumettre</button>
</form>