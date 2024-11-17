<?php
include_once "../../configuracion.php";
require_once 'C:/xampp/htdocs/TIENDA/util/vendor/autoload.php';
$datos = data_submitted();

if (isset($datos['idcompra'])) {
    $objAbmCompra = new AbmCompra();
    $redireccion = $objAbmCompra->finalizarCompra($datos);
    
    // Después de finalizar la compra, verifica si se completó correctamente
    if (strpos($redireccion, 'transaccion=exito') !== false) {
        // Si la compra se finalizó correctamente, enviamos el correo.
        $mailer = new Mailer();
        $sesion = new Session();
        $clienteMail = $sesion->getUsuario()->getUsMail();
        $clienteNombre = $sesion->getUsuario()->getUsNombre();
        $idCompra = $datos['idcompra'];
        $estado = "Iniciada";  // Puedes poner el estado correspondiente aquí
        
        try {
            // Enviar correo sobre la compra iniciada
            $mailer->sendMensajeCompraIniciada($clienteMail, $clienteNombre, $idCompra, $estado);
        } catch (Exception $e) {
            // Si hay un error al enviar el correo
            $respuesta['respuesta'] = false;
            $respuesta['msg'] = "Hubo un error al enviar el correo: " . $e->getMessage();
        }
        
        // Realizar la redirección después de todo el proceso
        header($redireccion);
    } else {
        // Si no se pudo finalizar la compra correctamente
        header($redireccion);
    }
} else {
    // Si no se recibió el idcompra
    header("Location:../paginas/tiendaFinalizar.php?transaccion=fallo");
}
?>