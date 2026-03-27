<?php
session_start();

$url = isset($_GET['url']) ? $_GET['url'] : 'auth/login';
$url = rtrim($url, '/');
$url = explode('/', $url);

$controllerMap = [
    'auth' => 'AuthController',
    'feed' => 'PostController',
    'post' => 'PostController',
    'profile' => 'ProfileController',
    'comment' => 'CommentController',
    'like' => 'LikeController'
];

$controllerKey = isset($url[0]) ? $url[0] : 'auth';
$controllerClass = isset($controllerMap[$controllerKey]) ? $controllerMap[$controllerKey] : ucfirst($controllerKey) . 'Controller';
$method = isset($url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

$controllerFile = __DIR__ . '/../app/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerClass();
    
    if (method_exists($controller, $method)) {
        if (!empty($params)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            $controller->$method();
        }
    } else {
        echo "404 - Method not found";
    }
} else {
    echo "404 - Controller not found: " . $controllerFile;
}
?>