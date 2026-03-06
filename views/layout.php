<!-- Este es el layout principal de la aplicación, es decir, 
 la estructura HTML que se va a cargar en todas las páginas de la aplicación, y dentro de esta estructura se va a cargar el contenido dinámico de cada página, 
 dependiendo de la página que se visite. -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
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

    <!-- Cargar el script de la aplicación, este script se va a cargar en todas las páginas de la aplicación, pero solo se va a ejecutar en la página de crear cita, ya que es el único lugar donde se necesita. -->
    <?php 
        echo $script ?? '';
    ?>
</body>

</html>