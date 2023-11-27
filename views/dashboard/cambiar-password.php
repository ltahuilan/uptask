<?php include_once __DIR__ . '/header_dashboard.php'; ?>

<div class="perfil contenedor-sm">

    <a href="/perfil" class="enlace">Ir a Perfil</a>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    
    <form action="/cambiar-password" method="POST" class="formulario">
        <div class="campo">
            <label for="password_actual">Password actual</label>
            <input
                type="password"
                id="password_actual"
                name="password_actual"
                placeholder="Tu password actual"
            />
        </div>
        <div class="campo">
            <label for="password_nuevo">Password Nuevo</label>
            <input
                type="password"
                id="password_nuevo"
                name="password_nuevo"
                placeholder="Tu Password Nuevo"
            />
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer_dashboard.php'; ?>