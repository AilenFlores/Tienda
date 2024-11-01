<?php
// Incluimos el archivo de la cabecera y otros necesarios
include("../../../Estructura/CabeceraSegura.php");
$datos = data_submitted();
$esNuevaPersona = true;
$resp = null;

// Verificamos si se está editando un usuario
if (isset($datos['accion']) && $datos['accion'] === 'editar' && isset($datos['idmenu'])) {
    $control = new abmMenu();
    $objMenuRol = new AbmMenuRol();
    $resp = convert_array($control->buscar(['idmenu' => $datos['idmenu']]));
    if ($resp && isset($resp[0])) {
        $persona = $resp[0];
        // Obtenemos los roles actuales del usuario
        $roles = convert_array($objMenuRol->buscar(['idmenu' => $persona['idmenu']]));
        $esNuevaPersona = false;
    }
}
?>
<!-- Interfaz del formulario -->
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm" style="max-width: 420px; margin: auto;">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h6 class="mb-0 text-black"><?php echo $esNuevaPersona ? "Registrar nuevo usuario" : "Editar usuario"; ?></h6>
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Volver</a>
            </div>

            <div class="card-body">
                <form action="accion.php" method="post" id="formMenu" name="formMenu" novalidate>
                    <input id="accion" name="accion" value="<?php echo $esNuevaPersona ? 'nuevo' : 'editar'; ?>" type="hidden">
                    
                    <?php if (!$esNuevaPersona) { ?>
                        <div class="mb-3">
                            <label for="idusuario" class="form-label"><strong>ID Menu:</strong></label>
                            <input type="text" class="form-control bg-light" id="idusuario" name="idusuario" value="<?php echo htmlspecialchars($persona["idmenu"]); ?>" readonly>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label for="usnombre" class="form-label text-secondary"><strong>Nombre:</strong></label>
                        <input type="text" class="form-control" id="usnombre" name="usnombre" value="<?php echo htmlspecialchars($esNuevaPersona ? '' : $persona["menombre"]); ?>" required>
                        <div class="invalid-feedback">Ingrese un nombre válido.</div>
                    </div>

                    <div class="mb-3">
                        <label for="uspass" class="form-label text-secondary"><strong>URL:</strong></label>
                        <input type="text" class="form-control" id="url" name="url" value="<?php echo htmlspecialchars($esNuevaPersona ? '' : $persona["medescripcion"]); ?>" required>
                        <div class="invalid-feedback">Ingrese una contraseña válida. Debe tener al menos 8 caracteres.</div>
                    </div>

                    <div class="mb-3">
                        <label for="usmail" class="form-label text-secondary"><strong>ID padre:</strong></label>
                        <input type="email" class="form-control" id="idpadre" name="idpadre" value="<?php echo htmlspecialchars($esNuevaPersona ? '' : $persona["objmenu"]); ?>" required>
                        <div class="invalid-feedback">Ingrese un correo electrónico válido.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary"><strong>Roles:</strong></label>
                        <div class="form-check">
                            <?php 
                            $objRol = new AbmRol();
                            $rolesExits = convert_array($objRol->buscar(null)); // Obtener todos los roles 
                            foreach ($rolesExits as $rol) { ?>
                            <input class="form-check-input" type="checkbox" id="rol_<?php echo $rol['idRol']; ?>" name="usrol[]" value="<?php echo $rol['idRol']; ?>" <?php if (isset($roles) && in_array($rol['idRol'], array_column($roles, 'objrol'))) echo 'checked'; ?>>
                            <label class="form-check-label" for="rol_<?php echo $rol['idRol']; ?>">
                                <?php echo $rol['roDescripcion']; ?>
                            </label>
                            <br>
                            <?php } ?>
                        </div>
                        <div class="invalid-feedback">Seleccione al menos un rol válido.</div>
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
