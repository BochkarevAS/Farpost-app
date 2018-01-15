<?php

namespace App\Core;

class Db {

    private $connection;

    public function __construct($host, $dbname, $user, $password) {
        $this->connection = new \PDO("pgsql:dbname=$dbname;host=$host", $user, $password);
    }

    public function getConnection() {
        return $this->connection;
    }
}