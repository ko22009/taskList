<?php

class Model
{
    public $connection;

    function __construct()
    {
        $db = databaseConnectionection::getInstance();
        $this->connection = $db->getConnectionection();
    }
}