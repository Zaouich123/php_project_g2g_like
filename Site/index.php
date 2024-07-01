<?php
require_once('header.php');
require_once('navbar.php');


?>
    <h1>Liste des offres</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Jeux</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Requête qui récupère les données des heros

        $jeuxObj = $bdd->query("SELECT id_jeu,nom_jeu FROM jeu");
        // Met les résultats dans un tableau
        $jeux = $jeuxObj->fetchAll();

        $nombresObj = $bdd->query("SELECT id_jeu,nom_jeu FROM jeu");

        foreach($jeux as $jeu){
            // Savoir le nombre d'annonce pour un jeu, si plusieurs met offres sinon offre
            $nombresObj = $bdd->prepare("SELECT COUNT(*) as nombre_annonce FROM annonce WHERE id_jeu = ?");
            $nombresObj-> execute([$jeu['id_jeu']]);
            $nombres = $nombresObj->fetch();
            ?>
            <tr>
                    <td>
                        <a href="jeux_solo.php?id=<?= $jeu['id_jeu'] ?>"><?= $jeu['nom_jeu'] ?></a>
                        <span>
                            Il y a 
                            <?= $nombres["nombre_annonce"]?>
                            <?php
                            if($nombres["nombre_annonce"]==1 || $nombres["nombre_annonce"]==0){
                                ?>
                                offre 
                                <?php
                            }
                            else{
                                ?>
                                offres
                                <?php
                            }
                            ?>
                            
                        </span>
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