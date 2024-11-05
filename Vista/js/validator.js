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
            var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // Expresión regular para validar que contenga al menos una letra y un número
            
            if (password === '' || !regex.test(password)) {
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
                form.submit(); // Envía el formulario solo si es válido
            }
        });
    }
    
    // Limpiar validación al escribir en los campos
    $('#usnombre, #uspass').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});

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
            var regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/; // Expresión regular para validar correo
            
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
                
                this.submit(); // Ahora que el formulario es válido, lo enviamos
            }
        });
    }
    
    // Limpiar validación al escribir en los campos
    $('#usNombre, #usPass, #usMail').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});
