<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\DbException;

class Db
{
    private static $instance;

    private $connection;

    private function __construct()
    {
        $dbConfig = include(ROOT . '/config/db_config.php');

        $host     = $dbConfig['host'];
        $dbname   = $dbConfig['dbname'];
        $user     = $dbConfig['user'];
        $password = $dbConfig['password'];

        try {
            $this->connection = new \PDO("pgsql:dbname=$dbname;host=$host", $user, $password);
        } catch (\PDOException $e) {
            throw new DbException('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): \PDO
    {
        return $this->connection;
    }

    /**
     * Получить id последней вставленной записи в базе (в рамках текущей сессии работы с БД).
     */
    public function getLastInsertId(): int
    {
        return (int) $this->connection->lastInsertId();
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $connect = $this->getConnection();
        $connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $sth    = $connect->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }
}