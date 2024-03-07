<?php

namespace controller;

use PDO;

class Connectbd
{
    private $connection;

    public function __construct()
    {
        $config = require "config/bd.php";

        $dsn = 'mysql:host=' . $config['mysql']['host'] . ';dbname=' . $config['mysql']['bdname'] . ';charset=' . $config['mysql']['charset'];
        $this->connection = new PDO($dsn, $config['mysql']['username'], $config['mysql']['password']);
    }

    public function getConnection()
    {

        return $this->connection;
    }
}