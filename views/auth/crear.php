<div class="contenedor crear">
    <!-- template -->
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php';?> 

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta</p>
        <form method="POST" action="/crear" class="formulario" novalidate>
        <!-- template -->
        <?php include_once __DIR__ . '/../templates/alertas.php'?>

            <div class="campo">
                <label for="nombre">Tu nombre:</label>
                <input 
                    type="text" 
                    for="nombre" 
                    name="nombre" 
                    placeholder="Escribe tu nombre"
                    value="<?php echo $usuario->nombre; ?>"
                    >
            </div>

            <div class="campo">
                <label for="apellido">Tu apellido:</label>
                <input 
                    type="text" 
                    for="apellido" 
                    name="apellido" 
                    placeholder="Escribe tu apellido"
                    value="<?php echo $usuario->apellido; ?>"
                    >
            </div>

            <div class="campo">
                <label for="email">Tu email:</label>
                <input 
                    type="email" 
                    for="email" 
                    name="email" 
                    placeholder="Escribe tu Email"
                    value="<?php echo $usuario->email?>"
                    >
            </div>

            <div class="campo">
                <label for="password">Tu password:</label>
                <input type="password" for="password" name="password" placeholder="Escribe tu password">
            </div>

            <div class="campo">
                <label for="password2">Repite tu password:</label>
                <input type="password" for="password2" name="password2" placeholder="Repetir password">
            </div>

            <input type="submit" value="Crear Cuenta">

        </form>
        
        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Inicia sesión</a>
            <a href="/recuperar">¿Olvidaste tu password?</a>
        </div>
    </div>
    
</div>