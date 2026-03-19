<?php 
// Archivo de entrada principal de la aplicación
require_once __DIR__ . '/../includes/app.php';

// Importar el Router y el Controlador de Login

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServcioController;
use MVC\Router;

// Importar el Router y el Controlador de Login
$router = new Router();

//iniciar sesion
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);

//cerrar sesion
$router->get('/logout', [LoginController::class, 'logout']);

//recuperar password
$router->get('/olvide', [LoginController::class, 'olvide']);    
$router->post('/olvide', [LoginController::class,'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);    
$router->post('/recuperar', [LoginController::class,'recuperar']);

//crear cuenta
$router->get('/crearCuenta', [LoginController::class,'crearCuenta']);
$router->post('/crearCuenta', [LoginController::class,'crearCuenta']);

// confirmar cuenta
$router->get('/confirmarCuenta', [LoginController::class,'confirmarCuenta']);
$router->get('/mensaje', [LoginController::class,'mensaje']);

// area privada
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

// API de citas
$router->get('/api/servicios', [APIController::class, 'index']);
$router->get('/api/admin/citas', [APIController::class, 'getCitasAdmin']);
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminar', [APIController::class, 'eliminar']);

// CRUD de servicios
$router->get('/servicios', [ServcioController::class, 'index']);
$router->get('/servicios/crear', [ServcioController::class, 'crear']);
$router->post('/servicios/crear', [ServcioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServcioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServcioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServcioController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
