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
    // Manejo de la acción de login
    if ($datos['accion'] === 'login') {
        $session = new Session();
        $resp = $session->iniciar($datos["usnombre"], $datos["uspass"]);      
        if ($resp && $session->validar()) {
            $mensaje = "Bienvenido";
            echo "<script>location.href = '../../privado/index.php?msg=" . urlencode($mensaje) . "';</script>";
            exit;
        } else {
            $mensaje = "Usuario o contraseña incorrectos.";
            echo "<script>location.href = '../../publico/login/login.php?msg=" . urlencode($mensaje) . "';</script>";
            exit;    
        }
    }
    // Manejo de otras acciones como alta 
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
echo "<script>location.href = '../login/login.php?msg=" . urlencode($mensaje) . "';</script>";
exit;
?>
