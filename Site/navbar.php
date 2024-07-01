<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light navbar-light ">
  <!-- Container wrapper -->
  <div class="container-fluid">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="index.php">G3A</a>

    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Link -->
        <?php
        if(isset($_SESSION['id_role']) && $_SESSION['id_role']==2){
        ?>
          <li class="nav-item">
            <a class="nav-link" href="admin.php">Admin menu</a>
          </li>
        <?php
        }
        ?>

        <li>
            <a class="nav-link" href="offre_jeu_ajout.php">Créer une offre</a>
        </li>
        <li>
            <a class="nav-link" href="index.php">Voir les offres</a>
        </li>
  
        <!-- Dropdown -->
        

      </ul>

      <!-- Icons -->
      <ul class="navbar-nav d-flex flex-row me-1">
        <li class="nav-item me-3 me-lg-0">
          <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i></a>
        </li>
        <li class="nav-item me-3 me-lg-0">
            <?php
            if(!isset($_SESSION['id_uti'])){
            
            ?>
                <a href="connexion.php" class="btn btn-primary">Connexion</a>
                <a href="inscription.php" class="btn btn-primary">Inscription</a>

            <?php
            }
            
        
            ?>

            <?php
            if(isset($_SESSION['id_uti'])){
            ?>
                <a href="deconnexion.php" class="btn btn-primary">Deconnexion</a>
                <a href="voir_uti.php" class="btn btn-primary">Profil</a>
            <?php
            }
            ?>
        </li>
      </ul>

    </div>
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->