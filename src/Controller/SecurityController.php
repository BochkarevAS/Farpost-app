<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Form\SecurityType;

class SecurityController extends Controller
{
    public function login(Request $request)
    {
        $data = new SecurityType();
        $form = $data->handleRequest($request);

        $user = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $request->setSession('username', $data->email);
            $request->setSession('success', 'Вы вошли в систему');

            $this->redirectToRoute('/user/list');
        }

        return $this->render('/security/login', [
            'user'   => $user,
            'errors' => $form->getErrors()
        ]);
    }

    public function logout()
    {
        session_destroy();

        $this->redirectToRoute('/user/list');
    }
}