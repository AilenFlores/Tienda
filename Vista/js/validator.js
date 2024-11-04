// Productos
var url;
function editarProductos(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Producto');
        $('#fm').form('load',row);
        url = 'accion/accionEditar.php';    
    }
}

function nuevoProductos(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Producto');
    $('#fm').form('clear');
    url = 'accion/accionAlta.php';
}

function saveProductos(){
    $('#fm').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
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


function bajaProductos(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm', '¿Seguro que desea eliminar?', function(r){
            if (r){
                $.post('accion/accionBaja.php', { idproducto: row.idproducto },
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

/////////////////////////// Roles
var url;
function editarRol(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Rol');
        $('#fm').form('load',row);
        url = 'accion/accionEditar.php';    
    }
}

function nuevoRol(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Rol');
    $('#fm').form('clear');
    url = 'accion/accionAlta.php';
}

function saveRol(){
    $('#fm').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
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


function bajaRol(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm', '¿Seguro que desea eliminar?', function(r){
            if (r){
                $.post('accion/accionBaja.php', { idRol: row.idRol },
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

//////////////// Usuarios
var url;
function editarUsuarios(){
    var row = $('#dg').datagrid('getSelected');   
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Usuario');
        $('#fm').form('load',row);
        url = 'accion/accionEditar.php';
         // Limpiar la selección previa de checkboxes
        $('input[name="usRol[]"]').prop('checked', false); // Desmarcar todos los checkboxes
            if (row.idRol && Array.isArray(row.idRol)) {
           // Iterar sobre cada rol y marcar el checkbox correspondiente
            row.idRol.forEach(function(rolId) {
            $('#rol_' + rolId).prop('checked', true);});
        }
    }
}

function nuevoUsuarios(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Usuario');
    $('#fm').form('clear');
    url = 'accion/accionAlta.php';}

function saveUsuarios(){
    let passwordField = $('#usPass'); 
    let password = passwordField.val();
    if (password) {
        password = CryptoJS.MD5(password).toString();
        passwordField.val(password);
    }
    $('#fm').form('submit',{
    url: url,
    onSubmit: function(){
        return $(this).form('validate');
        },
        success: function(result){
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
           
 function bajaUsuarios(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm', '¿Seguro que desea eliminar?', function(r){
            if (r){
                $.post('accion/accionBaja.php', { idUsuario: row.idUsuario },
                function(result){
                    if (result.respuesta){
                     $('#dg').datagrid('reload'); // recargar los datos
                        } else {
                            $.messager.show({ // mostrar mensaje de error
                            title: 'Error',
                            msg: result.errorMsg || 'Error al eliminar el usuario.'
                        });
                        }}, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                                console.log("Error en la solicitud:", textStatus, errorThrown);
                                $.messager.alert('Error', 'No se pudo conectar con el servidor.', 'error');});}
                            });
                        } else {
                            $.messager.alert('Advertencia', 'Seleccione un usuario primero.', 'warning');
                        }
                    }
//////Menu
var url;
function editarMenu(){
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

function nuevoMenu(){
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


function bajaMenu(){
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

///Usuario
var url;
function editarUsuario(){
    var row = $('#dg').datagrid('getSelected');   
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Usuario');
        $('#fm').form('load',row);
        url = 'accion/accionEditar.php';
    }
}





function saveUsuario(){
    let passwordField = $('#usPass'); // 
    let password = passwordField.val();
    // Encripta la contraseña para que viaje al servidor encriptada
    if (password) {
        password = CryptoJS.MD5(password).toString(); 
        passwordField.val(password);
    }
    $('#fm').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
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
