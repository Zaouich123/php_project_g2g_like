<?php
require_once 'header.php';

$message = "";
if(isset($_POST['mail'])){
    $insert = $bdd->prepare('INSERT INTO utilisateur (mail_uti, pseudo_uti, password_uti, id_role) VALUES(:mail, :pseudo, :mdp, :rolee)');
    $insert->execute([
            'mail' => $_POST['mail'],
            'pseudo' => $_POST['pseudo'],
            'mdp' => md5($_POST['password']),
            'rolee' => '2',
            
    ]);
    header('Location:connexion.php?message=inscriptionOk');die;
}
?>

        <div class="row">
            <div class="col-md-4 offset-md-4 text-center my-connexion">
                <h1>Inscription</h1>
                <?php
                /*if($message) {
                    */?><!--
                    <div class="alert alert-warning" role="alert">
                        <?/*= $message */?>
                    </div>
                    --><?php
/*                }*/
                ?>
                <div class="row">
                    <form class="col-md-12" method="post">
                        <div class="form-group">
                            <input type="text" required class="form-control" placeholder="Mail" name="mail" value="<?php if($message !== ""){echo $_POST['mail'];} ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" required class="form-control" placeholder="Pseudo" name="pseudo" value="<?php if($message !== ""){echo $_POST['pseudo'];} ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" required class="form-control" placeholder="Mot de passe" name="password" value="<?php if($message !== ""){echo $_POST['password'];} ?>">
                        </div>
                        <div>
                            <a href="connexion.php">Vous avez déjà un compte ? Connectez-vous !!!</a>
                        </div>

                        <input type="submit" value="Inscription" class="btn btn-primary form-control">
                    </form>
                </div>
            </div>

        </div>




<?php
require_once 'footer.php';