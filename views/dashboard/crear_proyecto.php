<?php include_once __DIR__ . '/header_dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'?>
    <form action="" method="POST" class="formulario">
        <?php include_once __DIR__ . '/formulario-dashboard.php'?>
        <input type="submit" value="Guardar Proyecto">
    </form>
</div>


<?php include_once __DIR__ . '/footer_dashboard.php'; ?>