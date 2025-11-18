<h1 class = "text-danger text-center">Nouvel Article</h1>
<?php
if (isset($_POST["Valider"])) {
    //var_dump($_POST);
    $subject =htmlentities($_POST["Subject"]);
    $article =nl2br($_POST["Article"]);

        if(strlen($subject)>50){
            echo'diminuez la taille de votre sujet';
            $validsubject = false;
        }else $validsubject = true;

    if ($validsubjec = true||!empty($article)) {

        $publishdate = date("Y-m-d H:i:s");
        $sql = $dbh->prepare("INSERT INTO Article(`subject`, `content`, `publishdate` ) VALUES (:subject, :content, :publishdate)");
        $sql->bindParam(':subject', $subject, PDO::PARAM_STR);
        $sql->bindParam(':content', $article, PDO::PARAM_STR);
        $sql->bindParam(':publishdate', $publishdate, PDO::PARAM_STR);
        $r = $sql->execute();
        if ($r) {
            echo "Article Posté";
        } else {
            echo "Echec de L'ajout";
        }
    }
}
?>

<form action="index.php?page=AjoutArticle" method="post">
      <div>
        <label for="exampleInputSubject" class="form-label mt-4">Subject</label>
        <input type="text" class="form-control" id="exampleSubject" aria-describedby="SubjectHelp" placeholder="Enter Subject" name="Subject" maxlength = 50 required>
      </div>
      <div>
        <label for="exampleInputArticle" class="form-label mt-4">Article</label>
        <textarea type="text" autocomplete="off" class="form-control" id="exampleArticle" aria-describedby="ArticleHelp" placeholder="Enter Article" name="Article" rows="20" cols="30" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary m-4" name="Valider">Soumettre</button>
</form>