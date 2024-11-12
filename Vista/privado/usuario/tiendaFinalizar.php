<?php 
include_once("../../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h1 class="display-5 pb-3 fw-bold">Estado compra</h1>
                <a href="tienda.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            <?php
                $datos = data_submitted();
                if ($datos['transaccion'] == "exito"){
                    echo '<h1 class="display-5 pb-3 fw-bold">Operación exitosa. Se esta revisando su compra.</h1>';
                }elseif($datos['transaccion'] == "fallo"){
                    echo '<h1 class="display-5 pb-3 fw-bold">Hubo un error con la compra.</h1>';
                }elseif($datos['transaccion'] == "stock"){
                    echo '<h1 class="display-5 pb-3 fw-bold">Uno de los productos no tiene stock suficiente.</h1>';
                }
            ?>
        </div>
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>