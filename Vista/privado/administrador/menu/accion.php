<?php
include_once "../../../../configuracion.php";
$resp = false;
$objMenu = new AbmMenu(); // Instanciar el ABM de Usuario
$objMenuRol = new abmMenuRol(); // Instanciar el ABM de UsuarioRol

if (!isset($datos)) {
    $datos = data_submitted();
} 
if (isset($datos['accion'])) {
    if ($datos['accion'] == 'listar') {
        $lista = convert_array($objMenu->buscar(null)); //
        foreach ($lista as $key => $rolObj) { 
            $roles = convert_array($objMenuRol->buscar(['idmenu' => $rolObj['idmenu']])); // Buscar el rol del usuario
            $lista[$key]['usRol'] = [];
                foreach ($roles as $rol) {
                    $lista[$key]['usRol'][] = $rol["objrol"];
                } 
        }
    }
     else {
        $resp = $objMenu->abm($datos);
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
