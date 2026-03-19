<?php
// Funciones para debuguear y sanitizar el HTML
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s(?string $html) : string {
    $s = htmlspecialchars($html ?? '', ENT_QUOTES, 'UTF-8');
    return $s;
}

// Verificar si el servicio actual es el último de la cita para mostrar un separador
function esUltimo( string $actual, string $proximo) : bool {
    if ($actual !== $proximo) {
        return true;
    }
    return false;
}

// Generar un token CSRF
function csrf_token() : string {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

// Validar el token CSRF
function validar_csrf(?string $token) : bool {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!$token || empty($_SESSION['csrf_token'])) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

// Verificar si el usuario esta autenticado
function isAuth() : void {
 if(!isset($_SESSION['login'])) {
    header('Location: /');
    exit;   
 }
}
// Verificar si el usuario es admin
function isAdmin() : void {
    if(!isset($_SESSION['admin']) || !$_SESSION['admin']) {
       header('Location: /');
       exit;   
    }
 }