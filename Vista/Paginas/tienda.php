<?php 
include_once("../Estructura/CabeceraSegura.php"); 
?>

<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h1 class="display-5 pb-3 fw-bold">Tienda</h1>
                <a href="../home/index.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

    <?php
    $objAbmProducto = new AbmProducto();
    $arregloProductos = $objAbmProducto->buscar(NULL);
    echo '<div class="row text-center">';
    foreach ($arregloProductos as $producto) {
        if ($producto->getProdeshabilitado() === NULL && $producto->getProcantstock() > 0) {
            echo "<div class='col-3 mb-5'>";
            echo "    <div class='card text-white bg-dark' onclick='verProducto(" . $producto->getIdproducto() . ")' style='cursor:pointer;'>";
            $archivo = "../img/productos/" . $producto->getIdproducto() . ".jpg";
            if (file_exists($archivo)) {
                echo "    <img src='../img/productos/" . $producto->getIdproducto() . ".jpg' class='card-img-top rounded-bottom' alt='artículo de tienda'>";
            } else {
                echo "    <img src='../img/productos/0.jpg' class='card-img-top rounded-bottom' alt='artículo de tienda'>";
            }
            echo "        <div class='card-body'>";
            echo "            <h5 class='card-title fw-bolder'>" . $producto->getPronombre() . "</h5>";
            echo "            <p class='card-text'>Precio: $" . $producto->getProImporte() . "</p>";
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

<!-- Cuadro de diálogo con EasyUI para mostrar los detalles del producto -->
<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <div id="dlg-content"></div>
</div>

<!-- Botones del cuadro de diálogo -->
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cerrar</a>
</div>

<?php include(STRUCTURE_PATH . "pie.php"); ?>