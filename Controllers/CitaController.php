<?php
// Controlador para manejar las citas
namespace Controllers;
use MVC\Router;

// Controlador para manejar las citas
class CitaController {
    // Método para mostrar la página de creación de citas
    public static function index(Router $router) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['nombre'])) {
            header('Location: /');
            exit();
        }

        // Renderizar la vista de creación de citas
        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre']
        ]);
    }
}
