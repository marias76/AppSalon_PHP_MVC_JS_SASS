<?php
// Controlador para la gestión de servicios
namespace Controllers;

use MVC\Router;

class ServcioController {
    // Método para mostrar los servicios (puede ser utilizado para una API o para renderizar una vista)
    public static function index(Router $router) {
        isAuth();
         $router->render('servicios/index', [
            
         ]);
    }

    public static function crear(Router $router) {        
        isAuth();        
         if($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Aquí puedes agregar la lógica para crear un nuevo servicio
             // Por ejemplo, podrías validar los datos recibidos y guardarlos en la base de datos

         }

         $router->render('servicios/crear', [
            
         ]);

    }
    public static function actualizar(Router $router) {            
        isAuth();
         if($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Aquí puedes agregar la lógica para actualizar un servicio existente
             // Por ejemplo, podrías validar los datos recibidos y actualizarlos en la base de datos

         }

         $router->render('servicios/actualizar', [
            
         ]);
    }
    public static function eliminar(Router $router) {
        isAuth();

         if($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Aquí puedes agregar la lógica para eliminar un servicio existente
             // Por ejemplo, podrías validar los datos recibidos y eliminarlos de la base de datos

         }
    }
}
