<?php

session_start();

$rotasPublicas = [
    '/login',
    '/login/autenticar'
];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$rotaAsset = str_starts_with($uri, '/assets/');

if (!isset($_SESSION['usuario_id']) && !in_array($uri, $rotasPublicas) && !$rotaAsset) {
    header('Location: /login');
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
$router = new Router();

require_once __DIR__ . '/../routes/web.php';

$router->dispatch();