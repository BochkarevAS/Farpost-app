<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Dto\UserDto;
use App\Service\Auth;

class SecurityController extends Controller
{
    public function login(Request $request)
    {
        $user = UserDto::handleRequest($request);

        if ($user->isSubmitted() && !$user->isValid()) {
            $auth = $this->container->get(Auth::class);

            if ($auth->checkExist($user) && $auth->checkLogin($user)) {
                return $this->render('security/login',[
                    'errors' => $user->errors
                ]);
            }

            $this->setSession('user', md5(uniqid()));

            $this->redirectToRoute('/');
        }

        return $this->render('security/login',[
            'errors' => $user->errors
        ]);
    }

    public function registration(Request $request)
    {
        $user = UserDto::handleRequest($request);

        if ($user->isSubmitted() && !$user->isValid()) {
            $this->redirectToRoute('/');
        }

        return $this->render('security/registration', [
            'errors' => $user->errors
        ]);
    }

    public function logout()
    {
        session_destroy();

        $this->redirectToRoute('login');
    }
}