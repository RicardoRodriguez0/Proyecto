<?php
if(!isset($indexphp) and $indexphp !== TRUE) {
	header('Location: /index.php');
	exit;
}

$func_ruta = 'configuracion/funciones/';

include($func_ruta.'depurar.php');
include($func_ruta.'comentario.php');
include($func_ruta.'mostrarNacimiento.php');
include($func_ruta.'paginacion.php');
include($func_ruta.'publicacion.php');
include($func_ruta.'publicidad.php');
include($func_ruta.'tiempo_transcurrido.php');
include($func_ruta.'puntos.php');
include($func_ruta.'rango.php');
include($func_ruta.'redireccionar.php');