<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService {

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function registration($password, $email) {
        $time = new \DateTimeImmutable('now', new \DateTimeZone('+0000'));

        $hash = password_hash($this->createSecretString($email, $password, $time), PASSWORD_DEFAULT);
        $code = base64_encode(json_encode(['email' => $email, 'time' => $time->format('U'), 'hash' => $hash]));

        $this->userRepository->createUser($password, $email, $code);
        $this->sendEmail($email, $code);
    }

    /**
     * Пиздец
     */
    public function login($password, $email) {
        $uid = $this->userRepository->getLogin($password, $email);

        if ($uid) {
            $_SESSION['user'] = $uid['id'];
            return true;
        }

        return false;
    }

    /**
     * Пиздец
     */
    public function valid($email, $password) {
        $errors = false;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Не корректный Email !!!';
        }

        if (strlen($password) < 3) {
            $errors[] = 'Пароль не может быть меньше трёх символов !!!';
        }

        return $errors;
    }

    /**
     * Ваще пиздец
     */
    public function checkExistUser($email) {
        return $this->userRepository->searchUser($email) ? false : true;
    }

    public function confirm($code) {
        $uid = $this->userRepository->isConfirm($code);

        if ($uid) {
            $_SESSION['user'] = $uid['id'];
            return true;
        }

        return false;
    }

    private function sendEmail($email, $message) {
        $result = mail($email, "Подтверждение", $message, "From: $email");
        return $result;
    }

    private function createSecretString($email, $password, $time) {
        return $email . $password . $time->format('YmdHis');
    }
}