<?php
$datos = data_submitted();
$objAbmProducto = new AbmProducto();
$producto = $objAbmProducto->buscar(['idproducto' => $datos['idproducto']])[0];

if ($producto): ?>
    <div class="row">
        <div class="col-md-6">
            <?php $archivo = "../img/productos/" . $producto->getIdproducto() . ".jpg"; ?>
            <img src='<?= file_exists($archivo) ? $archivo : "../img/productos/0.jpg" ?>' class='img-fluid rounded' alt='producto'>
        </div>
        <div class="col-md-6">
            <h4><?= $producto->getPronombre() ?></h4>
            <p><?= $producto->getProdetalle() ?></p>
            <p>Precio: $<?= $producto->getProImporte() ?></p>
            <p>Unidades disponibles: <?= $producto->getProcantstock() ?></p>
            <form method="post" action="../accion/accionTienda.php">
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" value="1" min="1" max="<?= $producto->getProcantstock() ?>">
                </div>
                <input type="hidden" name="idproducto" value="<?= $producto->getIdproducto() ?>">
                <button type="submit" class="btn btn-dark">Agregar al carrito</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <p>Producto no encontrado.</p>
<?php endif; ?>