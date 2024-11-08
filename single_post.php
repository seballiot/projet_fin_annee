<?php
require_once 'includes/header.php';
if(!isset($_SESSION['user']['id']))
  header('Location: index.php');
$post = selectOnePost('posts', $_GET['id']);
?>

<div class="container-fluid">
  <h1><?= $post->title;?></h1>
  <hr>
  <p><?= $post->content;?></p>
  <hr>
  <div class='rating-stars'>
    <ul id='stars' data-id_post="<?= $post->id_post;?>">
      <?php for ($i=1;$i<=5;$i++) : ?>
      <li class='star <?= Vote::getClass(floor($post->rating), $i);?>' data-value='<?= $i;?>'>
        <i class='fa fa-star fa-fw'></i>
      </li>
      <?php endfor;?>
    </ul>
    <p id="rep_msg"></p>
    <small>Note moyenne : <span id="rating"><?= $post->rating;?></span></small><br>
    <small>Nombre de votants: <span id="count_vote"><?= $post->count_vote;?></span></small>
  </div>

  <br>

  <div class="comments">
    <h4><?= $post->count_comments;?> Commentaire(s)</h4>
    <form id="form-comment" method="POST" action="send_comment.php?id=<?= $post->id_post;?>">
    <input type="hidden" name="id_parent" id="id_parent" value="0">
      <div class="form-row align-items-center">
        <div class="col-lg-10">
        <input class="form-control" type="text" name="comment_content" id="comment_content" placeholder="Rédigez votre commentaire">
        </div>
        <div class="col-lg-2">
          <button type="submit" class="btn btn-primary btn-block">Publier</button>
        </div>
      </div>
    </form><br>
    <?php
    $comments = new Comments($_GET['id']);
    $comments->getComments();
    ?>
  </div>

</div>

<?php require_once 'includes/footer.php';?>
