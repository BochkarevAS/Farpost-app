<?php

class UserController {

    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function actionIndex() {
        require_once(ROOT . '/Resources/views/user/main.php');
        return true;
    }

    public function actionConfirm() {
        $error = false;

        if (isset($_SESSION['user'])) {
            header('Location: /user/image');
            die();
        }

        if (isset($_POST['submit'])) {
            $code = $_POST['code'];

            if (!$this->user->confirm($code)) {
                $error = 'Не верный КОД !!!';
            } else {
                header('Location: /user/image');
                die();
            }
        }

        require_once(ROOT . '/Resources/views/user/confirm.php');

        return true;
    }

    public function actionRegistration() {
        $errors = false;

        if (isset($_SESSION['user'])) {
            header('Location: /user/image');
            die();
        }

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = $this->user->valid($email, $password);

            if ($errors == false) {
                $this->user->registration($password, $email);
                header('Location: /user/confirm');
            }
        }

        require_once(ROOT . '/Resources/views/user/registration.php');

        return true;
    }

    public function actionLogin() {
        $errors = false;

        if (isset($_SESSION['user'])) {
            header('Location: /user/image');
            die();
        }

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = $this->user->valid($email, $password);

            if (!$this->user->checkExistUser($email)) {
                $errors[] = 'Email или пароль существует !!!';
            }

            if (!$this->user->login($password, $email)) {
                $errors[] = "Не верный логин или пароль !!!";
            } else {
                header('Location: /user/image');
                die();
            }
        }

        require_once(ROOT . '/Resources/views/user/login.php');

        return true;
    }

    public function actionLogout() {
        unset($_SESSION['user']);
        header('Location: /user/login');
    }
}