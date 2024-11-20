<?php 
include_once("../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 text-center position-relative">
                <h2 class="fw-bold text-dark text-uppercase" style="letter-spacing: 1px; font-size: 2.5rem;"> Carrito </h2>
                <a href="tienda.php" class="btn btn-outline-secondary btn-sm position-absolute" style="top: 10px; right: 10px;">Volver</a>
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
               // echo '<button class="btn btn-success btn-sm mx-3 mb-3" onclick="confirmarCompra(' . $listaComprasUsuarioAct[0]->getIdcompra() . ')"><i class="bi bi-check-circle"></i> Confirmar Compra</button>';
               if (!empty($listaComprasUsuarioAct)) {
                echo '<button class="btn btn-primary btn-sm mx-3 mb-3" onclick="mostrarFormularioPago()"><i class="bi bi-credit-card"></i> Pagar</button>';
            }
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


<!-- Modal para el formulario de pago -->
<div class="modal fade" id="formularioPago" tabindex="-1" aria-labelledby="formularioPagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalFormularioPagoLabel">Formulario de Pago</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
        
            <form id="formPago" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="card-name" class="form-label">Nombre del titular</label>
                    <input type="text" class="form-control" id="card-name" name="card_name" maxlength="100" placeholder="Nombre del titular" required>
                    <div class="invalid-feedback">Por favor, ingrese el nombre del titular (solo letras).</div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="address" name="address" maxlength="200" placeholder="Dirección" required>
                    <div class="invalid-feedback">Por favor, ingrese la dirección.</div>
                </div>
                <div class="mb-3">
                    <label for="card-number" class="form-label">Número de tarjeta</label>
                    <input type="text" class="form-control" id="card-number" name="card_number" maxlength="16" placeholder="1234 5678 9012 3456" required>
                    <div class="invalid-feedback">El número de tarjeta debe tener 16 dígitos numéricos.</div>
                </div>
                <div class="mb-3">
                    <label for="expiry-date" class="form-label">Fecha de Expiración (MM/AA)</label>
                    <input type="text" class="form-control" id="expiry-date" name="expiry_date" maxlength="5" placeholder="MM/AA" required>
                    <div class="invalid-feedback">La fecha de expiración debe tener el formato MM/AA (Mes valido del 01 a 12 ).</div>
                </div>
                <div class="mb-3">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" placeholder="123" required>
                    <div class="invalid-feedback">El CVV debe tener 3 dígitos numéricos.</div>
                </div>
                <div class="d-grid">
                    <button type="button" class="btn btn-success btn-sm mx-3 mb-3" onclick="confirmarCompra(<?php echo $listaComprasUsuarioAct[0]->getIdcompra(); ?>)">
                        <i class="bi bi-check-circle"></i> Confirmar Compra
                    </button>
                 </div>
            </form>
        </div>
    </div>
</div>
</div>


<?php include(STRUCTURE_PATH . "pie.php"); ?>
