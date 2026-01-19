<?php
if (isset($_POST["Valider"])) {
    //var_dump($_POST);
    $email = $_POST["AdresseMail"];
    $password = htmlentities($_POST["Password"]);

    if (empty($email)) {
        echo 'Veuillez saisir un Email';
        $validemail = false;
    } else {
        $validemail = true;
    }
    if (empty($password)) {
        echo 'Veuillez saisir un Mot De passe';
        $valipassword = false;
    } else {
        $validpassword = true;
    }
    //si L'email et le mot de passe sont saisis
    if (($validemail) && ($validpassword)) {
        //on ecrit la requête qui va retourner les informations de l'utilisateur qui possède cet email
        $sql = 'SELECT name, surname, email,password,role FROM User where email= :email';
        //on prépare la requête
        $sql = $dbh->prepare($sql);
        // on associe la variable $email à la variable :email , cela protège des codes malveillants
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        // execute la requete
        $sql->execute();
        // on récupère la ligne de résultat
        $row = $sql->fetch();
        // si la ligne est nulle c'est que l'uilisateur n'existe pas
        if ($row == null) {
            // Alors , on écrit qu'il n'as pas les bons identifiants
            echo "Identifiants Incorrects";
        } else {
            if (password_verify($password, $row['password'])) {
                // la connexion à réussi et nous stockons l'email de la personne dans le tableau $_session en créant la clef login
                $_SESSION['login'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                header('Location:index.php');
                exit;
            } else {
                echo "Identifiants Incorrects";
            }
        }
    }
}
?>
<form action="index.php?page=connect" method="post">
  <h1 class = "text-danger text-center">Connexion</h1>
    <div>
      <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="AdresseMail">
    </div>
    <div>
      <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" name="Password">
    </div>
    <div>
      <button name="Valider" type="submit" class="btn btn-primary m-4">Connexion</button>
    </div>
</form>
