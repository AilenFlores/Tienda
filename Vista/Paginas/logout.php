<?php
include_once "../../configuracion.php";
ob_start(); // 
 $session = new Session();
 $resp = $session->cerrar();
 if ($resp) {
     $mensaje = "Sesión cerrada";
      echo "<script>location.href = '../Paginas/login.php?msg=" . urlencode($mensaje) . "';</script>";
      exit;
 } else {
     $mensaje = "Error al cerrar la sesión.";
 }
 
?>