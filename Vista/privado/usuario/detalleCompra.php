<?php 
include_once("../../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h1 class="display-5 pb-3 fw-bold">Detalle compra</h1>
                <a href="tienda.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            <div class="d-flex justify-content-center">
                <table id="detalleCompra" class="easyui-datagrid" style="width:800px"
                        toolbar="#toolbarDetalleCompra"
                        rownumbers="true" fitColumns="true" singleSelect="true">
                    <thead>
                        <tr>
                            <th field="pronombre" width="85">Nombre del Producto</th>
                            <th field="cicantidad" width="50">Cantidad</th>
                            <th field="proprecio" width="107">Precio Unitario</th>
                            <th field="preciototal" width="105">Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                    $arreglo["idcompra"] = $datos["idcompra"];
                    $objAbmCompraItem = new AbmCompraItem();
                    $arregloItems = $objAbmCompraItem->buscar($arreglo);
                    $totalCompra = 0;
                    foreach ($arregloItems as $compraItem){
                        echo "<td>".$compraItem->getObjProducto()->getPronombre()."</td>";
                        echo "<td>".$compraItem->getCicantidad()."</td>";
                        echo "<td>".$compraItem->getObjProducto()->getProimporte()."</td>";
                        $precioTotalProducto = $compraItem->getCicantidad()*$compraItem->getObjProducto()->getProimporte();
                        echo "<td>".$precioTotalProducto."</td></tr>";
                        $totalCompra = $totalCompra + $precioTotalProducto;
                    }
                    echo "<tr><td></td><td></td><td></td><td>Precio Total de la Compra: ".$totalCompra."</td></tr>";
                    echo "</tbody></table>";
                ?>
            </div>
        </div>
    </div>
</main>
<?php include(STRUCTURE_PATH . "pie.php"); ?>