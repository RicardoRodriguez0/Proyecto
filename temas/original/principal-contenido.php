<?php
$counts = mysql_query("SELECT idpublicacion FROM publicaciones") or die (mysql_error());
$count = (mysql_num_rows($counts));

if (isset($_GET['pos']) and is_numeric($_GET['pos']) and $_GET['pos'] >= 0) {
	if (($_GET['pos'] + 0.1) <= (($count / 10))) {
		$inicio=$_GET['pos'];
	} else {
		header("Location: ?&p=404");  
	}
} else {
	$inicio=0;
	}
	
/* 
	Comentarios
*/
if (isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] >= 0 /* and $_GET['id'] <= $count REVISAR*/) {
	$com=$_GET['id'];
	$registro_com=mysql_query("
	SELECT cuentas.idcuenta, cuentas.cuenta, cuentas.nombres, cuentas.apellidos, cuentas.imagen_perfil, cuentas.imagen_perfil_fondo, comentarios.cuentas_idcuenta, comentarios.publicaciones_idpublicacion, comentarios.comentario, comentarios.tiempo_de_creacion, comentarios.idcomentario,publicaciones.idpublicacion
	FROM comentarios 
	INNER JOIN publicaciones
	ON publicaciones.idpublicacion = comentarios.publicaciones_idpublicacion
	INNER JOIN cuentas
	ON cuentas.idcuenta = comentarios.cuentas_idcuenta
	WHERE publicaciones.idpublicacion=$com
	ORDER BY `idcomentario` DESC
	", $conn) or die(mysql_error());
} else {
	#REVISAR EN EL FUTURO
	/* 
		Esta accion se encuentra mas abajo
	*/
}
						
/* 
	PUBLICACIONES 
*/
if (!isset($_GET['id'])) {
	$inicio_2 = $inicio*10;
	$registros=mysql_query("
		SELECT cuentas.idcuenta, cuentas.cuenta, cuentas.nombres, cuentas.apellidos, cuentas.imagen_perfil, cuentas.imagen_perfil_fondo, publicaciones.idpublicacion, publicaciones.publicacion, publicaciones.tiempo_de_creacion, publicaciones.imagenes_idimagenes, imagenes.idimagenes, imagenes.ruta
		FROM cuentas
		INNER JOIN publicaciones 
		ON cuentas.idcuenta = publicaciones.cuentas_idcuenta
		INNER JOIN imagenes
		ON publicaciones.imagenes_idimagenes = imagenes.idimagenes
		ORDER BY `idpublicacion` DESC
		LIMIT $inicio_2,10", $conn) or die(mysql_error());
	$imp = 0;
	while ($reg=mysql_fetch_array($registros)) {
		post($reg);
		$imp++;
		if($imp == 5) {
			?>
            <div class="well-bl-2 visible-xs visible-sm"><div class="row"><div class="col-xs-12"><?php publicidad(); ?></div></div></div>
			<?php
		} else {
			echo "";
			}
				
	}
	
	$link = "?pos";
	mostrar_mas($inicio, $count, $link);
		
/* 
	COMENTARIOS
*/
} else {
	if(isset($com)) {
		$registros=mysql_query("
		SELECT cuentas.idcuenta, cuentas.cuenta, cuentas.nombres, cuentas.apellidos, cuentas.imagen_perfil, cuentas.imagen_perfil_fondo, publicaciones.idpublicacion, publicaciones.publicacion, publicaciones.tiempo_de_creacion, publicaciones.imagenes_idimagenes, imagenes.idimagenes, imagenes.ruta
		FROM cuentas
		INNER JOIN publicaciones 
		ON cuentas.idcuenta = publicaciones.cuentas_idcuenta
		INNER JOIN imagenes
		ON publicaciones.imagenes_idimagenes = imagenes.idimagenes
			WHERE idpublicacion = '$com'", $conn) or die(mysql_error());
		$reg=mysql_fetch_array($registros);
		post($reg);?>
		<div class="row">
            <div class="col-xs-12">


		<?php
		if(isset($_SESSION['username'])) {
			if(!isset($_POST['enviar_nota'])) {
				?>
                        <script>
						function comentario(msg, idmsg){
								var parametros = {
										"msg" : msg,
										"idmsg" : idmsg,
								};
								$.ajax({
										data:  parametros,
										url:   '<?php echo "temas/".$prop['tema']."/ajax/comentario.php"; ?>',
										type:  'post',
										beforeSend: function () {
												$("#resultado").html("Cargando...");
										},
										success:  function (response) {
												$("#resultado").html(response);
										}
								});
						}
						</script>
                <div class="well-bl-1">
                	Manda un comentario:
                    <form method="post" action="">
                        <textarea class="form-control" id="comentario" type="text" name="comentario" maxlength="400" required></textarea>
                        <buttom class="btn btn-warning form-control" name="enviar_notas"
                        onclick="comentario($('#comentario').val(), <?php echo $com;?>);return false;">Enviar comentario</buttom>
                        <div id="resultado"></div>
                    </form>
				</div><?php
            } else {
				?><div class="well-bl-1"><?php
                $idcuentap = mysql_query("SELECT idcuenta, email FROM cuentas WHERE email = '$_SESSION[username]'");
                $idcuentap2 = mysql_fetch_array($idcuentap);
                $idcuenta = $idcuentap2['idcuenta'];
                $comentario = antiSqlInjection($_POST['comentario']);
                if(!isset($comentario) and empty($comentario)) {
                    echo "Porfavor no deje campos vacios";
                } elseif(strlen($comentario) < 20) {
                    echo "La nota es muy corta, tiene que tener mas de 20 caracteres";
                } elseif(strlen($comentario) > 400){
                    echo "La nota es muy larga, el máximo de caracteres es 400";
                } else {
                $enviar_nota = mysql_query("
					INSERT INTO `comentarios` (`cuentas_idcuenta`, `publicaciones_idpublicacion`, `comentario`) 
					VALUES ('".$idcuenta."','".$com."','".$comentario."')") or die (mysql_error());
                echo "Comentario enviado";
				?></div><?php
                    }
                }
		} else { ?>
        <div class="row">
        <div class="col-xs-12">
        <div class="well-bl-1">
			<?php echo "Para escribir un comentario nesecitas tener una cuenta e iniciar sesión"; ?>
        </div></div></div><?php
		}
		if (mysql_num_rows($registro_com) > 0) {
			while ($cm=mysql_fetch_array($registro_com)) {
				post($cm);
				}
		} else {
			?><div class="row">
            <div class="col-xs-12">
            <div class="well-bl-1">
            	No hay comentarios
            </div></div></div>
		<?php }
	} else {
		header("Location: ?&pos=$inicio");
		}
		?>
	</div>
</div>
		<?php
	}
?>