<?php
include_once("../../configuracion.php");
include_once(STRUCTURE_PATH . "cabecera.php");
?>
<div class="main-content d-flex flex-column">
    <main class="p-5 text-center bg-light flex-grow-1">
        <div class="row">
            <?php
            $abmProducto = new AbmProducto();
            $listaProducto = $abmProducto->buscar(null);

            if (empty($listaProducto)) {
                // Si no hay productos, muestra un mensaje.
                echo '<p>No hay productos disponibles en este momento.</p>';
            } else {
                foreach ($listaProducto as $producto) {
                    if ($producto->getProcantstock() >= 1) {
            ?>
                        <div class="col-lg-4 mb-4">
                            <div class="card">
                                <img src="../../img/<?php echo $producto->getPronombre(); ?>.jpg" class="card-img-top" alt="<?php echo $producto->getPronombre(); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $producto->getPronombre(); ?></h5>
                                    <p class="card-text"><?php echo $producto->getProdetalle(); ?></p>
                                    <p class="card-text">$<?php echo $producto->getProimporte(); ?></p>
                                    <div class="text-center">
                                       
                                 <a class="btn btn-success" href="AccionAgregarCarrito&idproducto=<?php echo $producto->getIdproducto(); ?>">Agregar al carrito</a>

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
