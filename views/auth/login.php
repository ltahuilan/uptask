
<div class="contenedor login">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php';?> 

    <div class="contenedor-sm">

        <p class="descripcion-pagina">Iniciar sesión</p>

        <?php include_once __DIR__ . '/../templates/alertas.php';?> 

        <form method="POST" action="/" class="formulario">
            <div class="campo">
                <label for="email">Tu email:</label>
                <input type="email" for="email" name="email" placeholder="Escribe tu Email">
            </div>

            <div class="campo">
                <label for="password">Tu password:</label>
                <input type="password" for="password" name="password" placeholder="Escribe tu password">
            </div>

            <input type="submit" value="Iniciar Sesión">

        </form>
        
        <div class="acciones">
            <a href="/crear">¿Aún no tienes cuenta? Crea una</a>
            <a href="/recuperar">¿Olvidaste tu password?</a>
        </div>
    </div>
    
</div>