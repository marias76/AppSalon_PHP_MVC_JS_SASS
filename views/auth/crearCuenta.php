<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Crea tu cuenta en AppSalon</p>

<form class="formulario" method="post" action="/crearCuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu Nombre">
    </div>
    <div class="campo">
        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" placeholder="Tus Apellidos">
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" placeholder="Tu Teléfono">
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu Email">
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

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>