<?php 
include_once("../../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h6 class="mb-0 text-black"> Editar usuario</h6>
                <a href="../index.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            <div class="card-body">
                <!-- Contenedor de los formularios con separación -->
                <div class="row">
                    <!-- Primer formulario -->
                    <div class="col-md-5">
                        <form method="post" id="formUsuario" name="formUsuario" novalidate>
                            <div class="mb-3">
                                <label for="idUsuario" class="form-label"><strong>ID Usuario:</strong></label>
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
                                <label for="usmail" class="form-label text-secondary"><strong>Correo electrónico:</strong></label>
                                <input type="email" class="form-control" id="usMail" name="usMail" required>
                                <div class="invalid-feedback">
                                    Ingrese un correo electrónico válido.
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary" >Enviar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Línea divisoria vertical -->
                    <div class="col-md-1 d-flex justify-content-center align-items-center">
                        <div style="border-left: 1px solid #ccc; height: 100%;"></div>
                    </div>

                    <!-- Segundo formulario -->
                    <div class="col-md-5">
                        <form method="post" id="formPass" name="formPass" novalidate>
                            <div class="mb-3">
                                <label for="passNew" class="form-label"><strong>Cambiar Contraseña:</strong></label>
                                <input type="password" class="form-control bg-light" id="passNew" name="passNew">
                                <div class="invalid-feedback">
                                    Ingrese una contraseña de 8 caracteres.
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>
