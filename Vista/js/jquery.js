////////////////////////////////////////////////////////////////////////////////////////Funciones para cancelar compra y ver detalles en MIS COMPRAS del cliente.
//Funciones para la gestion de compras del Cliente
function cancelarCompraCliente() {
    var row = $('#dgSeg').datagrid('getSelected');
    if (row) {
        let r = window.confirm('¿Seguro que desea cancelar la CompraEstado?');
        if (r) {
            console.log('Confirmación recibida');
            
            // Llenar el formulario con los datos de la fila seleccionada
            $('#fmSeg [name="idcompraestado"]').val(row.idcompraestado || '');
            $('#fmSeg [name="idcompra"]').val(row.idcompra || '');
            $('#fmSeg [name="idcompraestadotipo"]').val(row.idcompraestadotipo || '');
            $('#fmSeg [name="cefechaini"]').val(row.cefechaini || '');
            $('#fmSeg [name="cefechafin"]').val(row.cefechafin || '');

            // Serializa los datos del formulario
            var formData = $('#fmSeg').serialize();

            // Muestra los datos serializados en la consola
            console.log("Datos en formData:", formData);

            // Realizar la solicitud AJAX
            $.ajax({
                url: 'accion/cancelarCompraCliente.php',
                type: 'POST',
                data: formData,
                success: function(result) {
                    try {
                        var result = JSON.parse(result);
                        
                        if (result.errorMsg) {
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $.messager.show({
                                title: 'Operación exitosa',
                                msg: result.respuesta
                            });
                            $('#dgSeg').datagrid('reload'); 
                        }
                    } catch (e) {
                        console.error("Error al parsear el resultado:", e);
                        console.log("Respuesta del servidor:", result);
                        $.messager.show({
                            title: 'Error',
                            msg: 'Ocurrió un problema con la respuesta del servidor.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                    $.messager.show({
                        title: 'Error',
                        msg: 'No se pudo procesar la solicitud. Error en la conexión.'
                    });
                }
            });
        } else {
            console.log('Cancelación recibida');
        }
    }
}






function verDetalleCliente(){
    var row = $('#dgSeg').datagrid('getSelected');
    if (row){
        window.location.href = "detalleCompra.php?idcompra="+row.idcompra;    
    }                       
}

///Funciones para la gestion de compras del Administrador
function siguienteEstado(){
    var row = $('#dgCompraEstado').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirmar','Seguro que desea avanzar la CompraEstado?',function(r){
            if (r){
                $('#fmCompraEstado').form('load',row);
                url = '../privado/administrador/compras/accion/siguienteEstadoCompra.php';
                $('#fmCompraEstado').form('submit',{
                    url: url,
                    iframe: false,
                    onSubmit: function(){
                        return $(this).form('validate');
                    },
                    success: function(result){
                        var result = eval('('+result+')');
                        if (result.errorMsg){
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $.messager.show({
                                title: 'Operacion exitosa',
                                msg: result.respuesta
                            });
                            $('#dgCompraEstado').datagrid('reload');    // reload the menu data
                        }
                    }
                });
            }
        });
    }
}

function cancelarCompraEstado(){
    var row = $('#dgCompraEstado').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirmar','Seguro que desea cancelar la CompraEstado?',function(r){
            if (r){
                $('#fmCompraEstado').form('load',row);
                url = '../privado/administrador/compras/accion/cancelarCompraEstado.php';
                $('#fmCompraEstado').form('submit',{
                    url: url,
                    iframe: false,
                    onSubmit: function(){
                        return $(this).form('validate');
                    },
                    success: function(result){
                        var result = eval('('+result+')');
                        if (result.errorMsg){
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $.messager.show({
                                title: 'Operacion exitosa',
                                msg: result.respuesta
                            });
                            $('#dgCompraEstado').datagrid('reload');    // reload the menu data
                        }
                    }
                });
            }
        });
    }
}

function muestraDetalleCompra(){
    var row = $('#dgCompraEstado').datagrid('getSelected');
    if (row){
        window.location.href = "detalleCompra.php?idcompra="+row.idcompra;    
    }
}

////////////////////////////////////////////////////////////////////////////// Productos

