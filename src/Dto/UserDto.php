<?php

declare(strict_types=1);

namespace App\Dto;

use App\Core\Request;

class UserDto
{
    public $email;

    public $password;

    public $submit;

    public $errors = [];

    public static function handleRequest(Request $request)
    {
        $dto = new self();

        $dto->email    = $request->request('email');
        $dto->password = $request->request('password');
        $dto->submit   = $request->request('submit');

        return $dto;
    }

    public function isValid()
    {
        if (!filter_var($this->email , FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Не корректный Email !!!';
        }

        if (strlen($this->password ) < 3) {
            $this->errors[] = 'Пароль не может быть меньше трёх символов !!!';
        }

        return $this->errors;
    }

    public function isSubmitted()
    {
        if (isset($this->submit)) {
            return true;
        }

        return false;
    }
}