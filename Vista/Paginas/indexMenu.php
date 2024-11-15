<?php 
include_once("../Estructura/CabeceraSegura.php");
?>
<title>Basic CRUD  - Menu y Menu Rol </title>
<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">Gestión - Menus</h2>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Administrador de Menues" class="easyui-datagrid" style="width:1200px;height:350px;"
        url="../accion/accionListarMenu.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idmenu" width="20">ID Menu</th>
                <th field="menombre" width="50">Nombre Menu</th>
                <th field="medescripcion" width="60">URL</th>
                <th field="idpadre" width="20">Padre</th>
                <th field="meRol" width="50"> Roles </th>
                <th field="medeshabilitado" width="30">Estado</th>
            </tr>
        </thead>
    </table>
</div>

<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevoMenu()">Nuevo</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editarMenu()">Editar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="bajaMenu()">Habilitar/Deshabilitar</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <input type="hidden" name="idmenu" id="idmenu">
        <input type="hidden" name="idpadre" id="idpadre">
        <div style="margin-bottom:10px">
            <input name="menombre" id="menombre" class="easyui-textbox" required="true" label="Nombre:" style="width:80%">
        </div>
        <div style="margin-bottom:10px">
            <input name="medescripcion" id="medescripcion" class="easyui-textbox" required="true" label="URL:" style="width:80%">
        </div>
        <div style="margin-bottom:10px">
            <h5>Roles:</h5>
            <div style="display: flex; flex-wrap: wrap; gap: 15px;"> 
            
                    <div style="display: flex; align-items: center; margin-right: 15px;">
                        <input  type="checkbox" name="meRol[]" id="rol_<?php echo $rol['idRol']; ?>" value="<?php echo $rol['idRol']; ?>" style="margin-right: 5px;">
                        <label for="rol_<?php echo $rol['idRol']; ?>"><?php echo $rol['roDescripcion']; ?></label>
                    </div>
              
            </div>
        </div>
    
    </form>
</div>


<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
</div>

 <?php include(STRUCTURE_PATH . "pie.php"); ?>
