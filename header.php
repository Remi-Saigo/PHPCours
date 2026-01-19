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
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=contact">Nous Contacter</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="index.php?page=ListeArticles">Liste Des articles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=ListeCommentaires">Liste Des Commentaires</a>
        </li>


        <?php
// Si on est connecté , si la clef login existe dans le tableau $_SESSION
if (isset($_SESSION['login'])) {
    //$email reçoit la valeur stockée dans $_SESSION
    $email = $_SESSION['login'];
    $role = $_SESSION['login'];
    if ($_SESSION['role'] == 'Admin') {;
        echo '  <li class="nav-item">
            <a class="nav-link" href="index.php?page=ListeCategories">Liste Des Catégories</a>
          </li>';
        echo ' <li class="nav-item">
          <a class="nav-link" href="index.php?page=ListeUser">Liste Des Utilisateurs</a>
        </li>';
        echo '<li class="nav-item">
        <a class="nav-link" href="index.php?page=AjoutCategorie">Nouvelle Catégorie</a>
      </li>';
        echo '  <li class="nav-item">
            <a class="nav-link" href="index.php?page=ListeCategories">Liste Des Catégories</a>
          </li>';
          echo '<li class="nav-item">
          <a class="nav-link" href="index.php?page=ListeContacts">Liste Des Contact</a>
        </li>';
        echo '<li class="nav-item">
        <a class="nav-link" href="index.php?page=AjoutCommentaire">Nouveau Commentaire</a>
      </li>';
    echo '<li class="nav-item">
        <a class="nav-link" href="index.php?page=AjoutArticle">Nouvel Article</a>
      </li>';
    echo '<li class="nav-item">
        <a class="nav-link" href="index.php?page=AjoutCategorie">Nouvelle Catégorie</a>
      </li>';}
          else{
    if ($_SESSION['role'] == 'User') {;
        echo '<li class="nav-item">
            <a class="nav-link" href="index.php?page=AjoutCommentaire">Nouveau Commentaire</a>
          </li>';
        echo '<li class="nav-item">
            <a class="nav-link" href="index.php?page=AjoutArticle">Nouvel Article</a>
          </li>';
        echo '<li class="nav-item">
            <a class="nav-link" href="index.php?page=AjoutCategorie">Nouvelle Catégorie</a>
          </li>';
        echo '  <li class="nav-item">
                <a class="nav-link" href="index.php?page=ListeCategories">Liste Des Catégories</a>
              </li>';}
            }
    //On affiche du HTML pour incliure l'adresse mail dans la navbar et prouver qu'on est connectés
    echo '<li class="nav-item">
          <a class="nav-link" href="">' . $email . '</a>
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
