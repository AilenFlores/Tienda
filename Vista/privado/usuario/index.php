<?php 
include_once("../../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm" style="max-width: 420px; margin: auto;">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h6 class="mb-0 text-black"> Editar usuario</h6>
                <a href="../index.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            <div class="card-body">
                <form  method="post" id="formUsuario" name="formUsuario" novalidate>
                    <div class="mb-3">
                        <label for="idusuario" class="form-label"><strong>ID Usuario:</strong></label>
                        <input type="text" class="form-control bg-light" id="idUsuario" name="idUsuario" readonly>
                    </div>
             

                    <div class="mb-3">
                        <label for="usnombre" class="form-label text-secondary"><strong>Nombre:</strong></label>
                        <input type="text" class="form-control" id="usNombre" name="usNombre" required>
                        <div class="invalid-feedback">
                            Ingrese un nombre válido.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="uspass" class="form-label text-secondary"><strong>Contraseña:</strong></label>
                        <input type="password" class="form-control" id="usPass" name="usPass" required>
                        <div class="invalid-feedback">
                            Ingrese una contraseña válida. Debe tener al menos 8 caracteres.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="usmail" class="form-label text-secondary"><strong>Correo electrónico:</strong></label>
                        <input type="email" class="form-control" id="usMail" name="usMail" required>
                        <div class="invalid-feedback">
                            Ingrese un correo electrónico válido.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-outline-danger">Borrar</button>
                        <button type="button" class="btn btn-primary" onclick="saveUsuario()">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        cargarDatosUsuario(); // Llama a la función para cargar los datos del usuario
    });
</script>

<?php include(STRUCTURE_PATH . "pie.php"); ?>
