<?php
// Incluimos el archivo de la cabecera y otros necesarios
include("../../../estructura/CabeceraSegura.php");
$datos = data_submitted();
$esNuevo = true;
$resp = null;

// Verificamos si se está editando 
if (isset($datos['accion']) && $datos['accion'] === 'editar' && isset($datos['idrol'])) {
    $control = new abmRol();;
    $resp = convert_array($control->buscar(['idRol' => $datos['idrol']]));
    if ($resp && isset($resp[0])) {
        $rol=$resp[0];
        $esNuevo = false;
    }
}
?>
<!-- Interfaz del formulario -->
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm" style="max-width: 420px; margin: auto;">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h6 class="mb-0 text-black"><?php echo $esNuevo ? "Registrar nuevo rol" : "Editar Rol"; ?></h6>
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Volver</a>
            </div>

            <div class="card-body">
                <form action="accion.php" method="post" id="formRol" name="formRol" novalidate>
                    <input id="accion" name="accion" value="<?php echo $esNuevo ? 'nuevo' : 'editar'; ?>" type="hidden">
                    
                    <?php if (!$esNuevo) { ?>
                        <div class="mb-3">
                            <label for="idrol" class="form-label"><strong>ID Rol:</strong></label>
                            <input type="text" class="form-control bg-light" id="idRol" name="idRol" value="<?php echo htmlspecialchars($rol["idRol"]); ?>" readonly>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label for="rodescripcion" class="form-label text-secondary"><strong>Nombre:</strong></label>
                        <input type="text" class="form-control" id="roDescripcion" name="roDescripcion" value="<?php echo htmlspecialchars($esNuevo ? '' : $rol["roDescripcion"]); ?>" required>
                        <div class="invalid-feedback">Ingrese un nombre válido.</div>
                    </div>



                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-outline-danger">Borrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>
