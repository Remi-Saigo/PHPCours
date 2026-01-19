<?php
    Session_start();
    require_once 'header.php';   
    require_once 'db/mariadb.php';
if($dbh!=NULL){
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 'home';
    }
    if(file_exists($page.'.php')){
        require_once $page.'.php';
    }
    else{
        require_once 'error404.php';
    }
} else {
    require_once 'maintenance.php';
}
  require_once 'footer.php'     
?>
