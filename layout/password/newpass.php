<!--форма замены пароля-->

<?php
//session_start();
//print_r($_SERVER);
//?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Восстановление пароля</title>
    <!--    <link rel="stylesheet" href="../css/main.css">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <form action="/password/newpass" method="POST">
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Пароль">
            <label for="floatingPassword">Пароль</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password_confirm" id="confirmPassword"
                   placeholder="Подтвердите пароль">
            <label for="confirmPassword">Подтвердите пароль</label>
        </div>
        <button type="submit" class="btn btn-primary" name="authorization">Отправить</button>
         <?php
        if ($error) {
            echo '<p style="border: 4px solid red">' . $error . '</p>';
        }
        ?>
    </form>
</div>

