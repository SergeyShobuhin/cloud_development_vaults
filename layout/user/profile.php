<?php
// редирект на профиль по ID  ---  чушь какая то!!!! как сделать на всех страницах
if (!$_SESSION['user']) {
    header('Location: /user/login');
    exit();
}

if ($_SESSION['user']['id'] !== $user['id']) {
    header("Location: /user/{$_SESSION['user']['id']}");
}
?>

<!--Форма профиля пользователя или администратора-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
    <!--    <link href="/css/bootstrap.min.css" rel="stylesheet">-->
    <!--    <link href="/css/album.css" rel="stylesheet">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <!--  тут вывод информации о пользователе  -->
    <nav class="navbar navbar-light bg-light">
        <form action="/user/logout" method="POST">
            <div class="container-fluid">
                <span class="navbar-brand">Ваш профиль</span>
                <button class="btn btn-outline-success" type="submit">Выход</button>
                <?php
                if ($user['is_admin'] === 1) {
                    echo '<a href="/admin/user"><button class="btn btn-primary" type="button">Управление администратора</button></a>';
                }
                ?>
            </div>
        </form>
        <form action="/layout/password/newpass.php" method="POST">
            <input type="text" class="form-control" placeholder="Введите новый пароль" aria-label="Last name"
                   name="password">
            <button class="btn btn-outline-success" type="submit">Сменить пароль</button>
        </form>
    </nav>
    <ul class="list-group">
        <li class="list-group-item">ФИО: <b><?php echo $user['full_name'] ?></b></li>
        <li class="list-group-item">Email: <b><?php echo $user['email'] ?></b></li>
        <li class="list-group-item">Ваш ID в системе: <b><?php echo $user['id'] ?></b></li>
    </ul>

    <?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/layout/file/load.php");
    ?>
</div>
</body>
