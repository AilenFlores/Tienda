<?php
include_once("../../configuracion.php");
$datos = data_submitted();
if (isset($datos['idcompra'])) {
    $idcompra = intval($datos['idcompra']);
    $objAbmCompraItem = new AbmCompraItem();
    $objAbmCompraItem->mostrarDetalles(['idcompra' => $idcompra]);
} else {
    echo "<p class='text-danger'>ID de compra no proporcionado.</p>";
}
