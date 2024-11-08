<?php
require_once 'includes/header.php';
if(!isset($_SESSION['user']['id']))
  header('Location: index.php');
$posts = selectAll('posts');
?>

<div class="container-fluid">
  <h1>Feed</h1>
  <hr>

  <?php foreach($posts as $post) :?>
  <h4><a href="single_post.php?id=<?= $post->id_post;?>"><?= $post->title;?></a></h4>
  <p><?= $post->content;?></p>
  <p><small>Note : <?= $post->rating;?>/5 <br><?= $post->count_comments;?> commentaire(s)</small></p>
  <br><br>
  <?php endforeach;?>
</div>

<?php require_once 'includes/footer.php';?>
