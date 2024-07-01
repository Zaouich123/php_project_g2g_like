<?php
require_once('header.php');
require_once('navbar.php');

if(!isset($_SESSION['id_uti'])){
    header('Location:index.php');die;
}

?>
    <h1>Création d'offre</h1>
    
    
    <table class="table">
        <thead>
        <tr>
            <th>Jeux</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Requête qui récupère les données id et nom des jeux

        $jeuxObj = $bdd->query("SELECT id_jeu,nom_jeu FROM jeu");
        // Met les résultats dans un tableau
        $jeux = $jeuxObj->fetchAll();

        foreach($jeux as $jeu){
            // Affiche les jeux pour la vente de compte
            ?>
            <tr>
                    <td>
                        <a href="offre_ajout.php?id=<?= $jeu['id_jeu'] ?>"><?= $jeu['nom_jeu'] ?></a>
                </td>
            </tr>
            <?php
        }
        ?>

        </tbody>
    </table>
<?php
require_once('footer.php');
?>