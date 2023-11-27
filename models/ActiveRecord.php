<?php 

namespace Model;

class ActiveRecord {

    //atributos estaticos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];
    protected static $alertas = [];
    public $id;
    public $imagen;
    

    /**
     * establecer la conexión a la base de datos
     */
    public static function setDB($conexion) {
        self::$db = $conexion;
    }


    public function guardar() {
        $resultado = '';
        if( !is_null($this->id) ) {
            $resultado = $this->actualizar();
        }else {
            $resultado = $this->crear();
        }
        return $resultado;
    }    
    
    public function crear() {
        $atributos = $this->sanitizarDatos();
        
        /**
         * Inserta valores en la DB
         */
        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";

        // return json_encode($query);

        //resultado de la consulta
        $resultado = self::$db->query($query);
        
        return [
            'resultado' => $resultado,
            'id' => self::$db->insert_id
        ];
    }

    /**
     * Actualizar un registro en la BD
     */
    public function actualizar() {

        $atributos = $this->sanitizarDatos();
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "${key}='${value}'";
        }
        
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id='$this->id'";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    /**
     * Eliminar un registro en la BD
     */
    public function eliminar() {

        if( !is_null($this->id) ) {
            
            $this->eliminarImagen();

            //Elima el registro de la DB
            $query = "DELETE FROM " . static::$tabla . " WHERE id=". self::$db->escape_string($this->id);
            // debuguear($query);
            $resultado = self::$db->query($query);
            return $resultado;
        }        
    }


    /**
     * mapea las columnas del arreglo $columnasDB con los atributos del objeto en memoria
     */
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna; //$this contiene la referencia del objeto en memoria
        }
        return $atributos;
    }


    /**
     * sanitiza la entrada de datos
     */
    public function sanitizarDatos() {
        $atributos = $this->atributos();
        $atributosSanitizados = [];
        foreach($atributos as $key => $value) {
            $atributosSanitizados[$key] = self::$db->escape_string($value);
        }        
        return $atributosSanitizados;
    }

    
    /**
     * asignar al atributo el nombre de la imagen
     */
    public function setImagen($imagen) {
        //si hay un id presente
        if( !is_null($this->id) ) {
            $this->eliminarImagen();
        }

        if($imagen) {
            $this->imagen = $imagen;
        }
    }


    /**
     * Elimina la imagen del disco duro
     */
    public function eliminarImagen() {
        //verificar que exista una imagen con el nombre
        $existeArchivo = file_exists(DIR_IMAGENES.$this->imagen);
        //Si existe la image, eliminar
        if($existeArchivo) {
            unlink(DIR_IMAGENES . $this->imagen);
        };
    }

    public static function setAlertas($mensaje, $tipo) {
        static::$alertas[$tipo][] = $mensaje;
    }

    /**
     * Devuelve el  arreglo de alertas
     */
    public static function getAlertas() {
        return static::$alertas;
    }


    /**
     * método para consultar todos los registros
     */
    public static function all() {        
        $query = "SELECT * FROM " . static::$tabla; 
        return self::consultarSQL($query);
    }
    
    /**
     * método que consulta determinado número de registros
     */
    public static function get($limite) {
        $query ="SELECT * FROM " . static::$tabla . " LIMIT " . $limite;
        return self::consultarSQL($query);
    }

    /**
     * Método que que consulta un registro en una columna de la BD
     */
    public static function where($columna, $valor) {
        $query = "SELECT *FROM " . static::$tabla . " WHERE ${columna} = '$valor'";

        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    /**
     * Consultar todos los registros asociados a un id
     */
    public static function belongsTo($columna, $valor) {
        $query = "SELECT *FROM " . static::$tabla . " WHERE ${columna} = '$valor'";

        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    /**
     * Método para encontrar un registro en concreto
     */
    public static function find($id) {
        $query = "SELECT * FROM ". static::$tabla . " WHERE id=${id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado); //array_shift devuelve el primer elemento de un array
    }


    /**
     * consulta SQL
     */
    public static function consultarSQL($query) {

        //consultar la base de datos
        $resultado = self::$db->query($query);

        //iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro); //El arreglo se llena con objetos
        }

        //liberar la memoria de datos
        $resultado->free();

        //retornar los resultados
        return $array;
    }

    /**
     * crear objeto con los datos del array, verificar si la propiedad del objeto existe 
     * y mapea la propiedad del arreglo con la del objeto
     * */
    protected static function crearObjeto($registro){
        $objeto = new static;
        foreach($registro as $key => $value) {
            
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value; // objecto["llave"] = "valor"
            }
        }
        return $objeto;
    }

    /**
     * Sincronizar objeto en memoria con POST
     */
    public function sincronizar($args = []) {
        foreach($args as $key => $value) { 
            $this->$key = $value;
        }
        return $this;
    }

}

?>