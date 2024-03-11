<?php

namespace controller;

use PDO;

class User extends BaseController
{

    private PDO $connection;

    public function __construct()
    {
        $this->connection = (new Connectbd())->getConnection();
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

            $statement = $this->connection->prepare(
                "INSERT INTO users (`id`, `email`, `password`, `full_name`, `date_created`, `is_admin`) VALUES (NULL, :email, :password, :full_name, :date, :is_admin)"
            );
            $statement->execute([
                'email' => $email,
                'password' => $password,
                'full_name' => $fullName,
                'date' => $date,
                'is_admin' => $admin
            ]);

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

        $statement = $this->connection->prepare("SELECT * FROM users WHERE `email` LIKE :email AND `password` LIKE :password");
        $statement->execute([
            'email' => $email,
            'password' => $password
        ]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

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

        $statement = $this->connection->prepare("SELECT * FROM users WHERE `id` = :id");
        $statement->execute([
            'id' => $id,
        ]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        $this->setLayout('profile')->render(['user' => $user]);
    }

    // логаут пользователя
    public function logout(): void
    {
        unset($_SESSION['user']);
        header('Location: /user/login');
    }
}
