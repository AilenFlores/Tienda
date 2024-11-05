<?php 
include_once "../../../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$mensaje = '';

if (isset($data['pronombre'])) {
    $objC = new AbmProducto();

    // Manejo de la carga de la imagen
    if (isset($_FILES['proimg']) && $_FILES['proimg']['error'] == 0) {
        // Establece la carpeta donde se guardarán las imágenes
        $carpetaDestino = '../img/'; // Asegúrate de que esta ruta es correcta y existe
        $nombreArchivo = $data['pronombre'].".jpg"; // Cambiar a .png si se requiere
        $rutaTemporal = $_FILES['proimg']['tmp_name'];
        $rutaImagen = $carpetaDestino . basename($nombreArchivo);
        
        // Mueve el archivo cargado a la carpeta de destino
        if (move_uploaded_file($rutaTemporal, $rutaImagen)) {
            // Aquí se puede almacenar la URL de la imagen en $data
            $data['proimg'] = 'http://localhost/tienda/vista/privado/deposito/productos/img/' . basename($nombreArchivo); // URL absoluta
        } else {
            $mensaje = "Error al mover la imagen a la carpeta de destino.";
        }
    }        

    // Continuar con el proceso de alta
    $data["accion"] = "nuevo";
    $respuesta = $objC->abm($data);

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
