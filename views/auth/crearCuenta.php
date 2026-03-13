 <!-- Vista para crear una cuenta de usuario -->
<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Crea tu cuenta en AppSalon</p>

<!-- Incluir el archivo de alertas para mostrar mensajes de error o éxito -->
<?php include __DIR__ . '/../templates/alertas.php'; ?>

<?php
$nombre = isset($usuario) && is_object($usuario) ? $usuario->nombre : '';
$apellido = isset($usuario) && is_object($usuario) ? $usuario->apellido : '';
$telefono = isset($usuario) && is_object($usuario) ? $usuario->telefono : '';
$email = isset($usuario) && is_object($usuario) ? $usuario->email : '';
?>

<!-- Formulario de creación de cuenta -->
<form class="formulario" method="post" action="/crearCuenta">
    <input type="hidden" name="csrf_token" value="<?php echo s(csrf_token()); ?>">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu Nombre" value="<?php echo s($nombre); ?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellidos</label>
        <input type="text" id="apellido" name="apellido" placeholder="Tus Apellidos" value="<?php echo s($apellido); ?>">
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" placeholder="Tu Teléfono" value="<?php echo s($telefono); ?>">
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu Email" value="<?php echo s($email); ?>">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Tu Contraseña">
    </div>
    <!-- <div class="campo">
        <label for="password2">Repetir Contraseña</label>
        <input type="password" id="password2" name="password2" placeholder="Repite tu Contraseña">
    </div> -->
    <input type="submit" class="boton" value="Crear Cuenta">

</form>

<!-- Acciones -->
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>

<script>
    const inputsFormulario = document.querySelectorAll('.formulario input');

    inputsFormulario.forEach(function (input) {
        input.addEventListener('click', function () {
            document.querySelectorAll('.alerta').forEach(function (alerta) {
                alerta.remove();
            });
        });
    });
</script>