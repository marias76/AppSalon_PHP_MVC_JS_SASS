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
    // Método para guardar una nueva cita desde la API
    public static function guardar() {
        $cita = new \Model\Cita($_POST);    
        $resultado = $cita->guardar();

        // $respuesta = [
        //     'cita' => $cita    

        // ];
        
        echo json_encode($resultado);
    }

}
