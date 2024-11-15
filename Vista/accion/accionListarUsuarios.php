<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new AbmUsuarioLogin();
$objUsuarioRol = new AbmUsuarioRol();
$objRol = new AbmRol(); 
$list = convert_array($objControl->buscar($data));

foreach ($list as $key => $personaObj) {
    $roles = convert_array($objUsuarioRol->buscar(['idusuario' => $personaObj['idUsuario']]));
    $list[$key]['usRol'] = [];
    foreach ($roles as $rol) {
        $rolActual = convert_array($objRol->buscar(["idRol" => $rol["idRol"]]));
        if (!empty($rolActual)) { 
            $list[$key]['usRol'][] = $rolActual[0]["roDescripcion"]; 
            $list[$key]['idRol'][] = $rolActual[0]["idRol"];
        }
    }
}
echo json_encode($list);
?>


                                