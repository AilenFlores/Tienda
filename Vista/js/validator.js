
////////////////////////////LOGIN/////////////////////////////////////
$(document).ready(function() {
    var form = document.getElementById("usLogin");
    
    if (form) {
        $('#usLogin').on('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario inicialmente
            let isValid = true;
            // Validar el campo "usuario"
            let usuario = $('#usnombre').val().trim();
            if (usuario === '') {
                $('#usnombre').addClass('is-invalid');
                isValid = false;
            } else {
                $('#usnombre').removeClass('is-invalid');
            }
            // Validar el campo "password"
            let password = $('#uspass').val().trim();
            if (password === '' ) {
                $('#uspass').addClass('is-invalid');
                isValid = false;
            } else {
                $('#uspass').removeClass('is-invalid');
                if (password === usuario) {
                    $('#uspass').addClass('is-invalid');
                    isValid = false;
                }
            }
            if (isValid) {
                // Hash de la contraseña antes de enviar
                var passhash = CryptoJS.SHA256(password).toString();
                $('#uspass').val(passhash);

                // Llamar a la función AJAX de envío
                enviarLogin();
            }
        });
    }

    $('#usnombre, #uspass').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});

// Función de envío AJAX
function enviarLogin() {
    $.ajax({
        url: 'accion/accionAlta.php',
        type: 'POST',
        data: $('#usLogin').serialize(),
        success: function(result) {
            try {
                var resultJson = JSON.parse(result.trim()); 
                if (resultJson.respuesta) {
                    // Si la respuesta es exitosa (login correcto)
                    Swal.fire({
                        title: "Bienvenido",
                        text: "Redirigiendo...",
                        icon: "success",
                        timer: 1000,  
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = "../../home/index.php";  // Redirige al index
                    });
                    
                } else {
                    $('#alerta-error').removeClass('d-none').text(resultJson.msg);
                     // Limpiar el campo de contraseña
                     $('#uspass').val('');
                }
            } catch (e) {
                $.messager.show({
                    title: 'Error',
                    msg: 'Respuesta del servidor no válida. Por favor, revisa la URL o el servidor.'
                });
            }
        },
    });
}



////////////////////////////REGISTRO/////////////////////////////////////
$(document).ready(function() {
    var form = document.getElementById("formRegistro");
    
    if (form) {
        $('#formRegistro').on('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario inicialmente
            
            let isValid = true;
            
            // Validar el campo "usuario"
            let usuario = $('#usNombre').val().trim();
            if (usuario === '') {
                $('#usNombre').addClass('is-invalid');
                isValid = false;
            } else {
                $('#usNombre').removeClass('is-invalid');
            }
            
            // Validar el campo "password"
            let password = $('#usPass').val().trim();
            var regexPassword = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // Expresión regular para validar que contenga al menos una letra y un número
            
            if (password === '' || !regexPassword.test(password)) {
                $('#usPass').addClass('is-invalid');
                isValid = false;
            } else {
                $('#usPass').removeClass('is-invalid');
            }
            
            // Validar si la contraseña es igual al nombre de usuario
            if (password === usuario) {
                $('#usPass').addClass('is-invalid');
                isValid = false;
            }

            // Validar el correo electrónico
            var email = $("#usMail").val().trim();
            var regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/; // Expresión regular para validar correo con @ y .com
            
            if (email === "" || !regexEmail.test(email)) {
                $("#usMail").addClass('is-invalid');
                isValid = false;
            } else {
                $("#usMail").removeClass('is-invalid');
            }

            // Si todo es válido, enviar el formulario
            if (isValid) {
                // Opcional: encriptar la contraseña antes de enviarla
                var passhash = CryptoJS.SHA256(password).toString();
                $('#usPass').val(passhash);
                // Llamar a la función AJAX de envío
                EnviarRegistro();
            }
        });
    }
    
    // Limpiar validación al escribir en los campos
    $('#usNombre, #usPass, #usMail').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});

