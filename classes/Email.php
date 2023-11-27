<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    protected $nombre;
    protected $email;
    protected $token;

    public function __construct($nombre, $email, $token){

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarEmail($accion) {

        //configuración del servidor de correo
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['MAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['MAIL_PORT'];
        $phpmailer->Username = $_ENV['MAIL_USER'];
        $phpmailer->Password = $_ENV['MAIL_PASS'];

        $phpmailer->setFrom('no-reply@uptask.com', 'Cuentas UpTask');
        // $phpmailer->addAddress('cuentas@uptask.com', 'UpTask.com');
        $phpmailer->addAddress($this->email);

        if($accion === 'confirmar') {

            $phpmailer->Subject = 'Confirma tu cuenta en UpTask';
            
            $phpmailer->isHTML(TRUE);
            $phpmailer->CharSet = 'UTF-8';

            $contenido = "<p>Hola <strong>". $this->nombre . "</strong></p>";
            $contenido .= "<p>Has creado tu cuenta en UpTask, solo hace falta confirmarla en el siguiente enlace:</p>";
            $contenido .= "<p><a href='". $_ENV['APP_URL'] . "/confirmar?token=" . $this->token . "'>Confirmar cuenta</a></p>";
            $contenido .= "<p>Si no puedes acceder con el boton, copia y pega la siguiente url:</p>";
            $contenido .= $_ENV['APP_URL'] . "/confirmar?token=" . $this->token. "<br>";
            $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje.</p>";

    
            // debuguear($contenido);
            $phpmailer->Body = $contenido;
            $phpmailer->send();
        }

        /**
         * Enviar instrucciones para reestablecer password
         */
        if($accion === 'reset') {
            $phpmailer->Subject = 'Restablece tu password de UpTask';
            
            $phpmailer->isHTML(TRUE);
            $phpmailer->CharSet = 'UTF-8';

            $contenido .= "<p>Hola <strong>".$this->nombre."</strong></p>";
            $contenido .= "<p>Para cambiar tu password haz clic en el siguiente enlace:</p>";
            $contenido .= "<p><a href='" . $_ENV['APP_URL'] . "/reset?token=" . $this->token . "'>Recuperar password.</a></p>";
            $contenido .= "<p>Si tu no solicitaste cambiar tu password, puedes ignorar este mensaje.</p>";
    
            $phpmailer->Body = $contenido;
            // debuguear(contenido);
            $phpmailer->send();
        }
    }
}
?>