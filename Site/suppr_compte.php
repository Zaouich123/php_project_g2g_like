<?php

require_once('header.php');

if($_SESSION['id_role']!=2){
    header('Location:index.php');die;
}
if(isset($_GET['id'])){




    // Faire un select avoir l'id de l'offre de l'uti
    $idOffreObj=$bdd->prepare('SELECT id_offre FROM annonce WHERE id_uti = ?');
    $idOffreObj->execute([$_GET['id']]);
    $idOffre=$idOffreObj->fetchAll();
    // Faire un select avoir l'attr de l'offre de l'uti
    $idAttrObj=$bdd->prepare('SELECT id_attr FROM annonce WHERE id_uti = ?');
    $idAttrObj->execute([$_GET['id']]);
    $idAttr=$idAttrObj->fetchAll();




    // Supprime l'utilisateur
    $deleteUti = $bdd->prepare('DELETE FROM utilisateur WHERE id_uti = ?');
    $deleteUti->execute([$_GET['id']]);
    // Supprime les annonces



    foreach($idOffre as $idO){
        $deleteOffre = $bdd->prepare('DELETE FROM annonce WHERE id_offre = ?');
        $deleteOffre->execute([$idO['id_offre']]);

    }

    
    foreach($idAttr as $idA){
        $deleteAttr = $bdd->prepare('DELETE FROM attribut WHERE id_attr = ?');
        $deleteAttr->execute([$idA['id_attr']]);
    }
    // Supprime les attributs de l'annonce associée
    

    header('Location:liste_uti.php');die;
}
?>