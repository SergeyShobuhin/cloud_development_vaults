<?php

namespace model;

use PDO;
use PDOException;

class Database
{
    private PDO $connection;

    public function __construct()
    {

        $config = require "config/config.php";
        $dsn = 'mysql:host=' . $config['mysql']['host'] . ';dbname=' . $config['mysql']['dbname'] . ';charset=' . $config['mysql']['charset'];

        try {

            $this->connection = new PDO($dsn, $config['mysql']['username'], $config['mysql']['password']);

        } catch (PDOException $exception) {

            print_r("Error: {$exception->getMessage()}");
            throw new PDOException($exception->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}