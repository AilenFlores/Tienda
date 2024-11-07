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
                        $objRol= new AbmUsuarioRol(); // Crear objeto de la clase AbmUsuarioRol
                        $objRoles = $objRol->buscarRol($roles); // Buscar obj roles
                        $selectedRole = isset($_COOKIE['menuIdRol']) ? $_COOKIE['menuIdRol'] : null;
                        ?>
                        <li class="nav-item"><a class="nav-link" href="#">Mi carrito</a></li>
                       
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                 <?= "Usuario: " . $_SESSION["usnombre"] ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <?php 
                                    $objMenuRol = new AbmMenuRol();
                                    $menues = $objMenuRol->menuesByIdRol($selectedRole); 
                                    foreach ($menues as $objMenu) {
                                        if ($objMenu["medeshabilitado"] == NULL) {
                                            echo '<li class="nav-item"><a href="' . BASE_URL . "/vista/" . $objMenu["medescripcion"] . '" class="dropdown-item">' . $objMenu["menombre"] . '</a></li>';
                                        }
                                    }  
                         ?>
                        
                         <li><hr class="dropdown-divider"></li>

                         <li class="dropdown-item">
                            <label for="roleSelect">Seleccionar Rol</label>
                            <select class="form-select form-select-sm" id="roleSelect" aria-label="Select role" style="width: 120px;">
                                <?php // Generar las opciones del select con el rol seleccionado de la cookie
                                foreach ($objRoles as $rolesArray) { 
                                    foreach ($rolesArray as $objRol) { 
                                        // Marcar la opción como seleccionada si coincide con la cookie
                                        $isSelected = ($selectedRole == $objRol["idRol"]) ? "selected" : "";
                                        echo '<option value="' . $objRol["idRol"] . '" ' . $isSelected . '>' . $objRol["roDescripcion"] . '</option>';
                                     }
                                    } ?>
                            </select>
                        </li>


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

<script>
document.getElementById("roleSelect").addEventListener("change", function () {
    const selectedRole = this.value;
    // Guardar el valor del rol seleccionado en una cookie
    document.cookie = "menuIdRol=" + selectedRole + "; path=/; max-age=" + 7 * 24 * 60 * 60;
    // Recargar la página para que el cambio de rol se aplique
    location.reload();
});
</script>