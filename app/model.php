<?php

class Model
{
    public $connection;

    function __construct()
    {
        $db = databaseConnection::getInstance();
        $this->connection = $db->getConnection();
    }
}