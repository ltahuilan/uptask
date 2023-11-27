
<div class="contenedor reset">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php';?> 

    <div class="contenedor-sm">

        <?php include_once __DIR__ . '/../templates/alertas.php';?> 

        <?php if($mostrar): ?>

        <p class="descripcion-pagina">Registra tu nuevo password</p>

        <form method="POST" class="formulario">
            <div class="campo">
                <label for="password">Password:</label>
                <input type="password" for="password" name="password" placeholder="Escribe tu nuevo password">
            </div>

            <div class="campo">
                <label for="password2">Password:</label>
                <input type="password" for="password2" name="password2" placeholder="Escribe tu nuevo password">
            </div>


            <input type="submit" value="Guardar">

        </form>
        
        <div class="acciones">
            <a href="/crear">¿Aún no tienes cuenta? Crea una</a>
            <a href="/">¿Ya tienes cuenta? Inicia sesión</a>
        </div>

        <?php endif; ?>
    </div>
    
</div>