<?php
require_once 'includes/header.php';
$users = selectAll('users');
?>

<div class="container">
  <h1>Connexion</h1>
  <hr>

  <div class="col-lg-12">
    <form method="POST" action="authentification.php">
      <div class="row">
        <div class="col">
          <input type="text" class="form-control" name="login" placeholder="Login">
        </div>
        <div class="col">
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="col">
          <input type="submit" class="btn btn-block btn-primary" value="Se connecter">
        </div>
      </div>
    </form>
  </div><br><br>

  <h4>Connecte toi avec un des comptes test suivants :</h4>
  <?php foreach ($users as $user) : ?>
  <p>
    <?= $user->name;?> | <?= $user->password;?>
  </p>
  <?php endforeach;?>

</div>

<?php require_once 'includes/footer.php';?>
