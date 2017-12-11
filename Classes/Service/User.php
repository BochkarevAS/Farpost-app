<?php

class User {

    public static function registration($password, $email) {
        $db = Db::getConnection();

        $sql = "INSERT INTO users (password, email) VALUES (:password, :email) RETURNING id";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, PDO::PARAM_STR);
        $result->bindParam('password', $password, PDO::PARAM_STR);
        $result->execute();

        $uid = $result->fetch();

        $_SESSION['user'] = $uid['id'];
    }

    public static function login($password, $email) {
        $db = Db::getConnection();

        $sql = "SELECT id FROM users WHERE email = :email AND password = :password";
        $result = $db->prepare($sql);

        $result->bindParam('email', $email, PDO::PARAM_STR);
        $result->bindParam('password', $password, PDO::PARAM_STR);
        $result->execute();

        $uid = $result->fetch();

        if ($uid) {
            $_SESSION['user'] = $uid['id'];
            return true;
        }

        return false;
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

    public static function sendEmail($email) {
        $email = 'snake-vl@mail.ru';
        $message = "Текст:";
        $subject = 'Код для подтверждения';




        if (mail($email, $subject, $message, "From: snake-vl@mail.ru")) {
            echo "<h3>Сообщение отправлено</h3>";
            $result = true;
     	} else {
           echo "<h3>При отправке сообщения возникла ошибка</h3>";
            $result = false;
        }



        return $result;
    }

    public static function createSecretString($email, $password, $time) {
        return $email . $password . $time->format('YmdHis');
    }

}