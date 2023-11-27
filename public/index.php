<?php

use MVC\Router;
use Controllers\TareasController;
use Controllers\LoginController;
use Controllers\DashboardController;

include_once __DIR__ . '/../includes/app.php';
// include_once '../includes/app.php';

$router = new Router();

//Controller::class muestra el path de la clase

//rutas 
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//rutas para crear cuenta
$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);

//formulario para recuperar password
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

//endpoits para reset password
$router->get('/reset', [LoginController::class, 'reset']);
$router->post('/reset', [LoginController::class, 'reset']);

//mensaje mostrado posterior a crear cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);

//confirmar cuenta
$router->get('/confirmar', [LoginController::class, 'confirmar']);


//dashboard
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
$router->post('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
$router->get('/proyecto', [DashboardController::class, 'proyecto']);
$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->post('/perfil', [DashboardController::class, 'perfil']);
$router->get('/cambiar-password', [DashboardController::class, 'cambiar_password']);
$router->post('/cambiar-password', [DashboardController::class, 'cambiar_password']);

//API para tareas
$router->get('/api/tarea', [TareasController::class, 'index']);
$router->post('/api/tarea', [TareasController::class, 'crear']);
$router->post('/api/tarea/actualizar', [TareasController::class, 'actualizar']);
$router->post('/api/tarea/eliminar', [TareasController::class, 'eliminar']);



$router->comprobarRutas();


?>