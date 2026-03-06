<?php
// En este archivo se va a registrar las rutas de la aplicación, 
// es decir, que URL va a ejecutar que función, y también se va a encargar de cargar las vistas, 
// es decir, el HTML que se muestra al usuario
namespace MVC;

// El Router se encarga de registrar las rutas de la aplicación, es decir, que URL va a ejecutar que función, y también se va a encargar de cargar las vistas, es decir, el HTML que se muestra al usuario
class Router
{
    // Arreglo de rutas, cada ruta es un arreglo asociativo donde la clave es la URL y el valor es la función que se va a ejecutar cuando el usuario acceda a esa URL
    public array $getRoutes = [];
    public array $postRoutes = [];

    // El método get se encarga de registrar las rutas que se van a ejecutar cuando el usuario acceda a una URL con el método GET, es decir, cuando el usuario acceda a una URL desde el navegador, o cuando haga clic en un enlace
    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }
// El método post se encarga de registrar las rutas que se van a ejecutar cuando el usuario acceda a una URL con el método POST, es decir, cuando el usuario envíe un formulario
    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }
// El método comprobarRutas se encarga de comprobar si la URL a la que el usuario está accediendo está registrada en el arreglo de rutas, y si es así, ejecutar la función correspondiente, si no, mostrar un mensaje de error
    public function comprobarRutas()
    {        
        // Proteger Rutas...
        session_start();

        // Arreglo de rutas protegidas...     
        $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        $currentUrl = $_SERVER['PATH_INFO'] ?? $requestUri;
        $currentUrl = rtrim($currentUrl, '/') ?: '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if ( $fn ) {
            // Call user fn va a llamar una función cuando no sabemos cual sera
            call_user_func($fn, $this); // This es para pasar argumentos
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }
// El método render se encarga de cargar la vista correspondiente a la URL a la que el usuario está accediendo, y también de pasarle los datos necesarios para mostrar la información al usuario
    public function render($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer
        include_once __DIR__ . '/views/layout.php';
    }
}
