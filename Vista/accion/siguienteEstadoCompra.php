<?php
include_once "../../configuracion.php";
require_once 'C:/xampp/htdocs/TIENDA/util/vendor/autoload.php';

// Obtener los datos enviados
$data = data_submitted();
$action = $data['accion'] ?? '';

$resp = ['success' => false, 'message' => 'Acción no válida'];

switch ($action) {
    case 'deposito':
        if (isset($data)) {
            $objAbmCompraEstado = new AbmCompraEstado();
            $resp = $objAbmCompraEstado->siguienteEstadoCompra($data);

            // Si la respuesta es exitosa, enviamos un correo
            if ($resp['success']) {
                $mailer = new Mailer();
                $usuario = new AbmUsuarioLogin();

                // Realiza la búsqueda del cliente
                $clientes = $usuario->buscar(['usnombre' => $data['usnombre']]);
                if (!empty($clientes) && is_array($clientes)) {
                    // Toma el primer cliente de la lista
                    $cliente = $clientes[0];
                    $clienteMail = $cliente->getUsMail();
                    $clienteNombre = $cliente->getUsNombre();
                    $idCompra = $data['idcompra'];

                    if ($clienteMail && $clienteNombre) {
                        try {
                            $estado = "Enviada";
                            $mailer->sendCambioEstadoCompraMail($clienteMail, $clienteNombre, $idCompra, $estado);
                        } catch (Exception $e) {
                            $resp['success'] = false;
                            $resp['message'] = "Hubo un error al enviar el correo: " . $e->getMessage();
                        }
                    } else {
                        $resp['message'] = "Los datos del cliente están incompletos.";
                    }
                } else {
                    $resp['message'] = "Cliente no encontrado.";
                }
            } else {
                $resp['message'] = $resp['errorMsg'] ?? 'Error desconocido';
            }
        } else {
            $resp['message'] = 'No se pudo realizar el cambio de estado debido a falta de idcompraitem.';
        }
        break;

    case 'administrador':
        if (isset($data)) {
            $objAbmCompraEstado = new AbmCompraEstado();
            $resp = $objAbmCompraEstado->siguienteEstadoCompra($data);

            if ($resp['success']) {
                $mailer = new Mailer();
                $usuario = new AbmUsuarioLogin();

                // Realiza la búsqueda del cliente
                $clientes = $usuario->buscar(['usnombre' => $data['usnombre']]);
                if (!empty($clientes) && is_array($clientes)) {
                    // Toma el primer cliente de la lista
                    $cliente = $clientes[0];
                    $clienteMail = $cliente->getUsMail();
                    $clienteNombre = $cliente->getUsNombre();
                    $idCompra = $data['idcompra'];

                    if ($clienteMail && $clienteNombre) {
                        try {
                            $estado = "Aceptada";
                            $mailer->sendCambioEstadoCompraMail($clienteMail, $clienteNombre, $idCompra, $estado);
                        } catch (Exception $e) {
                            $resp['success'] = false;
                            $resp['message'] = "Hubo un error al enviar el correo: " . $e->getMessage();
                        }
                    } else {
                        $resp['message'] = "Los datos del cliente están incompletos.";
                    }
                } else {
                    $resp['message'] = "Cliente no encontrado.";
                }
            } else {
                $resp['message'] = $resp['errorMsg'] ?? 'Error desconocido';
            }
        } else {
            $resp['message'] = 'No se pudo realizar el cambio.';
        }
        break;
    
    case 'cancelar':
        if (isset($data)) {
            $objAbmCompraEstado = new AbmCompraEstado();
            $resp = $objAbmCompraEstado->cancelarCompraEstado($data);

            if ($resp['success']) {
                $mailer = new Mailer();
                $usuario = new AbmUsuarioLogin();

                // Realiza la búsqueda del cliente
                $clientes = $usuario->buscar(['usnombre' => $data['usnombre']]);
                if (!empty($clientes) && is_array($clientes)) {
                    // Toma el primer cliente de la lista
                    $cliente = $clientes[0];
                    $clienteMail = $cliente->getUsMail();
                    $clienteNombre = $cliente->getUsNombre();
                    $idCompra = $data['idcompra'];

                    if ($clienteMail && $clienteNombre) {
                        try {
                            $estado = "Cancelada";
                            $mailer->sendCambioEstadoCompraMail($clienteMail, $clienteNombre, $idCompra, $estado);
                        } catch (Exception $e) {
                            $resp['success'] = false;
                            $resp['message'] = "Hubo un error al enviar el correo: " . $e->getMessage();
                        }
                    } else {
                        $resp['message'] = "Los datos del cliente están incompletos.";
                    }
                } else {
                    $resp['message'] = "Cliente no encontrado.";
                }
            } else {
                $resp['message'] = $resp['errorMsg'] ?? 'Error desconocido';
            }
        } else {
            $resp['message'] = 'No se pudo realizar el cambio.';
        }
        break;

    default:
        $resp['message'] = 'Acción no reconocida.';
        break;
}

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($resp);
exit;
?>