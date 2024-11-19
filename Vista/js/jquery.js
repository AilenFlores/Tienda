////////////////////////////////////////////////////////////////////////////////////////
//Funciones para el carrito de compras (finalizar, eliminar y eliminar item)
// Eliminar ítem del carrito
function eliminarItemCarrito(idCompraItem) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará el ítem del carrito.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../accion/accionCarrito.php',
                type: 'POST',
                data: { action: 'eliminarItemCarrito', idcompraitem: idCompraItem },
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Eliminado!',
                            'El ítem ha sido eliminado correctamente.',
                            'success'
                        ).then(() => {;
                            window.location.href = 'tienda.php'; // Redirigir a la tienda
                    })
                    } else {
                        Swal.fire(
                            'Error',
                            'Error al eliminar el ítem: ' + response.message,
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error',
                        'Ocurrió un error en la solicitud.',
                        'error'
                    );
                }
            });
        }
    });
}

// Cancelar compra
function cancelarCompra() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción cancelará la compra y no podrás revertirla.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cancelar compra',
        cancelButtonText: 'No, regresar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../accion/accionCarrito.php',
                type: 'POST',
                data: { action: 'cancelarCompra' },
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Cancelada!',
                            'La compra ha sido cancelada correctamente.',
                            'success'
                        ).then(() => {;
                        window.location.href = 'tienda.php'; // Redirigir a la tienda
                    })
                    } else {
                        Swal.fire(
                            'Error',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error',
                        'Ocurrió un error en la solicitud.',
                        'error'
                    );
                }
            });
        }
    });
}

// Confirmar compra
function confirmarCompra(idCompra) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción confirmará tu compra.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, confirmar compra',
        cancelButtonText: 'No, revisar',
    }).then((result) => {
        if (result.isConfirmed) {
            //cargando
            const loadingSwal = Swal.fire({
                title: 'Cargando...',
                text: 'Por favor, espere mientras procesamos su compra.',
                allowOutsideClick: false,  // Impide que el usuario cierre el alert mientras está mostrando
                didOpen: () => {
                    Swal.showLoading();  // Muestra el ícono de carga
                }
            });
            $.ajax({
                url: '../accion/accionCarrito.php',
                type: 'POST',
                data: { action: 'confirmarCompra', idcompra: idCompra },
                success: function (response) {
                    if (response.success) {
                        loadingSwal.close();
                        Swal.fire(
                            'Confirmada!',
                            'La compra ha sido confirmada correctamente.',
                            'success'
                        ).then(() => {
                        window.location.href = 'tienda.php?transaccion=exito';
                    });
                    }else {
                        Swal.fire(
                            'Error',
                            'Error al confirmar la compra: ' + response.message,
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error',
                        'Ocurrió un error en la solicitud.',
                        'error'
                    );
                }
            });
        }
    });
}

//Funciones para el funcionamiento de la tienda junto al carrito.////
function verProducto(idproducto) {
    $.ajax({
        url: '../accion/accionProductoTienda.php',
        type: 'POST',
        data: { idproducto: idproducto },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                // Verificar si la imagen existe
                const imagen = `../img/productos/${idproducto}.jpg`;
                const imagenPlaceholder = '../img/productos/0.jpg';

                // Comprobar si la imagen existe antes de mostrarla
                $.get(imagen)
                    .done(function () {
                        // Si la imagen existe, mostrarla
                        mostrarDetalleProducto(imagen, response.data, idproducto);
                    })
                    .fail(function () {
                        // Si no existe, usar el placeholder
                        mostrarDetalleProducto(imagenPlaceholder, response.data, idproducto);
                    });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo obtener la información del producto.',
            });
        }
    });
}

function mostrarDetalleProducto(imagen, data, idproducto) {
    const contenido = `
        <div style="text-align: left;">
            <img src="${imagen}" alt="Imagen del producto" style="width: 100%; height: auto; border-radius: 8px; margin-bottom: 15px;">
            <h3>${data.pronombre}</h3>
            <p><strong>Detalle:</strong> ${data.prodetalle}</p>
            <p><strong>Precio:</strong> $${data.proimporte}</p>
            <p><strong>Stock disponible:</strong> ${data.procantstock}</p>
            <div>
                <label for="cantidadProducto">Cantidad:</label>
                <input type="number" id="cantidadProducto" min="1" max="${data.procantstock}" value="1" style="width: 60px; text-align: center;">
            </div>
        </div>
    `;

    Swal.fire({
        title: 'Detalle del Producto',
        html: contenido,
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Agregar al carrito',
        cancelButtonText: 'Cerrar',
        customClass: {
            popup: 'swal-wide' 
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const cantidad = document.getElementById('cantidadProducto').value;
            agregarAlCarrito(idproducto, cantidad);
        }
    });
}

