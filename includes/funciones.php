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

// Verificar si el usuario esta autenticado
function isAuth() {
 if(!isset($_SESSION['login'])) {
    header('Location: /');
    exit;   
 }
}

