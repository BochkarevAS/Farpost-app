<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Service\UserService;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $data = new RegistrationType();
        $form = $data->handleRequest($request);

        $user = null;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserService $service */
            $service = $this->container->get(UserService::class);

            $user = new User();
            $user->setNickname($data->nickname);
            $user->setEmail($data->email);
            $user->setPassword(password_hash($data->password, PASSWORD_DEFAULT));
            $user->setToken($service->token());
            $user->setIsConfirmed(false);
            $user->setRole('user');
            $user->save();

            $request->setSession('username', $data->email);
            $request->setSession('success', 'Вы вошли в систему');

            $this->redirectToRoute('/user/list');
        }

        return $this->render('/registration/register', [
            'user'   => $user,
            'errors' => $form->getErrors()
        ]);
    }
}