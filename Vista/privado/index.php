<?php 
include_once("../Estructura/CabeceraSegura.php"); 
$datos = data_submitted();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <?php 
        if (isset($datos) && isset($datos['msg']) && $datos['msg'] != null) {
            $alertType = 'info';
            echo "<div class='alert alert-$alertType text-center' role='alert'>";
            echo htmlspecialchars($datos['msg']);
            echo "</div>";
        }
        ?>
    </div>
</div>

<div class="container-fluid text-center mb-5">
    <div class="mt-5">
        <div class="container">
            <h1 class="display-4 fuente-monts">Pagina Segura Provisoria</h1>
        </div>
    </div>
</div>

<?php include(STRUCTURE_PATH . "pie.php"); ?>
