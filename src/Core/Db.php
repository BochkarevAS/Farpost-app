<?php

declare(strict_types=1);

namespace App\Core;

class Db
{
    private $connection;

    public function __construct($host, $dbname, $user, $password)
    {
//        $this->connection = new \PDO("pgsql:dbname=$dbname;host=$host", $user, $password);
    }

    private function getConnection()
    {
        return $this->connection;
    }

    public function query($sql, $params = [])
    {
        $connect = $this->getConnection();
        $result  = $connect->prepare($sql);

        return $result->execute($params);
    }
}