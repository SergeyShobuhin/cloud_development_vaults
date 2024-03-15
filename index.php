<?php
session_start();

$rootDir = realpath(__DIR__ . '/');
require_once $rootDir . '/vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];

$urlList = require "config/route.php";
//
//if (!array_key_exists($_SERVER['REQUEST_URI'], $urlList)) {
//    $uri = '/user/login';
////    header('Location: /user/login');
////    exit();
//}
//
//$requestUri = rtrim($uri, '/');

$requestUri = rtrim($_SERVER['REQUEST_URI'], '/');

$uriParts = explode('?', $requestUri);
$requestUri = $uriParts[0] ?? $requestUri;
$requestMethod = strtoupper($_REQUEST['http_method'] ?? $_SERVER['REQUEST_METHOD']);


foreach ($urlList as $route => $methods) {

    $routePattern = preg_replace('/\{(.+?)\}/', '(.+?)', $route);
    $routePattern = "!^$routePattern$!";
    preg_match($routePattern, $requestUri, $matches);

    if (!$matches || empty($methods[$requestMethod])) {
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

    if (!$controllerName || !$controllerMethod) {

        throw new \RuntimeException('Возникла чудовищная ошибка, потерялся контроллер😱');
    }

    $controllerName = '\controller\\' . $controllerName . 'Controller';
    $controller = new $controllerName;
    $controller->{$controllerMethod}(...$params);  // динамическая передача параметров(...)

    break;
}

function pre($str)
{
    echo '<pre>';
    print_r($str);
    echo '</pre>';
}
