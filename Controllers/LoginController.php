<?php

namespace Controllers;

use Model\Usuario;
use Classes\Email;
use MVC\Router;

class LoginController {

    public static function login(Router $router) {
        $alertas = $_SESSION['alertas'] ?? [];
        unset($_SESSION['alertas']);

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);  
        
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
        $usuario = new Usuario;
        
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
                            // Crear el usuario
                        $resultado = $usuario->guardar();
                        if($resultado) {
                            header('Location: /mensaje');
                            exit;
                        }
                    }
                }
        }

        $router->render('auth/crearCuenta', [
            'usuario' => $usuario, 
            'alertas' => $alertas
        ]);
    }
    public static function mensaje(Router $router) { 
        $router->render('auth/mensaje', [
        ]);  
    }
    public static function confirmarCuenta(Router $router) { 
        $token = s($_GET['token'] ?? '');

        if(!$token) {
            $_SESSION['alertas'] = [
                'error' => ['Token No Valido']
            ];
            header('Location: /');
            exit;
        }

        /** @var Usuario|null $usuario */
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)) {
            $_SESSION['alertas'] = [
                'error' => ['Token No Valido o ya utilizado']
            ];
            header('Location: /');
            exit;
        } else {
            // confirmar la cuenta
            $usuario->confirmado = "1";
            $usuario->token = null;            
            $usuario->guardar();
            $_SESSION['alertas'] = [
                'exito' => ['Cuenta Comprobada Correctamente']
            ];

            header('Location: /');
            exit;
        }
    }

}   
