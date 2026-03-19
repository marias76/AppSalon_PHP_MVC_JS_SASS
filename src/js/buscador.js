// Buscador de eventos por fecha
document.addEventListener('DOMContentLoaded', function() {  
    iniciarApp();
});

const toastAdmin = typeof Swal !== 'undefined'
    ? Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2200,
        timerProgressBar: true
    })
    : null;

function iniciarApp() {
   buscarPorFecha();
   eliminarCita();
}   
function buscarPorFecha() {
    const fechaInput = document.querySelector('#fecha');
    if (!fechaInput) {
        return;
    }

    fechaInput.addEventListener('input', function(event) {
        const fechaSeleccionada = event.target.value;

        window.location = `?fecha=${fechaSeleccionada}`;
        
    });
}

function eliminarCita() {
    const formulariosEliminar = document.querySelectorAll('.js-eliminar-cita');

    if (!formulariosEliminar.length) {
        return;
    }

    formulariosEliminar.forEach(formulario => {
        formulario.addEventListener('submit', async function(evento) {
            evento.preventDefault();

            const confirmado = await confirmarEliminacion();

            if (!confirmado.isConfirmed) {
                return;
            }

            const datos = new FormData(formulario);

            try {
                const respuesta = await fetch(formulario.action, {
                    method: 'POST',
                    body: datos,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const resultado = await respuesta.json();

                if (!respuesta.ok || !resultado.resultado) {
                    throw new Error(resultado.mensaje || 'No se pudo eliminar la cita');
                }

                const cita = formulario.closest('li');
                cita?.remove();

                actualizarEstadoCitas();

                await mostrarToastExito(resultado.mensaje || 'La cita se eliminó correctamente.');
            } catch (error) {
                mostrarError(error.message || 'Ocurrió un error al intentar eliminar la cita.');
            }
        });
    });
}

function confirmarEliminacion() {
    return Swal.fire({
        title: '¿Eliminar cita?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#cb0000',
        cancelButtonColor: '#0da6f3',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });
}

function mostrarToastExito(mensaje) {
    if (!toastAdmin) {
        return Promise.resolve();
    }

    return toastAdmin.fire({
        icon: 'success',
        title: mensaje
    });
}

function mostrarError(mensaje) {
    return Swal.fire({
        title: 'No se pudo eliminar la cita',
        text: mensaje,
        icon: 'error',
        confirmButtonColor: '#cb0000'
    });
}

function actualizarEstadoCitas() {
    const listadoCitas = document.querySelector('.citas');
    const totalCitas = document.querySelector('.js-total-citas');
    const citasRestantes = document.querySelectorAll('.citas li').length;

    if (totalCitas) {
        totalCitas.textContent = `Total: ${citasRestantes} cita${citasRestantes !== 1 ? 's' : ''}`;
    }

    if (!listadoCitas || citasRestantes > 0) {
        return;
    }

    listadoCitas.remove();
    totalCitas?.remove();

    const contenedor = document.querySelector('#citas-admin');
    const fechaInput = document.querySelector('#fecha');
    const fechaSeleccionada = fechaInput?.value;
    const esHoy = fechaSeleccionada === new Date().toISOString().split('T')[0];

    const mensaje = document.createElement('P');
    mensaje.classList.add('alerta');
    mensaje.textContent = `No hay citas para ${esHoy ? 'hoy' : 'la fecha seleccionada'}.`;

    contenedor?.appendChild(mensaje);
}


