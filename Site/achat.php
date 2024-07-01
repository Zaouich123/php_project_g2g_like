<?php
require_once('header.php');
require_once('navbar.php');
if(!isset($_SESSION['id_uti'])){
    header('Location:index.php');die;
    
}


?>
    <h1>Merci pour votre achat</h1>

    
<?php
require_once('footer.php');
?>