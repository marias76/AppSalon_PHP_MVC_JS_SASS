<?php
// Controlador para el área de administración
namespace Controllers;
use Model\Cita;
use MVC\Router;

class AdminController {
    // Renderiza la vista del panel de administración
    public static function index(Router $router) {
        isAuth();
        isAdmin();  

        if (empty($_SESSION['admin'])) {
            header('Location: /cita');
            exit;
        }

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $citaId = isset($_GET['cita']) ? (int) $_GET['cita'] : 0;
        $fechas = explode('-', $fecha);

        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('Location: /404');
            exit;
        }

        // Validar formato de fecha para evitar inyección SQL
         if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
             $fecha = date('Y-m-d');
         }

        $consulta = "SELECT citas.id, citas.fecha, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente, ";
        $consulta .= "usuarios.email, usuarios.telefono, servicios.nombre AS servicio, servicios.precio ";
        $consulta .= "FROM citas ";
        $consulta .= "LEFT JOIN usuarios ON citas.usuarioId = usuarios.id ";
        $consulta .= "LEFT JOIN citasservicios ON citasservicios.citaId = citas.id ";
        $consulta .= "LEFT JOIN servicios ON servicios.id = citasservicios.servicioId ";
        if ($citaId > 0) {
            $consulta .= "WHERE citas.id = {$citaId} ";
        } elseif (!empty($fecha)) {
            $consulta .= "WHERE citas.fecha = '{$fecha}' ";
        }
        $consulta .= "ORDER BY citas.fecha ASC, citas.hora ASC";

        $citas = Cita::consultarSQL($consulta);

        $consultaCitasDisponibles = "SELECT id, fecha, hora FROM citas ORDER BY fecha DESC, hora DESC";
        $citasDisponibles = Cita::consultarSQL($consultaCitasDisponibles);

        // El JOIN con servicios devuelve una fila por servicio, por eso contamos IDs de cita únicos.
        $citasUnicas = [];
        foreach ($citas as $cita) {
            $citasUnicas[$cita->id] = true;
        }
        $totalCitas = count($citasUnicas);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'fecha' => $fecha,
            'citaId' => $citaId,
            'citas' => $citas,
            'citasDisponibles' => $citasDisponibles,
            'totalCitas' => $totalCitas
        ]);
    }
}   