<?php 
include_once("../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h1 class="display-5 pb-3 fw-bold">Carrito</h1>
                <a href="tienda.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            <?php
            $sesionActual = new Session();
            $objAbmUsuario = new AbmUsuarioLogin();
            $usuarioActual = $objAbmUsuario->buscar(['usnombre' => $sesionActual->getUsuario()->getUsnombre(), 'uspass' => $sesionActual->getUsuario()->getUspass()]);
            $idUsuario = $usuarioActual[0]->getIdUsuario();
            $arreglo["idusuario"] = $idUsuario;
            $arreglo["metodo"] = "carrito";
            $objAbmCompra = new AbmCompra();
            $listaComprasUsuarioAct = $objAbmCompra->buscar($arreglo);

            echo '<div class="d-flex justify-content-center">';
            echo '<table id="detalleCompra" class="easyui-datagrid" style="width:800px" 
                toolbar="#toolbarDetalleCompra" rownumbers="true" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="pronombre" width="85">Nombre del Producto</th>
                    <th field="cicantidad" width="50">Cantidad</th>
                    <th field="proprecio" width="107">Precio Unitario</th>
                    <th field="preciototal" width="90">Precio Total</th>
                    <th field="eliminarCompraItem" width="90"></th>
                </tr>
            </thead>
            <tbody>';

            if (count($listaComprasUsuarioAct) == 1) {
                $arreglo2["idcompra"] = $listaComprasUsuarioAct[0]->getIdcompra();
                $objAbmCompraItem = new AbmCompraItem();
                $listaObjCompraItem = $objAbmCompraItem->buscar($arreglo2);
                $totalCompra = 0;

                foreach ($listaObjCompraItem as $compraItem) {
                    echo "<tr><td>" . $compraItem->getObjProducto()->getPronombre() . "</td>";
                    echo "<td>" . $compraItem->getCicantidad() . "</td>";
                    echo "<td>" . $compraItem->getObjProducto()->getProimporte() . "</td>";
                    $precioTotalProducto = $compraItem->getCicantidad() * $compraItem->getObjProducto()->getProimporte();
                    echo "<td>" . $precioTotalProducto . "</td>";
                    echo "<td><a class='btn btn-outline-secondary btn-sm' onclick='eliminarItemCarrito(" . $compraItem->getIdcompraitem() . ")'>Eliminar</a></td></tr>";
                    $totalCompra += $precioTotalProducto;
                }

                echo "<tr><td></td><td></td><td>Precio Total de la Compra:</td>
                <td>" . $totalCompra . "</td><td></td></tr>";

                echo "</tbody></table></div>";

                // Los botones "Confirmar Compra" y "Cancelar Compra" fuera de la tabla
                echo '<div class="d-flex justify-content-center mt-3">';
                echo '<a class="btn btn-dark" style="margin-right:20px;" onclick="confirmarCompra(' . $listaComprasUsuarioAct[0]->getIdcompra() . ')">Confirmar</a>';
                echo '<a class="btn btn-secondary" style="margin-left:20px;" onclick="cancelarCompra()">Cancelar Compra</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>