<?php
include_once("../Estructura/CabeceraSegura.php");
?>

<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <!-- Encabezado de la tarjeta -->
            <div class="card-header bg-white border-bottom-0 text-center position-relative">
                <h1 class="fw-bold text-dark text-uppercase" style="letter-spacing: 1px; font-size: 2.5rem;"> Tienda</h1>
                <hr class="mt-3 mb-0" style="height: 3px; background-color: #6c757d; border: none; width: 50%; margin: auto;">
                <a href="../home/index.php" class="btn btn-outline-secondary btn-sm position-absolute" style="top: 10px; right: 10px;">Volver</a>
            </div>

            <?php
            // Obtener productos
            $objAbmProducto = new AbmProducto();
            $arregloProductos = $objAbmProducto->buscar(NULL);

            echo '<div class="row text-center g-4 py-4 mx-auto">';
            foreach ($arregloProductos as $producto) {
                // Mostrar productos habilitados y con stock mayor a 0
                if ($producto->getProdeshabilitado() === NULL && $producto->getProcantstock() > 0) {
                    echo '<div class="col-12 col-md-4 mb-4">'; 
                    echo '    <div class="card h-100 text-dark bg-light border" style="border-color: #6c757d; cursor: pointer; transition: transform 0.3s ease;" onclick="verProducto(' . $producto->getIdproducto() . ')">';

                    // Verificar si la imagen del producto existe
                    $archivo = "../img/productos/" . $producto->getIdproducto() . ".jpg";
                    if (file_exists($archivo)) {
                        echo '        <img src="' . $archivo . '" class="card-img-top rounded-3" alt="artículo de tienda" style="object-fit: cover; height: 250px;">';
                    } else {
                        echo '        <img src="../img/productos/0.jpg" class="card-img-top rounded-3" alt="artículo de tienda" style="object-fit: cover; height: 250px;">';
                    }

                    // Información del producto
                    echo '        <div class="card-body">';
                    echo '            <h5 class="card-title fw-bolder">' . htmlspecialchars($producto->getPronombre()) . '</h5>';
                    echo '            <p class="card-text text-muted">Precio: <span class="text-success">$' . number_format($producto->getProImporte(), 2) . '</span></p>';
                    echo '        </div>';

                    echo '    </div>';
                    echo '</div>';
                }
            }
            echo '</div>';
            ?>
        </div>
    </div>
</main>

<!-- Cuadro de diálogo con EasyUI para mostrar los detalles del producto -->
<div id="dlg" class="easyui-dialog" style="width:600px;" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <div id="dlg-content"></div>
</div>

<!-- Botones del cuadro de diálogo -->
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="javascript:$('#dlg').dialog('close')" style="width:90px;">Cerrar</a>
</div>

<?php
include(STRUCTURE_PATH . "pie.php");
?>
