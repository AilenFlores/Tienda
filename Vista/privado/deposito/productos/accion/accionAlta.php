<?php 
include_once "../../../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$mensaje = '';

if (isset($data['pronombre'])) {
    $objC = new AbmProducto();
    $data["accion"] = "nuevo";
    $respuesta = $objC->abm($data);
    $nuevo=convert_array($objC->buscar(null));
    $ultimoID=end($nuevo);
    $idProducto=($ultimoID['idproducto']);

    // Manejo de la carga de la imagen
    if (isset($_FILES['proimg']) && $_FILES['proimg']['error'] == 0) {
        // Establece la carpeta donde se guardarán las imágenes
        $carpetaDestino = "../../../../img/productos/";
        $nombreArchivo = $idProducto.".jpg"; // El nombre del archivo será el ID del producto
        $rutaTemporal = $_FILES['proimg']['tmp_name'];
        $rutaImagen = $carpetaDestino . basename($nombreArchivo);
        move_uploaded_file($rutaTemporal, $rutaImagen);
    }        
    
    if (!$respuesta) {
        $mensaje = "La acción ALTA no pudo concretarse.";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {
    $retorno['errorMsg'] = $mensaje;
}

echo json_encode($retorno);
?>
