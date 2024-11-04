<?php 
include_once("../../../Estructura/CabeceraSegura.php"); 
?>
<title>Basic CRUD  - Roles </title>
<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">Gestión - Roles</h2>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Administrador de Roles" class="easyui-datagrid" style="width:800px;height:300px;"
        url="accion/accionListar.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idRol" width="50">ID Rol</th>
                <th field="roDescripcion" width="50">Nombre Rol</th>
            </tr>
        </thead>
    </table>
</div>

<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevoRol()">Nuevo</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarRol()">Editar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="bajaRol()">Baja</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Información del Usuario</h3>
        <input type="hidden" name="idRol" id="idRol">
    
        <div style="margin-bottom:10px">
            <input name="roDescripcion" id="usNombre" class="easyui-textbox" required="true" label="Nombre Rol:" style="width:100%">
        </div>
    
    </form>
</div>

<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveRol()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
</div>


 <?php include(STRUCTURE_PATH . "pie.php"); ?>
