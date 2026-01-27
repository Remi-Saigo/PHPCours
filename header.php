<?php
// si la session n'est pas démarré alors le faire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super PHP</title>
    <link href="https://bootswatch.com/5/cyborg/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">PHP</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Accueil
            <span class="visually-hidden">(current)</span>
          </a>
        </li>



        <?php
// Si on est connecté , si la clef login existe dans le tableau $_SESSION
if (isset($_SESSION['login'])) {
    //$email reçoit la valeur stockée dans $_SESSION
    $email = $_SESSION['login'];
    $role = $_SESSION['login'];
    if ($_SESSION['role'] == 'Admin') {;
        echo '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
      <button type="button" class="btn btn-outline-danger">Listes Admin</button>
      <div class="btn-group" role="group">
        <button id="btnGroupDrop3" type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop3">
          <a class="dropdown-item" href="index.php?page=ListeUser">Liste des Utilisateurs</a>
          <a class="dropdown-item" href="index.php?page=ListeCategories">Liste des Categories</a>
          <a class="dropdown-item" href="index.php?page=ListeContacts">Liste des Contacts</a>
          <a class="dropdown-item" href="index.php?page=ListeArticles">Liste Des Articles</a>
        </div>
      </div>
    </div>';
    echo '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
      <button type="button" class="btn btn-outline-danger">Créer</button>
      <div class="btn-group" role="group">
        <button id="btnGroupDrop3" type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop3">
          <a class="dropdown-item" href="index.php?page=AjoutArticle">Nouvel Article</a>
          <a class="dropdown-item" href="index.php?page=AjoutCategorie">Nouvelle Catégorie</a>
        </div>
      </div>
    </div>';} 
    echo '<li class="nav-item">
          <a class="nav-link" href="index.php?page=Profil">' . $email . '</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=Deconnexion">Se Deconnecter</a>
        </li>';
} else {
    echo '<li class="nav-item">
          <a class="nav-link" href="index.php?page=connect">Connexion</a>
        </li>';
    echo '<li class="nav-item">
        <a class="nav-link" href="index.php?page=signup">S\'inscrire</a>
        </li>';
}
?>
          <li class="nav-item">
          <a class="nav-link" href="index.php?page=contact">Nous Contacter</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-sm-2" type="search" placeholder="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<div class="container text-center">
  <div class="row align-items-start">
