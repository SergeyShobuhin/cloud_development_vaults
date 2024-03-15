<?php

namespace controller;

use model\Password;

class PasswordController extends BaseController
{

    private AdminController $user;
    private Password $password;

    public function __construct()
    {
        $this->user = new AdminController();
        $this->password = new Password();
    }

    public function newpassword(): void
    {

        $password = $_POST['password'];
        $passwordConfirm = $_POST['password_confirm'];
        $email = $_SESSION['user']['email'];

        if (!empty($password) && $password === $passwordConfirm) {

            if (isset($email)) {

                $newpassword = md5($password);

                // отправляем в БД новый пароль
                $this->password->change($email, $newpassword);
                header("Location: /user/{$_SESSION['user']['id']}");

            } else {

                header('Location: /user');
            }
        } else {

            $this->setLayout('newpass')->render([
                'error' => 'пароли не совпадают'
            ]);
        }
    }

    public function send(): void
    {

        $email = $_POST['email'] ?? null;

        if (!empty($email)) {

            $user = $this->user->show($email);

            if (!empty($user['email'])) {

                $this->password->send($user['email']);

            } else {

                $this->setLayout('forgot')->render([
                    'error' => 'Пользователь с почтой ' . $email . ' не найден'
                ]);
            }
        }
    }
}
