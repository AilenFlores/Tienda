<?php 
include_once("../Estructura/Cabecera.php"); 
$resp = $session->validar();
if($resp) {
   echo "<script>location.href = '".BASE_URL."/vista/home/index.php';</script>";
}
?>

<main class="flex-fill bg-light">

<div id="alerta-error" class="alert alert-danger d-none text-center" role="alert">
</div>

<!--  Formulario de login -->
    <div class="container my-4">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center">INICIO SESION</h5>
                <br>
                <form method="post" id="usLogin" name="usLogin" novalidate>

                    <!-- Fila para usuario -->
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 3rem; height: calc(2.5rem + 2px); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user fa-lg"></i> 
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Usuario" id="usnombre" name="usnombre">
                            <div class="invalid-feedback">
                                Ingrese un usuario.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fila para password -->
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 3rem; height: calc(2.5rem + 2px); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-lock fa-lg"></i> 
                                </span>
                            </div>
                            <input type="password" class="form-control" id="uspass" name="uspass" placeholder="Password">
                            <div class="invalid-feedback">
                                Ingrese una contraseña.
                                <br>
                                Debe tener al menos 8 caracteres, letras y números.
                                <br>
                                No puede ser igual el usuario a la contraseña.
                            </div>
                        </div>
                    </div>
                    <!-- Fila para Botones -->
                    <div class="row">
                        <div class="col-sm-8 offset-sm-2">
                            <button type="submit" class="btn btn-success w-100">Enviar</button>
                        </div>
                    </div>
                    <!-- Fila para enlace de registro -->
                     <div class="row mt-3">
                        <div class="col text-center">
                            <p>¿No tienes una cuenta? <a href="registro.php?">Regístrate aquí</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>
