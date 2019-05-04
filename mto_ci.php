<?php
include_once("conexion.php");

$sql = "SELECT concepto.id, concepto.descripcion, grupo.descripcion AS grupo FROM concepto INNER JOIN grupo ON ( concepto.idgrupo = grupo.id ) ORDER BY grupo.descripcion ASC";

$con = new Conexion();
$datos = $con->retrieveArray($sql);
?>

<br>
<table border="0" width="96%" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="25"><img src="img/unique.png"></td>
        <td style="font-size:14px; text-shadow: 0 0 150px #FFF, 0 0 60px #FFF, 0 0 10px #CCC">Listado de Conceptos Individuales</td>
        <td width="90px" align="right"><button type="button" onclick="document.location.href='principal.php?pag=<?php echo $_REQUEST['pag']; ?>_add';" name="btnNuevo" class="button icon add">Nuevo</button></td>
    </tr>
</table>
<br>

<table border="0" width="96%" align="center" cellpadding="0" cellspacing="0" class="lista_tabla">
    <tr height="26px" class="lista_header">
    	<td align="center" width="50px">ID</td>
        <td width="200px">DESCRIPCION</td>
        <td>GRUPO</td>
    </tr>
	<?php for($i=0;$i<count($datos);$i++){ ?>
    <?php if($color==constant("COLOR_LISTA_02")){$color=constant("COLOR_LISTA_01");}else{$color=constant("COLOR_LISTA_02");} ?>
    
    <tr height="25px" style="background-color: #<?php echo $color; ?>">
    	<td class="lista_celda" align="center"><?php echo $datos[$i]['id']; ?></td>
        <td class="lista_celda"><font style="color: #<?PHP echo constant("COLOR_LISTA_DESCRIPCION"); ?>"><?php echo $datos[$i]['descripcion']; ?></font></td>
        <td class="lista_celda"><?php echo $datos[$i]['grupo']; ?></td>
    </tr>
    <?php } ?>
</table>