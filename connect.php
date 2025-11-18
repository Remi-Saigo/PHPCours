<?php
if (isset($_POST["Valider"])) {
  //var_dump($_POST);
  $email = $_POST["AdresseMail"];
  $password = htmlentities($_POST["Password"]);

  if (empty($email)) {
    echo 'Veuillez saisir un Email';
  }
  else{
    echo "$email";
  }
  if (empty($password)) {
    echo 'Veuillez saisir un Mot De passe';
  }
  else{
    echo "$password";
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