function agregarAlCarrito(idproducto, cantidad) {
    $.ajax({
        url: '../accion/accionTienda.php',
        type: 'POST',
        data: {
            idproducto: idproducto,
            cantidad: cantidad
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message,
                }).then(() => {
                    // Redirigir al carrito después de agregar el producto
                    window.location.href = '../paginas/carrito.php';  
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo agregar el producto al carrito. Inténtalo nuevamente.',
            });
        }
    });
}

//Funciones para la gestion de compras del Cliente
function cancelarCompraCliente() {
    var row = $('#dgSeg').datagrid('getSelected');
    if (row) {
        Swal.fire({
            title: "Confirmación",
            text: "¿Seguro que desea cancelar la CompraEstado?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, cancelar",
            cancelButtonText: "No, volver"
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Confirmación recibida');

                // Llenar el formulario con los datos de la fila seleccionada
                $('#fmSeg [name="idcompraestado"]').val(row.idcompraestado || '');
                $('#fmSeg [name="idcompra"]').val(row.idcompra || '');
                $('#fmSeg [name="idcompraestadotipo"]').val(row.idcompraestadotipo || '');
                $('#fmSeg [name="cefechaini"]').val(row.cefechaini || '');
                $('#fmSeg [name="cefechafin"]').val(row.cefechafin || '');

                var formData = $('#fmSeg').serialize();
                console.log("Datos en formData:", formData);

                // Mostrar cartel de carga
                Swal.fire({
                    title: 'Cargando...',
                    text: 'Procesando su solicitud, por favor espere.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Realizar la solicitud AJAX
                $.ajax({
                    url: '../accion/cancelarCompraCliente.php',
                    type: 'POST',
                    data: formData,
                    success: function (result) {
                        Swal.close(); // Cerrar el cartel de carga
                        try {
                            var result = JSON.parse(result);
                            Swal.fire({
                                title: result.success ? "Operación exitosa" : "Advertencia",
                                text: result.msg,
                                icon: result.success ? "success" : "warning",
                                showConfirmButton: true // Mostrar botón "OK"
                            }).then(() => {
                                if (result.success) {
                                    $('#dgSeg').datagrid('reload'); // Recargar la tabla
                                }
                            });
                        } catch (e) {
                            console.error("Error al parsear el resultado:", e);
                            Swal.fire({
                                title: "Error",
                                text: "Ocurrió un problema con la respuesta del servidor.",
                                icon: "error",
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.close(); // Cerrar el cartel de carga en caso de error
                        console.error("Error en la solicitud AJAX:", error);
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo procesar la solicitud. Error en la conexión.",
                            icon: "error",
                            showConfirmButton: true
                        });
                    }
                });
            } else {
                console.log('Cancelación recibida');
            }
        });
    } else {
        Swal.fire({
            title: "Advertencia",
            text: "Debe seleccionar una compra primero.",
            icon: "warning",
            timer: 2000,
            showConfirmButton: false
        });
    }
}

function verDetalleCliente() {
    var row = $('#dgSeg').datagrid('getSelected');
    if (row) {
        Swal.fire({
            title: "Confirmación",
            text: "¿Seguro que desea ver los detalles de la compra?",
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, ver detalles",
            cancelButtonText: "No, volver"
        }).then((result) => {
            if (result.isConfirmed) { // Cambié "isConfirmed" por "result.isConfirmed"
                console.log('Confirmación recibida');
                window.location.href = "../paginas/detalleCompra.php?idcompra=" + row.idcompra;
            } else {
                console.log('Cancelación recibida');
            }
        });
    } else {
        Swal.fire({
            title: "Advertencia",
            text: "Debe seleccionar una compra primero.",
            icon: "warning",
            timer: 2000,
            showConfirmButton: false
        });
    }
}

function descargarPdf() {
    var row = $('#dgSeg').datagrid('getSelected');
    if (row) {
        Swal.fire({
            title: "Confirmación",
            text: "¿Seguro que desea generar el PDF de la CompraEstado?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, generar PDF",
            cancelButtonText: "No, volver"
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Confirmación recibida');

                // Llenar el formulario con los datos de la fila seleccionada
                $('#fmSeg [name="idcompraestado"]').val(row.idcompraestado || '');
                $('#fmSeg [name="idcompra"]').val(row.idcompra || '');
                $('#fmSeg [name="idcompraestadotipo"]').val(row.idcompraestadotipo || '');
                $('#fmSeg [name="cefechaini"]').val(row.cefechaini || '');
                $('#fmSeg [name="cefechafin"]').val(row.cefechafin || '');

                // Serializar los datos del formulario
                var formData = $('#fmSeg').serialize();

                console.log("Datos en formData:", formData);

                // Realizar la solicitud AJAX
                $.ajax({
                    url: '../accion/generarPdfCliente.php', // Ruta al archivo PHP que genera el PDF
                    type: 'POST',
                    data: formData, // Datos del formulario
                    dataType: 'json', // Esperamos un JSON como respuesta
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'PDF Generado',
                                html: `<p>Tu PDF se ha generado correctamente. Puedes descargarlo desde el siguiente enlace:</p>
                                        <a href="${response.url}" target="_blank" class="btn btn-primary">Descargar PDF</a>`,
                                icon: 'success',
                                showConfirmButton: false, // Ocultar el botón de confirmación
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'Aceptar',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al generar el PDF:', error);
                        console.log('Respuesta completa:', xhr.responseText);  // Ver la respuesta completa
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un problema al intentar generar el PDF.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                        });
                    }
                });
                
            } else {
                console.log('Cancelación recibida');
            }
        });
    } else {
        Swal.fire({
            title: "Advertencia",
            text: "Debe seleccionar una compra primero.",
            icon: "warning",
            timer: 2000,
            showConfirmButton: false
        });
    }
}

