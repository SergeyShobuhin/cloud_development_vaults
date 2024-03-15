<?php

namespace model;

use PDO;

class User
{

    private PDO $connection;

    public function __construct()
    {
        $this->connection = (new Database())->getConnection();
    }

    public function add($email, $password, $fullName, $date, $admin): bool
    {

        $statement = $this->connection->prepare(
            "INSERT INTO users (`id`, `email`, `password`, `full_name`, `date_created`, `is_admin`) VALUES (NULL, :email, :password, :full_name, :date, :is_admin)"
        );
        return $statement->execute([
            'email' => $email,
            'password' => $password,
            'full_name' => $fullName,
            'date' => $date,
            'is_admin' => $admin
        ]);
    }

    public function find($email, $password): mixed
    {

        $statement = $this->connection->prepare("SELECT * FROM users WHERE `email` LIKE :email AND `password` LIKE :password");
        $statement->execute([
            'email' => $email,
            'password' => $password
        ]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function findId($id): mixed
    {

        $statement = $this->connection->prepare("SELECT * FROM users WHERE `id` = :id");
        $statement->execute([
            'id' => $id,
        ]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function update($data)
    {

        $statementUpdate = $this->connection->prepare(
            "UPDATE users SET email = :email, password = :password, full_name = :full_name, is_admin = :is_admin, id = :id WHERE id = :id"
        );
        $user = $statementUpdate->execute($data);

        return $user;
    }

    public function delete($id): bool
    {

        $statementDelete = $this->connection->prepare("DELETE FROM `users` WHERE `users`.`id` = :id");
        $user = $statementDelete->execute(['id' => $id]);

        return $user;
    }

    public function list(): false|array
    {

        $statement = $this->connection->prepare("SELECT * FROM users");
        $statement->execute();
        $users = $statement->fetchall(PDO::FETCH_ASSOC);

        return $users;
    }

    public function show($id): mixed
    {

        $email = $id;

        $statement = $this->connection->prepare("SELECT * FROM users WHERE `id` = :id OR `email` LIKE :id"); // костыль какой то, для поиска по почте
        $statement->execute([
            'id' => $id,
            'email' => $email,
        ]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

}