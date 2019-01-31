<?php

namespace App\Core;

/**
 * Сделать ленивую загрузку !!! Вот нахуя коннект постоянно тоскать ?????????
 */
class Db
{
    private $connection;

    public function __construct($host, $dbname, $user, $password)
    {
        $this->connection = new \PDO("pgsql:dbname=$dbname;host=$host", $user, $password);
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