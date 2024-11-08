<?php

class Comments {

  private $id_post;

  public function __construct($id_post){
    $this->exists($id_post);
    $this->id_post = $id_post;
  }

  private function exists($id_post){ // teste si le post existe
    $req = BDD::getInstance()->prepare('SELECT id_post FROM posts WHERE id_post = ?');
    $req->execute(array($id_post));
    if($req->rowCount() == 0){
      throw new Exception('Article inconnu');
    }
  }

  private function updateCountComment($nb){
    $req = BDD::getInstance()->prepare('SELECT count_comments FROM posts WHERE id_post = ?');
    $req->execute([$this->id_post]);
    $count_comments = $req->fetch(PDO::FETCH_OBJ)->count_comments;
    $req = BDD::getInstance()->prepare('UPDATE posts SET count_comments = ? WHERE id_post = ?');
    $req->execute(array(($count_comments + $nb), $this->id_post));
  }

  public function existsParentComment($id_parent){ // teste si le commentaire parent existe
    $req = BDD::getInstance()->prepare('SELECT id_comment FROM comments WHERE id_comment = ?');
    $req->execute(array($id_parent));
    if($req->rowCount() == 0){
      throw new Exception('Ce commentaire n\'existe pas');
    }
  }

  public function getComments(){
    $req = BDD::getInstance()->prepare('SELECT * FROM comments WHERE id_post = :id');
    $req->execute(array("id" => $this->id_post));
    $comments = $req->fetchAll(PDO::FETCH_OBJ);
    if($comments){
      $comments_by_id = [];
      foreach ($comments as $comment) { //commentaires indéxés par ids
        $comments_by_id[$comment->id_comment] = $comment;
      }
      foreach ($comments as $key => $comment) {
        if($comment->id_parent != 0){ //dans le cas ou c'est une réponse
          $comments_by_id[$comment->id_parent]->children[] = $comment; //on ajoute l'enfant au parent
          unset($comments[$key]); //on le retire de la liste des commentaires
        }
      }
      foreach ($comments as $comment) :
        $this->createDivComments($comment);
      endforeach;
    }
  }

  public function createDivComments($comment){
    $date_comment = new DateTime($comment->created_at);
    ?>
    <div class="alert alert-secondary" id="comment-<?= $comment->id_comment;?>">
      <div class="row">
        <div class="col-lg-3">
          <p>
            <b><?= ucfirst(idToUserInfo($comment->id_user)->name);?></b><br>
            Le <?= $date_comment->format('d/m');?> à <?= $date_comment->format('H:i');?>
          </p>
        </div>
        <div class="col-lg-9">
          <p><?= $comment->content;?></p>
        </div>
      </div>
      <button class="btn btn-secondary reply" data-id="<?= $comment->id_comment;?>">Répondre</button>
      <?= $comment->id_user == $_SESSION['user']['id'] ? '<a href="delete_comment.php?id_comment='.$comment->id_comment.'&id_post='.$comment->id_post.'" class="btn btn-danger">Supprimer</a>' : ''; ?>
    </div>
    <div style="margin-left: 50px;">
      <?php
      if(isset($comment->children)){
        foreach ($comment->children as $comment) {
          $this->createDivComments($comment);
        }
      }
      ?>
    </div>
    <?php
  }

  public function sendComment($id_user, $id_parent, $comment){
    // On ajoute le nouveau commentaire
    $req = BDD::getInstance()->prepare('INSERT INTO comments SET id_post = ?, id_user = ?, id_parent = ?, content = ?');
    $req->execute(array($this->id_post, $id_user, $id_parent, $comment));

    // On actualise le compteur
    $this->updateCountComment(1);
  }

  public function deleteComment($id_user, $id_comment){
    // On récupère l'id_parent du commentaire en question
    $req = BDD::getInstance()->prepare('SELECT id_parent FROM comments WHERE id_comment = ?');
    $req->execute(array($id_comment));
    if($req->rowCount() == 0){
      throw new Exception('Ce commentaire n\'existe pas');
    }
    $comment = $req->fetch(PDO::FETCH_OBJ);

    // On supprime le commentaire en question
    BDD::getInstance()->prepare('DELETE FROM comments WHERE id_comment =?')->execute([$id_comment]);

    // On monte tous les enfants de ce commentaire
    $req = BDD::getInstance()->prepare('UPDATE comments SET id_parent = ? WHERE id_parent = ?');
    $req->execute(array($comment->id_parent, $id_comment));

    // On actualise le compteur
    $this->updateCountComment(-1);
  }
}




