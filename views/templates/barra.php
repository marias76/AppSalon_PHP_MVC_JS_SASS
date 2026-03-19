<div class="barra">
    <?php $nombreBarra = $nombre ?? $_SESSION['nombre'] ?? ''; ?>
    <p>Hola: <?php echo s($nombreBarra); ?></p>
    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin']) && $_SESSION['admin']) { ?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver citas</a>
        <a class="boton" href="/servicios">Ver servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo servicio</a>
    </div>

<?php }?>

