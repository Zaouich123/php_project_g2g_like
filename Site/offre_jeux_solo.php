<?php
require_once('header.php');
require_once('navbar.php');

// Si je n'ai pas de variable id, je redirige vers l'accueil
if(!isset($_SESSION['id_uti'])){
    header('Location:index.php');die;
}



//Requête préparée pour avoir les attributs d'une offre, la personne qui vend l'offre, et l'offre en question
$annoncesObj = $bdd->prepare('SELECT u.pseudo_uti as pseudo_uti, u.id_uti as id_uti, a.id_offre as id_offre, a.titre_offre as titre_offre, a.des_offre as des_offre, a.prix_offre as prix_offre,
                            att.id_attr as id_attr, att.eb_attr as eb_attr, att.rp_attr as rp_attr, att.kamas_attr as kamas_attr, att.id_serveur as id_serveur, att.id_plat as id_plat,
                            s.nom_serveur as nom_serveur, p.nom_plat as nom_plat FROM utilisateur u 
                            LEFT JOIN annonce a on u.id_uti = a.id_uti LEFT JOIN attribut att on a.id_attr=att.id_attr LEFT JOIN serveur s on att.id_serveur=s.id_serveur LEFT JOIN platform p 
                            on att.id_plat=p.id_plat WHERE a.id_offre = ?');
$annoncesObj->execute([$_GET['id']]);

// Je récupère la première ligne du résultat (Je fais ça car je sélectionne par rapport à l'id)
$annonce = $annoncesObj->fetch();

// Si il n'y a pas d'offre, je redirige vers l'accueil
if($annonce == null){
    header('Location:index.php');die;
}
?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Titre</th>
      <th scope="col">Vendeur</th>
      <th scope="col">Description</th>
      <?php
      if($annonce['eb_attr'] != NULL){
        // Si il a un attribut eb on affiche
        ?>
        <th scope="col">Essence bleu</th>
        <?php
      }
      ?>
      <?php
      if($annonce['rp_attr'] != NULL){
        // Si il a un attribut rp on affiche
        ?>
        <th scope="col">RP</th>
        <?php
      }
      ?><?php
      if($annonce['kamas_attr'] != NULL){
        //Si il a un attribut kamas on affiche
        ?>
        <th scope="col">Kamas</th>
        <?php
      }
      ?><?php
      if($annonce['id_serveur'] != NULL){
        //Si il a un attribut serveur on affiche
        ?>
        <th scope="col">Serveur</th>
        <?php
      }
      ?><?php
      if($annonce['id_plat'] != NULL){
        //Si il a un attribut platform on affiche
        ?>
        <th scope="col">Platform</th>
        <?php
      }
      ?>
      
      <th scope="col">Prix</th>
      <th scope="col">Acheter</th>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><?= $annonce['id_offre'] ?></th>
      <td><?= $annonce['titre_offre'] ?></td>
      <td><a href="voir_uti2.php?id=<?= $annonce['id_uti'] ?>"><?= $annonce['pseudo_uti'] ?></td>
      <td><?= $annonce['des_offre'] ?></td>
      <?php
      if($annonce['eb_attr'] != NULL){
        // Si il a un attribut eb on affiche
        ?>
        <td><?= $annonce['eb_attr'] ?></td>
        
        <?php
      }
      ?>
      <?php
      if($annonce['rp_attr'] != NULL){
        // Si il a un attribut rp on affiche
        ?>
        <td><?= $annonce['rp_attr'] ?></td>
        <?php
      }
      ?><?php
      if($annonce['kamas_attr'] != NULL){
        //Si il a un attribut kamas on affiche
        ?>
        <td><?= $annonce['kamas_attr'] ?></td>
        <?php
      }
      ?><?php
      if($annonce['id_serveur'] != NULL){
        //Si il a un attribut serveur on affiche
        ?>
        <td><?= $annonce['nom_serveur'] ?></td>
        <?php
      }
      ?><?php
      if($annonce['id_plat'] != NULL){
        //Si il a un attribut platform on affiche
        ?>
        <td><?= $annonce['nom_plat'] ?></td>
        <?php
      }
      ?>
      <td><?= $annonce['prix_offre'] ?></td>
      <td><a href="achat.php?id=<?= $annonce['id_offre'] ?>">Acheter</a></td>
    </tr>
  </tbody>
</table>
<?php
require_once('footer.php');
