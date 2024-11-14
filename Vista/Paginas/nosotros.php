<?php 
include_once("../Estructura/Cabecera.php"); 
$datos = data_submitted();
?>
<main class="p-5 text-center bg-light">
  <h3 class="mb-4">Programación Web Dinámica 2024 - Universidad del Comahue</h3>
  <h4 class="mb-4">Integrantes:</h4>

  <div class="row justify-content-center align-items-stretch gx-4 gy-4">
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-secondary text-white fs-5 text-center">
          Flores Montes Ailen
        </div>
        <div class="card-body">
          <p class="card-text fs-6">
            <i class="bi bi-mortarboard-fill fs-5"></i> <span>Legajo: FAI-3547</span>
          </p>
          <p class="card-text fs-6">
            <i class="bi bi-envelope-at-fill fs-5"></i> <span>Email: ailen.flores@est.fi.uncoma.edu.ar</span>
          </p>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-secondary text-white fs-5 text-center">
          Loureiro Jazmín
        </div>
        <div class="card-body">
          <p class="card-text fs-6">
            <i class="bi bi-mortarboard-fill fs-5"></i> <span>Legajo: FAI-4228</span>
          </p>
          <p class="card-text fs-6">
            <i class="bi bi-envelope-at-fill fs-5"></i> <span>Email: jazmin.loureiro@est.fi.uncoma.edu.ar</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</main>


<?php include(STRUCTURE_PATH . "pie.php"); ?> 


