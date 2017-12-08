<?php

class User {

    public static function registration($password, $email) {

        $db = Db::getConnection();

        $sql = "INSERT INTO users (password, email) VALUES (:password, :email)";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, PDO::PARAM_STR);
        $result->bindParam('password', $password, PDO::PARAM_STR);
        $result->execute();
    }

    public static function checkEmail($email) {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public static function checkPassword($password) {

        if (strlen($password) < 3) {
            return false;
        }

        return true;
    }

    public static function checkEmailExist($email) {
        $db = Db::getConnection();

        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn()) {
            return false;
        }

        return true;
    }
}