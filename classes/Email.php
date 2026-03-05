<?php
namespace Classes;  
use PHPMailer\PHPMailer\PHPMailer;
/**
 * @method void enviarInstrucciones()
 */
// Clase para enviar emails de confirmación de cuenta y recuperación de password
class Email {
    public $email;
    public $nombre;
    public $token;
    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    // Método para enviar el email de confirmación de cuenta
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

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/public/index.php'));
        $fallbackBaseUrl = $scheme . '://' . $host . rtrim($scriptDir, '/');

        $baseUrl = rtrim($_ENV['APP_URL'] ?? $fallbackBaseUrl, '/');
        $confirmUrl = $baseUrl . '/confirmarCuenta?token=' . urlencode($this->token);

        // set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = '<html>';
        $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong>, has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace:</p>';
        $contenido .= '<p>Presiona aquí: <a href="' . $confirmUrl . '">Confirmar Cuenta</a></p>';
        $contenido .= '<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>';
        $contenido .= '</html>';
        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();
    }

    // Método para enviar el email de recuperación de password
    public function enviarInstrucciones() {
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
        $mail->Subject = 'Reestablece tu password';

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/public/index.php'));
        $fallbackBaseUrl = $scheme . '://' . $host . rtrim($scriptDir, '/');

        $baseUrl = rtrim($_ENV['APP_URL'] ?? $fallbackBaseUrl, '/');
        $recuperarUrl = $baseUrl . '/recuperar?token=' . urlencode($this->token);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = '<html>';
        $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong>, has solicitado reestablecer tu password.</p>';
        $contenido .= '<p>Presiona aquí: <a href="' . $recuperarUrl . '">Reestablecer Password</a></p>';
        $contenido .= '<p>Si tu no solicitaste este cambio, puedes ignorar este mensaje</p>';
        $contenido .= '</html>';
        $mail->Body = $contenido;

        $mail->send();
    }
}
