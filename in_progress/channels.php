<?php
require_once 'includes/header.php';
if(!isset($_SESSION['user']['id']))
  header('Location: index.php');
$channels = selectAll('channels');
?>

<div class="container">
  <h1>Channels de discussion</h1>
  <hr>

  <div class="row align-items-start">
    <div class="list-group col-lg-4">
    <?php foreach($channels as $channel) :?>
      <a href="?id=<?= $channel->id_channel;?>" class="list-group-item list-group-item-action <?php if(isset($_GET['id']) && $_GET['id'] == $channel->id_channel) echo 'active';?>"><?= $channel->name;?></a>
    <?php endforeach;?>
    </div>

    <?php if(isset($_GET['id'])) :
      $channel = selectOneChannel('channels', $_GET['id']);
      ?>
      <div class="col-lg-8 msg-box">
      <h4 class="text-center"><?= $channel->name;?></h4>
        <?php
        if($messages = selectMessages('channel_msg', $_GET['id'])){
          foreach($messages as $message) :
            $user = idToUserInfo($message->id_user);
            $date_message = new DateTime($message->created_at);
            if($user->name == $_SESSION['user']['name']) {
              ?>
              <p style="text-align: right;" class="message" data-id-msg="<?= $message->id_msg;?>">
                <small><?= $date_message->format('H:i');?></small> - <b>Moi</b>
                <br>
                <?= $message->message;?>
              </p>
              <?php
            }else {
              ?>
              <p class="message" data-id-msg="<?= $message->id_msg;?>">
                <b><?= ucfirst($user->name);?></b> - <small><?= $date_message->format('H:i');?></small>
                <br>
                <span style="text-align: justify;">
                  <?= $message->message;?>
                </span>
              </p>
              <?php
            }
            ?>
          <?php endforeach;
        }else
          echo '<span id="no-msg">Aucun message</span>';
        ?>
        <br id="separator">
        <hr>
        <form id="form-chat" method="POST" data-id-channel="<?= $_GET['id'];?>">
          <div class="form-row align-items-center">
            <div class="col-lg-8">
            <input class="form-control" type="text" name="message" id="chat-message" placeholder="Rédigez votre message">
            </div>
            <div class="col-lg-2">
              <button type="submit" class="btn btn-primary btn-block">Publier</button>
            </div>
          </div>
        </form><br>
      </div>
    <?php endif;?>
  </div>
</div>

<?php require_once 'includes/footer.php';?>
<script src="assets/js/refresh_msg.js"></script>
