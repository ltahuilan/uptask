<?php include_once __DIR__ . '/header_dashboard.php'; ?>

<?php if(count($proyectos) === 0) {?>
    <p class="no-proyectos">Aún no tienes proyectos, <a href="/crear-proyecto">comienza crendo uno...</p>
<?php } else {?>
    <ul class="lista-proyectos">
        <?php foreach($proyectos as $proyecto) :?>
            <li >
                <a href="/proyecto?url=<?php echo $proyecto->url?>" class="proyecto"><?php echo $proyecto->proyecto?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php }?>


<?php include_once __DIR__ . '/footer_dashboard.php'; ?>