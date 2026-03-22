<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina">Creación de Servicios</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<!-- Formulario para crear un nuevo servicio -->
<form action="/views/servicios/crear.php" method="post" class="formulario">

    <?php include_once __DIR__ . '/formulario.php'; ?>

    <input type="submit" class="boton" value="Crear Servicio">
</form>

