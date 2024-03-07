<!-- форма востановления пароля -->

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
    <form action="/password/forgot" method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Восстановить пароль</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Введите почту куда будет отправлено письмо с паролем.</div>
        </div>
        <button type="submit" class="btn btn-primary" name="restore">Восстановить</button>
        <?php
//        if ($error) {
//            echo '<p style="border: 4px solid red">' . $error . '</p>';
//        }
//        if ($message) {
//            echo '<p style="border: 4px solid green">' . $message . '</p>';
//        }
        switch (true) {
            case $error:
                echo '<p style="border: 4px solid red">' . $error . '</p>';
                break;
            case $message:
                echo '<p style="border: 4px solid green">' . $message . '</p>';
                break;
        }
        ?>
    </form>
</div>

