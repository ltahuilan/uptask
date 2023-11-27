/**
 * IIFE (Immediately Invoked Function Expression)
 * Funcion que se autoejecuta tan pronto es definida
 * Todo lo que esta dento de la funcion no puede ser accedido
 * desde fuera.
 */
(function() {

    obtenerTareas();
    let tareas = []; //variable global parta implementar Virtual DOM
    let filtradas = [];
    const estados = {
        '0': 'Pendiente',
        '1': 'Completa'
    };
    
    const btnTarea = document.querySelector('#nueva-tarea');
    btnTarea.addEventListener('click', function () {
        modalFormularioTarea();
    });

    //filtros de búsqueda
    const filtros = document.querySelectorAll('#filtros input[type="radio"');

    filtros.forEach( function (radio) {
        radio.addEventListener('input', filtrarTareas)
    })

    /**
     * Filtra las tareas por su estado
     */
    function filtrarTareas(event) {
        const filtro = event.target.value;

        if(filtro !== '') {
            filtradas = tareas.filter(tarea => tarea.estado === filtro );
            mostrarTareas();
        }else {
            filtradas = [];
        }
        mostrarTareas();
    }


    /**
     * Consume la API que devuelve las tareas desde el servidor
     */
    async function obtenerTareas() {
        try {
            const url = obtenerURLProyecto();
            const endpoint = `/api/tarea?url=${url}`;
            const respuesta = await fetch(endpoint);
            const resultado = await respuesta.json();
            tareas = resultado.tareas;

            mostrarTareas();
            
        } catch (error) {
            console.log(error);
        }
    }


    /**
     * Construye el HTML para mostrar las tareas 
     */
    function mostrarTareas() {
        limpiarHTMLTareas();
        contarCompletas();
        contarPendientes();

        const arrayTareas = filtradas.length ? filtradas : tareas;

        const listaTareas = document.querySelector('#lista-tareas');

        if(arrayTareas.length === 0) {
            const noTareas = document.createElement('LI');
            noTareas.classList.add('no-tareas');
            noTareas.innerHTML = 'No Hay tareas';
            listaTareas.appendChild(noTareas);
            return;
        }

        arrayTareas.forEach(tarea=> {

            //LI
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            //parrafo con el nombre de la tarea
            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.ondblclick = function () {
                modalFormularioTarea(true, {...tarea}); //se pasa una copial del arreglo de tareas
            }

            //contenedor de opciones
            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            //Boton para estado de la tarea
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado]}`.toLowerCase());
            btnEstadoTarea.dataset.tareaEstado = tarea.estado;
            btnEstadoTarea.textContent = `${estados[tarea.estado]}`;
            btnEstadoTarea.onclick = function () {
                //se pasa como parametro una copia del objeto de tarea para no mutar el objeto original
                cambiarEstadoTarea(tarea);
            };

            //Boton para eliminar tarea
            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.eliminarTarea = tarea.id;
            btnEliminarTarea.textContent = 'Eliminar';
            btnEliminarTarea.onclick = function (){
                confirmarEliminarTarea(tarea);
            }

            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);
            listaTareas.appendChild(contenedorTarea);
        });
    }

    function contarCompletas() {
        const contarCompletas = tareas.filter(tarea => tarea.estado === '1'); 
        const completasRadio = document.querySelector('#completas');

        if(contarCompletas.length === 0) {
            completasRadio.disabled = true;
        }else {
            completasRadio.disabled = false;
        }
    }

    function contarPendientes() {
        const contarPendientes = tareas.filter(tarea => tarea.estado === '0');
        const pendientesRadio = document.querySelector('#pendientes');

        if(contarPendientes.length === 0) {
            pendientesRadio.disabled = true;
        }else {
            pendientesRadio.disabled = false;
        }
    }

    /**
     * Construye el HTML para mostrar una ventana modal
     * para agregar o editar una tarea
     */
    function modalFormularioTarea(editar = false, tarea = {}) {

        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        <form class="formulario" method="POST" action="/api/tarea">
            <legend>${editar ? 'Editar Tarea' : 'Agregar Tarea'}</legend>
            <div class="campo">
                <label for="tarea">Nombre Tarea</label>
                <input 
                    type="text"
                    name="tarea"
                    id="tarea"
                    placeholder="${editar ? 'Editar nombre de la tarea' : 'Agrega una nueva tarea'}"
                    value="${editar ? tarea.nombre : ''}"
                />
            </div>
            <div class="opciones">
                <input
                    type="submit"
                    class="btn-crear-tarea"
                    value="${editar ? 'Guardar Cambios' : 'Crear tarea'}"
                />
                <button type="button" class="btn-cerrar-modal">Cerrar</button>
            </div>
        </form>
        `;        

        /**
         * es posible crear el selector 'formulario' debido a que para cuando
         * javascript ejecuta el setTimeout, ya existe el HTML
         * Orden de ejecusion:
         * 1.- Pila (stack). llamadas a funcion
         * 2.- Monticulo (heap). Objetos
         * 3.- Queue. Mensajes, setTimeout genera un mensaje en espera
         * https://developer.mozilla.org/es/docs/Web/JavaScript/EventLoop
         */
        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 250);        
        
        /**
         * Cerra el modal con Event Delegation de javascript ya que en este punto no existe el elemento
         * Se utilizado cuando se genera HTML con innerHTML
         */
        modal.addEventListener('click', function (event) {
            event.preventDefault();
            if(event.target.classList.contains('btn-cerrar-modal')) {
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 350);
            }
            
            if (event.target.classList.contains('btn-crear-tarea')) {
                const nombreTarea = document.querySelector('#tarea').value.trim();
                const inputName = document.querySelector('#tarea').name;
        
                if(nombreTarea === '') {
                    //mostrar alerta
                    mostrarAlerta(
                        'error', `El campo ${inputName} no puede estar vacío`, 
                        document.querySelector('.formulario legend')
                    );
                    return;
                }

                if(editar) {
                    //asignar el nombre editado al tarea.nombre
                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea);
                    
                }else {
                    agregarTarea(nombreTarea);
                }
        
            }
        });

        document.querySelector('.dashboard').appendChild(modal);
    }
    
    /**
     * Construye el HTML para mostrar un mensaje con parametros dinamicos
     */
    function mostrarAlerta(tipo, mensaje, referencia) {
        const existeAlerta = document.querySelector('.alerta');
        if(existeAlerta) {
            existeAlerta.remove();
        }

        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;
        //agrega el elemento después de la referencia haciendo traversing del DOM
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

        setTimeout( ()=> {
            alerta.remove();
        }, 4000);

    }


    /**
     * envía los datos del formulario por medio de fetch API
     */
    async function agregarTarea(tarea) {
        
        //contruir la peticion al servicior
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('url', obtenerURLProyecto());

        try {
            //enviar peticion hacia el servidor
            const url = `${location.origin}/api/tarea`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            //obtener respuesta del servidor
            const resultado = await respuesta.json();

            //leer las alertas enviadas desde el servidor
            // mostrarAlerta(
            //     resultado.tipo,
            //     resultado.mensaje,
            //     document.querySelector('.formulario legend')
            //     );

            if(resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');

                /**
                 * Implementar virtual DOM
                 * Actualizar las tareas sin recargar página
                 */
                const tareasObj = {
                    'id': String(resultado.id),
                    'nombre': tarea,
                    'estado': '0',
                    'proyectoId': resultado.proyectoId
                };

                //agreagra tarea nueva la objeto actual y mostrar en pantalla
                tareas = [...tareas, tareasObj];
                mostrarTareas();

                modal.remove();
                
                Swal.fire(
                    resultado.mensaje,
                    '',
                    'success'
                );
                // setTimeout(() => {

                // }, 3500);
            };

        }catch (error) {
            console.log(error);
        };
    }


    /**
     * Cambia el estado de la tarea en el evento click
     */
    function cambiarEstadoTarea(tarea) {

        nuevoEstado = tarea.estado === '1' ? '0' : '1';
        tarea.estado = nuevoEstado;
        actualizarTarea(tarea);
    }

    /**
     * Actualiza el estado de la tarea en la BD
     */
    async function actualizarTarea(tarea) {

        //construir peticion
        const { id, nombre, estado, proyectoId} = tarea;
        datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        //url del proyecto para verificar que existe (codigo en backend)
        datos.append('proyectoId', obtenerURLProyecto());
        
        //iterar sobre el objeto
        // for(let valor of datos.values()) {
        //     console.log(valor);
        // }

        try {
            url = `${location.origin}/api/tarea/actualizar`;
            respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            resultado = await respuesta.json();
            if(resultado.tipo === 'exito') {
                //remover modal
                const modal = document.querySelector('.modal');
                if(modal) {
                    modal.remove();
                }

                //mostrar alerta
                Swal.fire(
                    resultado.mensaje,
                    '',
                    'success'
                    );
                      
                //Implementar Virtual DOM
                //.map itera sobre un nuevo arreglo
                tareas = tareas.map( tareaEnMemoria => {                    
                    if(tareaEnMemoria.id === tarea.id) {
                        tareaEnMemoria.estado = estado;
                        tareaEnMemoria.nombre = nombre;
                    }
                    return tareaEnMemoria;
                })
                mostrarTareas();
            }

        } catch (error) {
            console.log(error);
        }
    }


    function confirmarEliminarTarea(tarea) {

        Swal.fire({
            title: 'Eliminar tarea?',
            text: "Este cambio no puede revertirse!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarTarea(tarea);
            }
        })
    }


    /**
     * Eliminar tarea en el backend
     */
    async function eliminarTarea(tarea) {
        const { id, nombre, estado, proyectoId } = tarea;
        //construir el FormData
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerURLProyecto());

        try {
            const url = `${location.origin}/api/tarea/eliminar`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            if(resultado.tipo === 'exito') {
                Swal.fire(
                    resultado.mensaje,
                    '',
                    'success'
                );

                /**
                 * Virtual DOM
                 * .filter() retrona los valores de una array filtrados de acuerdo a ciertos criterios
                 */
                tareas = tareas.filter( tareaEnMemoria => tareaEnMemoria.id !== tarea.id );
                mostrarTareas();
            }

        } catch(error) {
            console.log(error);
        }
    }

    /**
     * Leer datos del query string
     */
    function obtenerURLProyecto() {        
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams);
        return proyecto.url;
    }


    function limpiarHTMLTareas() {
        const listaTareas = document.querySelector('#lista-tareas');
        listaTareas.innerHTML = '';
    }

})();