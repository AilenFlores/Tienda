<?php
include_once "../../../../configuracion.php";
    // Enviar correo después de registrar el usuario
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once 'C:/xampp/htdocs/TIENDA/util/vendor/autoload.php'; // Ruta absoluta    
     // Cargar el autoload de Composer

ob_start();
$data = data_submitted();
$respuesta = ['respuesta' => false, 'msg' => ''];

if (isset($data['usNombre'])) {
    $abmUsuario = new AbmUsuarioLogin();
    $data["accion"] = "nuevo";
    $resp = $abmUsuario->abm($data);

    if ($resp) {
        // Si el usuario fue registrado correctamente
        $respuesta['respuesta'] = true;
        $respuesta['msg'] = "Usuario registrado correctamente.";

    

       

        // Crear una nueva instancia de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor de correo
            $mail->isSMTP();                                      // Usar SMTP
            $mail->Host = 'smtp.gmail.com';                         // Establecer el servidor SMTP
            $mail->SMTPAuth = true;                                 // Habilitar autenticación SMTP
            $mail->Username = 'agustinaafff@gmail.com';             // Usuario SMTP
            $mail->Password = 'uxkk aswh yoje iwpu';                // Contraseña de la aplicación (asegúrate de que es la correcta)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Encriptación TLS
            $mail->Port = 587;                                      // Puerto SMTP (587 para TLS)
        
            // Remitente y destinatario
            $mail->setFrom('agustinaafff@gmail.com', 'Amor');
            $mail->addAddress('juangabriel.ramos13@gmail.com', 'Amorcito'); // Agregar destinatario
        
            // Contenido del correo
            $mail->isHTML(true);                                    // Establecer formato de correo HTML
            $mail->Subject = 'Usuario Registrado';
            $mail->Body    = 'El usuario ha sido registrado correctamente.';
            $mail->AltBody = 'El usuario ha sido registrado correctamente (solo texto).';
        
            // Enviar correo
            $mail->send();
        } catch (Exception $e) {
            // Capturar cualquier error que ocurra durante el envío
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
        
    } else {
        // Si no se pudo registrar el usuario
        $respuesta['respuesta'] = false;
        $respuesta['msg'] = "No se pudo registrar el usuario.";
    }
}

echo json_encode($respuesta);
?>

