<?php

namespace controller;

class File extends BaseController
{
    private string $storageDir;

    // определяем директорию хранилища
    public function __construct()
    {
        $dir = '/uploaded/';
        $rootDir = $_SERVER["DOCUMENT_ROOT"] . $dir;
        $this->storageDir = $rootDir;
    }

//    загружаем файлы
    public function upload(): void
    {
        // формируем имя с ID пользователя для дальнейшей индификации его
        $id = $_SESSION['user']['id'];
        $storageName = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];
        $fileTemp = $this->storageDir . $id . '_' . $storageName;

//        print_r($_SESSION);
//        print_r($fileTemp);

        move_uploaded_file($tmpName, $fileTemp);
        header("Location: /user/$id");

//        $this->setLayout('login')->render([
//            'error' => 'не удалось загрузить файл'
//        ]);
    }

    public function load(): void
    {
        // формируем имя с ID пользователя для дальнейшей индификации его
        $files = scandir($this->storageDir);

//        if($files) {
//            print_r($files);
////            print_r($_SESSION['user']['id']);
//        }
        $this->setLayout('load')->render([
            'file' => $files,
            'currentUserId' => $_SESSION['user']['id']
        ]);
    }

    //показываем файлы
    public function getLoadFiles(): void
    {
        $files = scandir($this->storageDir);

//        if($files) {
//            print_r($files);
//        }
        $this->setLayout('load')->render([
            'file' => $files
        ]);
    }

    // удаляем файлы
    public function delete(): void
    {

        $fileName = $_GET['name_file'];
        $id = $_SESSION['user']['id'];

        $filePath = $this->storageDir . $fileName;
        unlink($filePath);
        header("Location: /user/$id");


    }

    // скачиваем файл
    public function download(): void
    {

        $fileName = $_GET['name_file'];
        $filePath = $this->storageDir . $fileName;

        // узнаём расшерение(тип) файла MIME
        $mime = mime_content_type($filePath);

        // Отправка заголовков для скачиваний файла
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');

        echo file_get_contents($filePath);
//        header('Location: /file/load');
    }
}

