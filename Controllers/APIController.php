<?php
// Controlador para la API de servicios
namespace Controllers;

// Importar el modelo de Servicio
class APIController {
    // Método para obtener los servicios en formato JSON
    public static function index() {
        isAuth();

        header('Content-Type: application/json; charset=utf-8');
        $servicios = \Model\Servicio::all();
        echo json_encode($servicios);

    }
    // Método para guardar una nueva cita desde la API
    public static function guardar() {
        isAuth();

        header('Content-Type: application/json; charset=utf-8');

        if(!validar_csrf($_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            echo json_encode(['resultado' => false, 'mensaje' => 'Solicitud inválida']);
            return;
        }

        $fecha = $_POST['fecha'] ?? '';
        $hora = $_POST['hora'] ?? '';
        $servicios = $_POST['servicios'] ?? '';
        $usuarioId = $_SESSION['id'] ?? null;

        if(!$usuarioId || !$fecha || !$hora || !$servicios) {
            http_response_code(400);
            echo json_encode(['resultado' => false, 'mensaje' => 'Datos incompletos']);
            return;
        }

        // Recibir los datos de la cita desde la solicitud POST
        $cita = new \Model\Cita([
            'fecha' => $fecha,
            'hora' => $hora,
            'usuarioId' => $usuarioId
        ]);
        $resultado = $cita->guardar();

        if(empty($resultado['resultado']) || empty($resultado['id'])) {
            http_response_code(500);
            echo json_encode(['resultado' => false, 'mensaje' => 'No se pudo guardar la cita']);
            return;
        }

        // Obtener el ID del cliente recién creado
        $id = $resultado['id'];

        // Devolver el resultado en formato JSON
        $idServicios = array_filter(array_map('intval', explode(',', $servicios)));

        if(empty($idServicios)) {
            http_response_code(400);
            echo json_encode(['resultado' => false, 'mensaje' => 'Servicios inválidos']);
            return;
        }

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

    // Método para obtener las citas del día para el área de administración
    public static function getCitasAdmin() {
        isAuth();

        if (empty($_SESSION['admin'])) {
            http_response_code(403);
            echo json_encode([]);
            return;
        }

        header('Content-Type: application/json; charset=utf-8');

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechaValida = \DateTime::createFromFormat('Y-m-d', $fecha);

        if (!$fechaValida || $fechaValida->format('Y-m-d') !== $fecha) {
            http_response_code(400);
            echo json_encode([]);
            return;
        }

        $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente, ";
        $consulta .= "usuarios.email, usuarios.telefono, servicios.nombre AS servicio, servicios.precio ";
        $consulta .= "FROM citas ";
        $consulta .= "LEFT JOIN usuarios ON citas.usuarioId = usuarios.id ";
        $consulta .= "LEFT JOIN citasservicios ON citasservicios.citaId = citas.id ";
        $consulta .= "LEFT JOIN servicios ON servicios.id = citasservicios.servicioId ";
        $consulta .= "WHERE citas.fecha = '{$fecha}' ";
        $consulta .= "ORDER BY citas.hora ASC";

        $citas = \Model\Cita::consultarSQL($consulta);
        echo json_encode($citas);
    }

// Método para eliminar una cita desde la API
    public static function eliminar() {
        isAuth();

        header('Content-Type: application/json; charset=utf-8');

         if(!validar_csrf($_POST['csrf_token'] ?? null)) {
             http_response_code(403);
             echo json_encode(['resultado' => false, 'mensaje' => 'Solicitud inválida']);
             return;
         }

         $id = $_POST['id'] ?? null;

         if(!$id) {
             http_response_code(400);
             echo json_encode(['resultado' => false, 'mensaje' => 'ID de cita no proporcionado']);
             return;
         }

         $cita = \Model\Cita::find($id);

         if(!$cita) {
             http_response_code(404);
             echo json_encode(['resultado' => false, 'mensaje' => 'Cita no encontrada']);
             return;
         }

         $resultado = $cita->eliminar();

         if(!$resultado) {
             http_response_code(500);
             echo json_encode(['resultado' => false, 'mensaje' => 'No se pudo eliminar la cita']);
             return;
         }

         echo json_encode(['resultado' => true, 'mensaje' => 'Cita eliminada correctamente']);
     }


}    
