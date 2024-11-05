<?php
include_once("../../configuracion.php");
include_once(STRUCTURE_PATH . "cabecera.php");
?>
<div class="main-content d-flex flex-column">
    <main class="p-5 text-center bg-light flex-grow-1">
        <div class="row">
            <?php
            $abmProducto = new AbmProducto();
            $listaProducto = convert_array($abmProducto->buscar(null));
            if (empty($listaProducto)) {
                // Si no hay productos, muestra un mensaje.
                echo '<p>No hay productos disponibles en este momento.</p>';
            } else {
                foreach ($listaProducto as $producto) {
                    if ($producto["procantstock"] >= 1 && $producto["prodeshabilitado"] == NULL) {
            ?>
                         <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card">
                            <img src="<?php echo $producto["proimg"]; ?>" class="card-img-top" alt="<?php echo $producto["pronombre"]; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $producto["pronombre"]; ?></h5>
                                    <p class="card-text"><?php echo $producto["prodetalle"]; ?></p>
                                    <p class="card-text">$<?php echo $producto["proimporte"]; ?></p>
                                    <div class="text-center">
                                       
                                 <a class="btn btn-success" href="AccionAgregarCarrito&idproducto=<?php echo $producto["idproducto"]; ?>">Agregar al carrito</a>

                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            }
            ?>
        </div>
    </main>
</div>

<?php include(STRUCTURE_PATH . "pie.php"); ?>
