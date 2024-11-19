<?php 
include_once("../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 text-center position-relative">
                <h2 class="fw-bold text-dark text-uppercase" style="letter-spacing: 1px; font-size: 2.5rem;"> Carrito </h2>
                <a href="../home/index.php" class="btn btn-outline-secondary btn-sm position-absolute" style="top: 10px; right: 10px;">Volver</a>
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

            if (count($listaComprasUsuarioAct) == 1) {
                // Hay productos en el carrito
                echo '<div class="table-responsive">';
                echo '<table id="detalleCompra" class="table table-striped table-bordered shadow-sm ">';
                echo '<thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">Nombre del Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio Unitario</th>
                            <th scope="col">Precio Total</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>';

                $arreglo2["idcompra"] = $listaComprasUsuarioAct[0]->getIdcompra();
                $objAbmCompraItem = new AbmCompraItem();
                $listaObjCompraItem = $objAbmCompraItem->buscar($arreglo2);
                $totalCompra = 0;

                foreach ($listaObjCompraItem as $compraItem) {
                    echo "<tr><td>" . $compraItem->getObjProducto()->getPronombre() . "</td>";
                    echo "<td>" . $compraItem->getCicantidad() . "</td>";
                    echo "<td>$" . number_format($compraItem->getObjProducto()->getProimporte(), 2, ',', '.') . "</td>";
                    $precioTotalProducto = $compraItem->getCicantidad() * $compraItem->getObjProducto()->getProimporte();
                    echo "<td>$" . number_format($precioTotalProducto, 2, ',', '.') . "</td>";
                    echo "<td><button class='btn btn-outline-danger btn-sm' onclick='eliminarItemCarrito(" . $compraItem->getIdcompraitem() . ")'><i class='bi bi-trash'></i> Eliminar</button></td></tr>";
                    $totalCompra += $precioTotalProducto;
                }

                echo "<tr class='table-secondary'>
                        <td colspan='3' class='text-right'><strong>Precio Total de la Compra:</strong></td>
                        <td><strong>$" . number_format($totalCompra, 2, ',', '.') . "</strong></td>
                        <td></td>
                    </tr>";

                echo "</tbody></table></div>";

                // Los botones "Confirmar Compra" y "Cancelar Compra" fuera de la tabla
                echo '<div class="d-flex justify-content-center mt-4">';
                echo '<button class="btn btn-success btn-sm mx-3 mb-3" onclick="confirmarCompra(' . $listaComprasUsuarioAct[0]->getIdcompra() . ')"><i class="bi bi-check-circle"></i> Confirmar Compra</button>';
                echo '<button class="btn btn-danger btn-sm mx-3 mb-3" onclick="cancelarCompra()"><i class="bi bi-x-circle"></i> Cancelar Compra</button>';
                echo '</div>';
            } else {
                // El carrito está vacío
                echo '<div class="text-center py-5">';
                echo '<i class="bi bi-cart-x" style="font-size: 50px; color: #6c757d; margin-bottom:20px;"></i>';
                echo '<h3 class="text-muted">Tu carrito está vacío</h3>';
                echo '<p class="text-muted">Parece que no has agregado ningún producto a tu carrito todavía.</p>';
                echo '<a href="tienda.php" class="btn btn-primary">Ir a la tienda</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>
