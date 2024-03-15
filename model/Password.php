<?php

namespace model;

class Password
{
    private Mail $mail;
    private User $user;
    private \PDO $connection;


    public function __construct()
    {
        $this->mail = new Mail();
        $this->user = new User();
        $this->connection = (new Database())->getConnection();
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

    public function send($email): void
    {

        $user = $this->user->show($email);
        $email = $user['email'];
        $generateResetToken = uniqid('', true); // генерируем случайный токен
        $newPassword = md5($generateResetToken); // шифруем токен
        $this->change($email, $newPassword);

        //отправляем письмо с новым паролем
        $this->mail->sendByMail($email, $generateResetToken);
    }
}



