<?php 
ob_start(); // 
?>
<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">PONER LOGO</a>
        <!-- Buscar form TODAVIA NO FUNCIONA -->
        <form class="d-flex ms-auto me-4">
            <div class="input-group">
                <input class="form-control search-bar" type="search" placeholder="¿Qué estás buscando?" aria-label="Buscar">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
        <!-- Navbar Toggler -->
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
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/Vista/privado/usuario/tienda.php">Tienda</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/Vista/privado/usuario/carrito.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16"><path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/></svg></a></li>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= "Usuario: " . $_SESSION["usnombre"] ?>
                            </button>

                               <!-- EMPIEZO A TRABAJAR CON ESTO -->
                            <ul class="dropdown-menu" id="menuDinamico" aria-labelledby="userDropdown">
                                 <div id="menuItems">    <!-- Aquí se cargarán los elementos del menú dinámico --> </div>
                                 <li><hr class="dropdown-divider"></li>
                                 <li><a class="dropdown-item" href="/Tienda/Vista/privado/sesion/logout.php">Cerrar Sesión</a></li>
                            </ul>

                       <!-- EMPIEZO A TRABAJAR CON ESTO -->
                </div>
                <?php } else { // Si la sesión no está iniciada ?>
                <a class="nav-link dropdown-toggle text-black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Mi Cuenta
                </a>
                <ul class="dropdown-menu " aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?= BASE_URL; ?>/Vista/publico/login/login.php">Iniciar Sesión</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL; ?>/Vista/publico/login/registro.php">Registro</a></li>
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
        url: '<?= BASE_URL ?>/vista/estructura/accion/accionListarMenu.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Limpiar el menú antes de agregar nuevos elementos
            $('#menuItems').empty();

            // Verificar si se recibió algún dato
            if (data && data.length > 0) {
                let menuHtml = '';
                // Crear los elementos del menú
                data.forEach(function(item) {
                    // Esto depende de los datos que devuelves desde el backend
                    if (!$('#menuItems').find('a[href="'+item.url+'"]').length) {
                        menuHtml += '<li><a href="' + item.url + '" class="dropdown-item">' + item.nombre + '</a></li>';
                    }
                });
                // Insertar los elementos generados en el contenedor del menú
                $('#menuItems').html(menuHtml);
            } else {
                console.error("No se encontraron menús.");
                $('#menuItems').html('<li class="dropdown-item">No hay menús disponibles</li>');
            }
        },
        error: function(xhr, status, error) {
            // Manejo de errores más detallado
            console.error("Error al cargar el menú dinámico: " + error);
            $('#menuItems').html('<li class="dropdown-item">Error al cargar el menú</li>');
        }
    });
});

</script>