<?php 
include_once("../Estructura/CabeceraSegura.php"); 
?>
<?php
    $datos = data_submitted();
    $arregloProductos = [];
    if (isset($datos['idproducto'])){
        $objAbmProducto = new AbmProducto();
        $arregloProductos = $objAbmProducto -> buscar($datos);
    }
    $objProducto = NULL;
    if (!empty($arregloProductos)){
        $objProducto = $arregloProductos[0];
    }
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h1 class="display-5 pb-3 fw-bold text-center"><?php echo $objProducto -> getPronombre() ?></h1>
                <a href="tienda.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="card text-white bg-dark">
                        <?php
                            $archivo = "../img/productos/" . $objProducto->getIdproducto() . ".jpg";
                            if (file_exists($archivo)) {
                                echo "<img src='" . $archivo . "' class='card-img-left rounded' alt='producto'>";
                            } else {
                                echo "<img src='../img/productos/0.jpg' class='card-img-left rounded' alt='producto'>";
                            }
                        ?>
                    </div>
                </div>
                <div class="col">
                        <div class="card bg-transparent border border-dark h-100">
                            <div class="card-body">
                                <h5 class="card-title mt-5"></h5>
                                <p><?php echo $objProducto -> getProdetalle() ?></p>
                                <?php
                                    if ($objProducto -> getProcantstock() > 0 && $objProducto -> getProdeshabilitado() == NULL){
                                        echo '<div class="col-12 mt-5">
                                                    <p>Unidades disponibles: ' . $objProducto -> getProCantstock() . '</p>
                                                </div>
                                                <form method="post" action="../accion/accionTienda.php">
                                                <div class="col-12 mt-5">
                                                    <small>Cantidad</small>
                                                    <input type="number" name="cantidad" id="cantidad" value="1" min="1" max="' . $objProducto -> getProcantstock() . '">';
                                                    if (isset($datos['error'])){
                                                        if ($datos['error'] == 1){
                                                            echo '<div style="color:red">Hubo un error con la compra. Intente de nuevo.</div>';
                                                        }
                                                        if ($datos['error'] == 2){
                                                            echo '<div style="color:red">Falta de stock. Revise su carro de compras.</div>';
                                                        }
                                                        
                                                    }
                                                    echo '<input type="hidden" name="idproducto" id="idproducto" value="' . $datos['idproducto'] . '">';
                                                    echo '<input type="hidden" name="maxStock" id="maxStock" value="' . $objProducto ->  getProcantstock() . '">
                                                </div>
                                                <div class="col">
                                                    <input type="submit" class="btn btn-dark mt-5" id="compra" name="compra" value="Agregar al carrito">
                                                </div>
                                                </form>';
                                    }else{
                                        echo '<div class="col-12">
                                                <h6>No disponible por el momento</h6>
                                            </div>';
                                    }
                                ?>
                            </div>
                        </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>