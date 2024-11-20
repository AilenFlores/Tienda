<?php // Archivo: Mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mail;

    public function __construct() {
        // Crear una nueva instancia de PHPMailer
        $this->mail = new PHPMailer(true);
        // Configuración SMTP
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'safezone.nqn@gmail.com';
        $this->mail->Password = 'ugyb oqyi spbr qhmu';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
    }

    public function sendWelcomeEmail($direccionMail, $nombreUsuario) {
        try {
            $this->mail->setFrom('safezone.nqn@gmail.com', 'Safezone: Seguridad Industrial');
            $this->mail->addAddress($direccionMail, $nombreUsuario); // Agregar destinatario
            $this->mail->Subject = 'Bienvenido a SafeZone';

            // Contenido del correo en formato HTML
            $body = '
            <html>
            <head>
                <style>
                    body { font-family: "Arial", sans-serif; background-color: #f9f9f9; }
                    .email-container { max-width: 650px; margin: 30px auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
                    .email-header { background-color: #007BFF; color: #ffffff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                    .email-footer { background-color: #f1f1f1; padding: 10px; font-size: 12px; text-align: center; border-radius: 0 0 10px 10px; }
                    .btn { background-color: #28a745; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
                    .btn:hover { background-color: #218838; }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="email-header">
                        <h1>¡Bienvenido a SafeZone!</h1>
                    </div>
                    <div class="email-content">
                        <p>¡Hola, ' . $nombreUsuario . '!</p>
                        <p>Gracias por registrarte en Safezone. Estamos emocionados de tenerte con nosotros.</p>
                    </div>
                    <div class="email-footer">
                        <p>Atentamente, el equipo de SafeZone</p>
                        <p>Dirección: Calle Ficticia 123, Ciudad Neuquen, País Argentina | Teléfono: 123-456-7890 | Email: safezone.nqn@gmail.com</p>
                    </div>
                </div>
            </body>
            </html>';

            $this->mail->Body    = $body;
            $this->mail->AltBody = '¡Gracias por registrarte en Safezone.';
            
            // Enviar correo
            $this->mail->send();
        } catch (Exception $e) {
            throw new \Exception("Hubo un error al enviar el correo: {$this->mail->ErrorInfo}");
        }
    }

    public function sendCambioEstadoCompraMail($direccionMail, $nombreUsuario, $idCompra, $estado) {
        if($estado=="Cancelada"){
            $estado="Cancelada, el dinero sera devuelto a su cuenta en los proximos dias.";
        }
        try {
            $this->mail->setFrom('safezone.nqn@gmail.com', 'Safezone: Seguridad Industrial');
            $this->mail->addAddress($direccionMail, $nombreUsuario); // Agregar destinatario
            $this->mail->Subject = 'Actualizacion del estado de su compra en SafeZone';

            // Contenido del correo en formato HTML
            $body = '
            <html>
            <head>
                <style>
                    body { font-family: "Arial", sans-serif; background-color: #f9f9f9; }
                    .email-container { max-width: 650px; margin: 30px auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
                    .email-header { background-color: #007BFF; color: #ffffff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                    .email-footer { background-color: #f1f1f1; padding: 10px; font-size: 12px; text-align: center; border-radius: 0 0 10px 10px; }
                    .btn { background-color: #28a745; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
                    .btn:hover { background-color: #218838; }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="email-header">
                        <h1>Actualizacion del estado en la compra Nr ' . $idCompra . '</h1>
                    </div>
                    <div class="email-content">
                        <p>¡Hola, ' . $nombreUsuario . '!</p>
                        <p>Hubo un cambio en el estado de su compra Nr ' . $idCompra . '.</p>
                        <p>Nuevo estado: ' . $estado . '</p>
                    </div>
                    <div class="email-footer">
                        <p>Atentamente, el equipo de SafeZone</p>
                        <p>Dirección: Calle Ficticia 123, Ciudad Neuquen, País Argentina | Teléfono: 123-456-7890 | Email: safezone.nqn@gmail.com</p>
                    </div>
                </div>
            </body>
            </html>';

            $this->mail->Body    = $body;
            $this->mail->AltBody = '¡Estado actualizado.';

            // Enviar correo
            $this->mail->send();
        } catch (Exception $e) {
            throw new \Exception("Hubo un error al enviar el correo: {$this->mail->ErrorInfo}");
        }
    }

    public function sendMensajeCompraIniciada($direccionMail, $nombreUsuario, $idCompra, $estado) {
        try {
            $this->mail->setFrom('safezone.nqn@gmail.com', 'Safezone: Seguridad Industrial');
            $this->mail->addAddress($direccionMail, $nombreUsuario); // Agregar destinatario
            $this->mail->Subject = 'Nueva compra en SafeZone';

            // Contenido del correo en formato HTML
            $body = '
            <html>
            <head>
                <style>
                    body { font-family: "Arial", sans-serif; background-color: #f9f9f9; }
                    .email-container { max-width: 650px; margin: 30px auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
                    .email-header { background-color: #007BFF; color: #ffffff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                    .email-footer { background-color: #f1f1f1; padding: 10px; font-size: 12px; text-align: center; border-radius: 0 0 10px 10px; }
                    .btn { background-color: #28a745; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
                    .btn:hover { background-color: #218838; }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="email-header">
                        <h1>¡Usted ha realizado una compra!</h1>
                    </div>
                    <div class="email-content">
                        <p>¡Hola, ' . $nombreUsuario . '!</p>
                        <p>Usted ha iniciado la compra Nr ' . $idCompra . '.</p>
                        <p>Estado: ' . $estado . '</p>
                    </div>
                    <div class="email-footer">
                        <p>Atentamente, el equipo de SafeZone</p>
                        <p>Dirección: Calle Ficticia 123, Ciudad Neuquen, País Argentina | Teléfono: 123-456-7890 | Email: safezone.nqn@gmail.com</p>
                    </div>
                </div>
            </body>
            </html>';

            $this->mail->Body    = $body;
            $this->mail->AltBody = '¡Nueva compra.';

            // Enviar correo
            $this->mail->send();
        } catch (Exception $e) {
            throw new \Exception("Hubo un error al enviar el correo: {$this->mail->ErrorInfo}");
        }
    }
}
?>