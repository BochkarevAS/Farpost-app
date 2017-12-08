<?php

class Db {

    public static function getConnection() {

        $host = "localhost";
        $dbname = "farpost";
        $user = "postgres";
        $password = "root";

        $dbh = new PDO("pgsql:dbname=$dbname;host=$host", $user, $password);

        return $dbh;
    }
}