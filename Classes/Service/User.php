<?php

class User {

    public static function registration($password, $email) {
        $db = Db::getConnection();

        $email = 'snake-vl@mail.ru';
        $time = new \DateTimeImmutable('now', new \DateTimeZone('+0000'));

        $hash = password_hash(User::createSecretString($email, $password, $time), PASSWORD_DEFAULT);
        $code = base64_encode(json_encode(['email' => $email, 'time' => $time->format('U'), 'hash' => $hash]));

        $sql = "INSERT INTO users (password, email, code) VALUES (:password, :email, :code)";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, PDO::PARAM_STR);
        $result->bindParam('password', $password, PDO::PARAM_STR);
        $result->bindParam('code', $code, PDO::PARAM_STR);
        $result->execute();

        User::sendEmail($email, $code);
    }

    public static function login($password, $email) {
        $db = Db::getConnection();

        $sql = "SELECT code FROM users WHERE email = :email AND password = :password";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, PDO::PARAM_STR);
        $result->bindParam('password', $password, PDO::PARAM_STR);
        $result->execute();

        $code = $result->fetch();

        return User::sendEmail($email, $code['code']);
    }

    public static function checkAuth() {

        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header('Location: /user/registration');
        die();
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

    public static function checkExist($email, $password) {
        $db = Db::getConnection();

        $sql = "SELECT COUNT(*) FROM users WHERE email = :email AND password = :password";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, PDO::PARAM_STR);
        $result->bindParam('password', $password, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn()) {
            return false;
        }

        return true;
    }

    public static function confirm($code) {
        $db = Db::getConnection();

        $sql = "SELECT id FROM users WHERE code = :code";
        $result = $db->prepare($sql);

        $result->bindParam('code', $code, PDO::PARAM_STR);
        $result->execute();

        $uid = $result->fetch();

        if ($uid) {
            $_SESSION['user'] = $uid['id'];
            return true;
        }

        return false;
    }

    public static function sendEmail($email, $message) {
        $result = mail($email, "Подтверждение", $message, "From: $email");
        return $result;
    }

    public static function createSecretString($email, $password, $time) {
        return $email . $password . $time->format('YmdHis');
    }

}