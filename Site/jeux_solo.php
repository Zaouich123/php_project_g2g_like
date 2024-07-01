<?php
require_once('header.php');
require_once('navbar.php');
// Si je n'ai pas de variable id, je redirige vers l'accueil
if(!isset($_SESSION['id_uti'])){
    header('Location:index.php');die;
}


if(isset($_POST['id_offre'])){
  $supprObj = $bdd->prepare('DELETE a.id_uti as id_uti, u.pseudo_uti as pseudo_uti, a.id_offre as id_offre, a.titre_offre as titre_offre, a.des_offre as des_offre, a.prix_offre as prix_offre  FROM utilisateur u
                            LEFT JOIN annonce a on u.id_uti = a.id_uti
                            WHERE a.id_jeu = ?');
  $supprObj->execute([$_GET['id']]);

// Je récupère la première ligne du résultat (Je fais ça car je sélectionne par rapport à l'id)
// $annonces = $annoncesObj->fetchAll();
}

//Requête préparée
$annoncesObj = $bdd->prepare('SELECT a.id_uti as id_uti, u.pseudo_uti as pseudo_uti, a.id_offre as id_offre, a.titre_offre as titre_offre, a.des_offre as des_offre, a.prix_offre as prix_offre  FROM utilisateur u
                            LEFT JOIN annonce a on u.id_uti = a.id_uti
                            WHERE a.id_jeu = ?');
$annoncesObj->execute([$_GET['id']]);

// Je récupère la première ligne du résultat (Je fais ça car je sélectionne par rapport à l'id)
$annonces = $annoncesObj->fetchAll();

// Si il n'y a pas d'offre, je redirige vers l'accueil
if($annonces == null){
    header('Location:index.php');die;
}
?>


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
    foreach($annonces as $annonce){

    
    ?>
    <tr>
      <th scope="row"><?= $annonce['pseudo_uti'] ?></th>
      <td><?= $annonce['titre_offre'] ?></td>
      <td><?= $annonce['des_offre'] ?></td>
      <td><?= $annonce['prix_offre'] ?></td>
      <td><a href="offre_jeux_solo.php?id=<?= $annonce['id_offre'] ?>">Voir offre</a></td>
      <?php
      if($_SESSION['id_role']==2){
          // Si tu es admin alors tu peux modifier ou supprimer
      ?>
      <td><a href="annonce_modif.php?id=<?=$annonce['id_offre'] ?>" class="btn btn-primary">Modifier l'annonce</a>
          <a href="suppr_annonce.php?id=<?=$annonce['id_offre'] ?>" class="btn btn-danger">Supprimer l'annonce</a>
        </td>
        <?php
        }
        ?>
      <?php
      if($_SESSION['id_uti']==$annonce['id_uti'] and $_SESSION['id_role']!=2){
          // Si tu es le propriétaire de l'annonce alors tu peux modifier ou supprimer
      ?>
      <td><a href="annonce_modif.php?id=<?= $annonce['id_offre'] ?>" class="btn btn-primary">Modifier l'annonce</a>
        <a href="suppr_annonce.php?id=<?= $annonce['id_offre'] ?>" class="btn btn-danger">Supprimer l'annonce</a>
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