function EnviarRegistro() {
    // Mostrar el alert de "Cargando"
    const loadingSwal = Swal.fire({
        title: 'Cargando...',
        text: 'Por favor, espera mientras procesamos tu registro.',
        allowOutsideClick: false,  // Impide que el usuario cierre el alert mientras está mostrando
        didOpen: () => {
            Swal.showLoading();  // Muestra el ícono de carga
        }
    });

    $.ajax({
        url: 'accion/accionRegistro.php',
        type: 'POST',
        data: $('#formRegistro').serialize(),
        success: function(result) {
            try {
                var resultJson = JSON.parse(result.trim()); // Intenta parsear el JSON de la respuesta
                if (resultJson.respuesta) {
                    // Si el registro fue exitoso, se cierra el "Cargando" y luego mostramos el mensaje de éxito
                    loadingSwal.close();  
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registro exitoso!',
                        text: 'Usuario registrado correctamente.',
                        confirmButtonText: 'Aceptar',
                        timer: 4000  
                    }).then(() => {
                        window.location.href = "../../publico/login/login.php";  // Redirige al login
                    });

                } else {
                    loadingSwal.close(); 
                    $('#usPass').val('');  // Limpiar el campo de contraseña
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'El usuario ya existe.',
                        confirmButtonText: 'Aceptar',
                        timer: 4000  
                    });
                }
            } catch (e) {
                $.messager.show({
                    title: 'Error',
                    msg: 'Respuesta del servidor no válida. Por favor, revisa la URL o el servidor.'
                });
            }
        },
        complete: function() {
            loadingSwal.close();
        },
    });
}



////////////////////////////MODIFICAR USUARIO/////////////////////////////////////
$(document).ready(function() {
    var form = document.getElementById("formUsuario");
    if (form) {
        $('#formUsuario').on('submit', function(event) {
            event.preventDefault(); 
            let isValid = true;
            
            // Validar el campo "usuario"
            let usuario = $('#usNombre').val().trim();
            if (usuario === '') {
                $('#usNombre').addClass('is-invalid');
                isValid = false;
            } else {
                $('#usNombre').removeClass('is-invalid');
            }
            
            // Validar el correo electrónico
            var email = $("#usMail").val().trim();
            var regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/; // Expresión regular para validar correo con @ y .com
            
            if (email === "" || !regexEmail.test(email)) {
                $("#usMail").addClass('is-invalid');
                isValid = false;
            } else {
                $("#usMail").removeClass('is-invalid');
            }

            // Si todo es válido, enviar el formulario
            if (isValid) {
                // Llamar a la función AJAX de envío
                saveUsuario();
            }
        });
    }
    
    // Limpiar validación al escribir en los campos
    $('#usNombre, #usMail').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});

function saveUsuario() {
    // Mostrar la alerta de confirmación primero
    Swal.fire({
        title: "¿Está seguro?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Guardar",
        denyButtonText: "No guardar"
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, enviamos el formulario con AJAX
            $.ajax({
                url: "accion/accionEditar.php",
                method: "POST",
                data: $('#formUsuario').serialize(), 
                success: function(result) {
                    var resultJson = eval('(' + result + ')');  // Evaluamos la respuesta JSON del servidor
                    if (!resultJson.respuesta) { 
                        Swal.fire("Error", "El nombre de usuario ya existe o no se pudo guardar la información.", "error");
                    } else {
                        Swal.fire("¡Cambios guardados!", "", "success").then(() => {
                        location.reload();
                        });
                    }
                },
                error: function() {
                    // En caso de error con la solicitud AJAX
                    Swal.fire("Error", "Hubo un problema al procesar la solicitud.", "error");
                }
            });
        } 
    });
}





////////////////////////////MODIFICAR CONTRASEÑA/////////////////////////////////////

$(document).ready(function() {
    var form = document.getElementById("formPass");
    
    if (form) {
        $('#formPass').on('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario inicialmente
            let isValid = true;
            let pass = $('#passNew').val().trim();
            if (pass === '' || pass.length < 8) {
                $('#passNew').addClass('is-invalid');
                isValid = false;
            } else {
                $('#passNew').removeClass('is-invalid');
            }

            if (isValid) {
                // Opcional: encriptar la contraseña antes de enviarla
                var passhash = CryptoJS.SHA256(pass).toString();
                $('#passNew').val(passhash);
                // Llamar a la función AJAX de envío
                savePass();
            }
        });
    }
    
    // Limpiar validación al escribir en los campos
    $('#passNew').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});

function savePass() {
    Swal.fire({
        title: "¿Está seguro?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Guardar",
        denyButtonText: "No guardar"
    }).then((result) => {
        if (result.isConfirmed) {
            // Envío del formulario con AJAX
            $.ajax({
                url: "accion/accionPass.php",
                method: "POST",
                data: $('#formPass').serialize(), 
                success: function(response){
                    var result = JSON.parse(response);  // Evaluamos la respuesta JSON del servidor
                    if (result.respuesta) {
                        $('#passNew').val('');
                        Swal.fire("¡Cambios guardados!", "", "success").then(() => {
                            location.reload();  // Recargamos la página después de guardar
                        });
                    } else {
                        // Si hubo un error, mostrar mensaje de error
                        Swal.fire("Error", "No se pudo cambiar la contraseña.", "error");
                    }
                },
            });
        } else if (result.isDenied) {
            $('#passNew').val('');
        }
    });
}
