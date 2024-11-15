<?php 
ob_start(); // 
?>
<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">
    <img src="<?php echo BASE_URL; ?>/Vista/img/logo.png" alt="SafeZone Logo" style="height: 40px;"></a>

        
        <!-- Menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
               
                <!-- Menu Dinamico -->   
                <li class="nav-item dropdown">
                    <?php 
                    $session = new Session();
                    if ($session->validar()) { // Verificar si la sesión está iniciada
                        ?>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= "Usuario: " . $_SESSION["usnombre"] ?>
                            </button>

                               <!-- Menu Dinamico -->
                            <ul class="dropdown-menu" id="menuDinamico" aria-labelledby="userDropdown">
                                 <div id="menuItems">    <!-- aca se cargarán los elementos del menú dinámico --> </div>
                                 <li><hr class="dropdown-divider"></li>
                                 <li><a class="dropdown-item" href="/Tienda/Vista/privado/sesion/logout.php">Cerrar Sesión</a></li>
                            </ul>

                       <!-- Menu Dinamico -->
                </div>
                <?php } else { // Si la sesión no está iniciada ?>
                <a class="nav-link dropdown-toggle text-black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Mi Cuenta
                </a>
                <ul class="dropdown-menu " aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?= BASE_URL; ?>/Vista/paginas/login.php">Iniciar Sesión</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL; ?>/Vista/paginas/registro.php">Registro</a></li>
                </ul> <?php } ?>
            </li>

        </ul>
    </div>
</div>
</nav>
<!-- Divider Line -->
<hr class="my-0 border-secondary">

<script>
 $(document).ready(function() {
    $.ajax({
        url: '<?= BASE_URL ?>/vista/accion/accionListarMenu.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#menuItems').empty();
            if (data && data.length > 0) {
                let menuHtml = '';
                data.forEach(function(item) {
                    if (!$('#menuItems').find('a[href="'+item.url+'"]').length) {
                        menuHtml += '<li><a href="' + item.url + '" class="dropdown-item">' + item.nombre + '</a></li>';
                    }
                });
                $('#menuItems').html(menuHtml);
            } else {
                console.error("No se encontraron menús.");
                $('#menuItems').html('<li class="dropdown-item">No hay menús disponibles</li>');
            }
        },
    });
});

</script>