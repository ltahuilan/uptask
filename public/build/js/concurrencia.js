(function(){
    /**
     * es posible crear el selector 'formulario' debido a que para cuando
     * javascript ejecuta el setTimeout, ya existe el HTML
     * Orden de ejecusion:
     * 1.- Pila (stack). llamadas a funcion
     * 2.- Monticulo (heap). Objetos
     * 3.- Queue. Mensajes, setTimeout genera un mensaje en espera
     * 
     * https://developer.mozilla.org/es/docs/Web/JavaScript/EventLoop
     */

    console.log('Primero -- (pila o stack)');

    function unaFuncion(){
        console.log('Desde la función -- (pila o stack)');
    }
    unaFuncion();

    setTimeout(() => {
        console.log('queue 1 -- se libera el queue y pasa a pila o stack');
    }, 0);

    console.log('Segundo -- (pila o stack)');
    
    setTimeout(() => {
        console.log('queue 2 -- se libera el queue y pasa a pila o stack');
    }, 0);
    
    console.log('Tercero -- (pila o stack)');

    //Resultado...

    // Primero 
    // Desde la función
    // Segundo
    // Tercero
    // queue 1  
    // queue 2
})();