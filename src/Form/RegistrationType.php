<?php

declare(strict_types=1);

namespace App\Form;

use App\Core\Request;
use App\Entity\User;

class RegistrationType extends AbstractType
{
    public string $nickname;

    public string $email;

    public string $password;

    public string $repeat;

    public function handleRequest(Request $request = null)
    {
        $this->nickname  = $request->request('nickname');
        $this->email     = $request->request('email');
        $this->password  = $request->request('password');
        $this->repeat    = $request->request('repeat');
        $this->submitted = $request->request('submit');

        if ($this->submitted) {
            $this->validate();
        }

        return $this;
    }

    public function validate(): void
    {
        if (!filter_var($this->email , FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Не корректный Email !!!';
        }

        if ('' === $this->nickname) {
            $this->errors[] = 'Nickname не может быть пустым !!!';
        }

        if (3 > strlen($this->password)) {
            $this->errors[] = 'Пароль не может быть меньше трёх символов !!!';
        }

        if ($this->password !== $this->repeat) {
            $this->errors[] = 'Пароль не совпадает !!!';
        }

        if (null !== User::findOneByColumn('nickname', $this->nickname)) {
            $this->errors[] = 'Пользователь с таким nickname уже существует';
        }

        if (null !== User::findOneByColumn('email', $this->email)) {
            $this->errors[] = 'Пользователь с таким email уже существует';
        }
    }
}