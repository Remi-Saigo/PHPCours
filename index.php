<?php
    //var_dump($_GET); (fonction qui permet d'afficher le contenu d'une variable, y compris les tableaux)
    require_once 'header.php';   
    require_once 'db/mariadb.php';
?>
<?php
if($dbh!=NULL){
    //Vérifie si la clef page existe dans le tableau $_GET
    if(isset($_GET['page'])){
        //Récupère la valeur qui correspond à la clef dans $_GET
        $page = $_GET['page'];
    }
    else{
        //Si la clef page n'existe pas dans le tableau , nous irons à la page home 
        $page = 'home';
    }
    //Si le fichier php de la page existe  
    if(file_exists($page.'.php')){
        //on l'apelle
        require_once $page.'.php';
    }
    else{
        //On apelle la page error
        require_once 'error404.php';
    }
} else {
    require_once 'maintenance.php';
}
?>
<?php
  require_once 'footer.php'     
?>
