<!-- // views/admin/index.php -->
<h1 class="nombre-pagina">Panel de Administración</h1>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h2>Citas</h2>
<!-- // Barra de búsqueda para filtrar citas por fecha -->
<div class="busqueda">
    <form class="formulario" method="get" action="/admin">
        <div class="campo">
            <label for="fecha">Filtrar por Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo s($fecha ?? ''); ?>">
        </div>
          
        <div class="formulario-acciones">
            <!-- <button type="submit" class="boton">Buscar</button> -->
            <?php if (isset($fecha) && $fecha !== date('Y-m-d')) { ?>
            <a href="/admin" class="boton">Hoy</a>            
            <?php } ?>
        </div>
            
    </form>
</div>

<!-- // Si se ha seleccionado una fecha, mostrar un mensaje indicando la fecha seleccionada -->
<div id="citas-admin">
    <!-- Si no hay citas, mostrar un mensaje -->
    <?php if (empty($citas)) { ?>
    <p class="alerta">No hay citas para <?php echo s($fecha) === date('Y-m-d') ? 'hoy' : 'la fecha seleccionada'; ?>.</p>
    <?php } else { ?>
    <p class="subtitulo js-total-citas">Total: <?php echo s($totalCitas); ?> cita<?php echo $totalCitas !== 1 ? 's' : ''; ?></p>
    <!--  Listado de citas -->
    <ul class="citas">
        <?php 
                $idCita = 0; // Variable para rastrear el ID de la cita actual
                foreach ($citas as $key => $cita) { 
                    // debuguear($key);
                    if($cita->id !== $idCita){
                        $total = 0; // Variable para acumular el total de servicios de la cita actual
                ?>
        <li>
            <p>ID: <span><?php echo s($cita->id); ?></span></p>
            <p>Fecha: <span><?php echo s($cita->fecha); ?></span></p>
            <p>Hora: <span><?php echo s($cita->hora); ?></span></p>
            <p>Cliente: <span><?php echo s($cita->cliente); ?></span></p>
            <p>Email: <span><?php echo s($cita->email); ?></span></p>
            <p>Teléfono: <span><?php echo s($cita->telefono); ?></span></p>

            <h3>Servicios</h3>

            <?php $idCita = $cita->id; // Actualizar el ID de la cita actual 
                } // fin if para evitar repetir la información de la cita en caso de que tenga varios servicios
                    $total += $cita->precio; // Acumular el precio del servicio actual al total de la cita
                    ?>
            <p class="servicio">Servicio: <span><?php echo s($cita->servicio). " " . s($cita->precio); ?></span></p>
            <?php
                        $actual = $cita->id; // Variable para rastrear el ID de la cita actual
                        $proximo = $citas[$key + 1]->id ?? 0; // ID de la próxima cita o 0 si no hay más citas

                        if(esUltimo($actual, $proximo)){
                            $total = number_format($total, 2); // Formatear el total a 2 decimales

                            ?>
                            <form action="/api/eliminar" method="post" class="js-eliminar-cita">
                                <input type="hidden" name="id" value="<?php echo s($cita->id); ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo s($_SESSION['csrf_token']); ?>">
                                <button type="submit" class="boton boton-eliminar">Eliminar</button>
                            </form>
            <p class="total">Total: <span><?php echo s($total); ?></span></p>
        </li>
        <?php } ?>
        <?php } ?>
        <!-- fin foreach para mostrar cada servicio de la cita -->
    </ul>
    <?php } ?>
</div>

<!-- // Incluir el script para el buscador de citas por fecha -->
<?php
    $rutaScript = __DIR__ . '/../../public/build/js/buscador.js';
    $versionScript = file_exists($rutaScript) ? filemtime($rutaScript) : time();
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='/build/js/buscador.js?v={$versionScript}'></script>
    ";
?>

