<?php
// Modelo de Usuario
namespace Model;

// Modelo de Usuario
class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    // Columnas de la base de datos
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'password', 'admin', 'confirmado', 'token'];

    // Atributos de la clase Usuario
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $password;
    public $admin;
    public $confirmado;
    public $token;
    
    // Constructor de la clase Usuario
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
        
    }
    // mensaje de validacion para la creacion de una cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El Telefono es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }
    // mensaje de validacion para el login de una cuenta
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        return self::$alertas;
    }
    
    // mensaje de validacion para el email de recuperar password
     public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        return self::$alertas;
    }

    // mensaje de validacion para el nuevo password
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // revisa si el usuario ya existe
    public function existeUsuario() {
        $email = self::$db->escape_string($this->email);
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }
        return $resultado;
    }

    // hashea el password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // genera un token unico para confirmar la cuenta
    public function crearToken() {
        $this->token = uniqid();
    }   

    // envia el email de confirmacion para crear la cuenta
    public function enviarEmail() {
        // Crear el objeto de email
    }
    
    // Verificar el password para iniciar sesion
    public function verificarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);

        // Verificar que el password sea correcto y que la cuenta este confirmada
        if(!$resultado || $this->confirmado !== '1') {
            self::$alertas['error'][] = 'Password incorrecto o tu cuenta no ha sido confirmada';
            return false;
        }

        return true;
    }
}
