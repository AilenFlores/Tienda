<?php
// detallesCompra.php
include_once("../Estructura/CabeceraSegura.php"); // Incluir cabecera segura

$datos = data_submitted(); // Obtener datos enviados desde la solicitud AJAX
$idcompra = $datos["idcompra"]; // Obtener el ID de la compra

// Crear instancia de AbmCompraItem y buscar los productos asociados a la compra
$objAbmCompraItem = new AbmCompraItem();
$arregloItems = $objAbmCompraItem->buscar(["idcompra" => $idcompra]);

// Crear arreglo para los productos de la compra
$productos = [];

foreach ($arregloItems as $compraItem) {
    // Obtener los datos del producto
    $producto = $compraItem->getObjProducto();

    // Añadir los detalles del producto al arreglo
    $productos[] = [
        'pronombre' => $producto->getPronombre(),
        'cantidad' => $compraItem->getCicantidad(),
        'precioUnitario' => $producto->getProimporte(),
        // No necesitamos 'precioTotal' en este caso, lo calcularemos en JavaScript
    ];
}

// Crear la respuesta JSON con los productos
$respuesta = [
    'success' => true,
    'productos' => $productos // Solo devolver los productos
];

error_log("Detalles de la compra: " . json_encode($respuesta)); // Loggear la respuesta

// Devolver la respuesta en formato JSON
echo json_encode($respuesta);
ob_end_flush();
?>