// Variables globales
let paso= 1;
let pasoInicial = 1;
let pasoFinal = 3;

// Objeto para almacenar la información de la cita
const cita = {  
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
};

// Esperar a que el DOM esté completamente cargado antes de ejecutar la función iniciarApp
document.addEventListener('DOMContentLoaded', function() {
    // console.log('[AppSalon] DOM cargado');
    try {
        iniciarApp();
    } catch (error) {
        // console.error('[AppSalon] Error al iniciar la app:', error);
    }
});
// Función para iniciar la app
function iniciarApp() {
    const totalTabs = document.querySelectorAll('.tabs button').length;
    if (!totalTabs) {
        // console.warn('[AppSalon] No se encontraron tabs para iniciar la app');
        return;
    }

    pasoFinal = Math.max(1, document.querySelectorAll('.tabs button').length);
    mostrarSeccion(); // Muestra la sección correspondiente al paso actual
    tabs(); // Función para manejar las pestañas   
    botonesPaginador(); // Función para manejar los botones del paginador 
    paginaSiguiente(); // Función para manejar el botón siguiente
    paginaAnterior(); // Función para manejar el botón anterior
    consultarAPI(); // Función para consultar la API de PHP
    idCliente(); // Función para obtener el ID del cliente
    nombreCliente(); // Función para obtener el nombre del cliente
    seleccionarFecha(); // Función para obtener la fecha de la cita
    seleccionarHora(); // Función para obtener la hora de la cita
    mostrarResumen(); // Función para mostrar el resumen de la cita
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

            if(paso === 3){
                mostrarResumen();   
            }
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
    mostrarResumen();   
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

// Función para consultar la API de PHP
async function consultarAPI() {
    try {
        const url = '/api/servicios';
        // console.log('[AppSalon] Consultando API:', url);
        const resultado = await fetch(url, {
            method: 'GET',
            cache: 'no-store',
            headers: {
                'Accept': 'application/json'
            }
        });

        // console.log('[AppSalon] Respuesta API:', resultado.status, resultado.statusText);

        if (!resultado.ok) {
            throw new Error(`Error HTTP ${resultado.status}: ${resultado.statusText}`);
        }

        const servicios = await resultado.json();
        // console.log('Servicios cargados:', servicios);
        mostrarServicios(servicios);
    } catch (error) {
        // console.error('No se pudieron cargar los servicios:', error);
    }
}   
// Función para mostrar los servicios en el DOM
function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio);
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        // Agregar el servicio al contenedor de servicios en el DOM (vista)
        document.querySelector('#servicios').appendChild(servicioDiv);
    });

}
// Función para seleccionar un servicio y agregarlo a la cita
function seleccionarServicio(servicio) {
    const { id } = servicio;    
    const {servicios} = cita;

    // Seleccionar el div del servicio que se hizo clic
    const divServicio = document.querySelector(`[data-id-servicio="${servicio.id}"]`);

    // comprobar si el servicio ya está seleccionado
    if(servicios.some( agregado => agregado.id === id)){
        // eliminar el servicio del arreglo de servicios
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
        return;
    }else{
        // agregar el servicio al arreglo de servicios
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }

    // console.log(cita);
}

// Función para obtener el nombre del cliente
function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
}
// Función para obtener el ID del cliente
function idCliente() {
    cita.id = document.querySelector('#id').value;
}

// Función para obtener la fecha de la cita
function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        const dia = new Date(e.target.value).getUTCDay();
        if([0].includes(dia)){
            e.target.value = '';
            mostrarAlerta('No atendemos los Domingos','error', '.formulario' );
        }else{
            cita.fecha = e.target.value;
        }
    }); 
    mostrarResumen();   
};  

// Función para obtener la hora de la cita
function seleccionarHora(){
    const inputHora = document.querySelector('#hora');  
    inputHora.addEventListener('input', function(e){
        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];
        if(hora < 10 || hora > 18){
            e.target.value = '';
            mostrarAlerta('Selecciona una hora entre las 10:00 y las 18:00','error', '.formulario' );
        }else{
            cita.hora = e.target.value;
        }
    });
}

// funcion alerta para mostrar mensajes al usuario
function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    
    // eliminar alerta previa
    const alertaExistente = document.querySelector('.alerta');
    if(alertaExistente){
        alertaExistente.remove();
    }   

    // crear alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    // agregar alerta al DOM
    const referencia = document.querySelector(elemento);
    if(!referencia){
        return;
    }

    // Agregar la alerta al DOM
    referencia.appendChild(alerta);

    // Eliminar la alerta después de 3 segundos
    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

// Función para mostrar el resumen de la cita
function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // limpiar resumen previo
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }   

    // validar que todos los campos estén completos
    if(Object.values(cita).includes('') || cita.servicios.length === 0){
        mostrarAlerta('Faltan datos de la cita, asegúrate de completar nombre, fecha, hora y seleccionar al menos un servicio','error', '.contenido-resumen', false);
         return;
    }

    // formatear el resumen de la cita
    const {nombre, fecha, hora, servicios} = cita;

    // Crear los elementos para mostrar el resumen de la cita
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);
    
    // Iterar sobre los servicios seleccionados y agregarlos al resumen
    servicios.forEach(servicio => {
        const {id, precio, nombre} = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;


        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
       resumen.appendChild(contenedorServicio);

    });

    // Crear los elementos para mostrar el resumen de la cita
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);
    
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;
    const fechaCliente = document.createElement('P');

    // Formatear la fecha a un formato más legible
    const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = new Date(fecha).toLocaleDateString('es-ES', opcionesFecha);

    fechaCliente.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;
    const horaCliente = document.createElement('P');
    horaCliente.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    // boton para confirmar la cita
    const botonConfirmar = document.createElement('BUTTON');
    botonConfirmar.classList.add('boton');
    botonConfirmar.textContent = 'Confirmar Cita';
    botonConfirmar.onclick = reservarCita;

    // Agregar los detalles del cliente al resumen
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCliente);
    resumen.appendChild(horaCliente);
    resumen.appendChild(botonConfirmar);
}   

// Función para reservar la cita
async function reservarCita()  {

    const {nombre, fecha, hora, servicios, id} = cita;
    const idServicios = servicios.map(servicio => servicio.id);
    
    const datos = new FormData();
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    try {
        // petición a la API para guardar la cita
            const url = 'http://appsalon_php_mvc_js_sass.local/api/citas';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos,
                
            });
            const resultado = await respuesta.json();
            // console.log(resultado.resultado);
            if(resultado.resultado){
                Swal.fire(
                    'Cita Agendada',
                    'Tu cita se ha agendado correctamente',
                    'success'
                ).then(() => {
                    window.location.reload();
                });
            } 

    } catch (error) {
        // console.error('Error al reservar la cita:', error);
        Swal.fire({
                icon: "error",
                title: "Error.....",
                text: "Hubo un error al reservar tu cita. Por favor, intenta nuevamente.",                
                });
    }
};

