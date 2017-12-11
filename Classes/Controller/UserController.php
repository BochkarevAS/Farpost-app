<?php

class UserController {

    public function actionIndex() {
        require_once(ROOT . '/Resources/views/user/main.php');

        return true;
    }

    public function actionConfirm() {
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

            if (!User::checkEmail($email)) {
                $errors[] = 'Не корректный Email !!!';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не может быть меньше трёх символов !!!';
            }

            if (!User::checkExist($email, $password)) {
                $errors[] = 'Email или пароль существует !!!';
            }

            $email = 'snake-vl@mail.ru';
            $password = (string)12345;
            $time = new \DateTimeImmutable('now', new \DateTimeZone('+0000'));

          // $res = User::createSecretString($email, $password, $time);

            $hash = password_hash(User::createSecretString($email, $password, $time), PASSWORD_DEFAULT);
            echo build_query(['code' => base64_encode(json_encode(['email' => $email, 'time' => $time->format('U'), 'hash' => $hash]))]);

            if (!User::sendEmail($email)) {
                $errors[] = 'Email послать не удалось !!!';
            }  else {
                header('Location: /user/confirm');
                die;
            }



            if ($errors == false) {
                User::registration($password, $email);
                header('Location: /user/image');
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

            if (!User::checkEmail($email)) {
                $errors[] = 'Не корректный Email !!!';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не может быть меньше трёх символов !!!';
            }

            if (!User::checkExist($email, $password)) {
                $errors[] = 'Email или пароль существует !!!';
            }

            if (!User::login($password, $email)) {
                $errors[] = "Не верный логин или пароль !!!";
            } else {
                header('Location: /user/image');
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