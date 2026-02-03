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
        if (isset($_POST['validerPhoto'])) {
            if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                echo "Veuillez sélectionner une image valide";
            } else {
                $imageInfo = getimagesize($_FILES['photo']['tmp_name']);
                $allowedMimes = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp',
                    'image/gif' => 'gif'
                ];
                if ($imageInfo === false || !array_key_exists($imageInfo['mime'], $allowedMimes)) {
                    echo "Format d'image non supporté (jpg, png, webp, gif)";
                } else {
                    $extension = $allowedMimes[$imageInfo['mime']];
                    $uploadDir = __DIR__ . '/images/profiles';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $fileName = 'user_' . $row['id'] . '_' . time() . '.' . $extension;
                    $destination = $uploadDir . '/' . $fileName;
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                        if (!empty($row['photo']) && str_starts_with($row['photo'], 'profiles/')) {
                            $oldFile = __DIR__ . '/images/' . $row['photo'];
                            if (is_file($oldFile)) {
                                unlink($oldFile);
                            }
                        }
                        $photoPath = 'profiles/' . $fileName;
                        $sql = "UPDATE User SET photo=:photo WHERE id=:id";
                        $sql = $dbh->prepare($sql);
                        $sql->bindParam(':photo', $photoPath, PDO::PARAM_STR);
                        $sql->bindParam(':id', $row['id'], PDO::PARAM_INT);
                        $sql->execute();
                        $row['photo'] = $photoPath;
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

        $photoSrc = !empty($row['photo']) ? 'images/' . $row['photo'] : 'images/default-avatar.svg';
        echo '<div class="mb-3">
                <img src="' . htmlspecialchars($photoSrc) . '" alt="Photo de profil" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
              </div>';
        echo '<br>Nom:' . $row['name'] . '<br>Prenom:' . $row['surname'] . '<br>Email:' . $row['email'];
        echo '<form action="index.php?page=Profil" method="post" enctype="multipart/form-data" class="mt-3">
            <label class="form-label">Photo de profil</label>
            <input type="file" name="photo" class="form-control" accept="image/*" required>
            <button type="submit" name="validerPhoto" class="btn btn-primary m-4">Mettre à jour la photo</button>
            </form>';
        echo '<form action="index.php?page=Profil" method="post">
            Mot De Passe<input type="password" name="password"/>
            Confirmation <input type="password" name="confirmer"/>
            <button type="submit" name="valider1" class="btn btn-primary m-4">Modifier</button>
            </form>';
    }
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
