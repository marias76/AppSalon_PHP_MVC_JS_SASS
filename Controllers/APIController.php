<?php
// Controlador para la API de servicios
namespace Controllers;

// Importar el modelo de Servicio
class APIController {
    // Método para obtener los servicios en formato JSON
    public static function index() {
        $servicios = \Model\Servicio::all();
        echo json_encode($servicios);

    }
}
