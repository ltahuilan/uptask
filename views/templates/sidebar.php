<aside class="sidebar">

    <div class="sidebar-mobile">
        <h2>UpTask</h2>
        <div class="menu-cerrar">
            <img src="/build/img/cerrar.svg" id="cerrar-menu" alt="imagen cerrar menu">
        </div>
    </div>

    <div class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Proyectos') ? 'activo' : ''; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === 'Crear Proyecto') ? 'activo' : ''; ?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo ($titulo === 'Perfil')? 'activo' : ''; ?>" href="/perfil">Perfil</a>
    </div>

    <div class="cerrar-sesion">
        <a href="/logout">Cerrar Sesión</a>
    </div>
</aside>