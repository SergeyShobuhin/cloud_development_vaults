<?php

namespace controller;

use model\User;

class AdminController extends BaseController
{

    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    // редактирование пользователя
    public function update($id): void
    {

//        $_GET['is_admin'] = isset($_GET['is_admin']) ? 1 : 0;         //переделать перед сдачей
        if (isset($_GET['is_admin'])) {
            $_GET['is_admin'] = 0;
        } else {
            $_GET['is_admin'] = 1;
        }

        $data = [
            'id' => $id,
            'email' => $_GET['email'],
            'password' => md5($_GET['password']),
            'full_name' => $_GET['full_name'],
            'is_admin' => $_GET['is_admin'],
        ];

        $this->user->update($data);
        header('Location: /admin/user');
    }

    // удаление пользователя
    public function delete($id): void
    {

        $id = (int)$id;
        $this->user->delete($id);

        header('Location: /admin/user');
    }

    // список пользователей
    public function list(): void
    {

        $users = $this->user->list();

        $this->setLayout('list')->render([
            'users' => $users,
            'currentUserId' => $_SESSION['user']['id']
        ]);
    }

    // поиск пользователя
    public function show($id)
    {

        $user = $this->user->show($id);

        $this->setLayout('show')->render([
            'error' => 'не удалось найти пользователя'
        ]);

        return $user;
    }
}
