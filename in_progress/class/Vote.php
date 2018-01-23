<?php

class Vote {

  private $id_post;

  public function __construct($id_post){
    $this->exists($id_post);
    $this->id_post = $id_post;
  }

  private function exists($id_post){
    $req = BDD::getInstance()->prepare('SELECT id_post FROM posts WHERE id_post = ?');
    $req->execute(array($id_post));
    if($req->rowCount() == 0){
      throw new Exception('Article inconnu');
    }
  }

  public function voting($id_user, $vote){
    $req = BDD::getInstance()->prepare("SELECT id_vote, vote FROM vote WHERE id_post=? AND id_user=?");
    $req->execute(array($this->id_post, $id_user));
    $user_voted = $req->fetch();

    // SI L'UTILISATEUR A DÉJÀ VOTÉ POUR CET ARTICLE
    if($user_voted){

      // SI IL REVOTE LA MÊME CHOSE : aucun traitement
      if($user_voted->vote == $vote){
        return 0;
      }else{

        // SI IL CHANGE SON VOTE : mise à jour de son vote
        $req = BDD::getInstance()->prepare("UPDATE vote SET vote = ?, created_at = ? WHERE id_vote = ?");
        $req->execute(array($vote, date('Y-m-d H:i:s'), $user_voted->id_vote));
        $this->updateStatsPost();
        return 1;
      }
    }else{

      // SI L'UTILISATEUR N'A JAMAIS VOTÉ POUR CET ARTICLE : création du vote
      $req = BDD::getInstance()->prepare("INSERT INTO vote SET id_post=?, id_user=?, vote=?");
      $req->execute(array($this->id_post, $id_user, $vote));
      $this->updateStatsPost();
      return 2;
    }

  }

  private function updateStatsPost(){
    $req = BDD::getInstance()->prepare("SELECT COUNT(id_vote) as count_vote, SUM(vote) as tot_vote FROM vote WHERE id_post=? GROUP BY id_post");
    $req->execute(array($this->id_post));
    $stats_post = $req->fetch();
    $rating = $stats_post->tot_vote / $stats_post->count_vote;
    $req = BDD::getInstance()->query("UPDATE posts SET rating = ".$rating.", count_vote = ".$stats_post->count_vote." WHERE id_post = ".$this->id_post);
    return true;
  }

  public static function getClass($rating, $value){ //permet d'ajouter une class selected
    if($rating >= $value) return 'selected';
  }
}
