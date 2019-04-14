<?php

declare(strict_types=1);

namespace App\Service;

use App\Core\Db;
use App\Dto\UserDto;
use App\Psr\ContainerInterface;

class Auth
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function checkExist(UserDto $dto)
    {
//        $repository = $this->container->get(DB::class);
//        $repository->searchUser($dto->email) ? false : true;

//        $dto->errors[] = 'Email или пароль существует !!!';
    }

    public function checkLogin(UserDto $dto)
    {
//        $dto->errors[] = "Не верный логин или пароль !!!";
    }
}