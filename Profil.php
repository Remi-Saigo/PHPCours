<h1 class = "text-danger text-center">Profil utilisateur</h1>
<?php
if (isset($_SESSION['login'])) {
    $sql = 'SELECT name, surname,email, id FROM User where email=:email';
    $sql = $dbh->prepare($sql);
    $sql->bindParam(':email', $_SESSION['login'], PDO::PARAM_STR);
    $sql->execute();
    $row = $sql->fetch();
    if ($row == null) {
        echo "Cet utilisateur n\'existe pas";
    } else {
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

        echo '<br>Nom:' . $row['name'] . '<br>Prenom:' . $row['surname'] . '<br>Email:' . $row['email'];
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
