<!--Kini ang entry point sa application.Nag handle siya sa pag route sa mga requests ngadto
sa sakto nga controller ug method base
<?php
session_start();

$url = isset($_GET['url']) ? $_GET['url'] : 'auth/login';
$url = rtrim($url, '/');
$url = explode('/', $url);

$controllerName = ucfirst($url[0]) . 'Controller';
$methodName = isset($url[1]) ? $url[1] : 'index';

$controllerMap = [
    'auth' => 'AuthController',
    'feed' => 'PostController',
    'post' => 'PostController',
    'profile' => 'ProfileController',
    'comment' => 'CommentController',
    'like' => 'LikeController'
];

$controllerKey = $url[0];
$controllerClass = isset($controllerMap[$controllerKey]) ? $controllerMap[$controllerKey] : $controllerName;

$controllerFile = 'C:\\Xampp\\htdocs\\yanqr_system\\app\\controllers\\' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerClass();
    
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        echo "404 - Method not found";
    }
} else {
    echo "404 - Controller not found: " . $controllerFile;
}
?>