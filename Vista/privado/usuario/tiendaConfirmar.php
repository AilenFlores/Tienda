<?php 
include_once("../../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h1 class="display-5 pb-3 fw-bold">Confirmar compra</h1>
                <a href="tienda.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            <?php
            $datos=data_submitted();
            if($datos['compra']=="Comprar" && isset($datos['idcompra'])){
                $objAbmCompraItem = new AbmCompraitem();
                $arregloItems = $objAbmCompraItem -> buscar(['idcompra' => $datos['idcompra']]);
                if (!empty($arregloItems)){
                    $totalPagar = 0;
                    foreach($arregloItems as $item){
                        echo '<div class="text-center">Producto: ' . $item -> getObjProducto() -> getPronombre();
                        echo '&nbsp;&nbsp;Cantidad: ' . $item -> getCicantidad() . '</div>';
                        $totalPagar += ( $item -> getObjProducto() -> getProimporte()) * $item->getCicantidad();
                    }
                    echo '<div class="text-center mt-5"><b>Total a pagar: </b>$' . $totalPagar . '</div>';
                    echo '<form method="post" action="accion/accionTiendaConfirmar.php" class="text-center">';
                    echo '<input type="hidden" name="idcompra" id="idcompra" value="' . $datos['idcompra'] . '">';
                    echo '<input type="submit" value="Comprar" class="btn btn-dark m-3"></form>';
                }
            }
            ?>
        </div>
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>