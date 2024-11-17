<?php
include_once "../../configuracion.php";
require_once 'C:/xampp/htdocs/TIENDA/util/vendor/autoload.php';

$datos = data_submitted();
$objAbmCompraEstado = new AbmCompraEstado();
$respuesta = $objAbmCompraEstado->cancelarCompraCliente($datos);

$respuestaFinal = [
    "success" => false,
    "msg" => $respuesta["respuesta"] ?? $respuesta["errorMsg"] ?? "Error desconocido",
    "correo" => null,
];

if ($respuestaFinal["msg"] === "Se canceló la compra y se actualizó el stock correctamente") {
    try {
        $mailer = new Mailer();
        $sesion = new Session();
        $clienteMail = $sesion->getUsuario()->getUsMail();
        $clienteNombre = $sesion->getUsuario()->getUsNombre();
        $idCompra = $datos['idcompra'];
        $estado = "Cancelada";

        $mailer->sendCambioEstadoCompraMail($clienteMail, $clienteNombre, $idCompra, $estado);
        $respuestaFinal["correo"] = "Correo enviado exitosamente";
        $respuestaFinal["success"] = true;
    } catch (Exception $e) {
        $respuestaFinal["correo"] = "Error al enviar el correo: " . $e->getMessage();
    }
} else {
    // Si hay un mensaje de error del ABM, el éxito sigue siendo falso.
    $respuestaFinal["success"] = false;
}

echo json_encode($respuestaFinal);
?>