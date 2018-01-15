<?php

namespace App\Repository;

use App\Core\Db;

class UserRepository {

    private $db;

    public function __construct(Db $db) {
        $this->db = $db;
    }

    public function createUser($password, $email, $code) {
        $sql = "INSERT INTO users (password, email, code) VALUES (:password, :email, :code)";
        $this->db->query($sql, [
            'email' => $email,
            'password' => $password,
            'code' => $code,
        ]);
    }

    public function getLogin($password, $email) {
        $sql = "INSERT INTO image (img, uid) VALUES (:img, :uid) RETURNING id, img";
        $result = $this->db->query($sql, [
            'email' => $email,
            'password' => $password
        ]);

        return $result->fetch();
    }

    public function searchUser($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);

        return $result->fetchColumn();
    }

    public function isConfirm($code) {
        $sql = "SELECT id FROM users WHERE code = :code";
        $result = $this->db->query($sql, ['code' => $code]);

        return $result->fetch();
    }
}