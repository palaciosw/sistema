<?php
include("conexion.php");
include("configura.php");

session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sistema de Control Interno</title>
    
    <link rel="icon" href="./favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
    
	<link rel="stylesheet" href="css/fuentes.css" type="text/css" media="screen" />    
    <link rel="stylesheet" href="css/html.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/menu.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/lista.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/gh-buttons.css" type="text/css" media="screen" />
    
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/maskedinput.js"></script>
</head>
<body>

<div id="header"></div>
<div id="header_menu"><?php include("menu.php"); ?></div>

<?php include($_REQUEST['pag'].".php"); ?>

</body>
</html>