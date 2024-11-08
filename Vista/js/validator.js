
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
    
    // Limpiar validación al escribir en los campos
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
                var resultJson = JSON.parse(result.trim()); // Intenta parsear el JSON de la respuesta
                if (resultJson.respuesta) {
                    // Si la respuesta es exitosa (login correcto)
                    window.location.href = "../../privado/index.php"; // Redirige al usuario a la página privada
                } else {
                    // Si la respuesta es falsa (login incorrecto)
                    $.messager.show({
                        title: 'Error',
                        msg: resultJson.msg  // Muestra el mensaje de error
                    });
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


// Función de envío AJAX
function EnviarRegistro() {
    $.ajax({
        url: 'accion/accionRegistro.php',
        type: 'POST',
        data: $('#formRegistro').serialize(),
        success: function(result) {
            try {
                var resultJson = JSON.parse(result.trim()); // Intenta parsear el JSON de la respuesta
                if (resultJson.respuesta) {
                    // Si la respuesta es exitosa (login correcto)
                    alert("Usuario registrado correctamente");
                    window.location.href = "../../publico/login/login.php"; // Redirige al usuario a la página privada
                } else {
                    // Si la respuesta es falsa (login incorrecto)
                    $.messager.show({
                        title: 'Error',
                        msg: resultJson.msg  // Muestra el mensaje de error
                    });
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


////////////////////////////MODIFICAR USUARIO/////////////////////////////////////
$(document).ready(function() {
    var form = document.getElementById("formUsuario");
    
    if (form) {
        $('#formUsuario').on('submit', function(event) {
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

///Usuario
function saveUsuario() {
    // Envío del formulario con AJAX
    $.ajax({
        url: "accion/accionEditar.php",
        method: "POST",
        data: $('#formUsuario').serialize(), // Serializa los datos del formulario
        success: function(result){
        var result = eval('('+result+')');
        if (result){
            alert("Cambios Realizados");  
            location.reload(); // Recarga la página después de la actualización 
        }

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
            
            // Validar el campo "usuario"
            let pass = $('#passNew').val().trim();
            if (pass === '' || pass.length < 8) {
                $('#passNew').addClass('is-invalid');
                isValid = false;
            } else {
                $('#passNew').removeClass('is-invalid');
            }

            // Si todo es válido, enviar el formulario
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
    $('#usNombre, #usMail').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});
function savePass() {
    // Envío del formulario con AJAX
    $.ajax({
        url: "accion/accionPass.php",
        method: "POST",
        data: $('#formPass').serialize(), // Serializa los datos del formulario
        success: function(result){
        var result = eval('('+result+')');
        if (result){
              // Limpiar el campo de contraseña
              $('#passNew').val('');
            alert("Cambios Realizados");  
           
        }

    }
    });
}
