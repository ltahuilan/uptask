<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareasController {

    /**
     * No requiere del Router porque no va a renderizar vistas
     */

    public static function index() {
        //obtener la url del proyecto
        $url = $_GET['url'];
        
        //consultar si la url existe
        $proyecto = Proyecto::where('url', $url);        
        
        //redireccionar si no existe el proyecto o no pertenecea al usuario de la session
        session_start();
        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }        
        
        //consultar todos los registros que pertenecen al proyecto
        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);

        echo json_encode(['tareas' => $tareas]);
        // echo json_encode($tareas);
    }


    public static function crear() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();

            //consultar el proyecto en la BD por medio de la url del proyecto
            $url = $_POST['url'];
            $proyecto = Proyecto::where('url', $url);
            // echo json_encode($_SESSION);
            // return;

            //verificar que el proyecto exista o pertenezca al usuario autenticado
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                //retornar por respuesta una aleta si el proyecto no existe en la BD 
                $alerta = [
                    'tipo' => 'error',
                    'mensaje' => 'Ha ocurrido un error al intentar agregar la tarea al proyecto'
                ];

                echo json_encode($alerta);
            }

            //Si todo esta OK, crear instancia de Tareas
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();

            if($resultado) {
                $respuesta = [
                    'id' => $resultado['id'],
                    'proyectoId' => $tarea->proyectoId,
                    'tipo' => 'exito',
                    'mensaje' => 'Tarea Creada Correctamente'
                ];

                echo json_encode($respuesta);
            }
        }
    }


    public static function actualizar() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //verificar si el proyecto existe
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);
            session_start();
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                //retornar por respuesta una aleta si el proyecto no existe en la BD 
                $alerta = [
                    'tipo' => 'error',
                    'mensaje' => 'Ha ocurrido un error al intentar actualizar la tarea'
                ];                
                echo json_encode($alerta);
                return;
            }

            $tarea = new Tarea($_POST);
            //asignar el id del proyecto al valor de proyectoId
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();

            if($resultado) {
                $respuesta = [
                    'id' => $tarea->id,
                    'proyectoId' => $tarea->proyectoId,
                    'tipo' => 'exito',
                    'mensaje' => 'Tarea Actualizada Correctamente'
                ];
                echo json_encode($respuesta);
            }
        }
    }


    public static function eliminar() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //verificar que el proyecto exista
            $url = $_POST['proyectoId'];
            $proyecto = Proyecto::where('url', $url);

            session_start();
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $alerta = [
                    'tipo' => 'error',
                    'mensaje' => 'Ha ocurrido un error al intentar eliminar la tarea'
                ];
                echo json_encode($alerta);
                return;
            }

            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();
            if($resultado) {
                $alerta = [
                    'tipo' => 'exito',
                    'mensaje' => 'Tarea Eliminada correctamente'
                ];
            }

            echo json_encode($alerta);
        }
    }
}
?>