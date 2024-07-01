<?php
    
    require_once('header.php');
    if($_SESSION['id_role']!=2){
        header('Location:index.php');die;
            // Si tu es admin alors tu peux modifier ou supprimer
    }
    // Change le role de l'utilisateur en user
    $userUtiRq=$bdd->prepare('UPDATE utilisateur SET id_role=:id_role WHERE id_uti =:id');
    $userUtiRq->execute([
        "id_role"=>1,
        "id"=>$_GET['id']
    ]);

    header('Location:liste_uti.php');die;
require_once('footer.php');
?>