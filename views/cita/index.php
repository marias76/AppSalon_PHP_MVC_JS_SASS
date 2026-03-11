<!-- Vista para crear una nueva cita -->
<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y completa la información para tu cita</p>

<!-- Incluir el formulario de citas -->
<div class="app">
     <!-- Navegación para los pasos del formulario -->
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <!-- Contenedor para los diferentes pasos del formulario -->
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <div id="servicios" class="listado-servicios"></div>
        <p class="text-center">Elige tus servicios a continuación</p>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca Tús Datos y Fecha de túCita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu Nombre" value="<?php echo $nombre; ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div>
        </form>
    </div>    
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen y Confirmación</h2>
        <p class="text-center">Verifica que la Información sea correcta antes de confirmar tu cita</p>
    </div>    

    <div class="paginacion">
        <button class="boton" type="button" id="anterior">&laquo; Anterior</button>
        <button class="boton" type="button" id="siguiente">Siguiente &raquo;</button>
    </div>
</div>

<?php 
// Incluir el script de la aplicación para manejar la lógica del formulario
    $rutaScript = __DIR__ . '/../../public/build/js/app.js';
    $versionScript = file_exists($rutaScript) ? filemtime($rutaScript) : time();
    $script = "
        <script src='/build/js/app.js?v={$versionScript}'></script>
    ";
?>