<?php include ("../../Estructura/Cabecera.php"); ?>

<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm" style="max-width: 420px; margin: auto; border: solid #ced4da ">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h6 class="mb-0 text-black">Registrar Usuario</h6>
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>
            <div class="card-body">
                <form action="accion.php" method="post" id="formUsuario" name="formUsuario" novalidate>
                    <input id="accion" name="accion" value="nuevo" type="hidden">

                    <div class="mb-3">
                        <label for="usnombre" class="form-label text-secondary"><strong>Nombre:</strong></label>
                        <input type="text" class="form-control" id="usnombre" name="usnombre" required>
                        <div class="invalid-feedback">
                            Ingrese un nombre válido.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="uspass" class="form-label text-secondary"><strong>Contraseña:</strong></label>
                        <input type="password" class="form-control" id="uspass" name="uspass" required>
                        <div class="invalid-feedback">
                            Ingrese una contraseña válida. Debe tener al menos 8 caracteres.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="usmail" class="form-label text-secondary"><strong>Correo electrónico:</strong></label>
                        <input type="email" class="form-control" id="usmail" name="usmail" required>
                        <div class="invalid-feedback">
                            Ingrese un correo electrónico válido.
                        </div>
                    </div>

                    <!-- Botones "Borrar" y "Enviar" juntos -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-outline-danger">Borrar</button>
                        <button type="submit" class="btn btn-primary" onclick="formSubmit()">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
<script>
function formSubmit()
{
    var password =  document.getElementById("uspass").value;
    //console.log(password);
    var passhash = CryptoJS.MD5(password).toString();
    //console.log(passhash);
    document.getElementById("uspass").value = passhash;

    setTimeout(function(){ 
        document.getElementById("formulario").submit();

	}, 500);
}
</script>

<?php include (STRUCTURE_PATH."pie.php"); ?>