function editarImagen(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $('#dlgImg').dialog('open').dialog('center').dialog('setTitle','Editar Imagen');
        $('#fmImg').form('load',row);
        url = '../accion/accionEditarImagen.php';    
    }
    else {
        $.messager.alert('Advertencia', 'Seleccione un producto primero.', 'warning');
    }
}

function guardarImagen(){
    $('#fmImg').form('submit', {
        url: url,  
        onSubmit: function(){
            return $(this).form('validate');  
        },
        success: function(result){
            try {
                var result = JSON.parse(result);
                // Verifica si hay un mensaje de error
                if (result.errorMsg) {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg  // Muestra el mensaje de error
                    });
                } else {
                    $.messager.show({
                        title: 'Operación exitosa',
                        msg: "Imagen actualizada correctamente."
                    });

                    $('#dlgImg').dialog('close');
                    $('#dgImg').datagrid('reload');  
                }
            } catch (e) {
                $.messager.show({
                    title: 'Error',
                    msg: 'Error al procesar la respuesta del servidor.'
                });
            }
        }
    });
}


//Funcion para abrir el dialogo de editar productos
function editarProductos(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Producto');
        $('#fm').form('load',row);
        // Ocultar el campo de la imagen
        $('#fm').find('input[name="proimg"]').closest('div').hide();
        url = '../accion/accionEditarProductos.php';    
    }
    else {
        $.messager.alert('Advertencia', 'Seleccione un producto primero.', 'warning');
    }
}

//Funcion para abrir el dialogo de nuevo producto
function nuevoProductos(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Producto');
    $('#fm').form('clear');
    // Mostrar el campo de la imagen
    $('#fm').find('input[name="proimg"]').closest('div').show();
    url = '../accion/accionAltaProductos.php';
}

// Función para guardar los productos
function saveProductos(){
    let nombre = $('#pronombre').val();
    if (nombre === '') {
        $.messager.show({
            title: "Nombre inválido",
            msg: 'Ingrese un nombre válido.',
            showType: 'show'
        });
        return false; 
    }

    let detalle = $('#prodetalle').val();
    if (detalle === '') {
        $.messager.show({
            title: "Detalle inválido",
            msg: 'Ingrese un detalle válido.',
            showType: 'show',
        });
        return false;
    }
    
    let stock = $('#prostock').val();
    if (stock === '' || parseInt(stock) <= 0) {
        $.messager.show({
            title: "Stock inválido",
            msg: 'Ingrese un stock válido (número positivo).',
            showType: 'show'
        });
        return false;
    }

    let precio = $('#proimporte').val();
    if (precio === '' || isNaN(precio) || parseFloat(precio) <= 0) {
        $.messager.show({
            title: "Precio inválido",
            msg: 'Ingrese un precio válido (número positivo).',
            showType: 'show'
        });
        return false;
    }
   // console.log($('#fm').find('input[name="proimg"]')); 
   if ($('#fm').find('input[name="proimg"]').val() === '') {
    //alert('Seleccione una imagen');
    $.messager.show({
        title: 'Imagen',
        msg: 'Seleccione una imagen formato jpeg o jpg.',
        showType: 'show'
    });
    return false;
}

    $('#fm').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            try {
                let resultObj = JSON.parse(result);
                console.log(resultObj);
                if (resultObj.respuesta){
                    $.messager.show({
                        title: 'Operacion exitosa',
                        msg: "Los datos se enviaron correctamente."
                    });
                }

                if (!resultObj.respuesta){
                    $.messager.show({
                        title: 'Error',
                        msg: resultObj.errorMsg
                    });
                } else {
                    $('#dlg').dialog('close');       
                    $('#dg').datagrid('reload');    
                }
            } catch (e) {
                $.messager.show({
                    title: 'Error',
                    msg: 'Error al procesar la respuesta del servidor.'
                });
            }
        }
    });
}


