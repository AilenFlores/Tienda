
<?php
include_once "../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$data["accion"]="editar";
if (isset($data['idmenu'])){
    $data["idmenu"] = intval($data["idmenu"]); // Convertir a número entero
    $objC = new AbmMenu();
    $respuesta = $objC->abm($data);
    if (!$respuesta){
        $sms_error = " La accion  MODIFICACION No pudo concretarse";  
    }else $respuesta =true;
    
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
     $retorno['errorMsg']=$sms_error;   
}


echo json_encode($retorno);
?>