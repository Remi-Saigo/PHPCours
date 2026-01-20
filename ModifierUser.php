<h1 class = "text-danger text-center">Modification Des Utilisateurs</h1>
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

        $user = null;
//Vérifie l'existence de la clef user dans le tableau $_GET (URL)
        if (isset(($_GET)["utilisateur"])) {
            //récupère la clef et sa valeur dans $user
            $user = $_GET['utilisateur'];
        }

//Si $user n'est pas null , lance le script
        if ($user) {
            //déclare la requête SQL permettant de chercher un user
            $sql = "SELECT id, name,password,email FROM User WHERE id=:id";
            //Prépare la requête , en protégeant les paramètres et en vérifiant leur type
            $sql = $dbh->prepare($sql);
            //On associe la variable PHP à la variable SQL
            $sql->bindParam(':id', $user, PDO::PARAM_INT);
            //On exécute la requête
            $sql->execute();
            //On récupère la ligne corresspondant à la réponse de la requête
            $row = $sql->fetch();
            // si la ligne est nulle c'est que la catégorie n'existe pas
            if ($row == null) {
                // Alors , on écrit qu'il n'as pas les bons identifiants
                echo "Cet utilisateur n\'existe pas";
            } else {
                echo '<form action="index.php?page=ModifierUser" method="post">
        <div>
        <label for="exampleInputArticle" class="form-label mt-4">user</label>
        <input type="text" autocomplete="off" class="form-control" id="exampleArticle" aria-describedby="userHelp" placeholder="Enter user"
        name="user" value="' . $row['name'] . '" required></input>
        </div>
        <div>
        <input type="text" autocomplete="off" class="form-control" id="exampleArticle" aria-describedby="userHelp" placeholder="Enter new Password"
        name="password"></input>
        </div>
        <div>
        <input type="text" autocomplete="off" class="form-control" id="exampleArticle" aria-describedby="userHelp" placeholder="Enter user"
        name="email" value="' . $row['email'] . '" required></input>
        </div>
        <div>
        <input name="id" value="' . $row['id'] . '" type="hidden"/>
      </div>
      <button type="submit" class="btn btn-primary m-4" name="Valider">Soumettre</button>
</form>';
            }
        } else {
            echo 'formulaire';
        if (isset($_POST["Valider"])) {
            $user = $_POST['user'];
            $id = $_POST['id'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            echo $id;
            echo $user;
            $sql = "UPDATE User SET name=:name , email=:email , password=:password WHERE id=:id";
            $password = password_hash("$password", PASSWORD_DEFAULT);
            $sql = $dbh->prepare($sql);
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->bindParam(':name', $user, PDO::PARAM_STR);
            $sql->bindParam(':password', $password, PDO::PARAM_STR);
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
            $sql->execute();
            $row = $sql->fetch();
            header('Location:index.php?page=ListeUser');
            if ($row == null) {
                echo "Erreur";
            }
            echo 'Formulaire envoyé';
        } else {
            echo 'La catégorie n\'existe pas./Manque d\'id';
        }
    }
} else {
    echo 'Veuillez vous connecter pour voir cette page<br>';

}
}
?>