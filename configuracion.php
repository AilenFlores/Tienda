<?php 
header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");
date_default_timezone_set('America/Argentina/Buenos_Aires'); 

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////


$directorio = '/Tienda'; // Escribir el directorio donde se encuentra el proyecto dentro del servidor
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].$directorio);
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].$directorio );
define('INCLUDES_PATH', ROOT_PATH.'/Vista/Estructura/includes/');
define('STRUCTURE_PATH', ROOT_PATH.'/Vista/Estructura/');
$GLOBALS['ROOT'] = ROOT_PATH;


include_once(ROOT_PATH.'/Util/funciones.php');
?>
