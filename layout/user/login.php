<?php
if (!empty($_SESSION)) {
    header("Location: /user/{$_SESSION['user']['id']}");
}
?>

<!--форма авторизации-->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Форма авторизации -->
<div class="container">
    <form action="/user/authorized" method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Введите почту.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            <div id="emailHelp" class="form-text">Введите пароль.</div>
        </div>

        <!--если не нашёл пользователя с подходящей почтой и паролем, печатаем сообщение об ошибке-->
        <?php
        if ($error) {
            echo '<p style="border: 4px solid red">' . $error . '</p>';
        }
        if ($message) {
            echo '<p style="border: 4px solid green">' . $message . '</p>';
        }
        ?>

        <button type="submit" class="btn btn-primary" name="authorization">Войти</button>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="/layout/password/forgot.php">
                <button class="btn btn-primary" type="button">Забыли пароль?</button>
            </a>
            <p class="h5"> или </p>
            <a href="/user">
                <button class="btn btn-primary" type="button">Нет аккаунта?</button>
            </a>
        </div>
    </form>
</div>
</body>