<?php

declare(strict_types=1);

namespace App\Form;

use App\Core\Request;
use App\Entity\User;

class SecurityType extends AbstractType
{
    public string $email;

    public string $password;

    public function handleRequest(Request $request = null)
    {
        $this->email     = $request->request('email');
        $this->password  = $request->request('password');
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

        $user = User::findOneByColumn('email', $this->email);

        if (null === $user) {
            $this->errors[] = 'Пользователь с таким email не существует';

            return;
        }

        if (false === password_verify($this->password, $user->getPassword())) {
            $this->errors[] = 'Пароль не верный';

            return;
        }
    }
}