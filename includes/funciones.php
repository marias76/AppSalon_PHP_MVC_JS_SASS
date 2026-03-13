<?php
// Funciones para debuguear y sanitizar el HTML
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function csrf_token() : string {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

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
function isAuth() {
 if(!isset($_SESSION['login'])) {
    header('Location: /');
    exit;   
 }
}

