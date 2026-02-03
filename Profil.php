<h1 class = "text-danger text-center">Profil utilisateur</h1>
<?php
if (isset($_SESSION['login'])) {
    $sql = 'SELECT name, surname,email, id, photo FROM User where email=:email';
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':email', $_SESSION['login'], PDO::PARAM_STR);
    $sql->execute();
    $row = $sql->fetch();
    if ($row == null) {
        echo "Cet utilisateur n\'existe pas";
    } else {
        if (isset($_POST['validerp'])) {
            if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                echo "Veuillez sélectionner une image valide";
            } else {
                $infoimage = getimagesize($_FILES['photo']['tmp_name']);
                $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                $extensionsok = ['jpg', 'jpeg', 'png', 'webp'];
               } 
               if ($infoimage === false ||!in_array($extension, $extensionsok)) {
                    echo "Format d'image non supporté";}
                    else {
                    $direction = __DIR__ . '/images/profiles';
                    if (!is_dir($direction)) {
                        mkdir($direction, 0755, true);
                    }
                    $fileName = 'user_' . $row['id'] . '_' . time() . '.' . $extension;
                    $destination = $direction . '/' . $fileName;
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                        if (!empty($row['photo']) && str_starts_with($row['photo'], 'profiles/')) {
                            $ancienfichier = __DIR__ . '/images/' . $row['photo'];
                            if (is_file($ancienfichier)) {
                                unlink($ancienfichier);
                            }
                        }
                        $cheminphoto = 'profiles/' . $fileName;
                        $sql = "UPDATE User SET photo=:photo WHERE id=:id";
                        $sql = $dbh->prepare($sql);
                        $sql->bindParam(':photo', $cheminphoto, PDO::PARAM_STR);
                        $sql->bindParam(':id', $row['id'], PDO::PARAM_INT);
                        $sql->execute();
                        $row['photo'] = $cheminphoto;
                        echo "Photo de profil mise à jour";
                    } else {
                        echo "Erreur lors de l'envoi de l'image";
                    }
            }
            }
        }

        if (isset($_POST['valider1'])) {
            $password = $_POST['password'];
            if (empty($password)) {
                echo 'saisir le mot de passe';
            } else {
                $confirmer = $_POST['confirmer'];
                if ($password == $confirmer) {
                    $password = password_hash("$password", PASSWORD_DEFAULT);
                    $sql = "UPDATE User SET password=:password WHERE email=:email";
                    $sql = $dbh->prepare($sql);
                    $sql->bindParam(':email', $_SESSION['login'], PDO::PARAM_STR);
                    $sql->bindParam(':password', $password, PDO::PARAM_STR);
                    $sql->execute();

                }
                $r = $sql->execute();
                if ($r) {
                    echo "Inscription réussie";
                } else {
                    echo "Inscription échouée";
                }
            }
        }

        $photo = !empty($row['photo']) ? 'images/' . $row['photo'] : 'images/default-avatar.svg';
        echo '<div class="mb-3">
                <img src="' . htmlspecialchars($photo) . '" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
              </div>';
        echo '<div class="mb-3">
            <br>Nom:' . $row['name'] . '<br>Prenom:' . $row['surname'] . '<br>Email:' . $row['email'];
        echo '</div>';
        echo '<form action="index.php?page=Profil" method="post" enctype="multipart/form-data" class="mt-3">
            <label class="form-label">Photo De Profil</label>
            <input type="file" name="photo" class="form-control" accept="image/*" required>
            <button type="submit" name="validerp" class="btn btn-primary m-4">Mettre à Jour la Photo</button>
            </form>';
        echo '<form action="index.php?page=Profil" method="post">
            Mot De Passe<input type="password" name="password"/>
            Confirmation <input type="password" name="confirmer"/>
            <button type="submit" name="valider1" class="btn btn-primary m-4">Modifier</button>
            </form>';
    
    if (isset($_POST['valider2'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        if (empty($name) || empty($surname)) {
            echo 'Effectuer un changement de Nom et Prénom';
        } else {
            $sql = "UPDATE User SET name=:name , surname=:surname WHERE email=:email";
            $sql = $dbh->prepare($sql);
            $sql->bindParam(':email', $_SESSION['login'], PDO::PARAM_STR);
            $sql->bindParam(':name', $name, PDO::PARAM_STR);
            $sql->bindParam(':surname', $surname, PDO::PARAM_STR);
            $sql->execute();

            $r = $sql->execute();
            if ($r) {
                echo "Inscription réussie";
            } else {
                echo "Inscription échouée";
            }
        }
    }
    echo '<form action="index.php?page=Profil" method="post">
    Nouveau Nom<input type="text" name="name"/>
    Nouveau Prénom <input type="text" name="surname"/>
    <button type="submit" name="valider2" class="btn btn-primary m-4">Modifier</button>
    </form>';

    if (isset($_POST['valider3'])) {
        $mail = $_POST['nemail'];
        if (empty($mail)) {
            echo 'Effectuer un changement de Mail';
        } else {
            $sql = "SELECT email FROM User WHERE email=:email";
            $sql = $dbh->prepare($sql);
            $sql->bindParam(':email', $mail, PDO::PARAM_STR);
            $sql->execute();
            $row = $sql->fetch();

            if ($row == null) {
                $confirmerE = $_POST['confirmationE'];
                if ($mail == $confirmerE) {
                    $sql = "UPDATE User SET email=:email WHERE id=:id";
                    $sql = $dbh->prepare($sql);
                    $sql->bindParam(':email', $mail, PDO::PARAM_STR);
                    $sql->bindParam(':id', $row['id'], PDO::PARAM_STR);
                    $sql->execute();
                }
                $r = $sql->execute();
                if ($r) {
                    echo "Mail Changé";
                    $_SESSION['login'] = $mail;
                    header('Location:index.php?page=Profil');
                } else {
                    echo "Inscription échouée";
                }
            } else {
                echo "Email déjà utilisé";
            }
        }
    }
    echo '<form action="index.php?page=Profil" method="post">
    Nouveau Mail<input type="text" name="nemail"/>
    Confirmation <input type="text" name="confirmationE"/>
    <button type="submit" name="valider3" class="btn btn-primary m-4">Modifier</button>
    </form>';
} else {
    echo 'Vous n\'etes pas connecté <br>';
}
