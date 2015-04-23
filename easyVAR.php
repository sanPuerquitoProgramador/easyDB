<?php
//Variables de entorno local
$ctrTmp = rand(1,700);
date_default_timezone_set('America/Mexico_City');
$servicio = 'p'; //¿En dónde estás trabajando? D para desarrollo, P para producción
switch($servicio)
{
	case 'd':
	$easy_db_name = 'root';
	$easy_db_pwd = 'root';
	$easy_db_host = "localhost";
    $easy_db_db = '';
    break;	
    case 'p':
	$easy_db_name = '';
	$easy_db_pwd = '';
    $easy_db_host = '';
    $easy_db_db = '';
	break;	
}
?>