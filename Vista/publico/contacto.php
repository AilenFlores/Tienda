<?php 
include_once("../Estructura/Cabecera.php"); 
$datos = data_submitted();
?>
<div class="container my-5">
    <div class="row">
        <!-- Información de contacto -->
        <div class="col-md-4">
            <h2 class="fw-bold text-secondary">Contacto</h2>
            <p class="text-muted">¡Si tienes alguna pregunta no dudes en comunicarte con nosotros vía WhatsApp!</p>
            <p><i class="fab fa-whatsapp"></i> +57 123456789</p>
            <p><i class="fas fa-phone-alt"></i> 310 2396965</p>
            <p><i class="fas fa-envelope"></i> contacto@empresa.com</p>
            <p><i class="fas fa-store"></i> Tienda Virtual</p>
        </div>

        <!-- Formulario de contacto -->
        <div class="col-md-8">
            <form action="ruta_de_envio.php" method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono">
                </div>
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                </div>

                <!-- Google reCAPTCHA -->
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="tu_site_key"></div>
                </div>

                <button type="submit" class="btn btn-secondary w-100">ENVIAR</button>
            </form>
        </div>
    </div>
</div>

<?php include(STRUCTURE_PATH . "pie.php"); ?> 

