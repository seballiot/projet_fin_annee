<?php
require_once("includes/php_header.php");
extract($_POST);
if(!empty($login) && !empty($password)){
  $req = Connexion()->prepare("SELECT * FROM users WHERE name = :name");
  $req->execute(array("name" => $login));
  $req = $req->fetch();
  if($req){
    if($password == $req->password){
      $_SESSION['user']['id'] = $req->id_user;
      $_SESSION['user']['name'] = $req->name;
      header("Location: home.php");
    }
    else{
      header("Location: index.php");
    }
  }else{
    header("Location: index.php");
  }
}
?>
