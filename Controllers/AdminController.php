<?php
// Controlador para el área de administración
namespace Controllers;
use Model\Cita;
use MVC\Router;

class AdminController {
    // Renderiza la vista del panel de administración
    public static function index(Router $router) {
        isAuth();

        if (empty($_SESSION['admin'])) {
            header('Location: /cita');
            exit;
        }

        $fecha = $_GET['fecha'] ?? '';

        $consulta = "SELECT citas.id, citas.fecha, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente, ";
        $consulta .= "usuarios.email, usuarios.telefono, servicios.nombre AS servicio, servicios.precio ";
        $consulta .= "FROM citas ";
        $consulta .= "LEFT JOIN usuarios ON citas.usuarioId = usuarios.id ";
        $consulta .= "LEFT JOIN citasservicios ON citasservicios.citaId = citas.id ";
        $consulta .= "LEFT JOIN servicios ON servicios.id = citasservicios.servicioId ";
        if (!empty($fecha)) {
            $consulta .= "WHERE citas.fecha = '{$fecha}' ";
        }
        $consulta .= "ORDER BY citas.fecha ASC, citas.hora ASC";

        $citas = Cita::consultarSQL($consulta);

        // El JOIN con servicios devuelve una fila por servicio, por eso contamos IDs de cita únicos.
        $citasUnicas = [];
        foreach ($citas as $cita) {
            $citasUnicas[$cita->id] = true;
        }
        $totalCitas = count($citasUnicas);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'fecha' => $fecha,
            'citas' => $citas,
            'totalCitas' => $totalCitas
        ]);
    }
}   