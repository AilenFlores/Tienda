<?php 
include_once "../../../../../configuracion.php";
$data = data_submitted();
$objControl = new AbmMenu();
$objMenuRol = new AbmMenuRol();
$objRol = new AbmRol();
$list = convert_array($objControl->buscar($data));

foreach ($list as $key => $menuObj) {
    $roles = convert_array($objMenuRol->buscar(['idmenu' => $menuObj['idmenu']]));
    $list[$key]['meRol'] = [];
    foreach ($roles as $rol) {
        $rolActual = convert_array($objRol->buscar(["idRol" => $rol["objrol"]]));
        if (!empty($rolActual)) { // Verificar si se encontró el rol
            $list[$key]['meRol'][] = $rolActual[0]["roDescripcion"]; 
            $list[$key]['idRol'][] = $rolActual[0]["idRol"];
        }
    }
}
echo json_encode($list);

?>


                                