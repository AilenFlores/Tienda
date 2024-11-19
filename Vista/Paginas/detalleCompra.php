<?php 
include_once("../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-5">
        <div class="card shadow-lg" style="background-color: #f8f9fa;"> 
            <div class="card-header" style="background-color: #007bff; color: white;"> 
                <div class="d-flex justify-content-between align-items-center"> 
                    <h4 class="display-6 pb-3 fw-bold text-center w-100">Detalle Compra</h4> 
                    <a href="misCompras.php" class="btn btn-outline-light btn-sm">Volver</a>
                </div>
            </div>

            <div class="card-body">
                <!-- Tabla de productos en la compra -->
                <div class="table-responsive">
                    <table id="detalleCompra" class="table table-bordered table-striped">
                        <thead class="bg-info text-white"> 
                            <tr>
                                <th>Nombre del Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Precio Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $datos = data_submitted();
                                $arreglo["idcompra"] = $datos["idcompra"];
                                $objAbmCompraItem = new AbmCompraItem();
                                $arregloItems = $objAbmCompraItem->buscar($arreglo);
                                $totalCompra = 0;
                                foreach ($arregloItems as $compraItem) {
                                    echo "<tr>";
                                    echo "<td>".$compraItem->getObjProducto()->getPronombre()."</td>";
                                    echo "<td>".$compraItem->getCicantidad()."</td>";
                                    echo "<td>".$compraItem->getObjProducto()->getProimporte()."</td>";
                                    $precioTotalProducto = $compraItem->getCicantidad()*$compraItem->getObjProducto()->getProimporte();
                                    echo "<td>".$precioTotalProducto."</td>";
                                    echo "</tr>";
                                    $totalCompra = $totalCompra + $precioTotalProducto;
                                }
                            ?>
                           
                            <tr class="font-weight-bold bg-light">
                                <td colspan="3" class="text-right">Precio Total de la Compra:</td>
                                <td><?php echo $totalCompra; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include(STRUCTURE_PATH . "pie.php"); ?>
