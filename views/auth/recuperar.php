<div class="contenedor recuperar">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php';?> 

    <div class="contenedor-sm">

        <p class="descripcion-pagina">Recupera tu password</p>

        <?php include_once __DIR__ . '/../templates/alertas.php';?> 

        <form method="POST" action="/recuperar" class="formulario" novalidate>

            <div class="campo">
                <label for="email">Tu email:</label>
                <input type="email" for="email" name="email" placeholder="Escribe tu Email">
            </div>

            <input type="submit" value="Recuperar">

        </form>
        
        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Inicia sesión</a>
            <a href="/crear">¿No tienes cuenta? Crear una</a>
        </div>
    </div>
    
</div>