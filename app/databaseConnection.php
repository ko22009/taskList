<?php

class databaseConnection
{

    private static $instance = null;
    private $connection;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbName = 'db_tasklist';
    private $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"];

    private function __construct()
    {
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->user, $this->pass, $this->options);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new databaseConnection();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

}