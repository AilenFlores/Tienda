<?php include ("../../Estructura/Cabecera.php"); ?>

<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm" style="max-width: 420px; margin: auto; border: solid #ced4da ">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h6 class="mb-0 text-black">Registrar Usuario</h6>
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>
            <div class="card-body">
                <form action="accion.php" method="post" id="formRegistro" name="formRegistro" novalidate >
                    <input id="accion" name="accion" value="nuevo" type="hidden">

                    <div class="mb-3">
                        <label for="usNombre" class="form-label text-secondary"><strong>Nombre:</strong></label>
                        <input type="text" class="form-control" id="usNombre" name="usNombre" required>
                        <div class="invalid-feedback">
                            Ingrese un nombre válido.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="usPass" class="form-label text-secondary"><strong>Contraseña:</strong></label>
                        <input type="password" class="form-control" id="usPass" name="usPass" required>
                        <div class="invalid-feedback">
                            Ingrese una contraseña válida. Debe tener al menos 8 caracteres.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="usMail" class="form-label text-secondary"><strong>Correo electrónico:</strong></label>
                        <input type="email" class="form-control" id="usMail" name="usMail" required>
                        <div class="invalid-feedback">
                            Ingrese un correo electrónico válido.
                        </div>
                    </div>

                    <!-- Botones "Borrar" y "Enviar" juntos -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-outline-danger">Borrar</button>
                        <button type="submit" class="btn btn-primary" >Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>


<?php include (STRUCTURE_PATH."pie.php"); ?>
