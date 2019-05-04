<?php

include("conexion.php");
$enlace = new Conexion();

$_usu = $_POST['txtUsuario'];
$_cla = md5($_POST['txtClave']);

$sql = "SELECT usuario.id, usuario.login, usuario.nombre FROM usuario WHERE login = '$_usu' AND clave = '$_cla'";
$array = $enlace->retrieveArray($sql);

$existe = count($array);

if($existe != 0)
{
	session_start();
	
	for($i=0;$i<count($array);$i++)
	{
		$_SESSION['loged'] = true;
		$_SESSION['login'] = $_usu;
		$_SESSION['nombre'] = $array[$i]['nombre'];
	}
	
	header("location: principal.php?pag=mto_ef");
}
else
{
	header("location: index.php");
}

?>