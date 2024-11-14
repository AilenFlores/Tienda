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
</head>
<body class="d-flex flex-column min-vh-100">
<header>
     <!-- Top Notification -->
<div class="text-center py-2 bg-primary text-white">
Tienda de Equipo de Proteccion Personal.
</div>
    <?php 
    // Incluir el menú de navegación desde el archivo "menu.php"
    include_once "menu.php";
    ?>
</header>



