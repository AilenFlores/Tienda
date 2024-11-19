<?php
include_once "../../configuracion.php";
require_once 'C:/xampp/htdocs/TIENDA/util/vendor/autoload.php';

// Obtener los datos enviados
$data = data_submitted();
$action = $data['action'] ?? '';

$resp = ['success' => false, 'message' => 'Acción no válida'];

switch ($action) {
    case 'eliminarItemCarrito':
        if (isset($data['idcompraitem'])) {
            $objAbmCompraItem = new AbmCompraItem();
            $resp = $objAbmCompraItem->eliminarItemDeCompra(['idcompraitem' => $data['idcompraitem']]);
        } else {
            $resp['message'] = 'ID del ítem no proporcionado.';
        }
        break;

    case 'cancelarCompra':
        $objAbmCompra = new AbmCompra();
        $resp = $objAbmCompra->cancelarCompra();
        break;

    case 'confirmarCompra':
        if (isset($data['idcompra'])) {
            $objAbmCompra = new AbmCompra();
            $resp = $objAbmCompra->finalizarCompra(['idcompra' => $data['idcompra']]);

            if ($resp['success']) {
                $mailer = new Mailer();
                $sesion = new Session();
                $clienteMail = $sesion->getUsuario()->getUsMail();
                $clienteNombre = $sesion->getUsuario()->getUsNombre();
                $idCompra = $data['idcompra'];
                $estado = "Iniciada";  // Puedes poner el estado correspondiente aquí
                
                try {
                    // Enviar correo sobre la compra iniciada
                    $mailer->sendMensajeCompraIniciada($clienteMail, $clienteNombre, $idCompra, $estado);
                } catch (Exception $e) {
                    // Si hay un error al enviar el correo
                    $resp['success'] = false;
                    $resp['message'] = "Hubo un error al enviar el correo: " . $e->getMessage();
                }
            }
        } else {
            $resp['message'] = 'ID de la compra no proporcionado.';
        }
        break;

    default:
        $resp['message'] = 'Acción no reconocida.';
        break;
}

header('Content-Type: application/json');
echo json_encode($resp);
exit;
?>