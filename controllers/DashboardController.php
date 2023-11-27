<?php 

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController{

    public static function index(Router $router) {
        //proteger la ruta
        autenticado();

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        //mostrar todos los proyectos asociados al id de la sesión activa

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router) {
        //proteger la ruta
        autenticado();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //crear instancia
            $proyecto = new Proyecto($_POST);

            //validar el formulario
            $alertas = $proyecto->validarProyecto();
            
            if(empty($alertas)) {
                //crear url
                $proyecto->url = md5(uniqid());
    
                //relacionar con el ip del usuario
                $proyecto->propietarioId = $_SESSION['id'];

                //guardar
                $proyecto->guardar();

                header('Location: /proyecto?url='.$proyecto->url);
            }
        }

        $router->render('dashboard/crear_proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }


    public static function proyecto(Router $router) {
        autenticado();

        $url = $_GET['url'];
        $proyecto = Proyecto::where('url', $url);
        
        //verificar que el proyecto corresponda al usuario de la sesion
        if($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        // debuguear($_SESSION['id']);

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function perfil(Router $router) {
        autenticado();
        $alertas = [];

        //consultar usuario en la BD
        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //sincronizar el objeto en memoria
            $usuario->sincronizar($_POST);

            //validar formulario
            $alertas = $usuario->validarNombre();
            $alertas = $usuario->validarEmail();

            if(empty($alertas)) {

                //verificar si el email ya existe
                $existeEmail = Usuario::where('email', $usuario->email);

                if($existeEmail && $existeEmail->id !== $_SESSION['id']) {
                    Usuario::setAlertas('El email ya esta en uso', 'error');
                    $alertas = Usuario::getAlertas();
                }else {
                    //actualizar el registro en la BD
                    $resultado = $usuario->guardar();
    
                    if($resultado) {
                        Usuario::setAlertas('Cambios guardados correctamente', 'exito');
                        $alertas = Usuario::getAlertas();
                    }
    
                    //actualizar nombre de usuario en memoria
                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
        }

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    public static function cambiar_password(Router $router) {
        autenticado();    
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //buscar el usuario en la BD con el id de usuario logueado
            $usuario = Usuario::find($_SESSION['id']);

            //sincronizar formulario con datos de usuario en memoria
            $usuario->sincronizar($_POST);

            //validar los campos
            $alertas = $usuario->validarPasswords();

            if(empty($alertas)) {
                //verificar que el password actual sea el correcto
                $resultado = $usuario->verificar_password();

                if(!$resultado) {
                    Usuario::setAlertas('El password actual es incorrecto', 'error');
                    $alertas = Usuario::getAlertas();
                }else {
                    $usuario->password = $usuario->password_nuevo;
                    $usuario->hashPassword();
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        Usuario::setAlertas('Password actualizado correctamente', 'exito');
                        $alertas = Usuario::getAlertas();
                    }
                    // debuguear($usuario);
                }

                //hashear password nuevo
                // debuguear($usuario);
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
        ]);
    }
}

?>