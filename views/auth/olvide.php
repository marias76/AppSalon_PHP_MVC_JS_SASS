 <!-- Vista para la página de "Olvidé mi contraseña" -->
<h1 class="nombre-pagina">Olvidé mi contraseña</h1>
<p class="descripcion-pagina">Ingresa tu correo electrónico para recibir instrucciones de recuperación</p>

<!-- Incluir el archivo de alertas para mostrar mensajes de error o éxito -->
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<!-- Formulario para recuperar contraseña -->
<form  class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" placeholder="Tu correo electrónico" value="<?php echo s($email ?? ''); ?>">
    </div>
    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>

 <!-- Enlaces para volver a iniciar sesión o crear una cuenta -->
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crearCuenta">¿Aún no tienes una cuenta? Crear Cuenta</a>  
</div>

<!-- Script para limpiar alertas al hacer clic o enfocar el campo de correo electrónico -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.querySelector('#email');

        if (!emailInput) {
            return;
        }

        const limpiarAlertas = function () {
            const alertas = document.querySelectorAll('.alerta');
            alertas.forEach(function (alerta) {
                alerta.remove();
            });
        };

        emailInput.addEventListener('click', limpiarAlertas);
        emailInput.addEventListener('focus', limpiarAlertas);
    });
</script>
