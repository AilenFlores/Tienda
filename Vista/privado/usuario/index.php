<?php 
include_once("../../Estructura/CabeceraSegura.php"); 
?>
<title>Basic CRUD - Usuario</title>
<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">Gestión - Usuario</h2>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Administrador de Usuario" class="easyui-datagrid" style="width:800px;height:200px;"
        url="accion/accionListar.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idUsuario" width="50">ID </th>
                <th field="usNombre" width="50">Nombre </th>
                <th field="usMail" width="50">Mail </th>
            </tr>
        </thead>
    </table>
</div>

<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarUsuario()">Editar</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
<form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
    <h3>Información del Usuario</h3>
    <input type="hidden" name="idUsuario" id="idUsuario">
    
    <div style="margin-bottom:10px">
        <input name="usNombre" id="usNombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
    </div>
    
    <div style="margin-bottom:10px">
        <input name="usPass" id="usPass" class="easyui-textbox" label="Contraseña:" style="width:100%" type="password">
    </div>

    <div style="margin-bottom:10px">
        <input name="usMail" id="usMail" class="easyui-textbox" required="true" label="Mail:" style="width:100%" autocomplete="email">
    </div>
</form>

</div>

<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUsuario()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
</div>





<?php include (STRUCTURE_PATH."pie.php"); ?>
