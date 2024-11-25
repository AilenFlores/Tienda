<?php 
include_once("../Estructura/CabeceraSegura.php"); 
?>

<title>Basic CRUD  - Productos </title>
<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">Gestión - Productos</h2>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Administrador de Productos" class="easyui-datagrid" style="width:1200px;height:350px;"
        url="../accion/accionListarProductos.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
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
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="bajaProductos()">Habilitar/Deshabilitar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarImagen()">Cambiar Imagen</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
<form id="fm" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
    <input type="hidden" name="idproducto" id="idproducto">
    
    <div style="margin-bottom:10px">
        <input name="pronombre" id="pronombre" class="easyui-textbox" label="Nombre:" required="true" style="width:80%">
    </div>
    <div style="margin-bottom:10px">
        <input name="prodetalle" id="prodetalle" class="easyui-textbox"  label="Detalle:" required="true" style="width:100%">
    </div>
    <div style="margin-bottom:10px">
        <input name="procantstock" id="procantstock" class="easyui-textbox" type="number" required="true" label="Stock:" style="width:50%">
    </div>
    <div style="margin-bottom:10px">
        <input name="proimporte" id="proimporte" class="easyui-textbox"  type="number" label="Importe:" required="true" style="width:50%">
    </div>
    
    <!-- Campo para cargar la foto -->
    <div style="margin-bottom:10px">
        <input name="proimg" id="proimg"  accept=".jpg,.jpeg" class="easyui-filebox" label="Imagen jpg:" labelPosition="top" data-options="prompt:'Elige un archivo jpg...'" style="width:100%" >
    </div>

</form>

<!-- Diálogo para cambiar la imagen -->
<div id="dlgImg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-img-buttons'">
    <form id="fmImg" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
        <!-- Campo para cargar la imagen -->
        <input type="hidden" name="idproducto" id="idproducto">
        <div style="margin-bottom:10px">
            <input name="proimgNew" id="proimgNew" required="true" accept=".jpg,.jpeg" class="easyui-filebox" label="Imagen jpg:" labelPosition="top" data-options="prompt:'Elige un archivo...'" style="width:100%">
        </div>
    </form>

    <!-- Botones del diálogo -->
    <div id="dlg-img-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="guardarImagen()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgImg').dialog('close')" style="width:90px">Cancelar</a>
    </div>
</div>

</div>

<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProductos()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
</div>

 <?php include(STRUCTURE_PATH . "pie.php"); ?>
