<?php
// Incluimos el archivo de la cabecera y otros necesarios
include("../../../Estructura/CabeceraSegura.php");
$datos = data_submitted();
$esNueva = true;
$resp = null;

// Verificamos si se está editando
if (isset($datos['accion']) && $datos['accion'] === 'editar' && isset($datos['idproducto'])) {
    $control = new AbmProducto();
    $resp = convert_array($control->buscar(['idproducto' => $datos['idproducto']]));
    if ($resp && isset($resp[0])) {
        $persona = $resp[0];
        $esNueva = false;
    }
}
?>
<!-- Interfaz del formulario -->
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm" style="max-width: 420px; margin: auto;">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h6 class="mb-0 text-black"><?php echo $esNueva ? "Registrar nuevo producto" : "Editar producto"; ?></h6>
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Volver</a>
            </div>

            <div class="card-body">
                <form action="accion.php" method="post" id="formProducto" name="formProducto" novalidate>
                    <input id="accion" name="accion" value="<?php echo $esNueva ? 'nuevo' : 'editar'; ?>" type="hidden">
                    
                    <?php if (!$esNueva) { ?>
                        <div class="mb-3">
                            <label for="idproducto" class="form-label"><strong>ID Producto:</strong></label>
                            <input type="text" class="form-control bg-light" id="idproducto" name="idproducto" value="<?php echo htmlspecialchars($persona["idproducto"]); ?>" readonly>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label for="pronombre" class="form-label text-secondary"><strong>Nombre:</strong></label>
                        <input type="text" class="form-control" id="pronombre" name="pronombre" value="<?php echo htmlspecialchars($esNueva ? '' : $persona["pronombre"]); ?>" required>
                        <div class="invalid-feedback">Ingrese un nombre válido.</div>
                    </div>

                    <div class="mb-3">
                        <label for="prodetalle" class="form-label text-secondary"><strong>Detalle:</strong></label>
                        <input type="text" class="form-control" id="prodetalle" name="prodetalle" value="<?php echo htmlspecialchars($esNueva ? '' : $persona["prodetalle"]); ?>" required>
                        <div class="invalid-feedback">Ingrese una detalle válida.</div>
                    </div>

                    <div class="mb-3">
                        <label for="procantstock" class="form-label text-secondary"><strong>Stock:</strong></label>
                        <input type="text" class="form-control" id="procantstock" name="procantstock" value="<?php echo htmlspecialchars($esNueva ? '' : $persona["procantstock"]); ?>" required>
                        <div class="invalid-feedback">Ingrese un numero válido.</div>
                    </div>

                    <div class="mb-3">
                        <label for="proimporte" class="form-label text-secondary"><strong>Importe:</strong></label>
                        <input type="text" class="form-control" id="proimporte" name="proimporte" value="<?php echo htmlspecialchars($esNueva ? '' : $persona["proimporte"]); ?>" required>
                        <div class="invalid-feedback">Ingrese un importe válido.</div>
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
