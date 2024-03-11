<!--Форма регистрации-->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация аккаунта</title>
    <!--    <link rel="stylesheet" href="css/main.css">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<!-- Форма регистрации пользователя -->
<div class="container">
    <form action="/user/add" method="post">
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="full_name" id="floatingInput" placeholder="Введите ФИО">
            <label for="floatingInput">ФИО</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Пароль">
            <label for="floatingPassword">Пароль</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password_confirm" id="confirmPassword"
                   placeholder="Подтвердите пароль">
            <label for="confirmPassword">Подтвердите пароль</label>
        </div>
        <!--   проверяем пароли на равенство    -->
        <?php
        if ($error) {
            echo '<p style="border: 4px solid red">' . $error . '</p>';
        }
        ?>
        <button type="submit" class="btn btn-primary" name="register">Зарегистрироваться</button>
        <div class="mb-3"> Уже зарегистрированы? - <a href="/user/login">авторизуйтесь</a></div>
    </form>
</div>
</body>