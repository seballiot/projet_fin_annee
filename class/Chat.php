<?php

class Chat {

  private $id_channel;

  public function __construct($id_channel){
    $this->exists($id_channel);
    $this->id_channel = $id_channel;
  }

  private function exists($id_channel){
    $req = BDD::getInstance()->prepare('SELECT id_channel FROM channels WHERE id_channel = ?');
    $req->execute(array($id_channel));
    if($req->rowCount() == 0){
      throw new Exception('Channel inconnu');
    }
  }

  public function sendMessage($id_user, $message){
    $req = BDD::getInstance()->prepare('INSERT INTO channel_msg SET id_channel =?, id_user =?, message =?');
    $req->execute(array($this->id_channel, $id_user, $message));
    return true;
  }

  public function getLastMessage($id_msg){
    $req = BDD::getInstance()->prepare('SELECT * FROM channel_msg WHERE id_channel = :id_channel AND id_msg > :id_message ORDER BY created_at ASC');
    $req->execute(array('id_channel' => $this->id_channel, 'id_message' => $id_msg));
    $lastMessages = $req->fetchAll(PDO::FETCH_OBJ);
    $content = '';
    foreach($lastMessages as $lastMessage){
      $user = idToUserInfo($lastMessage->id_user);
      $date_message = new DateTime($lastMessage->created_at);
      if($user->name == $_SESSION['user']['name']) {
        $content .='
        <p style="text-align: right;" class="message" data-id-msg="'.$lastMessage->id_msg.'">
          <small>'.$date_message->format('H:i').'</small> - <b>Moi</b>
          <br>
          <span style="text-align: justify;">
            '.$lastMessage->message.'
          </span>
        </p>
        ';
      }else{
        $content .= '
        <p class="message" data-id-msg="'.$lastMessage->id_msg.'">
          <b>'.ucfirst($user->name).'</b> - <small>'.$date_message->format('H:i').'</small>
          <br>
          <span style="text-align: justify;">
            '.$lastMessage->message.'
          </span>
        </p>
        ';
      }
    }
    return $content;
  }

}
