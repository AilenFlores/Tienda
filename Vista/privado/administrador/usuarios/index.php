<?php 
include_once("../../../Estructura/CabeceraSegura.php"); 
$objRol = new AbmRol();
$roles = convert_array($objRol->buscar([]));
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
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="bajaUsuarios()">Baja</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Información del Usuario</h3>
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
        <div style="margin-bottom:10px">
            <h4>Roles:</h4>
            <?php foreach ($roles as $rol): ?>
                <div>
                    <input type="checkbox" name="usRol[]" id="rol_<?php echo $rol['idRol']; ?>" value="<?php echo $rol['idRol']; ?>">
                    <label for="rol_<?php echo $rol['idRol']; ?>"><?php echo $rol['roDescripcion']; ?></label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </form>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUsuarios()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
</div>

 <?php include(STRUCTURE_PATH . "pie.php"); ?>