//Funcion para habilitar O deshabilitar productos
function bajaProductos(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm', '¿Seguro que desea cambiar el estado?', function(r){
            if (r){
                $.post('../accion/accionBajaProductos.php', { idproducto: row.idproducto },
                function(result){
                    if (result.respuesta){
                        $('#dg').datagrid('reload'); // recargar los datos
                        } else {
                            $.messager.show({ // mostrar mensaje de error
                                title: 'Error',
                                 msg: result.errorMsg || 'Error al eliminar el producto.'
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

///////////////////////////////////////////////////////////////////////////////////////////// Roles

//Funcion para abrir el dialogo de editar roles
function editarRol(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Rol');
        $('#fm').form('load',row);
        url = '../accion/accionEditarRol.php';    
    }
    else {
        $.messager.alert('Advertencia', 'Seleccione un rol primero.', 'warning');
    }
}

//Funcion para abrir el dialogo de nuevo rol
function nuevoRol(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Agregar nuevo Rol');
    $('#fm').form('clear');
    url = '../accion/accionAltaRol.php';
}

//Funcion para guardar los roles
function saveRol(){
    var nombre = $('#roDescripcion').val().trim();
    if (nombre === '') {
        $.messager.show({
            title: "Nombre invalido",
            msg: 'Ingrese un nombre valido.',
            showType: 'show'
        });
        return false; 
    }
    $('#fm').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if (result.respuesta){
                $.messager.show({
                    title: 'Operacion exitosa',
                    msg: "Los datos se enviaron correctamente."
                });
            }
          
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

//Funcion para habilitar O deshabilitar roles
function bajaRol(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm', '¿Seguro que desea eliminar el rol?', function(r){
            if (r){
                $.post('../accion/accionBajaRol.php', { idRol: row.idRol },
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
                            $.messager.alert('Error', 'El rol esta asociado a un usuario.', 'error');
                        });
                    }
                });
            } else {
                $.messager.alert('Advertencia', 'Seleccione un rol primero.', 'warning');
            }
        }

////////////////////////////////////////////////////////////////////////////////////////////// Usuarios Admin
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

    //funcion para guardar la contraseña nueva en admin usuarioRol
function savePassword() {
    var pass = $('#passNew').val().trim();
    if (pass === '' || pass.length < 8) {
        $.messager.show({
            title: 'Contraseña',
            msg: 'Por favor, ingrese una contraseña válida (mínimo 8 caracteres).',
            showType: 'show'
        });
        return false; 
    }
    // Encriptación de la contraseña antes del envio al servidor
    var encryptedPassword = CryptoJS.SHA256(pass).toString();
    var formData = $('#fmPass').serializeArray(); 
    formData = formData.map(function(field) {
        if (field.name === 'passNew') {
            field.value = encryptedPassword;  
        }
        return field;
    });
    $.ajax({
        url: "../accion/accionPassUsuarios.php",
        method: "POST",
        data: $.param(formData), 
        success: function(result) {
            var result = eval('(' + result + ')');
            if (result) {
                $('#dlgPass').dialog('close');
                // Recarga la tabla de datos
                $('#dg').datagrid('reload');
                if (result.respuesta){
                    $.messager.show({
                        title: 'Operacion exitosa',
                        msg: "Los datos se enviaron correctamente."
                    });
                }
            }
        }
    });
}
// Funcion para abrir el dialogo de editar usuarios
function cargarRolesUsuarios(callback) {
    $.ajax({
        url: '../accion/accionRolesExistUsuarios.php',
        method: 'GET',
        dataType: 'json',
        success: function(roles) {
            // Llenar los roles en el formulario
            var rolesContainer = $('div[style="display: flex; flex-wrap: wrap; gap: 15px;"]');
            rolesContainer.empty();  // Limpiar los roles previos

            // Iterar sobre los roles y agregarlos al formulario
            roles.forEach(function(rol) {
                var checkbox = $('<div>', {style: 'display: flex; align-items: center;'});
                var input = $('<input>', {
                    type: 'checkbox',
                    name: 'usRol[]',
                    id: 'rol_' + rol.idRol,
                    value: rol.idRol,
                    style: 'margin-right: 5px;'
                });
                var label = $('<label>', {
                    for: 'rol_' + rol.idRol,
                    text: rol.roDescripcion
                });

                checkbox.append(input).append(label);
                rolesContainer.append(checkbox);
            });

            if (callback) callback(roles);
        },
        error: function() {
            alert('Error al cargar los roles');
        }
    });
}

// Función para marcar los roles que existen en la base de datos en el formulario
function marcarRolesSeleccionados(row) {
    if (row && row.idRol && Array.isArray(row.idRol)) {
        // Limpiar la selección previa de checkboxes
        $('input[name="usRol[]"]').prop('checked', false); // Desmarcar todos los checkboxes

        // Iterar sobre cada rol y marcar el checkbox correspondiente
        row.idRol.forEach(function(rolId) {
            $('#rol_' + rolId).prop('checked', true);
        });
    }
}

// Funcion para abrir el dialogo de editar usuarios sin el campo password
function editarUsuarios() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Menu');
        $('#fm').form('load', row);
        // Ocultar el campo de la contraseña
        $('#fm').find('input[name="usPass"]').closest('div').hide();
        url = '../accion/accionEditarUsuarios.php'; 
        
        // Cargar los roles y luego marcar los seleccionados
        cargarRolesUsuarios(function(roles) {
            marcarRolesSeleccionados(row); // Marcar los roles seleccionados después de cargar los roles
        });
    }
    else {
        $.messager.alert('Advertencia', 'Seleccione un usuario primero.', 'warning');
    }
}

// Funcion para abrir el dialogo de nuevo usuarios con el campo password
function nuevoUsuarios(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','Agregar Nuevo Usuario');
    $('#fm').form('clear');
    // Mostrar el campo de la contraseña
    $('#fm').find('input[name="usPass"]').closest('div').show();
    url = '../accion/accionAltaUsuarios.php';
    //carga los roles en el formulario
    cargarRolesUsuarios(); }


// Funcion para guardar los usuarios 
    function saveUsuarios() {
        var nombre = $('#usNombre').val().trim();
        if (nombre === '') {
            $.messager.show({
                title: 'Error',
                msg: 'Por favor, ingrese un nombre.',
                showType: 'show'
            });
            return false; 
        }
    
        var mail = $('#usMail').val().trim();
        if (mail === '' || !mail.includes('@')) {
            $.messager.show({
                title: 'Error',
                msg: 'Por favor, ingrese un correo electrónico válido.',
                showType: 'show'
            });
            return false; 
        }
    
        var pass = $('#usPass').val().trim();
        if (pass === '' || pass.length < 8) {
            $.messager.show({
                title: 'Error',
                msg: 'Por favor, ingrese una contraseña válida (mínimo 8 caracteres).',
                showType: 'show'
            });
            return false;
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

        const checkboxes = document.querySelectorAll('input[name="usRol[]"]');
        const selectedCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);
        // Verifica que solo uno esté seleccionado
        if (selectedCheckboxes.length === 0 || selectedCheckboxes.length > 1) {
        $.messager.show({
            title: 'Error',
            msg: 'Por favor, seleccione un rol.',
            showType: 'show'
        });
        return false;
    } 
        
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
                    $('#dlg').dialog('close'); 
                    $('#dg').datagrid('reload'); 
                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: result.errorMsg,
                        showType: 'show'
                    });
                }
            },
        });
        return false; 
    }
    
    

