<?php
// index.php
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/':
        require __DIR__ . '/pages/login.php';
        break;
    case '/register':
        require __DIR__ . '/pages/register.php';
        break;
    case '/dashboard_redes':
        require __DIR__ . '/pages/dashboard_redes.php';
        break;
    case '/dashboard_telefonico':
        require __DIR__ . '/pages/dashboard_telefonico.php';
        break;
    case '/logout':
        require __DIR__ . '/pages/logout.php';
        break;
    default:
        http_response_code(404);
        echo 'Página no encontrada';
        break;
}
?>
