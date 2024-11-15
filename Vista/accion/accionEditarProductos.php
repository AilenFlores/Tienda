
<?php
include_once "../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$data["accion"]="editar";
if (isset($data['idproducto'])){
    $data["idproducto"] = intval($data["idproducto"]); // Convertir a número entero
    $objC = new AbmProducto();
    $respuesta = $objC->abm($data);
    

    if (!$respuesta){

        $sms_error = " La accion  MODIFICACION No pudo concretarse";
        
    }else $respuesta =true;
    
}
// Agregar los datos al retorno para ver en la consola

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
    
}
echo json_encode($retorno);
?>