///Funciones para la gestion de compras del Deposito
function siguienteEstadoDeposito() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        // Mostrar mensaje de confirmación
        $.messager.confirm('Confirmación', '¿Seguro que desea avanzar la CompraEstado?', function(result) {
            if (result) {
                // Llenar el formulario con los datos de la fila seleccionada
                $('#fmCompraEstado [name="idcompraestado"]').val(row.idcompraestado);
                $('#fmCompraEstado [name="idcompra"]').val(row.idcompra);
                $('#fmCompraEstado [name="idcompraestadotipo"]').val(row.idcompraestadotipo);
                $('#fmCompraEstado [name="cefechaini"]').val(row.cefechaini);
                $('#fmCompraEstado [name="cefechafin"]').val(row.cefechafin);
                $('#fmCompraEstado [name="usnombre"]').val(row.usnombre);

                var formData = $('#fmCompraEstado').serialize();
                // Agregar la nueva variable "accion" al array de datos
                formData += '&accion=deposito';

                // Verificar el estado antes de hacer la solicitud AJAX
                if (row.idcompraestadotipo == 2 || row.idcompraestadotipo == 3 || row.idcompraestadotipo == 4) {
                    // Realizar la solicitud AJAX
                    $.ajax({
                        url: '../accion/siguienteEstadoCompra.php',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $.messager.progress({
                                text: 'Procesando...'
                            });
                        },
                        success: function(result) {
                            var response = result;
                            $.messager.progress('close'); // Cerrar el mensaje de carga

                            if (response.errorMsg) {
                                // Mostrar el mensaje de error si existe
                                $.messager.alert('Error', response.errorMsg,);
                            } else {
                                // Mostrar mensaje de éxito si no hay error
                                $.messager.alert('Operación exitosa', response.respuesta, 'info', function() {
                                    $('#dg').datagrid('reload'); // Recargar los datos de la tabla
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $.messager.progress('close'); // Cerrar el mensaje de carga
                            $.messager.alert('Error', 'No se pudo procesar la solicitud. Error en la conexión.',);
                        }
                    });
                } else if (row.idcompraestadotipo == 1) {
                    $.messager.alert('Error', 'La compra primero debe ser aceptada por el Administrador.');
                }
            }
        });
    } else {
        $.messager.alert('Advertencia', 'Debe seleccionar una compra primero.', 'warning');
    }
}

