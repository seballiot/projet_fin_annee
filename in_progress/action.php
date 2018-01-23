<?php
require_once 'includes/php_header.php';

if($_GET['a'] == "delete"){
  $req_delete = Connexion()->prepare('DELETE FROM relations_friends WHERE id_relation = :id_relation');
  $req_delete->execute(array(
    "id_relation" => $_GET['id']
  ));
  header('Location: home.php');
}

if($_GET['a'] == "add"){
  $req_insert = Connexion()->prepare('INSERT INTO relations_friends (id_user1, id_user2) VALUES (:id_user1, :id_user2)');
  $req_insert->execute(array(
    "id_user1" => $_SESSION['user']['id'],
    "id_user2" => $_GET['id']
  ));
  header('Location: home.php');
}

if($_GET['a'] == "accept"){
  $req_update = Connexion()->prepare('UPDATE relations_friends SET waiting = 0, created_at = :created_at WHERE id_relation = :id_relation');
  $req_update->execute(array(
    "id_relation" => $_GET['id'],
    "created_at" => date('Y-m-d H:i:s')
  ));
  header('Location: home.php');
}
