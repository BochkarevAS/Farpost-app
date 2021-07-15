<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Entity\User;
use App\Exceptions\NotFoundException;
use App\Form\UserType;
use App\Service\UserService;
use App\Exceptions\FileException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::findAll();

        return $this->render('user/list', [
            'users' => $users
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function show(int $id)
    {
        $user = User::findById($id);

        if (null === $user) {
            throw new NotFoundException();
        }

        return $this->render('user/show', [
            'user' => $user
        ]);
    }

    /**
     * @throws NotFoundException
     * @throws FileException
     */
    public function edit(Request $request, int $id)
    {
        $user = User::findById($id);

        if (null === $user) {
            throw new NotFoundException();
        }

        $data = new UserType();
        $form = $data->handleRequest($request, $id);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setNickname($data->nickname);
            $user->setPassword($data->password);
            $user->setEmail($data->email);

            if ($data->file) {
                $this->uploaded()->delete($user->getAvatar());

                $avatar = $this->uploaded()->upload();
                $user->setAvatar($avatar);
            }

            $user->save();

            $this->redirectToRoute('/user/' . $user->getId() . '/edit');
        }

        return $this->render('user/edit', [
            'user'   => $user,
            'errors' => $form->getErrors()
        ]);
    }

    /**
     * @throws FileException
     */
    public function create(Request $request)
    {
        $data = new UserType();
        $form = $data->handleRequest($request);

        $user = null;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserService $service */
            $service = $this->container->get(UserService::class);

            $user = new User();
            $user->setNickname($data->nickname);
            $user->setEmail($data->email);
            $user->setPassword($service->passwordHash($data->password, $data->email));
            $user->setToken($service->token());
            $user->setIsConfirmed(false);
            $user->setRole('user');

            if ($data->file) {
                $avatar = $this->uploaded()->upload();
                $user->setAvatar($avatar);
            }

            $user->save();

            $this->redirectToRoute('/user/list');
        }

        return $this->render('user/create', [
            'user'   => $user,
            'errors' => $form->getErrors()
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function delete(int $id): void
    {
        $user = User::findById($id);

        if (null === $user) {
            throw new NotFoundException();
        }

        $this->uploaded()->delete($user->getAvatar());
        $user->delete();

        $this->redirectToRoute('/user/list');
    }
}