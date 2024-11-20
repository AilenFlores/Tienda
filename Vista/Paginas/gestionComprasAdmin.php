<?php 
include_once("../Estructura/CabeceraSegura.php");
?>
<title>Basic CRUD  - Menu y Menu Rol </title>

<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">
    Gestión - Compra
</h2>

<!-- Tabla para gestionar CompraEstado -->
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <!-- Tabla para gestionar CompraEstado -->
<div style="display: flex; justify-content: center; width: 100%; margin-bottom: 20px;">
    <table id="dg" title="Administrador de Compra-Estado" class="easyui-datagrid" style="width:1200px;height:350px;"
           url="../accion/listarCompraEstado.php"
           toolbar="#toolbar" pagination="true"
           rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idcompraestado" width="50">Id Compra Estado</th>
                <th field="idcompra" width="40">Id Compra</th>
                <th field="idcompraestadotipo" width="65">Id CompraEstadoTipo</th>
                <th field="cetdescripcion" width="40">Estado</th>
                <th field="cefechaini" width="55">Fecha de inicio</th>
                <th field="cefechafin" width="50">Fecha de fin</th>
                <th field="usnombre" width="50">Comprador</th>
            </tr>
        </thead>
    </table>
</div>


    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="siguienteEstadoAdmi()">Siguiente Estado</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="cancelarCompraEstadoAdmi()">Cancelar Compra</a>
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
            <div>
                <input type="hidden" name="usnombre" value="">
            </div>
        </form>
    </div>
    <div id="dlgCompraEstado-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCompraEstadoAdmi()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCompraEstado').dialog('close')" style="width:90px">Cancelar</a>
    </div>
</div>
<br>

<!-- Tabla para mostrar el detalle de la compra -->

<div id="dlgDetalleCompra" class="easyui-dialog" style="width:600px;" data-options="closed:true,modal:true,border:'thin',buttons:'#dlgDetalleCompra-buttons'">
    <table id="detalleCompraTable" style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">Producto</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Cantidad</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Precio Unitario</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Precio Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- Se llenará dinámicamente con JavaScript -->
        </tbody>
    </table>
    <div id="totalCompra" style="text-align: right; font-weight: bold; margin-top: 10px;">Total de la Compra: 0</div>
</div>



<?php include(STRUCTURE_PATH . "pie.php"); ?>