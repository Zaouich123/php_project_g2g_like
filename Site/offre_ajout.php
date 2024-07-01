<?php
    require_once('header.php');
    require_once('navbar.php');
    if(!isset($_SESSION['id_uti'])){
        // si je ne suis pas connecté, renvoie vers la page d'accueil
        header('Location: index.php');die;
    }
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


            // Insert lors de la creation d'une offre les attributs de celle ci
            $insertAttr = $bdd->prepare('INSERT INTO attribut (eb_attr, rp_attr, kamas_attr, id_plat, id_serveur) VALUES (:eb, :rp, :kamas, :plat, :serv)');
            $insertAttr->execute([
                "eb" => $_POST['eb'],
                "rp" => $_POST['rp'],
                "kamas" => $_POST['kamas'],
                "plat" => $_POST['plat'],
                "serv" => $_POST['serv']             
            ]);

            // Insert une offre
            $insertAnnonce = $bdd->prepare('INSERT INTO annonce (titre_offre, des_offre, prix_offre, id_attr, id_jeu, id_uti) VALUES (:titre, :descr, :prix, :attr, :jeu, :uti)');
            $insertAnnonce->execute([
                "titre" => $_POST['titre'],
                "descr" => $_POST['descr'],
                "prix" => $_POST['prix'],
                "attr" => $bdd -> lastInsertId(),
                "jeu" => $_GET['id'],
                "uti" => $_SESSION['id_uti']
            ]);
            header('Location:offre_jeu_ajout.php');die;
    }
     // Ensuite on fait un formulaire pour modif / ajout
        ?>

            <h1>Creation d'offre</h1>
            
            <form action="" method="POST">
                <div>
                    <label for="" class="col-md-2">titre</label>
                    <input type="text" name="titre" required>
                </div>
                <div>
                    <label for="" class="col-md-2">description</label>
                    <input type="text" name="descr" required>
                </div>
                <div>
                    <label for="" class="col-md-2">prix</label>
                    <input type="number" name="prix" required>
                </div>
                <?php
                if($_GET['id']==1){
                    // Si nous sommes dans le cas league of legends
                ?>
                    <div>
                        <label for="" class="col-md-2">Nombre d'essence bleu</label>
                        <input type="number" name="eb" required>
                    </div>
                    <div>
                        <label for="" class="col-md-2">Nombre d'rp</label>
                        <input type="number" name="rp" required>
                    </div>
                    <?php
                }

                if($_GET['id']==3){
                    // Si nous sommes dans le cas dofus
                ?>
                    <div>
                        <label for="" class="col-md-2">Nombre de kamas</label>
                        <input type="number" name="kamas">
                    </div>
                    <?php
                }
                if($_GET['id']==1){
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
                            <option value="" selected></option>
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
                
                if($_GET['id']==2){
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
                            <option value="" selected></option>
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