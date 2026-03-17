<div class="barra">
    <?php $nombreBarra = $nombre ?? $_SESSION['nombre'] ?? ''; ?>
    <p>Hola: <?php echo s($nombreBarra); ?></p>
    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>