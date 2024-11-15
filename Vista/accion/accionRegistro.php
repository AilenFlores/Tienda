<?php
include_once "../../configuracion.php";
require_once 'C:/xampp/htdocs/TIENDA/util/vendor/autoload.php';    

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
    
            // Crear instancia de Mailer
            $mailer = new Mailer();
            $direccionMail = $data['usMail'];
            $nombreUsuario = $data['usNombre'];
    
            try {
                // Enviar correo de bienvenida
                $mailer->sendWelcomeEmail($direccionMail, $nombreUsuario);
            } catch (Exception $e) {
                $respuesta['respuesta'] = false;
                $respuesta['msg'] = "Hubo un error al enviar el correo: " . $e->getMessage();
            }
            
        } else {
            // Si no se pudo registrar el usuario
            $respuesta['respuesta'] = false;
            $respuesta['msg'] = "No se pudo registrar el usuario.";
        }
    }
    
    echo json_encode($respuesta);
    
    ?>
    
    