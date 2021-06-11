<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.83.1">
  <title><?= (isset($title)) ? $title : SITETITLE ?></title><!-- ⛔Condition ternaire à mettre en plcace -->

  <!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbar-fixed/"> -->





  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <!-- 
  <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
  <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
  <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
  <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
  <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico"> -->
  <meta name="theme-color" content="#7952b3">


  <!-- <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=9cwj7zUOh3jpLzMAlgCViXVRboYxf_yZyVpPvc959skvs2-FlKDhZnbZIiqYhOKyOkmjCmrur6wvZ9D5YbWdoGV_tDnmGS5jHDhuNXuGICs" charset="UTF-8"></script> -->
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
<!-- <link href="navbar-top-fixed.css" rel="stylesheet"> -->

  <!-- css local -->
  <link rel="stylesheet" href="<?php echo URL ?>css/style.css">
</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark fixed-top navigation" >
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= URL ?>"><?= SITETITLE ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link <?php if ($title == "Accueil") echo 'active'; ?> " aria-current="page" href="<?= URL ?>">Accueil</a>
          </li>

          <?php if (!isConnected()) : ?>
            <!-- Si l'utilisateur n'est pas connecté on affiche inscription et connexion -->
            <li class="nav-item">
              <a class="nav-link <?php if ($title == "Inscription") echo 'active'; ?>" href="<?= URL ?>inscription.php">Inscription</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if ($title == "Connexion") echo 'active'; ?>" href="<?= URL ?>connexion.php" tabindex="-1" aria-current="page">Connexion</a>
            </li>
          <?php endif ?>
          <!-- Fin utilisateur non connecté -->


          <?php if (isConnected()) : ?>
            <li class="nav-item">
              <a class="nav-link <?php if ($title == "Profil") echo 'active'; ?>" href="<?php echo URL ?>frontOffice/profil.php">Profil (<?php echo $_SESSION['user']['pseudo'] ?>)</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="<?php echo URL ?>connexion.php?action=logout"><i class="bi bi-power"></i></a>
            </li>


            <?php if (isAdmin()) : ?>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle  <?php if ($title == "Gestion des utilisateurs" || $title == "Gestion des catégories"  ) echo 'active'; ?>" href="#" id="sousmenu" role="button" data-bs-toggle="dropdown">Back Office</a>
                <ul class="dropdown-menu">
                  <?php if (isAdmin()) : ?>
                    
                    <li>
                      <a class="dropdown-item" href="<?php echo URL ?>backOffice/gestion_annonces.php">Gestion des annonces</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="<?php echo URL ?>backOffice/gestion_membres.php">Gestion des membres</a>
                    </li>

                    <li>
                      <a class="dropdown-item" href="<?php echo URL ?>backOffice/gestion_categories.php">Gestion des catégories</a>
                    </li>
                 
                  <?php endif ?>
                </ul>
              </li>
            <?php endif; ?>
            <!-- Fin utilisateur admin -->
          <?php endif; ?>
          <!-- Fin utilisateur connecté -->



        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>


        </form>
      </div>
    </div>
  </nav>


  <main class=" mt-5">

    <?php
