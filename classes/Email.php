<?php

namespace Classes;  

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;
    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    public function enviarConfirmacion() {
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'] ?? 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = (int) ($_ENV['EMAIL_PORT'] ?? 2525);
        $mail->Username = $_ENV['EMAIL_USER'] ?? 'TU_MAILTRAP_USERNAME';
        $mail->Password = $_ENV['EMAIL_PASS'] ?? 'TU_MAILTRAP_PASSWORD';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->setFrom($_ENV['EMAIL_FROM'] ?? 'no-reply@appsalon.com', 'AppSalon');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';

        // set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = '<html>';
        $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong>, has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace:</p>';
        $contenido .= '<p>Presiona aquí: <a href="http://localhost/AppSalon_PHP_MVC_JS_SASS/confirmar?token=' . $this->token . '">Confirmar Cuenta</a></p>';
        $contenido .= '<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>';
        $contenido .= '</html>';
        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();
    }
}
