<?php

namespace App\Repository;

use App\Core\Db;

class UserRepository {

    private $db;

    public function __construct(Db $db) {
        $this->db = $db;
    }

    public function createUser($password, $email, $code) {
        $db = $this->db->getConnection();

        $sql = "INSERT INTO users (password, email, code) VALUES (:password, :email, :code)";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, \PDO::PARAM_STR);
        $result->bindParam('password', $password, \PDO::PARAM_STR);
        $result->bindParam('code', $code, \PDO::PARAM_STR);
        $result->execute();
    }

    public function getLogin($password, $email) {
        $db = $this->db->getConnection();

        $sql = "SELECT id FROM users WHERE email = :email AND password = :password";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, \PDO::PARAM_STR);
        $result->bindParam('password', $password, \PDO::PARAM_STR);
        $result->execute();

        return $result->fetch();
    }

    public function searchUser($email) {
        $db = $this->db->getConnection();

        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, \PDO::PARAM_STR);
        $result->execute();

        return $result->fetchColumn();
    }

    public function isConfirm($code) {
        $db = $this->db->getConnection();

        $sql = "SELECT id FROM users WHERE code = :code";
        $result = $db->prepare($sql);

        $result->bindParam('code', $code, \PDO::PARAM_STR);
        $result->execute();

        return $result->fetch();
    }
}