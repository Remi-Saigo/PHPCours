<?php
if (isset($_POST["Valider"])) {
    $email = htmlentities($_POST["Mail"]);
    $password = htmlentities($_POST["Password"]);
    $name = htmlentities($_POST["Name"]);
    $surname = htmlentities($_POST["Surname"]);

    if (empty($email) || empty($password) || empty($name) || empty($surname)) {
        echo "Veuillez remplir tous les champs :<br>";
        if (empty($email)) {
            echo 'Veuillez saisir un Email<br>';
        }
        if (empty($password)) {
            echo 'Veuillez saisir un Mot De passe<br>';
        }
        if (empty($name)) {
            echo 'Veuillez saisir un Nom<br>';
        }
        if (empty($surname)) {
            echo 'Veuillez saisir un Prénom<br>';
        }
    } 
        $sql = "SELECT email FROM User WHERE email=:email";
        $sql = $dbh->prepare($sql);
        $sql->bindParam(':email', $mail, PDO::PARAM_STR);
        $sql->execute();
        $row2 = $sql->fetch();

    if ($row2 == null && !empty($email) && !empty($password) && !empty($name) && !empty($surname)) {
        $password = password_hash("$password", PASSWORD_DEFAULT);
        $sql = $dbh->prepare("INSERT INTO User(`name`, `surname`, `email`, `password`,`role`) VALUES (:name, :surname, :email, :password,'User')");
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':surname', $surname, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':password', $password, PDO::PARAM_STR);
        $r = $sql->execute();
        $row = $sql->fetch();
        if ($r) {
            echo "Inscription réussie";
        } else {
            echo "Inscription échouée";
        }
    } else {
      echo "Email déjà utilisé";
  }
    
}
?>

<h1 class = "text-danger text-center">Inscription</h1>
  <div class="col-12 col-md-6">
    <form action="index.php?page=signup" method="post">
      <div>
        <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="Mail">
      </div>
      <div>
        <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"name="Password" autocomplete="off">
      </div>
      <div>
        <label for="exampleInputName" class="form-label mt-4">Nom</label>
        <input type="text" class="form-control" id="exampleInputName" placeholder="Nom" name="Name"autocomplete="off">
      </div>
      <div>
        <label for="exampleInputSurname" class="form-label mt-4">Prénom</label>
        <input type="text" class="form-control" id="exampleInputSurname" placeholder="Surname" name="Surname"autocomplete="off">
      </div>
    </div>
    <div class="col-12 col-md-6">
      <legend class="mt-4">Genre</legend>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="Genre" id="optionsRadios1" value="Homme" checked="">
          <label class="form-check-label" for="optionsRadios1">Homme</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="Genre" id="optionsRadios2" value="Femme">
          <label class="form-check-label" for="optionsRadios2">Femme</label>
        </div>
        <div class="form-check disabled">
          <input class="form-check-input" type="radio" name="Genre" id="optionsRadios3" value="Autre"  >
          <label class="form-check-label" for="optionsRadios3">Autre</label>
        </div>
    </div>
  <button type="submit" class="btn btn-primary m-4" name="Valider">Soumettre</button>
</form>
