
<?php
include_once "../../../../configuracion.php";
session_start(); // Inicia o reanuda una sesión
$data = data_submitted();
$respuesta = false;
$data["accion"]="editarPass";
if (isset($data['passNew'])){
    $objC = new AbmUsuarioLogin();
    $data['idUsuario'] = $_SESSION['idusuario'];
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