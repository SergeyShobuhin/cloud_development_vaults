
<?php
session_start();
//print_r($_SESSION);

//if (!empty($_SESSION['user'])) {
//    header("Location: /user/{$_SESSION['user']['id']}");
//    die();
//}

$rootDir = realpath(__DIR__ . '/');
require_once $rootDir . '/vendor/autoload.php';

$requestUri = rtrim($_SERVER['REQUEST_URI'], '/');
$uriParts = explode('?', $requestUri);
$requestUri = $uriParts[0] ?? $requestUri;
$requestMethod = strtoupper($_REQUEST['http_method'] ?? $_SERVER['REQUEST_METHOD']);

$urlList = [
    '/user' => [
        'GET' => 'User::registration',
    ],
    '/user/add' => [
        'POST' => 'User::add',
    ],

    '/user/login' => [
        'GET' => 'User::login',
    ],
    '/user/authorized' => [
        'POST' => 'User::authorized',
    ],
    '/user/logout' => [
        'POST' => 'User::logout',
    ],
    '/user/{id}' => [
        'GET' => 'User::profile',
    ],

    '/admin/user' => [
        'GET' => 'Admin::list',
    ],
    '/admin/user/{id}' => [
        'GET' => 'Admin::show',
        'DELETE' => 'Admin::delete',
        'PUT' => 'Admin::update',
    ],

    '/file/load' => [
        'GET' => 'File::load',
        'POST' => 'File::upload',
    ],
    '/file/download' => [
        'GET' => 'File::download',
    ],
    '/file/delete' => [
        'DELETE' => 'File::delete',
    ],

    '/password/forgot' => [
        'POST' => 'Password::send'
    ],
    '/password/newpass' => [
        'POST' => 'Password::newpassword'
    ],


    // ещё нужно добавить директорию
];

foreach ($urlList as $route => $methods) {

    $routePattern = preg_replace('/\{(.+?)\}/', '(.+?)', $route);
    $routePattern = "!^$routePattern$!";
    preg_match($routePattern, $requestUri, $matches);

    if(!$matches || empty($methods[$requestMethod])){
        continue;
    }

    unset($matches[0]);
    $paramValues = array_values($matches);
    preg_match_all('/\{(.+?)\}/', $route, $matches);

    $params = [];

    foreach ($matches[1] as $index => $paramName) {

        $params[$paramName] = $paramValues[$index] ?? null;

    }

    list($controllerName, $controllerMethod) = explode('::', $methods[$requestMethod]);

    if(!$controllerName || !$controllerMethod) {

        throw new Exception('Возникла чудовищная ошибка, потерялся контроллер😱');
    }

    $controllerName = '\controller\\' . $controllerName;
    $controller = new $controllerName;
    $controller->{$controllerMethod}(...$params);  // динамическая передача параметров(...)

    break;
}

function pre($str) {
    echo '<pre>';
    print_r($str);
    echo '</pre>';
}
