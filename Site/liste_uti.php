<?php

    

    require_once('header.php');
    require_once('navbar.php');
    if($_SESSION['id_role']!=2){
        header('Location:index.php');die;
            // Si tu es admin alors tu peux modifier ou supprimer
    }
    // Permet de lister tous les utilisateurs enregistrés sauf nous même
    $listeUtiRq=$bdd->prepare('SELECT * FROM utilisateur WHERE id_uti != ?');
    $listeUtiRq->execute([$_SESSION['id_uti']]);
    $listeUti=$listeUtiRq->fetchAll();

// Affiche la liste des utilisateurs avec leur pseudo, mail, motdepass, et les actions 
?>
    <table class="table">
    <thead>
      <tr>
        <th scope="col">Pseudo</th>
        <th scope="col">mail</th>
        <th scope="col">motdepass</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($listeUti as $liste){
  
      
      ?>
      <tr>
        <th scope="row"><?= $liste['pseudo_uti'] ?></th>
        <td><?= $liste['mail_uti'] ?></td>
        <td><?= $liste['password_uti'] ?></td>
        <?php
        if($liste['id_role']==2){
            // Si la personne est admin, alors tu peux suppr son compte ou le passer en utilisateur
        ?>
            <td><a href="uti_user.php?id=<?=$liste['id_uti'] ?>" class="btn btn-primary">Passer utilisateur</a>
            <a href="suppr_compte.php?id=<?=$liste['id_uti'] ?>" class="btn btn-danger">Supprimer le compte</a>
          </td>
          <?php
          }

        elseif($liste['id_role']!=2){
                // Si la personne est user, alors tu peux suppr son compte ou le passer en admin
        ?>
            <td><a href="uti_admin.php?id=<?=$liste['id_uti'] ?>" class="btn btn-primary">Passer Admin</a>
                <a href="suppr_compte.php?id=<?=$liste['id_uti'] ?>" class="btn btn-danger">Supprimer le compte</a>
            </td>
          <?php
          }
          ?>
      </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
  <?php
  require_once('footer.php');
  