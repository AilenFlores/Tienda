<?php
    include_once("../../configuracion.php");
    $tituloPagina = "Carrito";
    include_once("../estructura/encabezadoPrivado.php");

    if (!$permiso) {
        echo "<a class='btn btn-lg btn-dark text-center text-white float-start position-absolute d-flex justify-content-start mt-2' href='inicio.php'><i class='bi bi-arrow-90deg-left'></i></a>";
        echo "<br><br><br><h1 class='display-5 pb-3 fw-bold'>No puede acceder al carrito de compras ya que no tiene los permisos necesarios en su rol o el menú se encuentra deshabilitado.</h1>";
    // Verifica que el menu padre no se encuentre deshabilitado
    } elseif (($rolActivo -> getIdrol() == $arregloObjMenuRol2[0] -> getObjRol() -> getIdrol()) && (!isset($arregloMenuPadre))) {
        echo "<a class='btn btn-lg btn-dark text-center text-white float-start position-absolute d-flex justify-content-start mt-2' href='inicio.php'><i class='bi bi-arrow-90deg-left'></i></a>";
        echo "<br><br><br><h1 class='display-5 pb-3 fw-bold'>No puede acceder al carrito de compras ya que la página se encuentra deshabilitada en una jerarquía superior del menú.</h1>";
    } elseif (!$subMenuDeshabilitado) {
        echo "<a class='btn btn-lg btn-dark text-center text-white float-start position-absolute d-flex justify-content-start mt-2' href='inicio.php'><i class='bi bi-arrow-90deg-left'></i></a>";
        echo "<br><br><br><h1 class='display-5 pb-3 fw-bold'>No puede acceder al carrito de compras ya que la página se encuentra deshabilitada.</h1>";
    } elseif (!$existeSubMenu) {
        echo "<a class='btn btn-lg btn-dark text-center text-white float-start position-absolute d-flex justify-content-start mt-2' href='inicio.php'><i class='bi bi-arrow-90deg-left'></i></a>";
        echo "<br><br><br><h1 class='display-5 pb-3 fw-bold'>No puede acceder al carrito de compras ya que la página no existe.</h1>";
    } else {
?>

<a class="btn btn-lg btn-dark text-center text-white float-start position-absolute d-flex justify-content-start" href="../paginas/tienda.php"><i class="bi bi-arrow-90deg-left"></i></a>
<h1 class="display-5 pb-3 fw-bold">Carrito</h1>

<?php
    $sesionActual = new Session();
    $objAbmUsuario = new AbmUsuario();
    $usuarioActual = $objAbmUsuario -> buscar(['usnombre' => $sesionActual -> getUsuario() -> getUsnombre(), 'uspass' => $sesionActual -> getUsuario() -> getUspass()]);
    $idUsuario = $usuarioActual[0]->getIdUsuario();
    $arreglo["idusuario"] = $idUsuario;
    $arreglo["metodo"] = "carrito";
    $objAbmCompra = new AbmCompra();
    $listaComprasUsuarioAct = $objAbmCompra->buscar($arreglo);
    echo '<div class="d-flex justify-content-center">
    <table id="detalleCompra" class="easyui-datagrid" style="width:800px"
        toolbar="#toolbarDetalleCompra"
        rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="pronombre" width="85">Nombre del Producto</th>
            <th field="cicantidad" width="50">Cantidad</th>
            <th field="proprecio" width="107">Precio Unitario</th>
            <th field="preciototal" width="90">Precio Total</th>
            <th field="eliminarCompraItem" width="90"></th>
        </tr>
    </thead>
    <tbody></div>';
    if(count($listaComprasUsuarioAct) == 1){
        $arreglo2["idcompra"] = $listaComprasUsuarioAct[0]->getIdcompra();
        $objAbmCompraItem = new AbmCompraItem();
        $listaObjCompraItem = $objAbmCompraItem->buscar($arreglo2);
        $totalCompra = 0;
        foreach($listaObjCompraItem as $compraItem){
            echo "<tr><td>".$compraItem->getObjProducto()->getPronombre()."</td>";
            echo "<td>".$compraItem->getCicantidad()."</td>";
            echo "<td>".$compraItem->getObjProducto()->getProprecio()."</td>";
            $precioTotalProducto = $compraItem->getCicantidad()*$compraItem->getObjProducto()->getProprecio();
            echo "<td>" . $precioTotalProducto . "</td>";
            echo "<td><a href='../accion/tienda/bajaCompraItem.php?idcompraitem=" . $compraItem -> getIdcompraitem() . "'>Eliminar</a></td></tr>";
            $totalCompra = $totalCompra + $precioTotalProducto;
        }
        echo "<tr><td></td><td></td><td>Precio Total de la Compra:</td>
        <td>".$totalCompra."</td><td></td></tr>";
        echo "</tbody></table>";
        echo '<form method="post" action="tiendaConfirmar.php">';
        echo '<input type="hidden" name="idcompra" id="idcompra" value="' . $listaComprasUsuarioAct[0] -> getIdcompra() . '"></div>';
        echo '<div class="mt-5 text-center"><input type="submit" class="btn btn-dark" id="compra" name="compra" value="Comprar"></form>';
        echo '<a href="../accion/tienda/bajaCompra.php" class="btn btn-secondary" style="margin-left:20px;">Cancelar Compra</a>';
    }
?>

<?php
    }
    include_once("../estructura/pie.php");
?>