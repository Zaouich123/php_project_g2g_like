<?php
require_once('header.php');
if(!isset($_SESSION['id_uti'])){
    header('Location:index.php');die;
}
if(isset($_GET['id'])){
    // Faire un select avoir l'attr de l'offre
    $idSelect=$bdd->prepare('SELECT id_attr FROM annonce WHERE id_offre = ?');
    $idSelect->execute([$_GET['id']]);
    $id=$idSelect->fetch();

    // Supprime l'annonce
    $deleteoffre = $bdd->prepare('DELETE FROM annonce WHERE id_offre = ?');
    $deleteoffre->execute([$_GET['id']]);
    // Supprime les attributs de l'annonce associée
    $deleteattr = $bdd->prepare('DELETE FROM attribut WHERE id_attr = ?');
    $deleteattr->execute([$id['id_attr']]);

    header('Location:jeux_solo.php');die;
}
?>