function cancelarCompraEstadoDeposito() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        // Mostrar mensaje de confirmación
        $.messager.confirm('Confirmación', '¿Seguro que desea cancelar la CompraEstado?', function(result) {
            if (result) {
                // Llenar el formulario con los datos de la fila seleccionada
                $('#fmCompraEstado [name="idcompraestado"]').val(row.idcompraestado);
                $('#fmCompraEstado [name="idcompra"]').val(row.idcompra);
                $('#fmCompraEstado [name="idcompraestadotipo"]').val(row.idcompraestadotipo);
                $('#fmCompraEstado [name="cefechaini"]').val(row.cefechaini);
                $('#fmCompraEstado [name="cefechafin"]').val(row.cefechafin);
                $('#fmCompraEstado [name="usnombre"]').val(row.usnombre);

                var formData = $('#fmCompraEstado').serialize();
                // Agregar la nueva variable "accion" al array de datos
                formData += '&accion=cancelar';

                // Verificar el estado antes de hacer la solicitud AJAX
                if (row.idcompraestadotipo == 2 || row.idcompraestadotipo == 4 || row.idcompraestadotipo == 3) {
                    // Realizar la solicitud AJAX
                    $.ajax({
                        url: '../accion/siguienteEstadoCompra.php',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $.messager.progress({
                                text: 'Procesando...'
                            });
                        },
                        success: function(result) {
                            var response = result;
                            $.messager.progress('close'); // Cerrar el mensaje de carga

                            if (response.errorMsg) {
                                // Mostrar el mensaje de error si existe
                                $.messager.alert('Error', response.errorMsg,);
                            } else {
                                // Mostrar mensaje de éxito si no hay error
                                $.messager.alert('Operación exitosa', response.respuesta, 'info', function() {
                                    $('#dgCompraEstado').datagrid('reload'); // Recargar los datos de la tabla
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $.messager.progress('close'); // Cerrar el mensaje de carga
                            $.messager.alert('Error', 'No se pudo procesar la solicitud. Error en la conexión.',);
                        }
                    });
                } else if (row.idcompraestadotipo == 1) {
                    $.messager.alert('Error', 'Las compras iniciadas son manejadas por el administrador.');
                }
            }
        });
    } else {
        $.messager.alert('Advertencia', 'Debe seleccionar una compra primero.', 'warning');
    }
}

///Funciones para la gestion de compras del Administrador
function siguienteEstadoAdmi() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        // Mostrar mensaje de confirmación
        $.messager.confirm('Confirmación', '¿Seguro que desea avanzar la CompraEstado?', function(result) {
            if (result) {
                // Llenar el formulario con los datos de la fila seleccionada
                $('#fmCompraEstado [name="idcompraestado"]').val(row.idcompraestado);
                $('#fmCompraEstado [name="idcompra"]').val(row.idcompra);
                $('#fmCompraEstado [name="idcompraestadotipo"]').val(row.idcompraestadotipo);
                $('#fmCompraEstado [name="cefechaini"]').val(row.cefechaini);
                $('#fmCompraEstado [name="cefechafin"]').val(row.cefechafin);
                $('#fmCompraEstado [name="usnombre"]').val(row.usnombre);

                var formData = $('#fmCompraEstado').serialize();
                // Agregar la nueva variable "accion" al array de datos
                formData += '&accion=administrador';

                // Verificar el estado antes de hacer la solicitud AJAX
                if (row.idcompraestadotipo == 1 || row.idcompraestadotipo == 3 || row.idcompraestadotipo == 4) {
                    // Realizar la solicitud AJAX
                    $.ajax({
                        url: '../accion/siguienteEstadoCompra.php',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $.messager.progress({
                                text: 'Procesando...'
                            });
                        },
                        success: function(result) {
                            var response = result;
                            $.messager.progress('close'); // Cerrar el mensaje de carga

                            if (response.errorMsg) {
                                // Mostrar el mensaje de error si existe
                                $.messager.alert('Error', response.errorMsg,);
                            } else {
                                // Mostrar mensaje de éxito si no hay error
                                $.messager.alert('Operación exitosa', response.respuesta, 'info', function() {
                                    $('#dg').datagrid('reload'); // Recargar los datos de la tabla
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $.messager.progress('close'); // Cerrar el mensaje de carga
                            $.messager.alert('Error', 'No se pudo procesar la solicitud. Error en la conexión.',);
                        }
                    });
                } else if (row.idcompraestadotipo == 2) {
                    $.messager.alert('Error', 'Ya se encuentra aceptada la compra, el siguiente paso le corresponde al deposito.');
                }
            }
        });
    } else {
        $.messager.alert('Advertencia', 'Debe seleccionar una compra primero.', 'warning');
    }
}

