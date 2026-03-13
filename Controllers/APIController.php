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

        // Recibir los datos de la cita desde la solicitud POST
        $cita = new \Model\Cita($_POST);    
        $resultado = $cita->guardar();

        // Obtener el ID del cliente recién creado
        $id = $resultado['id'];

        // Devolver el resultado en formato JSON
        $idServicios = explode(',', $_POST['servicios']);

        // Guardar la relación entre la cita y los servicios seleccionados
        foreach ($idServicios as $idServicio) {
            $arg = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];  
            $citaServicio = new \Model\CitaServicio($arg);
            $citaServicio->guardar();
        }   

        // Devolver la respuesta en formato JSON
        echo json_encode(['resultado' => $resultado]);
    }
}
