<?php
	# Comienzo de session
	session_start();
	
	# Compresion GZip
	if(!extension_loaded('zlib')){
		ini_set('zlib.output_compression_level', 1);  
		ob_start('ob_gzhandler'); 
	}
	
	if (isset($_SESSION['admin'])) {
		# Cargar configuracion
		require_once("../../../configuracion/database.php");
		require_once("../../../configuracion/propiedades.php");
		require_once("../../../configuracion/funciones.php");
		
		# Cargar
		if (isset($_POST['msg']) and isset($_POST['idmsg']) and is_numeric($_POST['idmsg']) and $_POST['idmsg'] > 0 and isset($_SESSION['username'])) {
			    $comentario = antiSqlInjection($_POST['msg']);
				$idmsg = antiSqlInjection($_POST['idmsg']);
				
                if(!isset($comentario) and empty($comentario)) {
                    echo "Porfavor no deje campos vacios";
                } elseif(strlen($comentario) < 20) {
                    echo "La nota es muy corta, tiene que tener mas de 20 caracteres";
                } elseif(strlen($comentario) > 400){
                    echo "La nota es muy larga, el máximo de caracteres es 400";
                } else {
                $enviar_nota = mysql_query("
					INSERT INTO `comentarios` (`cuentas_idcuenta`, `publicaciones_idpublicacion`, `comentario`) 
					VALUES ('".$pf['idcuenta']."','".$idmsg."','".$comentario."')") or die (mysql_error());
                echo "Comentario enviado";
				}
			
			} else {
				echo "Error";
				}
	
		mysql_close($conn);
		ob_end_flush();
	} else {
		echo "<div style='text-align:center; font-size:50px;'> TEST WEB</div>";
		//header('location: http://www.hostinger.es/');
		}
?>
