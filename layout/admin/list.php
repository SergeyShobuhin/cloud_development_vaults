<!--форма администратора / список пользователей-->
<?php

if (!$_SESSION['user']) {
    header('Location: /user/login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Список пользователей</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="/user/<?php echo $currentUserId; ?>">
    <button class="btn btn-primary" type="button">Вернуться в профиль</button>
</a>
<h2>Список пользователей</h2>
<div class="table-responsive list-group">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Имя</th>
            <th>Права администратора</th>
            <th>Дата создания</th>
            <th colspan="2">Изменить/Удалить пользователя</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // выводим список таблицы базы данных

        foreach ($users as $user) {

            if (isset($user['is_admin']) && $user['is_admin'] === 1) {
                $checkbox = 'checked="checked"';
            } else {
                $checkbox = '';
            }

            echo "<tr class='list-group-item-action list-group-item-warning'>";
            echo "<form method='put' action='/admin/user/{$user['id']}'>";
            echo "<td > " . $user['id'] . "</td>";
            echo "<td > <input type='text' name='email' value='" . $user['email'] . "'></td>";
            echo "<td> <input type='text' name='full_name' value='" . $user['full_name'] . "'></td>";
            echo "<td> <input type='checkbox' name='is_admin' value='" . $user['is_admin'] . "' $checkbox '></td>";
            echo "<td> " . $user['date_created'] . "</td>";
            echo "<td> <input class='btn btn-info' name='action' type='submit' value='Изменить'>";
            echo "<input name='http_method' type='hidden' value='put'> 
                </td>";

            echo "</form> 
                <form method='get' action='/admin/user/{$user['id']}'>
                <td> 
                    <input class='btn btn-danger' name='action' type='submit' value='Удалить'> 
                    <input name='http_method' type='hidden' value='delete'>
              </td>";
            echo "</form>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<form method="post" action="/user/add">
    <div>
        <h1>Создать нового пользователя:</h1>
        <label> Email: <input type="text" name="email"></label>
        <label> Имя: <input type="text" name="full_name"></label>
        <label> Пароль: <input type="text" name="password"></label>
        <label> Пароль ещё раз: <input type="text" name="password_confirm"></label>
        <label> Администратор? <input type="checkbox" name="is_admin"></label>
        <div><input type="submit" name="register" value="Ввести в базу"></div>
    </div>
</form>
</body>
</html>
