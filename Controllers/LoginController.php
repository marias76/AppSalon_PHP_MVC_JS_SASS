<?php

namespace Controllers;

use Model\usuario;
use Classes\Email;
use MVC\Router;

class LoginController {

    public static function login(Router $router) {
        $router->render('auth/login');  
        
    }
    public static function logout() {
        echo "Desde el logoutController";
    }
    public static function olvide(Router $router) {
        $router->render('auth/olvide', [
            
        ]);  
        
    }
    public static function recuperar() {
        echo "<h1>Recuperar Contraseña</h1>";
    }
    public static function crearCuenta(Router $router) {
        $usuario = new usuario;
        
        // Alertas vacias
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $usuario->sincronizar($_POST);
                $alertas = $usuario->validarNuevaCuenta(); 
                // revisar que alertas este vacio
                if(empty($alertas)) {
                    // Verificar que el usuario no este registrado
                    $resultado = $usuario->existeUsuario();
                    if($resultado->num_rows) {
                        $alertas = Usuario::getAlertas();
                    } else{
                        // no esta registrado
                            // hashear el password
                        $usuario->hashPassword();   
                            // Generar un token unico
                        $usuario->crearToken();
                            // enviar el email de confirmacion
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);  
                        $email->enviarConfirmacion();
                        
                        // debuguear($usuario);
                            // Crear el usuario
                    }

                    
                }

        }

        $router->render('auth/crearCuenta', [
            'usuario' => $usuario, 
            'alertas' => $alertas
        
        ]);
    }

}   