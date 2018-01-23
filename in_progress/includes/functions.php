<?php

// établie une connexion avec la BDD
function Connexion(){
    try
    {
        $bdd = new PDO(DSN, USERNAME, PASSWORD);
        $bdd->query('SET NAMES utf8');
        return $bdd;
    }
    catch(Exception $e)
    {
        die('Erreur lors de la connexion : '.$e->getMessage());
    }
}

// genère les messages flash
function flashMsg(){
    if(isset($_SESSION['flash']))
    {
        foreach ($_SESSION['flash'] as $class => $message)
        {
            ?>
                <div class="alert alert-<?php echo $class; ?> fade in alert-dismissible" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $message; ?>
                </div>
            <?php
        }

        unset($_SESSION['flash']);
    }
}

function dd($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

function selectOne($table, $id) {
    $rowToGet = BDD::getInstance()->prepare('SELECT * FROM ' . $table . ' WHERE id_relation = :id');
    $rowToGet->execute(array("id" => $id));
    $row = $rowToGet->fetch();
    if(!$row) return false;
    else return $row;
}

function selectOneChannel($table, $id) {
    $rowToGet = BDD::getInstance()->prepare('SELECT * FROM ' . $table . ' WHERE id_channel = :id');
    $rowToGet->execute(array("id" => $id));
    $row = $rowToGet->fetch();
    if(!$row) return false;
    else return $row;
}

function selectOnePost($table, $id) {
    $rowToGet = BDD::getInstance()->prepare('SELECT * FROM ' . $table . ' WHERE id_post = :id');
    $rowToGet->execute(array("id" => $id));
    $row = $rowToGet->fetch();
    if(!$row) return false;
    else return $row;
}

function selectMessages($table, $id) {
    $rowToGet = BDD::getInstance()->prepare('SELECT * FROM ' . $table . ' WHERE id_channel = :id');
    $rowToGet->execute(array("id" => $id));
    $row = $rowToGet->fetchAll();
    if(!$row) return false;
    else return $row;
}

function selectComments($table, $id) {
    $rowToGet = BDD::getInstance()->prepare('SELECT * FROM ' . $table . ' WHERE id_post = :id');
    $rowToGet->execute(array("id" => $id));
    $row = $rowToGet->fetchAll();
    if(!$row) return false;
    else return $row;
}

function selectAll($table) {
    $rowsToGet = BDD::getInstance()->query('SELECT * FROM ' . $table);
    $rows = $rowsToGet->fetchAll();
    if(!$rows) return false;
    else return $rows;
}
function idToUserInfo($id_user){
    $req = BDD::getInstance()->prepare('SELECT * FROM users WHERE id_user = :id_user');
    $req->execute(array("id_user" => $id_user));
    $row = $req->fetch();
    if(!$row) return false;
    else return $row;
}
