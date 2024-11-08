<?php 
include_once("../../../Estructura/CabeceraSegura.php"); 
?>
<title>Basic CRUD  - Usuarios </title>
<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">Gestión - Usuarios y Roles</h2>
<div class="container" style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Administrador de usuarios" class="easyui-datagrid" style="width:1100px;height:350px;"
        url="accion/accionListar.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idUsuario" width="30">ID</th>
                <th field="usNombre" width="50">Nombre</th>
                <th field="usMail" width="70">Correo</th>
                <th field="usRol" width="50"> Roles </th>
                <th field="usDeshabilitado" width="50">Estado</th>
            </tr>
        </thead>
    </table>
</div>

<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevoUsuarios()">Nuevo</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarUsuarios()">Editar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="bajaUsuarios()">Habilitar/Deshabilitar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-lock" plain="true" onclick="cambiarContraseña()">Cambiar Contraseña</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
    
        <input type="hidden" name="idUsuario" id="idUsuario">
        
        <div style="margin-bottom:10px">
            <input name="usNombre" id="usNombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <input name="usPass" id="usPass" class="easyui-textbox" required="true" label="Contraseña:" style="width:100%" type="password">
        </div>
        <div style="margin-bottom:10px">
            <input name="usMail" id="usmail" class="easyui-textbox" required="true" label="Correo:" style="width:100%">
        </div>
        <input type="hidden" name="usDeshabilitado" id="usDeshabilitado">

        <div style="margin-bottom:10px">
            <h6>Asignar Roles:</h6>
            <div style="display: flex; flex-wrap: wrap; gap: 15px;"> 
                <?php foreach ($roles as $rol): ?>
                    <div style="display: flex; align-items: center;">
                        <input type="checkbox" name="usRol[]" id="rol_<?php echo $rol['idRol']; ?>" value="<?php echo $rol['idRol']; ?>" style="margin-right: 5px;">
                        <label for="rol_<?php echo $rol['idRol']; ?>"><?php echo $rol['roDescripcion']; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </form>
</div>

<div id="dlgPass" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-pass-buttons'">
<form id="fmPass" method="post" novalidate style="margin:0;padding:20px 50px">

    <input type="hidden" name="idUsuarioPass" id="idUsuarioPass">

    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label for="passNew" style="width: 150px; margin-right: 10px;">Nueva Contraseña:</label>
        <input name="passNew" id="passNew" class="easyui-textbox" required="true" style="flex-grow: 1; width: auto;" type="password">
    </div>
</form>
</div>


<div id="dlg-pass-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="savePassword()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgPass').dialog('close')" style="width:90px">Cancelar</a>
</div>

<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUsuarios()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
</div>


 <?php include(STRUCTURE_PATH . "pie.php"); ?>
