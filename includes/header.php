<?php require_once 'includes/php_header.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Projet fin d'année</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Bubbleio</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <?php if(isset($_SESSION['user'])):?>
  <div class="collapse navbar-collapse" id="navbarText">

    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="home.php">Amis</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="posts.php">Articles</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="channels.php">Discussions</a>
      </li>
    </ul>

    <ul class="navbar-nav">
      <!-- <li class="nav-item">
        <div class="dropdown nav-link">
          <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell"></i> (1)
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> -->
            <!-- <h6 class="dropdown-header">Aucune notification</h6> -->
            <!-- <h6 class="dropdown-header">Demande d'ajout de Alex</h6>
            <a class="dropdown-item" href="#">Voir le profil</a>
            <span class="dropdown-item" href="#">
              <a href="#">Accepter</a>
              -
              <a href="#">Refuser</a>
            </span>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Nouveau message de Micka</h6>
            <span class="dropdown-item" href="#">
              <a href="#">Voir le message</a>
            </span>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Jack a répondu à votre commentaire</h6>
            <span class="dropdown-item" href="#">
              <a href="#">Voir la réponse</a>
            </span>
          </div>
        </div>
      </li> -->
      <li class="nav-item">
        <div class="dropdown nav-link">
          <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user"></i> <?= ucfirst($_SESSION['user']['name']);?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#"></i> Mon profil</a>
            <a class="dropdown-item" href="#">action 2</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="deconnexion.php"><i class="fa fa-sign-out"></i> Déconnexion</a>
          </div>
        </div>
      </li>
    </ul>

  </div>
  <?php endif;?>
</nav>
