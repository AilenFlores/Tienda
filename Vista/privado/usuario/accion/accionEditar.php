
<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$data["accion"]="editarActual";
if (isset($data['idUsuario'])){
    $objC = new AbmUsuarioLogin();
    $respuesta = $objC->abm($data);
    if (!$respuesta){
        $sms_error = " La accion  MODIFICACION No pudo concretarse";  
    }else $respuesta =true;
    
}
$_SESSION['usnombre'] = $data['usNombre']; // Actualiza el nombre de usuario en la sesión
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
     $retorno['errorMsg']=$sms_error;   
}
echo json_encode($retorno);
?>