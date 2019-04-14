<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Service\User;

class MainController extends Controller
{
    private $user;

//    public function __construct(User $user)
//    {
//        $this->user = $user;
//    }

    public function index($a, $b, Request $request)
    {
        return $this->render('layout/main');
    }

    public function confirm()
    {
        $errors = false;

        if (isset($_POST['submit'])) {
            $code = $_POST['code'];

            /**
             * За такое порукам довать надо !!!
             */
            if (!$this->userService->confirm($code)) {
                $errors = 'Не верный КОД !!!';
            } else {
                header('Location: /user/image');
                die();
            }
        }

        return $this->view->render('user/confirm', [
            'errors' => $errors
        ]);
    }

    public function actionRegistration() {
        $errors = false;

        /**
         * Ааааааааааааааааааааааа это пиздец !!!!!!!!!!!!!
         * Зделать нармальный Request !!!!!!!!!!!!!!!!
         * Да и логика пиздец
         * Хотя бы DTO ...
         */
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = $this->userService->valid($email, $password);

            if ($errors == false) {
                $this->userService->registration($password, $email);
                header('Location: /user/confirm');
            }
        }

        return $this->view->render('user/registration', [
            'errors' => $errors
        ]);
    }

    public function actionLogin() {
        $errors = false;

        /**
         * Детский сад конечно
         * Нет слов
         */
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = $this->userService->valid($email, $password);

            if (!$this->userService->checkExistUser($email)) {
                $errors[] = 'Email или пароль существует !!!';
            }

            if (!$this->userService->login($password, $email)) {
                $errors[] = "Не верный логин или пароль !!!";
            } else {
                header('Location: /user/image');
                die();
            }
        }

        return $this->view->render('user/login', [
            'errors' => $errors
        ]);
    }

    public function actionLogout() {
        unset($_SESSION['user']);
        header('Location: /user/login');
        return;
    }
}