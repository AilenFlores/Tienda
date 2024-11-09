// Productos

function editarProductos(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Producto');
        $('#fm').form('load',row);
        url = 'accion/accionEditar.php';    
    }
    else {
        $.messager.alert('Advertencia', 'Seleccione un producto primero.', 'warning');
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
                $.messager.alert('Advertencia', 'Seleccione un producto primero.', 'warning');
            }
        }

/////////////////////////// Roles

function editarRol(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Rol');
        $('#fm').form('load',row);
        url = 'accion/accionEditar.php';    
    }
    else {
        $.messager.alert('Advertencia', 'Seleccione un rol primero.', 'warning');
    }
}

function nuevoRol(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Agregar nuevo Rol');
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
                                 msg: result.errorMsg || 'Error al eliminar el rol.'
                                });
                            }}, 'json'
                         ).fail(function(jqXHR, textStatus, errorThrown) {
                            console.log("Error en la solicitud:", textStatus, errorThrown);
                            $.messager.alert('Error', 'No se pudo conectar con el servidor.', 'error');
                        });
                    }
                });
            } else {
                $.messager.alert('Advertencia', 'Seleccione un rol primero.', 'warning');
            }
        }

//////////////// Usuarios
    // Abre el diálogo de cambio de contraseña
    function cambiarContraseña() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $('#dlgPass').dialog('open').dialog('setTitle', 'Cambiar Contraseña');
            $('#fmPass').form('clear');
            $('#idUsuarioPass').val(row.idUsuario);
        } else {
            $.messager.alert('Advertencia', 'Seleccione un usuario primero.', 'warning');
        }
    }

    
function savePassword() {
    var pass = $('#passNew').val().trim();
    if (pass === '' || pass.length < 8) {
        $.messager.show({
            title: 'Error',
            msg: 'Por favor, ingrese una contraseña válida (mínimo 8 caracteres).',
            showType: 'show'
        });
        return false; 
    }
    var encryptedPassword = CryptoJS.SHA256(pass).toString();
    var formData = $('#fmPass').serializeArray(); 
    formData = formData.map(function(field) {
        if (field.name === 'passNew') {
            field.value = encryptedPassword;  
        }
        return field;
    });
    $.ajax({
        url: "accion/accionPass.php",
        method: "POST",
        data: $.param(formData), 
        success: function(result) {
            var result = eval('(' + result + ')');
            if (result) {
                // Cierra el cuadro de diálogo
                $('#dlgPass').dialog('close');
                // Recarga la tabla de datos
                $('#dg').datagrid('reload');
                alert("Cambios Realizados");
            }
        }
    });
}


function editarUsuarios(){
    var row = $('#dg').datagrid('getSelected');   
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Usuario');
        $('#fm').form('load',row);
         // Ocultar el campo de la contraseña
         $('#fm').find('input[name="usPass"]').closest('div').hide();
        url = 'accion/accionEditar.php';
         // Limpiar la selección previa de checkboxes
        $('input[name="usRol[]"]').prop('checked', false); // Desmarcar todos los checkboxes
            if (row.idRol && Array.isArray(row.idRol)) {
           // Iterar sobre cada rol y marcar el checkbox correspondiente
            row.idRol.forEach(function(rolId) {
            $('#rol_' + rolId).prop('checked', true);});
        }
    }
    else {
        $.messager.alert('Advertencia', 'Seleccione un usuario primero.', 'warning');
    }
}

function nuevoUsuarios(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Agregar Nuevo Usuario');
    $('#fm').form('clear');
    // Mostrar el campo de la contraseña
    $('#fm').find('input[name="usPass"]').closest('div').show();

    url = 'accion/accionAlta.php';}



    function saveUsuarios() {
        var nombre = $('#usNombre').val().trim();
        if (nombre === '') {
            $.messager.show({
                title: 'Error',
                msg: 'Por favor, ingrese un nombre.',
                showType: 'show'
            });
            return false; // Prevenir el envío del formulario si el nombre está vacío
        }
    
        var mail = $('#usMail').val().trim();
        if (mail === '' || !mail.includes('@')) {
            $.messager.show({
                title: 'Error',
                msg: 'Por favor, ingrese un correo electrónico válido.',
                showType: 'show'
            });
            return false; // Prevenir el envío del formulario si el correo electrónico no es válido
        }
    
        var pass = $('#usPass').val().trim();
        if (pass === '' || pass.length < 8) {
            $.messager.show({
                title: 'Error',
                msg: 'Por favor, ingrese una contraseña válida (mínimo 8 caracteres).',
                showType: 'show'
            });
            return false; // Prevenir el envío del formulario si la contraseña no es válida
        }

        // Encriptación de la contraseña
        var encryptedPassword = CryptoJS.SHA256(pass).toString();
        var formData = $('#fm').serializeArray();
        
        // Reemplazar la contraseña plana con la cifrada
        formData = formData.map(function(field) {
            if (field.name === 'usPass') {
                field.value = encryptedPassword;
            }
            return field;
        });
        
        // Enviar los datos con AJAX
        $.ajax({
            url: url, 
            type: 'POST',
            data: formData, 
            success: function(result) {
                var result = JSON.parse(result);
                if (result.respuesta) {
                    $.messager.show({
                        title: 'Éxito',
                        msg: 'Los datos se han guardado correctamente.',
                        showType: 'show'
                    });
                    $('#dlg').dialog('close'); // Cerrar el diálogo
                    $('#dg').datagrid('reload'); // Recargar la datagrid
                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg,
                        showType: 'show'
                    });
                }
            },
            error: function(xhr, status, error) {
                $.messager.show({
                    title: 'Error',
                    msg: 'Hubo un error al enviar los datos: ' + error,
                    showType: 'show'
                });
            }
        });
        
        return false; // Prevenir el envío del formulario de manera tradicional
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
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Agregar Nuevo Menu');
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
                $('#dlg').dialog('close');     
                $('#dg').datagrid('reload');  
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
                                 msg: result.errorMsg || 'Error al eliminar el menu.'
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




$(document).ready(function() {
    if ($('#formUsuario').length) {
        cargarDatosUsuario(); // Llamar a la función cargarDatosUsuario() cuando el formulario esté presente
    }
});

function cargarDatosUsuario() {
    $.ajax({
        url: 'accion/accionListar.php',
        method: 'POST',
        dataType: 'json',
        success: function(data) {
            console.log(data);  // Verifica la respuesta
            if (data) {
                $('#idUsuario').val(data[0].idUsuario);
                $('#usNombre').val(data[0].usNombre);
                $('#usMail').val(data[0].usMail);
            } else {
                console.log("Datos incompletos o nulos.");
            }
        },
        error: function(xhr, status, error) {
            console.log("Error en la petición AJAX: " + error);
        }
    });
}





