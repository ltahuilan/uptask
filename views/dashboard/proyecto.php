<?php include_once __DIR__ . '/header_dashboard.php'; ?>

<div class="contenedor-sm">

    <div class="filtros" id="filtros">
        <div class="filtros-inputs">
            <h2>Filtros:</h2>

            <div class="campo">
                <label for="todas">Todas</label>
                <input type="radio" name="filtro" id="todas" value="" checked>
            </div>

            <div class="campo">
                <label for="completas">completas</label>
                <input type="radio" name="filtro" id="completas" value="1">
            </div>

            <div class="campo">
                <label for="pendientes">Pendientes</label>
                <input type="radio" name="filtro" id="pendientes" value="0">
            </div>
        </div>
    </div>

    <div class="contenedor-nueva-tarea">
        <button type="button" class="nueva-tarea" id="nueva-tarea">&#43; Añadir tarea</button>
    </div>

    <ul id="lista-tareas" class="lista-tareas"></ul>
</div>

<?php include_once __DIR__ . '/footer_dashboard.php'; ?>

<?php 
$script .= '
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="build/js/tareas.js"></script>
    '
?>