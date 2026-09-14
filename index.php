<?php
namespace Aura;
use Aura\Core\Router;
use Aura\Core\Container;
use Aura\Core\Response;

$projectRoot = __DIR__;
spl_autoload_register(function ($class) use ($projectRoot) {
    $prefix = 'Aura\\';
    $base_dir = $projectRoot . '/sources/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Initialize Container
$container = new Container();

//Sanitize GET parameters
if (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
        if (is_string($value)) {
            $_GET[$key] = htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
        }
    }
}

// Initialize Router
$router = new Router($container);

// Define Routes
$router->get('/', [Controllers\AuthController::class, 'index']);
$router->post('/login', [Controllers\AuthController::class, 'login']);
$router->get('/logout', [Controllers\AuthController::class, 'logout']);

// Dashboard & Modules
$router->get('/dashboard', [Controllers\DashboardController::class, 'index']);
$router->get('/estudiantes', [Controllers\EstudiantesController::class, 'index']);
$router->post('/estudiantes/agregar', [Controllers\EstudiantesController::class, 'agregar']);
$router->post('/estudiantes/carga-masiva', [Controllers\EstudiantesController::class, 'cargaMasiva']);
$router->get('/catalogos', [Controllers\CatalogosController::class, 'index']);
$router->post('/catalogos/programas', [Controllers\CatalogosController::class, 'agregarPrograma']);
$router->put('/catalogos/programas/{id}', [Controllers\CatalogosController::class, 'editarPrograma']);
$router->delete('/catalogos/programas/{id}', [Controllers\CatalogosController::class, 'eliminarPrograma']);
$router->post('/catalogos/generaciones', [Controllers\CatalogosController::class, 'agregarGeneracion']);
$router->put('/catalogos/generaciones/{id}', [Controllers\CatalogosController::class, 'editarGeneracion']);
$router->delete('/catalogos/generaciones/{id}', [Controllers\CatalogosController::class, 'eliminarGeneracion']);

// Dispatch
$response = $router->dispatch();
if ($response instanceof Response) {
    $response->send();
}