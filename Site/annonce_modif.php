<?php
    require_once('header.php');
    require_once('navbar.php');
    if(!isset($_SESSION['id_uti'])){
        // si je ne suis pas connecté, renvoie vers la page d'accueil
        header('Location: index.php');
    }
    //Requête préparée pour avoir les attributs d'une offre, la personne qui vend l'offre, et l'offre en question
    $annoncesObj = $bdd->prepare('SELECT u.pseudo_uti as pseudo_uti, u.id_uti as id_uti, a.id_offre as id_offre, a.id_jeu as id_jeu, a.titre_offre as titre_offre, a.des_offre as des_offre, a.prix_offre as prix_offre,
    att.id_attr as id_attr, att.eb_attr as eb_attr, att.rp_attr as rp_attr, att.kamas_attr as kamas_attr, att.id_serveur as id_serveur, att.id_plat as id_plat,
    s.nom_serveur as nom_serveur, p.nom_plat as nom_plat FROM utilisateur u 
    LEFT JOIN annonce a on u.id_uti = a.id_uti LEFT JOIN attribut att on a.id_attr=att.id_attr LEFT JOIN serveur s on att.id_serveur=s.id_serveur LEFT JOIN platform p 
    on att.id_plat=p.id_plat WHERE a.id_offre = ?');
    $annoncesObj->execute([$_GET['id']]);
    
    // Je récupère la première ligne du résultat (Je fais ça car je sélectionne par rapport à l'id)
    $annonce = $annoncesObj->fetch();
    if(isset($_POST['prix'])) {
        // Si il n'y a pas d'élément, alors on met les lignes en null
        if(!isset($_POST['eb']) || $_POST['eb'] == ''){
            $_POST['eb'] = null;
        }
        if(!isset($_POST['kamas']) ||$_POST['kamas'] == ''){
            $_POST['kamas'] = null;
        }
        if(!isset($_POST['rp']) ||$_POST['rp'] == ''){
            $_POST['rp'] = null;
        }
        if(!isset($_POST['plat']) ||$_POST['plat'] == ''){
            $_POST['plat'] = null;
        }
        if(!isset($_POST['serv']) ||$_POST['serv'] == ''){
            $_POST['serv'] = null;
        }
            
            print_r($bdd->errorInfo());
            $idAttrObj=$bdd->prepare('SELECT id_attr FROM annonce WHERE id_offre = ?');
            $idAttrObj->execute([$_GET['id']]);
            $idAttr=$idAttrObj->fetch();




            // update lors de la creation d'une offre les attributs de celle ci
            $updateAttr = $bdd->prepare('UPDATE attribut SET eb_attr=:eb, rp_attr=:rp, kamas_attr=:kamas, id_plat=:plat, id_serveur=:serv WHERE id_attr=:id_attr');
            $updateAttr->execute([
                "eb" => $_POST['eb'],
                "rp" => $_POST['rp'],
                "kamas" => $_POST['kamas'],
                "plat" => $_POST['plat'],
                "serv" => $_POST['serv'],
                "id_attr" => $idAttr['id_attr']                
            ]);

            // update une offre
            $updateAnnonce = $bdd->prepare('UPDATE annonce SET titre_offre=:titre, des_offre=:descr, prix_offre=:prix WHERE id_offre=:id_offre');
            $updateAnnonce->execute([
                "titre" => $_POST['titre'],
                "descr" => $_POST['descr'],
                "prix" => $_POST['prix'],
                "id_offre" => $_GET['id']
            ]);
            header('Location:offre_jeu_ajout.php');die;
    }

    // Ensuite on fait un formulaire pour modif / ajout
        ?>

            <h1>Modification d'offre</h1>
            
            <form action="" method="POST">
                <div>
                    <label for="" class="col-md-2">titre</label>
                    <input type="text" value="<?= $annonce['titre_offre'] ?>" name="titre" required>
                </div>
                <div>
                    <label for="" class="col-md-2">description</label>
                    <input type="text" value="<?= $annonce['des_offre'] ?>" name="descr" required>
                </div>
                <div>
                    <label for="" class="col-md-2">prix</label>
                    <input type="number" value="<?= $annonce['prix_offre'] ?>" name="prix" required>
                </div>
                <?php
                if($annonce['id_jeu']==1){
                    // Si nous sommes dans le cas league of legends
                ?>
                    <div>
                        <label for="" class="col-md-2">Nombre d'essence bleu</label>
                        <input type="number" value="<?= $annonce['eb_attr'] ?>" name="eb" required>
                    </div>
                    <div>
                        <label for="" class="col-md-2">Nombre d'rp</label>
                        <input type="number" value="<?= $annonce['rp_attr'] ?>" name="rp" required>
                    </div>
                    <?php
                }

                if($annonce['id_jeu']==3){
                    // Si nous sommes dans le cas dofus
                ?>
                    <div>
                        <label for="" class="col-md-2">Nombre de kamas</label>
                        <input type="number" value="<?= $annonce['kamas_attr'] ?>" name="kamas">
                    </div>
                    <?php
                }
                if($annonce['id_jeu']==1){
                    // Si nous sommes dans le cas league of legends, on prend tous les noms de serveur pour pouvoir les mettres en option
                $serveurRq = $bdd->query('SELECT * FROM serveur ORDER BY nom_serveur');
                $serveur = $serveurRq->fetchAll();
                ?>
                <div class="row">
                    <div class="col-md-2">
                        <label>Serveur</label>
                    </div>
                    <div class="col-md-8">
                        <select name="serv" id="" class="form-control">
                            <option value="<?= $annonce['nom_plat'] ?>" selected></option>
                            <?php
                            foreach ($serveur as $serv) {
                                ?>
                                <option value="<?= $serv['id_serveur'] ?>"><?= $serv['nom_serveur'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php
                }
                
                if($annonce['id_jeu']==2){
                    // Si nous sommes dans le cas de rust, on prend le nom des platform et on créer des lignes en plus de form
                $platRq = $bdd->query('SELECT * FROM platform ORDER BY nom_plat');
                $plat = $platRq->fetchAll();
                ?>
                <div class="row">
                    <div class="col-md-2">
                        <label>platform</label>
                    </div>
                    <div class="col-md-8">
                        <select name="plat" id="" class="form-control">
                            <option value="<?= $annonce['id_plat'] ?>" selected></option>
                            <?php
                            foreach ($plat as $pla) {
                                //Choix du de la platform stockée dans la base de donnée 
                                ?>
                                <option value="<?= $pla['id_plat'] ?>"><?= $pla['nom_plat'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php
                }
                ?>
                <input method="post" type="submit" class="btn btn-primary">
                </form>
                <?php

?>
<?php
require_once('footer.php');
?>