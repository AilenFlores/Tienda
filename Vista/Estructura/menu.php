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
                        $roles = $session->getRol(); // Obtener roles de la sesión
                        ?>
                        <li class="nav-item"><a class="nav-link" href="#">Mi carrito</a></li>
                       
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                 <?= "Usuario: " . $_SESSION["usnombre"] ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <?php 
                                    $objMenuRol = new AbmMenuRol();
                                    $menues = $objMenuRol->menuesByIdRol($roles); 
                                    foreach ($menues as $objMenu) {
                                        if ($objMenu["medeshabilitado"] == NULL) {
                                            echo '<li class="nav-item"><a href="' . BASE_URL . "/vista/" . $objMenu["medescripcion"] . '" class="dropdown-item">' . $objMenu["menombre"] . '</a></li>';
                                        }
                                    }  
                         ?>
                    

                        <li><hr class="dropdown-divider"></li>

                        <li><a class="dropdown-item" href="/Tienda/Vista/privado/sesion/logout.php">Cerrar Sesión</a></li>
                    </ul>
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
