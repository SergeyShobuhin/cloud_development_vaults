<?php

namespace controller;

class Password extends BaseController
{

    private Admin $user;
    private Mail $mail;
    private \PDO $connection;

    public function __construct()
    {

        $this->user = new Admin();
        $this->mail = new Mail();
        $this->connection = (new Connectbd())->getConnection();

    }

    public function change($email, $newPassword): void
    {

        // отправляем в БД новый пароль
        $statementUpdate = $this->connection->prepare("UPDATE users SET password = :password WHERE email = :email");
        $statementUpdate->execute([
            'email' => $email,
            'password' => $newPassword,
        ]);
    }

    public function newpassword(): void
    {

        $password = $_POST['password'];
        $passwordConfirm = $_POST['password_confirm'];
        $email = $_SESSION['user']['email'];

        if (!empty($password) && $password === $passwordConfirm) {

            if (isset($email)) {

                $newpassword = md5($password);
                print_r($newpassword);

                // отправляем в БД новый пароль
                $this->change($email, $newpassword);
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

    public function send()
    {

        $email = $_POST['email'] ?? null;

        if (!empty($email)) {

            $user = $this->user->show($email);

            if (!empty($user['email'])) {

                $email = $user['email'];
                $generateResetToken = uniqid('', true); // генерируем случайный токен
                $newPassword = md5($generateResetToken); // шифруем токен
                $this->change($email, $newPassword);

                //отправляем письмо с новым паролем
                $this->mail->sendByMail($email, $generateResetToken);

            } else {

                $this->setLayout('forgot')->render([
                    'error' => 'Пользователь с почтой ' . $email . ' не найден'
                ]);
            }
        }
    }
}