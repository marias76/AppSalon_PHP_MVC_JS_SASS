<?php
// Controlador para el Login, Registro, Recuperar Contraseña y Confirmar Cuenta
namespace Controllers;
use Model\Usuario;
use Classes\Email;
use MVC\Router;

// Controlador para el Login, Registro, Recuperar Contraseña y Confirmar Cuenta
class LoginController {

    // Iniciar Sesion
    public static function login(Router $router) {
        $alertas = $_SESSION['alertas'] ?? [];
        unset($_SESSION['alertas']);

        // revisar si el usuario esta enviando algo por post
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();  

                // revisar que alertas este vacio
            if(empty($alertas)){
                /** @var Usuario|null $usuario */
                $usuario = Usuario::where('email', $auth->email);

                // Verificar que el usuario este confirmado
                if($usuario){
                    // Verificar el password
                    $usuario->verificarPasswordAndVerificado($auth->password);
                    // Autenticar el usuario / Iniciar la sesion
                    session_start();
                    $_SESSION['id'] = $usuario->id; 
                    $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                    $_SESSION['email'] = $usuario->email; 
                    $_SESSION['login'] = true; 
                    
                    // Redireccionar al usuario
                    if($usuario->admin === "1") {
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        header('Location: /admin');
                    }else{
                        header('Location: /cita');
                    }  
                }else{
                    // Usuario no encontrado
                    Usuario::setAlerta('error', 'Usuario No Encontrado');
                }
                
            }
        }

    $alertas = Usuario::getAlertas();   
    // render a la vista
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);  
        
    }
    // Cerrar Sesion
    public static function logout() {
        echo "Desde el logoutController";
    }
    // Recuperar Password / Olvidé mi Password
    public static function olvide(Router $router) {
        $alertas = $_SESSION['alertas'] ?? [];
        unset($_SESSION['alertas']);

        // revisar si el usuario esta enviando algo por post
        if($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();  

            // revisar que alertas este vacio
            if(empty($alertas)){
                /** @var Usuario|null $usuario */
                $usuario = Usuario::where('email', $auth->email);
                // Verificar que el usuario exista y este confirmado
                if($usuario && $usuario->confirmado === "1") {
                    // Generar un token unico
                    $usuario->crearToken();
                    $usuario->guardar();

                        // Alerta de exito
                    Usuario::setAlerta('exito', 'Se han enviado las instrucciones a tu email');

                        // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    
                } else {
                    Usuario::setAlerta('error', 'El Usuario No Existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        // render a la vista
        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);  
        
    }
    // Recuperar Contraseña
    public static function recuperar(Router $router) {
        $alertas = $_SESSION['alertas'] ?? [];
        unset($_SESSION['alertas']);
        $error = false;

        $token = s($_GET['token'] ?? '');   
        // buscar usuario por su token
        /** @var Usuario|null $usuario */
        $usuario = Usuario::where('token', $token);
    
        // revisar si el usuario esta enviando algo por post
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Valido');
            $error = true;
        }
        // Si el usuario existe, revisar si el usuario esta enviando algo por post
        if($_SERVER['REQUEST_METHOD'] === 'POST') { 
            // leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();  

            // revisar que alertas este vacio
            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                    exit;
                }
            }
        }
            
        $alertas = Usuario::getAlertas();
        // render a la vista
        $router->render('auth/recuperarPassword', [
            'alertas' => $alertas,
            'error' => $error
        ]);
        
    }

    // Crear Cuenta
    public static function crearCuenta(Router $router) {
        $usuario = new Usuario;
        // Alertas vacias
        $alertas = [];

        // revisar si el usuario esta enviando algo por post
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
        // render a la vista
        $router->render('auth/crearCuenta', [
            'usuario' => $usuario, 
            'alertas' => $alertas
        ]);
    }
    // Mensaje de confirmacion de cuenta
    public static function mensaje(Router $router) { 
        $router->render('auth/mensaje', [
        ]);  
    }
    // Confirmar Cuenta
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
