<?php
session_start();
include_once "../../../configuracion.php";
$resp = false;
$mensaje = "Acción no realizada."; // Mensaje predeterminado
$objTrans = new AbmUsuarioLogin();
if (!isset($datos)) {
    $datos = data_submitted();
}
if (isset($datos['accion'])) {
    if ($datos['accion'] === 'logout') {
        $session = new Session();
        $resp = $session->cerrar();
        if ($resp) {
            $mensaje = "Sesión cerrada";
             echo "<script>location.href = '../../publico/login/login.php?msg=" . urlencode($mensaje) . "';</script>";
             exit;
        } else {
            $mensaje = "Error al cerrar la sesión.";
        }
    }
    // Manejo de otras acciones como listar o ABM
    else {
            $resp = $objTrans->abm($datos);
            if ($resp) {
                $mensaje = "La acción " . htmlspecialchars($datos['accion']) . " se realizó correctamente.";
            } else {
                $mensaje = "La acción " . htmlspecialchars($datos['accion']) . " no pudo concretarse.";
            }  
    }
}

// Redirigir a la página de mensajes
echo "<script>location.href = '../index.php?msg=" . urlencode($mensaje) . "';</script>";

?>
