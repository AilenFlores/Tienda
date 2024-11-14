<?php 
include_once("../../../Estructura/CabeceraSegura.php");
?>
<title>Basic CRUD  - Menu y Menu Rol </title>
<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">Gestión - Compras</h2>

<!-- Tabla para gestionar CompraEstado -->
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Gestión de relación Compra-Estado" class="easyui-datagrid" style="width:1200px;height:350px;"
        url="accion/listarCompraEstado.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idcompraestado" width="20">ID Compra Estado</th>
                <th field="idcompra" width="50">ID Compra</th>
                <th field="idcompraestadotipo" width="60">Id CompraEstadoTipo</th>
                <th field="cetdescripcion" width="20">Estado</th>
                <th field="cefechaini" width="50">Fecha de inicio</th>
                <th field="cefechafin" width="30">Fecha de fin</th>
                <th field="usnombre" width="50">Comprador</th>
            </tr>
        </thead>
    </table>
</div>
<div id="toolbarCompraEstado">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="siguienteEstado()">Siguiente Estado</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="cancelarCompraEstado()">Cancelar Compra</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="muestraDetalleCompra()">Detalles de la Compra</a>
</div>

<div id="dlgCompraEstado" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlgCompraEstado-buttons'">
    <form id="fmCompraEstado" method="post" novalidate style="margin:0;padding:20px 50px">
        <div>
            <input type="hidden" name="idcompraestado" value="idcompraestado">
        </div>
        <div>
            <input type="hidden" name="idcompra" value="idcompra">
        </div>
        <div>
            <input type="hidden" name="idcompraestadotipo" value="idcompraestadotipo">
        </div>
        <div>
            <input type="hidden" name="cefechaini" value="cefechaini">
        </div>
        <div>
            <input type="hidden" name="cefechafin" value="cefechafin">
        </div>
    </form>
</div>
<div id="dlgCompraEstado-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCompraEstado()" style="width:90px">Guardar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCompraEstado').dialog('close')" style="width:90px">Cancelar</a>
</div>
<br>

<!-- Tabla para gestionar CompraItem -->
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Gestión de relación Compra-Item" class="easyui-datagrid" style="width:1200px;height:350px;"
        url="..." toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
            <th field="idcompraitem" width="15">Id Compra Item</th>
                <th field="idproducto" width="10">Id Producto</th>
                <th field="pronombre" width="10">Nombre Producto</th>
                <th field="cicantidad" width="15">Cantidad</th>
                <th field="idcompra" width="10">Id Compra</th>
                <th field="usnombre" width="15">Comprador</th>
            </tr>
        </thead>
    </table>
</div>
<div id="toolbarCompraItem">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="eliminarCompraItem()">Eliminar CompraItem</a>
</div>

<div id="dlgCompraItem" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlgCompraItem-buttons'">
    <form id="fmCompraItem" method="post" novalidate style="margin:0;padding:20px 50px">
        <div>
            <input type="hidden" name="idcompraitem" value="idcompraitem">
        </div>
        <div>
            <input type="hidden" name="idcompra" value="idcompra">
        </div>
    </form>
</div>
<div id="dlgCompraItem-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCompraEstado()" style="width:90px">Guardar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCompraItem').dialog('close')" style="width:90px">Cancelar</a>
</div>

<?php include(STRUCTURE_PATH . "pie.php"); ?>