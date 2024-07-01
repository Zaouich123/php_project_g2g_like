<?php
require_once('header.php');
require_once('navbar.php');


if(!isset($_SESSION['id_uti'])){
    header('Location:index.php');die;
}


if(isset($_POST['mail'])){

    // Change le pseudo, mdp et mail de l'uti
    $userUtiRq=$bdd->prepare('UPDATE utilisateur SET pseudo_uti=:pseudo_uti,mail_uti=:mail_uti WHERE id_uti =:id');
    $userUtiRq->execute([
        "pseudo_uti"=>$_POST['pseudo'],
        "mail_uti"=>$_POST['mail'],
        "id"=>$_SESSION['id_uti']
    ]);

    $_SESSION['pseudo']=$_POST['pseudo'];

    header('Location:voir_uti.php');die;
}
// Formulaire de modification
?>
    <form action="" method="POST">
        <div>
            <label for="" class="col-md-2">Modification du Pseudo</label>
            <input type="text" value="<?= $_SESSION['pseudo'] ?>"  name="pseudo" required>
        </div>
        <div>
            <label for="" class="col-md-2">Modification du mail</label>
            <input type="text" value="<?= $_SESSION['mail_uti'] ?>"  name="mail" required>
        </div>

        <div>
            <input type="submit" value="Valider les modifications">
        </div>
    </form>
<?php
require_once('footer.php');
?>