//Funcion para habilitar O deshabilitar usuarios 
 function bajaUsuarios(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm', '¿Seguro que desea cambiar el estado?', function(r){
            if (r){
                $.post('../accion/accionBajaUsuarios.php', { idUsuario: row.idUsuario },
                function(result){
                    if (result.respuesta){
                     $('#dg').datagrid('reload'); 
                        } else {
                            $.messager.show({
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

////////////////////////////////////////////////////////////////////////////////Menu
// Función para cargar los roles en el formulario de menú
function cargarRolesMenu(callback) {
    $.ajax({
        url: '../accion/accionRolesExistMe.php',
        method: 'GET',
        dataType: 'json',
        success: function(roles) {
            // Llenar los roles en el formulario
            var rolesContainer = $('div[style="display: flex; flex-wrap: wrap; gap: 15px;"]');
            rolesContainer.empty();  

            // Iterar sobre los roles y agregarlos al formulario
            roles.forEach(function(rol) {
                var checkbox = $('<div>', {style: 'display: flex; align-items: center;'});
                var input = $('<input>', {
                    type: 'checkbox',
                    name: 'meRol[]',
                    id: 'rol_' + rol.idRol,
                    value: rol.idRol,
                    style: 'margin-right: 5px;'
                });
                var label = $('<label>', {
                    for: 'rol_' + rol.idRol,
                    text: rol.roDescripcion
                });

                checkbox.append(input).append(label);
                rolesContainer.append(checkbox);
            });
            if (callback) callback(roles);
        },
        error: function() {
            alert('Error al cargar los roles');
        }
    });
}

// Función para marcar los roles seleccionados en el formulario
function marcarRolesSeleccionados(row) {
    if (row && row.idRol && Array.isArray(row.idRol)) {
        $('input[name="meRol[]"]').prop('checked', false); // Desmarcar todos los checkboxes
        // Iterar sobre cada rol y marcar el checkbox correspondiente
        row.idRol.forEach(function(rolId) {
            $('#rol_' + rolId).prop('checked', true);
        });
    }
}
// Funcion para abrir el dialogo de editar menu en el que se cargan los roles dinamicamente 
function editarMenu() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Menu');
        $('#fm').form('load', row);
        url = '../accion/accionEditarMenu.php'; 
        
        // Cargar los roles y luego marcar los seleccionados
        cargarRolesMenu(function(roles) {
            marcarRolesSeleccionados(row); // Marcar los roles seleccionados después de cargar los roles
        });
    }
  else {
        $.messager.alert('Advertencia', 'Seleccione un menu primero.', 'warning');
    }
}

// Funcion para abrir el dialogo de nuevo menu en el que se cargan los roles dinamicamente
function nuevoMenu() {
    // Abrir el diálogo para nuevo menú
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Menu');
    $('#fm').form('clear');
    url = '../accion/accionAltaMenu.php'; 

    // Cargar los roles sin marcar ninguno (para nuevo menú)
    cargarRolesMenu();
}

//Funcion para guardar los menus 
function saveMenu(){
    var nombre = $('#menombre').val().trim();
    if (nombre === '') {
        $.messager.show({
            title: 'Nombre Invalido',
            msg: 'Por favor, ingrese un nombre valido.',
            showType: 'show'
        });
        return false; 
    }
    var descripcion = $('#medescripcion').val().trim();
    if (descripcion === '') {
        $.messager.show({
            title: 'URL Invalida',
            msg: 'Por favor, ingrese una URL valida.',
            showType: 'show'
        });
        return false; 
    }

    const checkboxes = document.querySelectorAll('input[name="meRol[]"]');
    const selectedCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);
    // Verifica que solo uno esté seleccionado
    if (selectedCheckboxes.length === 0 || selectedCheckboxes.length > 1) {
        $.messager.show({
            title: 'Advertencia',
            msg: 'Por favor, seleccione solo un rol.',
            showType: 'show'
        });
        return false;
    }

    $('#fm').form('submit',{
        url: url,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
           // alert("Accion Correcta");   
           if (result.respuesta){
                $.messager.show({
                    title: 'Operacion exitosa',
                    msg: "Los datos se enviaron correctamente."
                });
            }
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

//Funcion para habilitar O deshabilitar menus
function bajaMenu(){
    var row = $('#dg').datagrid('getSelected');
    if (row){
        $.messager.confirm('Confirm', '¿Seguro que desea cambiar el estado del menu?', function(r){
            if (r){
                $.post('../accion/accionBajaMenu.php', { idmenu: row.idmenu },
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
                $.messager.alert('Advertencia', 'Seleccione un menu primero.', 'warning');
            }
        }


//////////////////////////////////////Editar Usuario Perfil
// funcion para cargar los datos del usuario en el formulario de editar perfil dinamicamente
$(document).ready(function() {
    if ($('#formUsuario').length) {
        cargarDatosUsuario(); // Llamar a la función cargarDatosUsuario() cuando el formulario esté presente
    }
});

function cargarDatosUsuario() {
    $.ajax({
        url: '../accion/accionListarUsuario.php',
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

// funcion para cargar los datos del usuario en el formulario de editar perfil dinamicamente
$(document).ready(function() {
    if ($('#formPass').length) {
        cargarPass(); // Llamar a la función cargarDatosUsuario() cuando el formulario esté presente
    }
});

function cargarPass() {
    $.ajax({
        url: '../accion/accionListarUsuario.php',
        method: 'POST',
        dataType: 'json',
        success: function(data) {
            console.log(data);  // Verifica la respuesta
            if (data) {
                $('#idUsuarioPass').val(data[0].idUsuario);
                console.log(data[0].idUsuario);
            } else {
                console.log("Datos incompletos o nulos.");
            }
        },
        error: function(xhr, status, error) {
            console.log("Error en la petición AJAX: " + error);
        }
    });
}





