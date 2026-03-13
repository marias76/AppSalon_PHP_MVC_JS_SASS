<!--  vista login.php -->
<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión en tu cuenta</p>

<!-- Incluir el archivo de alertas para mostrar mensajes de error o éxito -->
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<!-- Formulario de inicio de sesión -->
<form class="formulario" method="post" action="/">
    <input type="hidden" name="csrf_token" value="<?php echo s(csrf_token()); ?>">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu Email"> 
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu Password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">

    <div class="acciones">
        <a href="/crearCuenta">¿Aún no tienes una cuenta? Crear una</a>
        <a href="/olvide">¿Olvidaste tu password?</a>
    </div>
</form>

<!-- Script para limpiar las alertas cuando el usuario hace clic o enfoca el campo de email -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.querySelector('#email');
        const alertasExito = document.querySelectorAll('.alerta.exito');

        // Ocultar automaticamente mensajes de exito para no saturar la pantalla.
        if (alertasExito.length) {
            setTimeout(function () {
                alertasExito.forEach(function (alerta) {
                    alerta.remove();
                });
            }, 4000);
        }

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