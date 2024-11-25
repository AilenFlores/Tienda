<?php
// Incluir el archivo de configuración una sola vez
include_once("/xampp/htdocs/tienda/configuracion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda</title>
    <?php 
    // Incluir los enlaces de CSS/JS desde el archivo "links.php"
    include_once "links.php";
    ?>
<body class="d-flex flex-column min-vh-100">
<header>
<div class="text-center py-2 bg-primary text-white">
   Tienda de Equipo de Proteccion Personal.
</div>
    <?php 
    // Incluir el menú de navegación desde el archivo "menu.php"
    include_once "menu.php";
    ?>
    </head>
<?php
$resp = $session->validar();
if(!$resp) {
    $mensaje ="Error, inicie sesion y vuelva a intentarlo";
   echo "<script>location.href = '".BASE_URL."/vista/paginas/login.php?msg=".$mensaje."';</script>";
}

else{
    $abmMenu= new AbmMenuRol();
    $rol=$session->getRol();
    if(!$abmMenu->tienePermiso($rol)){
        $session->cerrar();
        $mensaje ="Error, no tiene permisos para acceder a esta pagina";
        echo "<script>location.href = '".BASE_URL."/vista/paginas/login.php?msg=".$mensaje."';</script>";
    }
}
?>
</header>



