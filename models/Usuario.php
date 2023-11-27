<?php 

namespace Model;

class Usuario extends ActiveRecord{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'confirmado', 'token'];
    protected static $alertas = [];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $confirmado;
    public $token;


    public function __construct($args = []) {
        //llenado el arreglo de $args
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        // $this->password_actual= $args['password_actual'] ?? '';
        // $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    
    //validar formulario para login
    /**
     * $alertas declarada como protected static en ActiveRecord
     * se accede a la variable con la expresion self::$alertas
     */
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El campo email es requerido';
        }

        //validar el formato del email
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El formato del email no es valido';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'El campo password es requerido';
        }

        return self::$alertas;
    }

    /** 
     * validar datos del formulario para nuevo usuario
    */
    public function validar() : array {

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El campo nombre es requerido';
        }

        if(!$this->email) {
            self::$alertas['error'][] = 'El campo email es requerido';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'El campo password es requerido';
        }

        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }

        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los passwords no coiniciden';
        }

        return self::$alertas;
    }

    /**
     * método que valida si un email existe y si su formato es valido
     */
    public function validarEmail() : array {

        if(!$this->email) {
            self::$alertas['error'][] = 'El campo email es requerido';
        }
        //validar el formato del email
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El formato del email no es valido';
        }
        return self::$alertas;
    }

    /**
     * método que verifica si el campo de nombre tiene datos
     */
    public function validarNombre() : array {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El campo nombre es requerido';
        }
        return self::$alertas;
    }

    public function verificar_password() : bool {
        return password_verify($this->password_actual, $this->password);
    }

    /**
     * validar formulario de cambio de password
     */
    public function validarPasswords() : array {
        if(!$this->password_actual) {
            self::$alertas['error'][] = 'El campo password actual es requerido';
        }
        if(!$this->password_nuevo || strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El password nuevo debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }


    //hashear password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function setToken() : void {
        $this->token = md5(uniqid());
    }

}

?>