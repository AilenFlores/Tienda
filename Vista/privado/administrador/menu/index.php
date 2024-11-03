<?php 
include_once("../../../Estructura/CabeceraSegura.php");
$objRol = new AbmRol();
$roles = convert_array($objRol->buscar([])); 
?>
<title>Basic CRUD  - Usuarios </title>
<link rel="stylesheet" type="text/css" href="../../../js/jquery-easyui-1.6.6/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="../../../js/jquery-easyui-1.6.6/themes/icon.css">
<link rel="stylesheet" type="text/css" href="../../../js/jquery-easyui-1.6.6/themes/color.css">
<script type="text/javascript" src="../../../js/jquery-easyui-1.6.6/jquery.min.js"></script>
<script type="text/javascript" src="../../../js/jquery-easyui-1.6.6/jquery.easyui.min.js"></script>

<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">Gestión - Menus</h2>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Administrador de Menues" class="easyui-datagrid" style="width:1200px;height:350px;"
        url="accion/accionListar.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idmenu" width="50">ID Menu</th>
                <th field="menombre" width="50">Nombre Menu</th>
                <th field="medescripcion" width="50">URL</th>
                <th field="idpadre" width="50">Padre</th>
                <th field="meRol" width="50"> Roles </th>
                <th field="medeshabilitado" width="50">Estado</th>
            </tr>
        </thead>
    </table>
</div>

<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo()">Nuevo</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editar()">Editar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="baja()">Baja</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Información del Menu</h3>
        <input type="hidden" name="idmenu" id="idmenu">

        <input type="hidden" name="idpadre" id="idpadre">
    
        <div style="margin-bottom:10px">
            <input name="menombre" id="menombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
        </div>

        <div style="margin-bottom:10px">
            <input name="medescripcion" id="medescripcion" class="easyui-textbox" required="true" label="URL:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <h4>Roles:</h4>
            <?php foreach ($roles as $rol): ?>
                <div>
                    <input type="checkbox" name="meRol[]" id="rol_<?php echo $rol['idRol']; ?>" value="<?php echo $rol['idRol']; ?>">
                    <label for="rol_<?php echo $rol['idRol']; ?>"><?php echo $rol['roDescripcion']; ?></label>
                </div>
            <?php endforeach; ?>
        </div>
    
    </form>
</div>

<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Aceptar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
</div>





            
    <script type="text/javascript">
            var url;
            function editar(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Menu');
                    $('#fm').form('load',row);
                    url = 'accion/accionEditar.php'; 
                     // Limpiar la selección previa de checkboxes
                     $('input[name="meRol[]"]').prop('checked', false); // Desmarcar todos los checkboxes
                     if (row.idRol && Array.isArray(row.idRol)) {
                        // Iterar sobre cada rol y marcar el checkbox correspondiente
                        row.idRol.forEach(function(rolId) {
                            $('#rol_' + rolId).prop('checked', true);});
                        }   
                }
            }

            function nuevo(){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Menu');
                $('#fm').form('clear');
                url = 'accion/accionAlta.php';
            }

            function saveMenu(){
                $('#fm').form('submit',{
                    url: url,
                    onSubmit: function(){
                        return $(this).form('validate');
                    },
                    success: function(result){
                        console.log("Respuesta del servidor:", result);
                        var result = eval('('+result+')');
                        alert("Accion Correcta");   
                        if (!result.respuesta){
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $('#dlg').dialog('close');        // close the dialog
                            $('#dg').datagrid('reload');    // reload 
                        }
                    }
                });
            }

           
            function baja(){
                var row = $('#dg').datagrid('getSelected');
                if (row){
                    $.messager.confirm('Confirm', '¿Seguro que desea eliminar?', function(r){
                        if (r){
                            $.post('accion/accionBaja.php', { idmenu: row.idmenu },
                            function(result){
                                if (result.respuesta){
                                    $('#dg').datagrid('reload'); // recargar los datos
                                    } else {
                                        $.messager.show({ // mostrar mensaje de error
                                            title: 'Error',
                                             msg: result.errorMsg || 'Error al eliminar el usuario.'
                                            });
                                        }}, 'json'
                                     ).fail(function(jqXHR, textStatus, errorThrown) {
                                        console.log("Error en la solicitud:", textStatus, errorThrown);
                                        $.messager.alert('Error', 'No se pudo conectar con el servidor.', 'error');
                                    });
                                }
                            });
                        } else {
                            $.messager.alert('Advertencia', 'Seleccione un usuario primero.', 'warning');
                        }
                    }

     </script>

 <?php include(STRUCTURE_PATH . "pie.php"); ?>
