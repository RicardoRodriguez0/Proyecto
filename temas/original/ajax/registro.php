<?php
if (isset($_POST['permiso']) and $_POST['permiso'] == 'allowed') {
	$cuenta = antiSqlInjection($_POST['cuenta']);
	$contraseña = antiSqlInjection($_POST['contraseña']);
	$contraseña2 = antiSqlInjection($_POST['contraseña2']);
	$email = antiSqlInjection($_POST['email']);
	$nombres = antiSqlInjection($_POST['nombres']);
	$nacimiento = antiSqlInjection($_POST['año']).'-'.antiSqlInjection($_POST['mes']).'-'.antiSqlInjection($_POST['dia']); 

if(isset($_POST['sexo'])) {
	$sexo = antiSqlInjection($_POST['sexo']);
} else {
	$sexo = 3;
	}

$crevisar = $db->query("SELECT cuenta FROM `cuentas` WHERE `cuenta`='".$cuenta."'");
$erevisar = $db->query("SELECT email FROM `cuentas` WHERE `email`='".$email."'");

/*
-----------------------
Errores al registrarse
-----------------------
*/

//$cuenta
 if(!isset($cuenta) or empty($cuenta)) {
	echo 'Porfavor llene el nombre de usuario';
} elseif(strlen($cuenta) < 4) {
	echo 'El nombre de usuario tiene que tener mas de 4 caracteres!';
} elseif(strlen($cuenta) > 20){
	echo 'El nombre de usuario tiene que tener entre 4 a 20 caracteres!';
} elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $cuenta)){
	die('<h3>Error en el nombre de usuario</h3>
		 <strong>Solo se aceptan caracteres alfanuméricos:</strong><br>
		 A-Z mayusculas y minusculas. Exeptuando la Ñ<br> 
		 Numeros: 0-9<br>
		 Signos: _ <br><br>
		 <strong>No es valido: </strong><br>
		 El espacio, todo tiene que ir pegado');
} elseif ($crevisar->num_rows != NULL) {
	echo 'Este nombre de usuario ya esta en uso';
	
//$contraseña
} elseif(!isset($contraseña) or empty($contraseña)) {
	echo 'Porfavor llene la contraseña';
} elseif(strlen($contraseña) < 6){
	echo 'La contraseña tiene que ser mayor de 6 caracteres';
} elseif(strlen($contraseña) > 30){
	echo 'La contraseña tiene que ser menor a 30 caracteres';
} elseif(!isset($contraseña2) or empty($contraseña2)) {
	echo 'Porfavor llene la verificacion de contraseña';
} elseif($contraseña !== $contraseña2) {
	echo 'Los campos de contraseña y repetir contraseña no son iguales';
	
//$email
} elseif(!isset($email) or empty($email)) {
	echo 'Porfavor llene el campo email';
} elseif(strlen($email) < 1){
	echo 'Porfavor llene el campo email';
} elseif(strlen($email) > 100){
	echo 'El email es muy largo';
} elseif ($erevisar->num_rows != NULL) {
	echo 'Este email ya esta en uso';
	
//$nombres
} elseif(!isset($nombres) or empty($nombres)) {
	echo 'Porfavor llene el campo nombres';
} elseif(strlen($nombres) < 1){
	echo 'Porfavor llene el campo nombres';
} elseif(mb_strlen($nombres, 'utf8') > 21){
	echo 'El campo nombre(s) tiene que ser menor o igual a 20 caracteres ';
	
//$nacimiento
}elseif(!isset($nacimiento) or empty($nacimiento)){
	echo 'Porfavor ponga la fecha de nacimiento!';  
} elseif($_POST['año'] == 'año' or 
		$_POST['mes'] == 'mes' or
		$_POST['dia'] == 'dia'){
	echo 'Porfavor ponga la fecha de nacimiento!'; 
} elseif (!checkdate($_POST['mes'], $_POST['dia'], $_POST['año'])) {
	echo 'Fecha de nacimiento invalidad. Esta fecha no existe';
	
//$sexo
} elseif (!isset($sexo) or empty($sexo) or $sexo == 3) { //REVISAR ERROR
	echo 'Porfavor llene el campo sexo';

/*
----------------
Envio de datos
----------------
*/

} else {
	$ia = $db->query("INSERT INTO `cuentas` (`cuenta`,`contraseña`,`nacimiento`,`email`,`nombre`,`sexo`) VALUES ('".$cuenta."','".$contraseña."','".$nacimiento."','".$email."','".$nombres."','".$sexo."')");
	echo 'Registrado';
	}
} else {
	echo 'No tienes permiso para entrar aqui!';
	}
