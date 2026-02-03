<h1 class = "text-danger text-center">Nouvel Article</h1>
<?php
if (isset($_POST["Valider"])) {
    $subject =htmlentities($_POST["Subject"]);
    $article =nl2br($_POST["Article"]);

        if(strlen($subject)>50){
            echo'diminuez la taille de votre sujet';
            $validsubject = false;
        }else $validsubject = true;


        $annuler=FALSE;
        $taillemax=500*1000;
        //var_dump($_FILES);
    if ($validsubject = true&&  !empty($article)) {

        if (isset($_FILES['image'])){
            if ($_FILES['image']['size'] > $taillemax) {
                echo "Fichier trop volumineux ,500 Ko max";
                $annuler = true;
                $image=NULL;
                $anciennom=NULL;
            } else {
            if(!empty($_FILES['image']['name'])){
            //On récupère le nom temporaire du fichier
            $tmp=$_FILES['image']['tmp_name'];
            $name=$_FILES['image']['name'];
            $image=uniqid().substr($name, -5);
            $extension=strtolower(pathinfo($name,PATHINFO_EXTENSION));
            $fa = array("png","jpg","jpeg","webp","pdf");
            $anciennom=$name;
            if (!in_array($extension, $fa)){
                echo 'L\'extension n\'est pas accéptée';
                $image=NULL;
                $anciennom=NULL;
                $annuler=TRUE;
            }
            if(!$annuler){
                move_uploaded_file($tmp,'images/'.$image);
            }
        }
        else{
            $image=NULL;
            $anciennom=NULL;
        }
    }
}

        if(!$annuler){
        $publishdate = date("Y-m-d H:i:s");
        $sql = $dbh->prepare("INSERT INTO Article(`subject`, `content`, `publishdate`,`images`, `anciennom` ) VALUES (:subject, :content, :publishdate, :images, :anciennom)");
        $sql->bindParam(':subject', $subject, PDO::PARAM_STR);
        $sql->bindParam(':content', $article, PDO::PARAM_STR);
        $sql->bindParam(':publishdate', $publishdate, PDO::PARAM_STR);
        $sql->bindParam(':images', $image, PDO::PARAM_STR);
        $sql->bindParam(':anciennom', $anciennom, PDO::PARAM_STR);
        $r = $sql->execute();
        if ($r) {
            echo "Article Posté";
        } else {
            echo "Echec de L'ajout";
        }
    }
}
}
?>

<!-- enctype , sert à préciser comment on envoie les données , quand on envoie un fichier il faut mettre multipart/form-->
<form action="index.php?page=AjoutArticle" method="post" enctype="multipart/form-data">
      <div>
        <label for="exampleInputSubject" class="form-label mt-4">Subject</label>
        <input type="text" class="form-control" id="exampleSubject" aria-describedby="SubjectHelp" placeholder="Enter Subject" name="Subject" maxlength = 50 required>
      </div>
      <div>
        <label for="exampleInputArticle" class="form-label mt-4">Article</label>
        <textarea type="text" autocomplete="off" class="form-control" id="exampleArticle" aria-describedby="ArticleHelp" placeholder="Enter Article" name="Article" rows="20" cols="30" required></textarea>
      </div>
      <div>
        <!-- type = file permet de définir le type de données envoyées , ici fichier-->
        <input name="image" class="form-control" type="file"/>

      <button type="submit" class="btn btn-primary m-4" name="Valider">Soumettre</button>
</form>