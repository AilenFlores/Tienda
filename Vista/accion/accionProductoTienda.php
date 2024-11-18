<?php
include_once "../../configuracion.php";

// Configurar la cabecera para devolver JSON
header('Content-Type: application/json');

$data = data_submitted();

if (isset($data['idproducto'])) {
    $idproducto = $data['idproducto']; // Verifica que esto esté asignado correctamente
    $objAbmProducto = new AbmProducto();
    $producto = $objAbmProducto->buscar(['idproducto' => $idproducto]); // Filtra correctamente el ID

    if (!empty($producto) && is_array($producto)) {
        $producto = $producto[0]; // Asume que buscar devuelve un array
        echo json_encode([
            'status' => 'success',
            'data' => [
                'pronombre' => $producto->getPronombre(),
                'prodetalle' => $producto->getProdetalle(),
                'proimporte' => $producto->getProImporte(),
                'procantstock' => $producto->getProcantstock(),
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
    }
}

?>