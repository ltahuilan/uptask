<?php

//*****UpTask*****

define('TEMPLATES_URL', __DIR__  .  '/templates');
define('FUNCIONES_URL', 'funciones.php');
define('DIR_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/uploads/');

function incluirTemplates (string $template, bool $inicio = false, bool $admin = false) {
    include TEMPLATES_URL . "/" . $template . "php";
};

/**
 * helper que comprueba si un usuario ha inciado sesión
 */
function autenticado() {
    session_start();    
    if ( !isset($_SESSION['login']) ) {
        header('location: /');
    }
};

/**
 * helper para debuguear, romple el flujo con exit;
 */
function debuguear($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}

/**
 * Sanitiza la entrada de datos por medio de strings desde un formulario, querystring o cualquier otro medio
 */
function sntzr($html) : string {
    $string = htmlspecialchars($html);
    return $string;
}

/**
 * valida el tipo de entidad 
 */
function validarTipo($tipo) {
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}


//mostrar alertas
function mostrarAlerta($codigo) {
    $mensaje = '';

    switch($codigo) {
        case 1 :
            $mensaje = 'Registro creado con éxito';
            break;
        case 2 :
            $mensaje = 'Registro actualizado correctamente';
            break;
        case 3 :
            $mensaje = 'Registro eliminado correctamente';
            break;
        default:
            $mensaje = NULL;
    }

    return $mensaje;
}

function validarORedireccionar($url) {
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //si no hay ningún id
    if(!$id) {
        header("Location: ${url}");
    }

    return $id;
}