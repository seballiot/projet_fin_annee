<?php
require_once 'includes/php_header.php';

if(!isset($_SESSION['user']['id'])){
  http_response_code(403);
  die();
}

if(isset($_GET['id_comment']) && isset($_GET['id_post'])){
  $comment = new Comments($_GET['id_post']);
  $comment->deleteComment($_SESSION['user']['id'], $_GET['id_comment']);
}else{
  http_response_code(403);
  die();
}

header('Location: single_post.php?id='.$_GET['id_post']);
