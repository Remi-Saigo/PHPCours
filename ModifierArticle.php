<h1 class = "text-danger text-center">Modification Des Articles</h1>
<?php
if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'Admin') {;
        $article = null;
        if (isset($_GET['article']) && is_numeric($_GET['article'])) {
            $article = (int) $_GET['article'];
        }

        if ($article) {
            $sql = "SELECT id, subject, content, images, anciennom FROM Article WHERE id=:id";
            $sql = $dbh->prepare($sql);
            $sql->bindParam(':id', $article, PDO::PARAM_INT);
            $sql->execute();
            $row = $sql->fetch();
            if ($row == null) {
                echo "Cet article n'existe pas";
            } else {
                $articleContent = str_replace(["<br />", "<br>", "<br/>"], "\n", $row['content']);
                echo '<form action="index.php?page=ModifierArticle" method="post" enctype="multipart/form-data">
      <div>
        <label for="exampleInputSubject" class="form-label mt-4">Sujet</label>
        <input type="text" autocomplete="off" class="form-control" id="exampleInputSubject" aria-describedby="SubjectHelp" placeholder="Enter Subject"
        name="Subject" value="' . htmlspecialchars($row['subject']) . '" maxlength="50" required></input>
        <input name="id" value="' . $row['id'] . '" type="hidden"/>
        <input name="current_image" value="' . htmlspecialchars($row['images']) . '" type="hidden"/>
        <input name="current_oldname" value="' . htmlspecialchars($row['anciennom']) . '" type="hidden"/>
      </div>
      <div>
        <label for="exampleInputArticle" class="form-label mt-4">Article</label>
        <textarea type="text" autocomplete="off" class="form-control" id="exampleInputArticle" aria-describedby="ArticleHelp" placeholder="Enter Article" name="Article" rows="20" cols="30" required>' . htmlspecialchars($articleContent) . '</textarea>
      </div>
      <div class="mt-4">
        <label class="form-label">Image actuelle</label>
        <div>
          <span class="text-muted">' . htmlspecialchars($row['anciennom']) . '</span>
        </div>
        <input name="image" class="form-control" type="file"/>
      </div>
      <button type="submit" class="btn btn-primary m-4" name="Valider">Soumettre</button>
</form>';
            }
        } else {
            if (isset($_POST["Valider"])) {
                $subject = htmlentities($_POST["Subject"]);
                $articleContent = nl2br($_POST["Article"]);
                $id = $_POST['id'];
                $currentImage = $_POST['current_image'] ?? null;
                $currentOldName = $_POST['current_oldname'] ?? null;
                $image = $currentImage;
                $anciennom = $currentOldName;

                if (strlen($subject) > 50) {
                    echo 'diminuez la taille de votre sujet';
                    $validsubject = false;
                } else {
                    $validsubject = true;
                }

                $annuler = false;
                $taillemax = 500 * 1000;

                if ($validsubject == true && !empty($articleContent)) {
                    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                        if ($_FILES['image']['size'] > $taillemax) {
                            echo "Fichier trop volumineux ,500 Ko max";
                            $annuler = true;
                        } else {
                            $tmp = $_FILES['image']['tmp_name'];
                            $name = $_FILES['image']['name'];
                            $image = uniqid() . substr($name, -5);
                            $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                            $fa = array("png", "jpg", "jpeg", "webp", "pdf");
                            $anciennom = $name;
                            if (!in_array($extension, $fa)) {
                                echo 'L\'extension n\'est pas accéptée';
                                $image = $currentImage;
                                $anciennom = $currentOldName;
                                $annuler = true;
                            }
                            if (!$annuler) {
                                move_uploaded_file($tmp, 'images/' . $image);
                            }
                        }
                    }

                    if (!$annuler) {
                        $sql = "UPDATE Article SET subject=:subject, content=:content, images=:images, anciennom=:anciennom WHERE id=:id";
                        $sql = $dbh->prepare($sql);
                        $sql->bindParam(':id', $id, PDO::PARAM_INT);
                        $sql->bindParam(':subject', $subject, PDO::PARAM_STR);
                        $sql->bindParam(':content', $articleContent, PDO::PARAM_STR);
                        $sql->bindParam(':images', $image, PDO::PARAM_STR);
                        $sql->bindParam(':anciennom', $anciennom, PDO::PARAM_STR);
                        $sql->execute();
                        $row = $sql->fetch();
                        header('Location:index.php?page=ListeArticles');
                        if ($row == null) {
                            echo "Erreur";
                        }
                        echo 'Formulaire envoyé';
                    }
                }
            } else {
                echo 'L\'article n\'existe pas./Manque d\'id';
            }
        }
    } else {
        echo 'Veuillez vous connecter pour voir cette page<br>';
    }
}
?>
