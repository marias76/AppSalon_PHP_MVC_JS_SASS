<!-- Vista Recuperar Contraseña -->
<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Ingresa tu nueva contraseña</p>

<!-- Incluir el archivo de alertas para mostrar mensajes de error o éxito -->
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<!-- Si hay un error, no mostrar el formulario para ingresar la nueva contraseña -->
<?php if($error) return; ?>

<!-- Formulario para ingresar la nueva contraseña -->
<form class="formulario" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo s(csrf_token()); ?>">
    <div class="campo">
        <label for="password">Nueva Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Tu nueva contraseña">
    </div>
    <input type="submit" class="boton" value="Guardar Nueva Contraseña">
</form>

<!-- Enlaces para volver a iniciar sesión o crear una cuenta -->
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
    <a href="/crearCuenta">¿Aún no tienes una cuenta? Crear Cuenta</a>
</div>

