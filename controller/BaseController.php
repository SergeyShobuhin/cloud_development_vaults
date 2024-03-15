<?php

namespace controller;

class BaseController
{

    private string $layout = 'default';

    protected function setLayout(string $layout): BaseController
    {
        $this->layout = $layout;

        return $this;
    }

    protected function render(array $params = []): void
    {
        $className = get_class($this);      // Возвращает имя класса, к которому принадлежит объект
        $classNameParts = explode('\\', $className);        //Разбивает строку с помощью разделителя
        $controllerName = str_replace('Controller', '', lcfirst(end($classNameParts))); // преобразуем имя контроллера для Layout
        $layoutPath = dirname(realpath(__DIR__ . '/')) . "/layout/$controllerName/{$this->layout}.php";     //строим полный путь к форме которую обрабатыватываем
        extract($params);       //Импортирует переменные из массива в текущую таблицу символов
        require_once $layoutPath;       // подключает файл из layout
    }
}
