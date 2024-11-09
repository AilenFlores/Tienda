<?php 
include_once("../../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h1 class="display-5 pb-3 fw-bold">Tienda</h1>
                <a href="../index.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>


    <?php
    $objAbmProducto = new AbmProducto();
    $arregloProductos = $objAbmProducto -> buscar(NULL);
    echo '<div class="row text-center">';
        foreach ($arregloProductos as $producto){
            if ($producto -> getProdeshabilitado() == NULL && $producto -> getProcantstock() > 0) {
                echo "<div class='col-3 mb-5'>";
                echo "    <div class='card text-white bg-dark'>";
                $archivo = "../../img/productos/" . $producto->getIdproducto() . ".jpg";
                if (file_exists($archivo)){
                    echo "    <img src='../../img/productos/" . $producto -> getIdproducto() . ".jpg' class='card-img-top rounded-bottom' alt='articulo de tienda'>";
                } else {
                    echo "    <img src='../../img/productos/0.jpg' class='card-img-top rounded-bottom' alt='articulo de tienda'>";
                }
                echo "        <div class='card-body'>";
                echo "            <h5 class='card-title fw-bolder'>" . $producto -> getPronombre() . "</h5>";
                echo "            <a href='productos.php?idproducto=" . $producto -> getIdproducto() . "' class='stretched-link'></a>";
                echo "            <p class='card-text'>Precio: $" . $producto -> getProImporte() . "</p>";
                echo "        </div>";
                echo "    </div>";
                echo "</div>";
            }
        }
    echo '</div>';
?>



        </div>
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>