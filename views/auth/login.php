<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión en tu cuenta</p>

<!-- Incluir el archivo de alertas para mostrar mensajes de error o éxito -->
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<!-- Formulario de inicio de sesión -->
<form class="formulario" method="post" action="/">

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