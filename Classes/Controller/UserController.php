<?php

class UserController {

    public function actionRegistration() {

        $errors = false;

        if (isset($_POST['submit'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!User::checkEmail($email)) {
                $errors[] = 'Не корректный Email !!!';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не может быть меньше трёх символов !!!';
            }

            if (!User::checkEmailExist($email)) {
                $errors[] = 'Такой Email существует !!!';
            }

            if ($errors == false) {
                User::registration($password, $email);
            }


        }

        require_once(ROOT . '/Resources/views/user/registration.php');

//        header('Location: ' .  $_SERVER['HTTP_REFERER']);

    }
}