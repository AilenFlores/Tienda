<?php 
include_once("../Estructura/Cabecera.php"); 
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
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>

    </div>
    
    <div class="carousel-inner">
        <!-- Primera Diapositiva -->
        <div class="carousel-item active" data-bs-interval="2000">
            <img src="../img/carrusel1.png" class="d-block w-100" height="500" alt="Primera diapositiva">
        </div>

        <!-- Segunda Diapositiva -->
        <div class="carousel-item" data-bs-interval="2000">
            <img src="../img/carrusel2.png" class="d-block w-100" height="500" alt="Segunda diapositiva">
        </div>

    </div>
    
    <!-- Controles del carrusel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>






   <!-- Section Container -->
<div class="container my-4">
    <div class="row text-center justify-content-center">
        <!-- Free Shipping -->
        <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="fas fa-shipping-fast fa-3x mb-2 text-primary"></i>
            <h5 class="fw-bold text-primary">Envío ¡GRATIS!</h5>
            <p class="text-primary">Por compras iguales o superiores a $150.000 tu envío sale totalmente gratis.</p>
        </div>
        
        <!-- Easy and Secure Payment -->
        <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="fas fa-credit-card fa-3x mb-2 text-primary"></i>
            <h5 class="fw-bold text-primary">Compra Fácil y Seguro</h5>
            <p class="text-primary">Paga por medio de transferencia a cuentas como Banco Nacion, Naranja o Mercado Pago.</p>
        </div>
        
        <!-- Contact Us -->
        <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="fab fa-whatsapp fa-3x mb-2 text-primary"></i>
            <h5 class="fw-bold text-primary">¿Tienes alguna duda?</h5>
            <p class="text-primary">Si tienes alguna duda, comunícate con nosotros vía WhatsApp.</p>
        </div>
    </div>
</div>

  

<?php include(STRUCTURE_PATH . "pie.php"); ?> 


  


