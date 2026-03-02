<?php

namespace Controllers;

use MVC\Router;

class LoginController {

    public static function login(Router $router) {
        $router->render('auth/login');  
        
    }
    public static function logout() {
        echo "Desde el logoutController";
    }
    public static function olvide() {
        echo "Desde el olvideController";
        
    }
    public static function recuperar() {
        echo "<h1>Recuperar Contraseña</h1>";
    }
    public static function crearCuenta() {
        echo "<h1>Crear Cuenta</h1>";
    }

}   