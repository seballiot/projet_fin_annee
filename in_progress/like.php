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
$Vote = new Vote($id_post);
$code_response = $Vote->voting($_SESSION['user']['id'], $vote);

$req = BDD::getInstance()->prepare('SELECT rating, count_vote FROM posts WHERE id_post = ?');
$req->execute(array($id_post));
$stats_post = $req->fetch(PDO::FETCH_OBJ);

$reponse = [
  'code' => $code_response,
  'rating' => $stats_post->rating,
  'count_vote' => $stats_post->count_vote
];
die(json_encode($reponse));
