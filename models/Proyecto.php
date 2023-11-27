<?php 

namespace Model;

class Proyecto extends ActiveRecord{

    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioId'];
    public $id;
    public $proyecto;
    public $url;
    public $propietarioId;


    public function __construct($args=[]) {
        $this->id = $args['id'] ?? NULL;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? NULL;
    }
    
    /**
     * Validar la entrada de datos en el formulario crear proyecto
     */
    public function validarProyecto() {
        if(!$this->proyecto) {
            self::$alertas['error'][] = 'El nombre del proyecto es requerido';
        }

        return self::$alertas;
    }
}


?>