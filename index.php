<?php
	# Comienzo de session
	session_start();
	
	# Compresion GZip
	if(!extension_loaded('zlib')){
		ini_set('zlib.output_compression_level', 1);  
		ob_start('ob_gzhandler'); 
	}
	
	# Cargar configuracion
	require_once("configuracion/database.php");
	require_once("configuracion/propiedades.php");
	require_once("configuracion/funciones.php");
	
	# Cargar tema
	require_once("temas/$prop[tema]/index.php");

	mysql_close($conn);
	ob_end_flush();

?>