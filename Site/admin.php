<?php

require_once('header.php');
require_once('navbar.php');

if($_SESSION['id_role']!=2){
    header('Location:index.php');die;
    
}
?>



<a href="liste_uti.php"> Liste des utilisateurs </a>


<?php
require_once('footer.php');
?>