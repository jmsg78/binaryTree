<?php
error_reporting(E_ALL ^ E_NOTICE);
class DB
{
    private static $instancia;
    private $dbh;
 
    private function __construct()
    {
        try {

            $host = 'localhost';
            $db =   'binarytree';
            $user = 'root';
            $pwd =  '';
            $this->dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pwd);
            $this->dbh->exec("SET CHARACTER SET utf8");

        } catch (PDOException $e) {

            print "Error!: " . $e->getMessage();

            die();
        }
    }

    public function prepare($sql)
    {
        return $this->dbh->prepare($sql);
    }
 
    public static function singleton()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed', E_USER_ERROR);
    }
}