<?php include ("../../Estructura/CabeceraSegura.php"); ?>
<?php
$datos = data_submitted();
$datos['idusuario'] = (int) $_SESSION['idusuario'];
$esNuevaPersona = true; // Por defecto, es una nueva persona
$resp = null; 

// Verifica si estamos editando o agregando una nueva persona
if (isset($datos['idusuario'])) {
    $control = new AbmUsuarioLogin();
    $resp = convert_array($control->buscar($datos));
    if ($resp && isset($resp[0])) {
        $persona = $resp[0];
        $esNuevaPersona = false;
    }
}
?>

<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm" style="max-width: 420px; margin: auto;">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h6 class="mb-0 text-black"><?php echo $esNuevaPersona ? "Registrar nuevo usuario" : "Editar usuario"; ?></h6>
                <a href="../index.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            <div class="card-body">
                <form id="formUsuario" action="accion.php" method="post" novalidate onsubmit="formSubmit(); return false;">
                    <input id="accion" name="accion" type="hidden" value="<?php echo $esNuevaPersona ? 'nuevo' : 'editar'; ?>">

                    <?php if(!$esNuevaPersona) { ?>
                        <div class="mb-3">
                            <label for="idusuario" class="form-label"><strong>ID Usuario:</strong></label>
                            <input type="text" class="form-control bg-light" id="idusuario" name="idusuario" value="<?php echo $persona["idUsuario"]; ?>" readonly>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label for="usnombre" class="form-label text-secondary"><strong>Nombre:</strong></label>
                        <input type="text" class="form-control easyui-textbox" id="usnombre" name="usnombre" value="<?php echo $esNuevaPersona ? '' : $persona["usNombre"]; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="uspass" class="form-label text-secondary"><strong>Contraseña:</strong></label>
                        <input type="password" class="form-control easyui-textbox" id="uspass" name="uspass" value="<?php echo $esNuevaPersona ? '' : $persona["usPass"]; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="usmail" class="form-label text-secondary"><strong>Correo electrónico:</strong></label>
                        <input type="email" class="form-control easyui-textbox" id="usmail" name="usmail" value="<?php echo $esNuevaPersona ? '' : $persona["usMail"]; ?>" required validType="email">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
<script>
function formSubmit(){
    var password = document.getElementById("uspass").value;
    var passhash = CryptoJS.MD5(password).toString();
    document.getElementById("uspass").value = passhash;
    setTimeout(function(){ 
        document.getElementById("formUsuario").submit();
    }, 500);
}
</script>


<?php include (STRUCTURE_PATH."pie.php"); ?>
