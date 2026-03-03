<h1 class="nombre-pagina">Olvidé mi contraseña</h1>
<p class="descripcion-pagina">Ingresa tu correo electrónico para recibir instrucciones de recuperación</p>

<form  class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" placeholder="Tu correo electrónico">
    </div>
    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crearCuenta">¿Aún no tienes una cuenta? Crear Cuenta</a>  
</div>
