<?php

declare(strict_types=1);

namespace App\Service;

class UserService
{
    public function passwordHash(string $password, string $email): string
    {
        $time = new \DateTimeImmutable('now', new \DateTimeZone('+0000'));

        $hash = password_hash($this->createSecretString($email, $password, $time), PASSWORD_DEFAULT);
        $pass = base64_encode(json_encode(['email' => $email, 'time' => $time->format('U'), 'hash' => $hash]));

        /**
         * Послать на почту токен.
         */
        // $this->sendEmail($email, $pass);

        return $pass;
    }

    public function token(): string
    {
        $bytes = openssl_random_pseudo_bytes(20, $cstrong);

        return bin2hex($bytes);
    }

    private function sendEmail($email, $message): bool
    {
        return mail($email, "Подтверждение", $message, "From: $email");
    }

    private function createSecretString($email, $password, $time): string
    {
        return $email . $password . $time->format('YmdHis');
    }
}