<?php
require_once 'includes/php_header.php';
if($_SERVER['REQUEST_METHOD'] != 'POST'){ // pour la sécurisation
  http_response_code(403);
  die();
}

if(!isset($_SESSION['user']['id'])){
  http_response_code(403);
  die();
}

extract($_POST);
if(!empty($comment_content)){
  $id_parent = isset($id_parent) ? $id_parent : 0;

  $comment = new Comments($_GET['id']);
  if($id_parent != 0){
    $comment->existsParentComment($id_parent);
  }

  $comment->sendComment($_SESSION['user']['id'], $id_parent, htmlspecialchars($comment_content));
}else{
  // message comme quoi faut remplir le input
}
header('Location: single_post.php?id='.$_GET['id']);
