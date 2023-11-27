<?php include_once __DIR__ . '/header_dashboard.php'; ?>

<div class="perfil contenedor-sm">

    <a href="/cambiar-password" class="enlace">Cambiar Password</a>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    
    <form action="/perfil" method="POST" class="formulario">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Tu Nombre"
                value="<?php echo $usuario->nombre; ?>"
            />
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Tu Email"
                value="<?php echo $usuario->email; ?>"
            />
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>


<?php include_once __DIR__ . '/footer_dashboard.php'; ?>