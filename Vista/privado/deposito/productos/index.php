<?php 
include_once("../../../Estructura/CabeceraSegura.php"); 
?>
<title>Basic CRUD  - Productos </title>
<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">Gestión - Productos</h2>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Administrador de Productos" class="easyui-datagrid" style="width:1200px;height:350px;"
        url="accion/accionListar.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idproducto" width="20">ID</th>
                <th field="pronombre" width="50">Nombre</th>
                <th field="prodetalle" width="80">Detalle</th>
                <th field="procantstock" width="20">Stock</th>
                <th field="proimporte" width="30">Importe</th>
                <th field="prodeshabilitado" width="50">Estado</th>
            </tr>
        </thead>
    </table>
</div>

<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevoProductos()">Nuevo</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarProductos()">Editar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="bajaProductos()">Baja</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Información del Producto</h3>
        <input type="hidden" name="idproducto" id="idproducto">
        
        <div style="margin-bottom:10px">
            <input name="pronombre" id="pronombre" class="easyui-textbox" required="true" label="Nombre:" style="width:80%">
        </div>
        <div style="margin-bottom:10px">
            <input name="prodetalle" id="prodetalle" class="easyui-textbox" required="true" label="Detalle:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <input name="procantstock" id="procantstock" class="easyui-textbox" required="true" label="Stock:" style="width:50%">
        </div>
        <div style="margin-bottom:10px">
            <input name="proimporte" id="proimporte" class="easyui-textbox" required="true" label="Importe:" style="width:50%">
        </div>
        
    </form>
</div>

<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProductos()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
</div>

 <?php include(STRUCTURE_PATH . "pie.php"); ?>
