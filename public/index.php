<?php
// public/index.php
// Simple front controller using GET param `page` and `action`

require_once __DIR__ . '/../app/bootstrap.php';

session_start();

// route mapping: page -> controller class
$routes = [
    'shop'   => ['controller' => 'ProductController', 'default_action' => 'list'],
    'product'=> ['controller' => 'ProductController', 'default_action' => 'detail'],
    'cart'   => ['controller' => 'CartController', 'default_action' => 'index'],
    'checkout'=>['controller' => 'OrderController', 'default_action' => 'checkoutForm'],
    'order'  => ['controller' => 'OrderController', 'default_action' => 'success'],
    'wishlist'=>['controller' => 'WishlistController', 'default_action' => 'index'],
    'account'=>['controller' => 'UserController', 'default_action' => 'account'],
    'contact'=>['controller' => 'ContactController', 'default_action' => 'form'],
    'home'   => ['controller' => 'ProductController', 'default_action' => 'home'],
    'login'  => ['controller' => 'UserController', 'default_action' => 'loginForm'],
    'logout' => ['controller' => 'UserController', 'default_action' => 'logout'],
];

// default page
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;

if (!isset($routes[$page])) {
    http_response_code(404);
    echo "Halaman tidak ditemukan.";
    exit;
}

$route = $routes[$page];
$controllerName = $route['controller'];
$actionName = $action ?: $route['default_action'];

// instantiate controller (controllers expect $db)
$controllerFile = __DIR__ . "/../app/controllers/{$controllerName}.php";
if (!file_exists($controllerFile)) {
    http_response_code(500);
    echo "Controller tidak ditemukan: {$controllerName}";
    exit;
}

require_once $controllerFile;
$controller = new $controllerName($db);

// call method if exists
if (!method_exists($controller, $actionName)) {
    http_response_code(404);
    echo "Aksi tidak ditemukan: {$actionName}";
    exit;
}

// call with GET/POST merged param (controller methods decide)
$response = $controller->{$actionName}($_REQUEST);

// if controller returned array for JSON API, output JSON
if (is_array($response) && isset($response['__json'])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
} else {
    // otherwise controller itself should include views or redirect
}
