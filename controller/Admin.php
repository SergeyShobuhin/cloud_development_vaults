<?php

namespace controller;

use PDO;

class Admin extends BaseController
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = (new Database())->getConnection();
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

        $statementUpdate = $this->connection->prepare(
            "UPDATE users SET email = :email, password = :password, full_name = :full_name, is_admin = :is_admin, id = :id WHERE id = :id"
        );
        $statementUpdate->execute($data);
        header('Location: /admin/user');
    }

    // удаление пользователя
    public function delete($id): void
    {
        $id = (int)$id;

        $statementDelete = $this->connection->prepare("DELETE FROM `users` WHERE `users`.`id` = :id");
        $statementDelete->execute(['id' => $id]);

        header('Location: /admin/user');
    }

    // список пользователей
    public function list(): void
    {
        $statement = $this->connection->prepare("SELECT * FROM users");
        $statement->execute();
        $users = $statement->fetchall(PDO::FETCH_ASSOC);

        $this->setLayout('list')->render([
            'users' => $users,
            'currentUserId' => $_SESSION['user']['id']
        ]);
    }

    // поиск пользователя
    public function show($id)
    {
        $email = $id;

        $statement = $this->connection->prepare("SELECT * FROM users WHERE `id` = :id OR `email` LIKE :id"); // костыль какой то, для поиска по почте
        $statement->execute([
            'id' => $id,
            'email' => $email,
        ]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        $this->setLayout('show')->render([
            'error' => 'не удалось найти пользователя'
        ]);

        return $user;
    }
}