function cancelarCompraEstadoAdmi() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        // Mostrar mensaje de confirmación
        $.messager.confirm('Confirmación', '¿Seguro que desea cancelar la CompraEstado?', function(result) {
            if (result) {
                // Llenar el formulario con los datos de la fila seleccionada
                $('#fmCompraEstado [name="idcompraestado"]').val(row.idcompraestado);
                $('#fmCompraEstado [name="idcompra"]').val(row.idcompra);
                $('#fmCompraEstado [name="idcompraestadotipo"]').val(row.idcompraestadotipo);
                $('#fmCompraEstado [name="cefechaini"]').val(row.cefechaini);
                $('#fmCompraEstado [name="cefechafin"]').val(row.cefechafin);
                $('#fmCompraEstado [name="usnombre"]').val(row.usnombre);

                var formData = $('#fmCompraEstado').serialize();
                // Agregar la nueva variable "accion" al array de datos
                formData += '&accion=cancelar';

                // Verificar el estado antes de hacer la solicitud AJAX
                if (row.idcompraestadotipo == 1 || row.idcompraestadotipo == 4 || row.idcompraestadotipo == 3) {
                    // Realizar la solicitud AJAX
                    $.ajax({
                        url: '../accion/siguienteEstadoCompra.php',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $.messager.progress({
                                text: 'Procesando...'
                            });
                        },
                        success: function(result) {
                            var response = result;
                            $.messager.progress('close'); // Cerrar el mensaje de carga

                            if (response.errorMsg) {
                                // Mostrar el mensaje de error si existe
                                $.messager.alert('Error', response.errorMsg,);
                            } else {
                                // Mostrar mensaje de éxito si no hay error
                                $.messager.alert('Operación exitosa', response.respuesta, 'info', function() {
                                    $('#dgCompraEstado').datagrid('reload'); // Recargar los datos de la tabla
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $.messager.progress('close'); // Cerrar el mensaje de carga
                            $.messager.alert('Error', 'No se pudo procesar la solicitud. Error en la conexión.',);
                        }
                    });
                } else if (row.idcompraestadotipo == 2) {
                    $.messager.alert('Error', 'Las compras aceptadas son manejadas por el deposito.');
                }
            }
        });
    } else {
        $.messager.alert('Advertencia', 'Debe seleccionar una compra primero.', 'warning');
    }
}

//Funcion utilizada por el deposito y administrador para ver los detalles de la compra
function muestraDetalleCompra() {
    var row = $('#dg').datagrid('getSelected'); // Obtener la fila seleccionada
    if (row) {
        // Solicitud AJAX para obtener los detalles de la compra
        $.ajax({
            url: '../accion/detallesCompra.php',
            type: 'POST',
            data: { idcompra: row.idcompra },
            dataType: 'json',
            beforeSend: function() {
                console.log('Enviando solicitud AJAX');
            },
            success: function(data) {
                console.log("Respuesta recibida:", data);
                if (data.success) {
                    var productos = data.productos;
                    var totalCompra = 0;
                    var tbody = $('#detalleCompraTable tbody');
                    tbody.empty(); // Limpiar la tabla antes de llenarla

                    // Agregar productos a la tabla
                    productos.forEach(function(producto) {
                        var precioTotalProducto = producto.cantidad * producto.precioUnitario;
                        tbody.append('<tr>' +
                            '<td style="border: 1px solid #ddd; padding: 8px;">' + producto.pronombre + '</td>' +
                            '<td style="border: 1px solid #ddd; padding: 8px;">' + producto.cantidad + '</td>' +
                            '<td style="border: 1px solid #ddd; padding: 8px;">' + producto.precioUnitario + '</td>' +
                            '<td style="border: 1px solid #ddd; padding: 8px;">' + precioTotalProducto + '</td>' +
                            '</tr>');
                        totalCompra += precioTotalProducto;
                    });

                    // Mostrar el total de la compra
                    $('#totalCompra').text('Total de la Compra: $' + totalCompra.toFixed(2));

                    // Abrir el cuadro de diálogo con los detalles
                    $('#dlgDetalleCompra').dialog('open');
                } else {
                    $.messager.alert('Error', 'No se pudo obtener los detalles de la compra.');
                }
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud AJAX:", error);
                $.messager.alert('Error', 'Error en la solicitud AJAX.');
            }
        });
    } else {
        $.messager.alert('Advertencia', 'Por favor, seleccione una compra primero.');
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
        url: "../accion/accionPassUsuario.php",
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
        url: '../accion/accionRolesExist.php',
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
        url: '../accion/accionRolesExist.php',
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





