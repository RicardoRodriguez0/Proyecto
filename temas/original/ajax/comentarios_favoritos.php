<?php
if(!isset($indexphp) and $indexphp !== TRUE) {
	header('Location: /index.php');
	exit;
}
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['idcom']) && $_POST['idcom'] > 0 && is_numeric($_POST['idcom']) && rango() >= 1) {
	$idcom = $_POST['idcom'];
	
	if ($fav_is_p = $db->query('SELECT cuentas_idcuenta, comentarios_idcomentario FROM comentarios_favoritos WHERE comentarios_idcomentario = '.$idcom.' AND cuentas_idcuenta = '.$pf['idcuenta'])) {
		$fav_is =  $fav_is_p->num_rows;
	}
	
	if ($fav_p = $db->query('SELECT * FROM comentarios_favoritos WHERE comentarios_idcomentario = '.$idcom)) {
		$fav = $fav_p->num_rows;
	}
	
	if ($fav_is > 0) {
		$ia = $db->query("DELETE FROM comentarios_favoritos WHERE cuentas_idcuenta = ".$pf['idcuenta']." and comentarios_idcomentario = ".$idcom);
		puntos('-','2','comentarios','idcomentario',$idcom);
		echo $fav - 1;
	} else {
		$ia = $db->query('INSERT INTO `comentarios_favoritos` (`cuentas_idcuenta`,`comentarios_idcomentario`) VALUES ('.$pf['idcuenta'].','.$idcom.')');
		puntos('+','2','comentarios','idcomentario',$idcom);
		echo $fav + 1;
		}
			
} else {
	echo 'Inicia sesión';
	}
