<?php 
// Incluimos las funciones y la conexión a la base de datos
require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Cargamos las variables de entorno
use Dotenv\Dotenv;

// Cargamos las variables de entorno desde el archivo .env 
//ubicado en el directorio raíz del proyecto
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);