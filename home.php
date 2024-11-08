<?php
require_once 'includes/header.php';
if(!isset($_SESSION['user']['id']))
  header('Location: index.php');
$req = BDD::getInstance()->prepare('SELECT * FROM relations_friends WHERE id_user1 = :id_user1 OR id_user2 = :id_user2');
$req->execute(array(
  "id_user1" => $_SESSION['user']['id'],
  "id_user2" => $_SESSION['user']['id']
));
$datas = $req->fetchAll(PDO::FETCH_OBJ);
$user_check[] = $_SESSION['user']['id'];
?>

<div class="container-fluid">
  <h1>Amis</h1>
  <hr>
    <div class="row">
      <div class="col-md-4">
        <h3>Vos amis</h3>
        <?php
        if($datas){
          foreach ($datas as $data) { // parmis toutes les relations d'amis relatives à l'utilisateur connecté
            if($data->id_user1 == $_SESSION['user']['id']){ // si il a des relations où c'est lui qui a envoyé l'invite à l'autre
              $user = idToUserInfo($data->id_user2);
              if($data->waiting){ // si la relation n'a pas encore été accepté par l'autre
                echo '<b>'.$user->name.'</b> (en attente d être accepté)'.'| <a href="action.php?a=delete&id='.$data->id_relation.'">Annuler la demande</a>';
                echo "</br>";
                $user_check[] = $data->id_user2;
              }else{ // si la relation a été accepté par l'autre
                echo '<b>'.$user->name.'</b>| <a href="action.php?a=delete&id='.$data->id_relation.'">Supprimer la relation</a>';
                echo "</br>";
                $user_check[] = $data->id_user2;
              }
            }
            else{ // si il a des relations où c'est lui qui a reçu une invitation
              if(!$data->waiting){ // et qu'il l'a accepté
                $user = idToUserInfo($data->id_user1);
                echo '<b>'.$user->name.'</b>| <a href="action.php?a=delete&id='.$data->id_relation.'">Supprimer la relation</a>';
                echo "</br>";
                $user_check[] = $data->id_user1;
              }
            }
          }
        }else
          echo "Vous n'avez aucun ami";
        ?>
      </div>

      <div class="col-md-4">
        <h3>Demande en amis</h3>
        <?php
        foreach ($datas as $data) { // parmis toutes les relations d'amis relatives à l'utilisateur connecté
          if($data->waiting && $data->id_user2 == $_SESSION['user']['id']){ // si il a des relations où c'est lui qui a reçu une invitation et qu'il ne l'a pas accepté
            $user = idToUserInfo($data->id_user1);
            echo '<b>'.$user->name.'</b>| <a href="action.php?a=accept&id='.$data->id_relation.'">Accepter</a> - <a href="action.php?a=delete&id='.$data->id_relation.'">Refuser</a>';
            echo "</br>";
            $user_check[] = $data->id_user1;
          }
        }
        ?>
      </div>

      <div class="col-md-4">
        <h3>Autres utilisateurs</h3>
        <?php

        $users = selectAll('users');
        foreach ($users as $user) {
          if(!in_array($user->id_user, $user_check)){
            $user_info = idToUserInfo($user->id_user);
            echo '<b>'.$user_info->name.'</b>| <a href="action.php?a=add&id='.$user_info->id_user.'">Inviter en ami</a></br>';
          }
        }

        ?>
      </div>
  </div>
</div>

<?php require_once 'includes/footer.php';?>
