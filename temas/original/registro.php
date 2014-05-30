<div class="well-bl-1">
<?php
if (!isset($_SESSION["username"])) {
?>
<script>
function registro(permiso, cuenta, contraseña, contraseña2, email, nombres, dia, mes, año, sexo){
		var parametros = {
				"permiso" : permiso,
				"cuenta" : cuenta,
				"contraseña" : contraseña,
				"contraseña2" : contraseña2,
				"email" : email,
				"nombres" : nombres,
				"dia" : dia,
				"mes" : mes,
				"año" : año,
				"sexo" : sexo,
		};
		$.ajax({
				data:  parametros,
				url:   '<?php echo "temas/".$prop['tema']."/ajax/registro.php"; ?>',
				type:  'post',
				beforeSend: function () {
						$("#resultado").html("Enviando...");
				},
				success:  function (response) {
						$("#resultado").html(response);
				}
		});
}
</script>
<form method="post" action="">
<div class="row">
    <div class="col-xs-12">
        <label for="registro-form-cuenta-input" id="registro-form-label">Nombre de usuario</label>
        <p><input class="form-control" type="text" name="cuenta" id="registro-form-cuenta-input" maxlength="15"  placeholder="nombre de usuario" required></p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <label for="registro-form-contraseña1-input" id="registro-form-label">Contraseña</label>
    <p><input class="form-control" type="password" name="contraseña" id="registro-form-contraseña1-input" maxlength="30" placeholder="nueva contraseña" required></p>
    </div>
    <div class="col-md-6">
    <label for="registro-form-contraseña2-input" id="registro-form-label">Repetir contraseña</label>
    <p><input class="form-control" type="password" name="contraseña2" id="registro-form-contraseña2-input" maxlength="30" placeholder="repita contraseña" required></p>
    </div> 
</div>
<div class="row">
    <div class="col-xs-12"> 
    <label for="registro-form-correo-input" id="registro-form-label">Correo electrónico</label>
    <p><input class="form-control" type="email" name="email" id="registro-form-correo-input" maxlength="100" placeholder="correo electrónico" required></p>
    </div> 
</div>
<div class="row">
    <div class="col-md-12"> 
    <label for="registro-form-nombres-input" id="registro-form-label">Nombre y apellido</label>
    <p><input class="form-control" type="text" name="nombres" id="registro-form-nombres-input" maxlength="20" placeholder="nombre y apellido" required></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
    	<label class="text-center">Nacimiento:</label>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo mostrarNacimiento('dia'); ?>
    </div>
    <div class="col-md-4">
        <?php echo mostrarNacimiento('mes'); ?>
    </div>
    <div class="col-md-4">
        <?php echo mostrarNacimiento('año'); ?>
    </div>
</div>
<p>
<div class="row">
	<div class="col-md-12 text-center">     
        <label for="hombre" id="registro-form-label">
            Hombre
        </label>
        <input type="radio" name="sexo" class="registro-form-sexo-input" id="hombre" value="1">
        <label for="mujer" id="registro-form-label">
            Mujer
        </label>
        <input type="radio" name="sexo" class="registro-form-sexo-input"  id="mujer" value="2">
    </div>
</div>
</p>
<div class="row">
	<div class="col-xs-12">
    	<buttom onclick="registro(
        'allowed',
        $('#registro-form-cuenta-input').val(),
        $('#registro-form-contraseña1-input').val(),
        $('#registro-form-contraseña2-input').val(),
        $('#registro-form-correo-input').val(),
        $('#registro-form-nombres-input').val(),
        $('#dia').val(),
        $('#mes').val(),
        $('#año').val(),
        $('.registro-form-sexo-input').val()
        );return false;" name="registro" class="btn btn-warning form-control">Registrarse</buttom>
	</div>
</div>
</form>
<div id="resultado">
</div>
</div>
<?php

} else {
	header("Location: ?p=404");
	}
	
		
?>