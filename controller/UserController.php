<?php

namespace controller;

use model\User;

class UserController extends BaseController
{
    private User $model;

    public function __construct()
    {
        $this->model = new User();
    }

    // регистрация пользователя
    public function add(): void
    {

        $email = $_POST['email'];
        $fullName = $_POST['full_name'];
        $password = md5($_POST['password']);
        $passwordConfirm = md5($_POST['password_confirm']);
        $date = date('Y-m-d H:i:s');

        if (isset($_POST['is_admin'])) {
            $admin = 1;
        } else {
            $admin = 0;
        }

        //проверяем совпадение пароля и создаём пользователя в БД
        if ($password !== $passwordConfirm) {

            $this->setLayout('registration')->render([
                'error' => 'пароли не совпадают'
            ]);
        } else {

            $this->model->add($email, $password, $fullName, $date, $admin);

            if ($_SESSION['user']) {
                header("Location: /admin/user");
            } else {
                header('Location: /user/login');
            }
        }
    }

    public function registration(): void
    {
        $this->setLayout('registration')->render();
    }

    // авторизация пользователя
    public function authorized(): void
    {

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $user = $this->model->find($email, $password);

        if ($user) {

            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'full_name' => $user['full_name'],
                'password' => $user['password'],
                'is_admin' => $user['is_admin']
            ];

            $id = $user['id'];
            header("Location: /user/$id"); // отправляем на страницу юзера с сответствующим id
        }

        $this->setLayout('login')->render([
            'error' => 'не удалось авторризоваться, не верно введён пароль или почта'
        ]);
    }

    public function login(): void
    {
        $this->setLayout('login')->render();
    }

    // профиль пользователя
    public function profile($id): void
    {
        $user = $this->model->findId($id);
        $this->setLayout('profile')->render(['user' => $user]);
    }

    // логаут пользователя
    public function logout(): void
    {
        unset($_SESSION['user']);
        header('Location: /user/login');
    }
}
