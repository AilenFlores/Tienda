<?php 
ob_start(); // 
?>
<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">Inicio</a>
        <!-- Buscar form -->
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
                <li class="nav-item"><a class="nav-link" href="#">Ayuda</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Mi carrito</a></li>
   
                <!-- Menu Dinamico -->   
                <li class="nav-item dropdown">
                    <?php 
                    $session = new Session();
                    if ($session->validar()) { // Verificar si la sesión está iniciada ?>
                        <a class="nav-link dropdown-toggle text-black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= "Nombre de usuario: " . $_SESSION["usnombre"] ?>
                        </a> 
                         <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <?php 
                            $roles = $session->getRol(); 
                            $objMenuRol = new AbmMenuRol();
                            $menues = $objMenuRol->menuesByIdRol($roles); 
                            foreach ($menues as $objMenu) {
                                if ($objMenu["medeshabilitado"] == NULL) {
                                    echo '<li class="nav-item"><a href="' . BASE_URL ."/vista/". $objMenu["medescripcion"] . '" class="dropdown-item">' . $objMenu["menombre"] . '</a></li>';
                                }
                            }  
                    ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/Tienda/Vista/privado/sesion/logout.php">Cerrar Sesión</a></li>
                </ul>
                <?php }
                 else { // Si la sesión no está iniciada ?>
                <a class="nav-link dropdown-toggle text-black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Mi Cuenta
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
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

<!-- Secondary Navbar -->
<div class="bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="secondaryNavbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item me-5"><a class="nav-link text-dark" href="<?php echo BASE_URL; ?>/index.php">INICIO</a></li>
                    <li class="nav-item me-5"><a class="nav-link text-dark" href="<?php echo BASE_URL; ?>/Vista/publico/productos.php">PRODUCTOS</a></li>
                    <li class="nav-item me-5"><a class="nav-link text-dark" href="<?php echo BASE_URL; ?>/vista/publico/nosotros.php">SOBRE NOSOTROS</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="<?php echo BASE_URL; ?>/Vista/publico/contacto.php">CONTACTO</a></li>
                </ul>
            </div>
        </nav>
    </div>
</div>
