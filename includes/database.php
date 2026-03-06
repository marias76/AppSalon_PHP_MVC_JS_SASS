<?php
// Cargar las variables de entorno desde el archivo .env
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar las variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Configuración de la base de datos
$dbHost = $_ENV['DB_HOST'];
$dbPort = (int)($_ENV['DB_PORT']);
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];
$dbName = $_ENV['DB_NAME'];

// Conexión a la base de datos
$db = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
mysqli_set_charset($db, 'utf8mb4');

// Verificar la conexión
if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo " errno de depuración: " . mysqli_connect_errno();
    echo " error de depuración: " . mysqli_connect_error();
    exit;
}