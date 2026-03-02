<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="build/css/app.css">
</head>

<body>
    <!-- Aquí se va a cargar un contenido dinámico,
    dependiendo de la página que se visite, por ejemplo, si se visita la página de login,
    se va a cargar el contenido de la vista de login, si se visita la página de crear cuenta,
    se va a cargar el contenido de la vista de crear cuenta, etc. -->
    <div class="contenedor-app">
        <div class="imagen"></div>
        <div class="app">
            <?php echo $contenido; ?>
        </div>
    </div>
</body>

</html>