<?php
require_once('header.php');
require_once('navbar.php');
if(!isset($_SESSION['id_uti'])){
  // SI tu n'es pas connecté, revoie vers la page d'accueil
    header('Location:index.php');die;
}

if(isset($_SESSION['id_uti'])){
  // Prend toutes les offres actuelles de l'utilisateur actuelle
  $annProfil = $bdd->prepare('SELECT u.id_uti as id_uti, u.pseudo_uti as pseudo_uti, u.mail_uti as mail_uti, r.nom_role as nom_role, a.id_offre as id_offre, 
                      a.titre_offre as titre_offre, a.des_offre as des_offre, a.prix_offre as prix_offre FROM utilisateur u LEFT JOIN role r on u.id_role = r.id_role LEFT JOIN annonce a
                      on u.id_uti=a.id_uti WHERE u.id_uti = ?');
  $annProfil->execute([$_SESSION['id_uti']]);

  $annProf = $annProfil->fetchAll();


  // Prend toutes les informations de l'utilisateur
  $Profil = $bdd->prepare('SELECT utilisateur.id_uti as id_uti, utilisateur.pseudo_uti as pseudo_uti, utilisateur.mail_uti as mail_uti, role.nom_role as nom_role
                          FROM utilisateur INNER JOIN role on utilisateur.id_role = role.id_role WHERE utilisateur.id_uti = ?');
  $Profil->execute([$_SESSION['id_uti']]);

  $Prof = $Profil->fetch();
}


// Information sur le profil et les offres de celui-ci
?>


<div>
    <h3>Pseudo :</h3>
    <?=$Prof['pseudo_uti'] ?>
</div>
<div><h3>Mail :</h3>
    <?=$Prof['mail_uti'] ?>
</div>
<div><h3>Role :</h3>
    <?=$Prof['nom_role'] ?>
</div>
<div><a href="uti_modif.php" class="btn btn-primary">Modifier l'utilisateur</a>
</div>



<table class="table">
  <thead>
    <tr>
      <th scope="col">Vendeur</th>
      <th scope="col">Titre</th>
      <th scope="col">Description</th>
      <th scope="col">Prix</th>
      <th scope="col">Voir</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach($annProf as $annPro){


    
    ?>
    <tr>
      <th scope="row"><?= $annPro['pseudo_uti'] ?></th>
      <td><?= $annPro['titre_offre'] ?></td>
      <td><?= $annPro['des_offre'] ?></td>
      <td><?= $annPro['prix_offre'] ?></td>
      <td><a href="offre_jeux_solo.php?id=<?= $annPro['id_offre'] ?>">Voir offre</a></td>
      <?php
      if($_SESSION['id_role']==2){
        // Si il est admin il peut modif ou suppr

      ?>
      <td><a href="hero_modif.php?id=<?=$annPro['id_offre'] ?>" class="btn btn-primary">Modifier l'annonce</a>
          <a href="suppr_annonce.php?id=<?=$annPro['id_offre'] ?>" class="btn btn-danger">Supprimer l'annonce</a>
        </td>
        <?php
        }
        ?>
      <?php
      if($_SESSION['id_uti']==$annPro['id_uti'] and $_SESSION['id_role']!=2){
        // Si ce sont ces offres il peut modif ou suppr

      ?>
      <td><a href=".php?id=<?= $annPro['id_offre'] ?>" class="btn btn-primary">Modifier l'annonce</a>
        <a href="suppr_annonce.php?id=<?= $annPro['id_offre'] ?>" class="btn btn-danger">Supprimer l'annonce</a>
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
?>