<?php

class BDD extends PDO {

    private $PDOinstance = null;
    private static $objet = null;

    public function __construct()
    {
        try
        {
            $this->PDOinstance = parent::__construct(DSN, USERNAME, PASSWORD);
            $this->PDOinstance = parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $this->PDOinstance = parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->PDOinstance = parent::query('SET NAMES utf8');
        }
        catch(Exception $e)
        {
            die('Erreur lors de la connexion : '.$e->getMessage());
        }
    }

    public static function getInstance()
    {
        if(is_null(self::$objet))
        {
            self::$objet = new BDD();
        }
        return self::$objet;
    }
}
