<?php
include_once "../../../../configuracion.php";
$resp = false;
$objTrans = new AbmUsuarioLogin(); // Instanciar el ABM de Usuario
$objUsuarioRol = new AbmUsuarioRol(); // Instanciar el ABM de UsuarioRol

if (!isset($datos)) {
    $datos = data_submitted();
} 
if (isset($datos['accion'])) {
    if ($datos['accion'] == 'listar') {
        $lista = convert_array($objTrans->buscar(null));
        foreach ($lista as $key => $personaObj) { 
            $roles = convert_array($objUsuarioRol->buscar(['idusuario' => $personaObj['idUsuario']])); // Buscar el rol del usuario
            $lista[$key]['usRol'] = [];
                foreach ($roles as $rol) {
                    $lista[$key]['usRol'][] = $rol["idRol"];
                } 
        }
    }
     else {
        $resp = $objTrans->abm($datos);
        if ($resp) {
            $mensaje = "La acción " . $datos['accion'] . " se realizó correctamente.";
        } else {
            $mensaje = "La acción " . $datos['accion'] . " no pudo concretarse.";
        }
        // Redirigir a la página de mensajes
        echo("<script>location.href = './index.php?msg=$mensaje';</script>");
    }
}
?>
