<!-- Вывод файлов в профель -->
<div class="container">
    <form action="/file/load" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="formFile" class="form-label">Загрузите файл</label>
            <input class="form-control" type="file" name="file">
            <button class="btn btn-outline-success" type="submit">Загрузить</button>
        </div>
    </form>
    <!--  тут вывод списка файлов пользователя  -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Название файла</th>
            <th scope="col">- -</th>
            <th scope="col">- -</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <?php

                // выводим список файлов пользователя
                $dir = '/uploaded/';
                $rootDir = $_SERVER["DOCUMENT_ROOT"] . $dir;
                $files = scandir($rootDir, 0);
                $countNumber = 1;

                foreach ($files as $file) {

                    if ($file == '.' || $file == '..') {
                        continue;
                    }

                    // отделяем файлы по id юзера
                    $separateId = explode('_', $file);

                    if ($separateId[0] == $_SESSION['user']['id']) {

                        echo "<form method='GET' action='/file/download' enctype='multipart/form-data'>";
                        echo "<tr>";
                        echo "<th scope='row'>" . $countNumber . '</th>';
                        echo "<td>" . $file . "</td>";
                        echo "<input type='hidden' name='name_file' value='" . $file . "'>";
                        echo "<td>
                                       <input name='action' type='submit' value='Скачать'>
                                        
                                  </td>";
                        echo "</form>
                                   <form method='GET' action='/file/delete' enctype='multipart/form-data'>";
                        echo "<input type='hidden' name='name_file' value='" . $file . "'>      
                                   <td>
                                       <input name='action' type='submit' value='Удалить'>
                                       <input name='http_method' type='hidden' value='delete'>     
                                    </td>";
                        echo "</form>";
                        echo "</tr>";

                        $countNumber++;
                    }

                    echo "</form>";
                }

                if ($countNumber == 1) {
                    echo 'Ваше хранилище пока пустое';
                }

                echo '</table>';
                ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>

