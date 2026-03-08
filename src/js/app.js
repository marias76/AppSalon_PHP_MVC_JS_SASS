// Variables globales
let paso= 1;
let pasoInicial = 1;
let pasoFinal = 3;

// Función para iniciar la app
document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});
// Función para iniciar la app
function iniciarApp() {
    pasoFinal = Math.max(1, document.querySelectorAll('.tabs button').length);
    mostrarSeccion(); // Muestra la sección correspondiente al paso actual
    tabs(); // Función para manejar las pestañas   
    botonesPaginador(); // Función para manejar los botones del paginador 
    paginaSiguiente(); // Función para manejar el botón siguiente
    paginaAnterior(); // Función para manejar el botón anterior
}

// Función para mostrar la sección correspondiente al paso actual
function mostrarSeccion() {    
    // Ocultar todas las secciones
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }

    // seleccionar la sección con el paso actual
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    // quitar la clase de actual al botón anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    // resaltar el botón actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');    
}
// Función para manejar las pestañas
function tabs() {   
    // Seleccionar los botones de las pestañas
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton => {
        boton.addEventListener('click', function(e) {
            paso = Number(e.target.dataset.paso);
            botonesPaginador();
        });
    });
}
// función para manejar los botones del paginador
function botonesPaginador() {
    const botonAnterior = document.querySelector('#anterior');
    const botonSiguiente = document.querySelector('#siguiente');

    if (!botonAnterior || !botonSiguiente) {
        return;
    }
    // Calcular el paso final basado en el número de pestañas
    pasoFinal = Math.max(1, document.querySelectorAll('.tabs button').length);
    botonAnterior.classList.toggle('ocultar', paso <= 1);
    botonSiguiente.classList.toggle('ocultar', paso >= pasoFinal);

    mostrarSeccion();
}

// Función para manejar el botón siguiente
function paginaSiguiente() {
    const botonSiguiente = document.querySelector('#siguiente');
    if (!botonSiguiente) {
        return;
    }

    botonSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) {
            return;
        }

        paso++;
        botonesPaginador();
    });
}
// Función para manejar el botón anterior
function paginaAnterior() {
    const botonAnterior = document.querySelector('#anterior');
    if (!botonAnterior) {
        return;
    }

    botonAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) {
            return;
        }

        paso--;
        botonesPaginador();
    });
}
