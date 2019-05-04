<?php $con = new Conexion(); ?>

<br/>
<form name="frm" method="post">
<table border="0" width="96%" align="center" cellpadding="0" cellspacing="0">
	<tr height="31px">
    	<td width="25"><img src="img/build_add.png"></td>
        <td style="font-size:14px; text-shadow: 0 0 150px #FFF, 0 0 60px #FFF, 0 0 10px #CCC">Registrar de Entidades Financieras</td>
    </tr>
</table>
<br>

<table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr height="40px">
    	<td width="100px">Descripcion</td>
        <td width="300px"><input type="text" name="descripcion" style="width:96%"/></td>
    </tr>
    <tr height="40px">
    	<td colspan="2" align="right">
	        <button type="button" onclick="document.location.href='principal.php?pag=<?php echo substr($_REQUEST['pag'],0,6); ?>';" name="btnRegresa" class="button icon arrowleft">Regresar</button>
            <button type="submit" name="btnGuarda" class="button icon approve">Guardar</button>
        </td>
    </tr>
</table>
</form>

<?php
if(isset($_POST['btnGuarda']))
{
	//CAPTURAR DATOS
	$dDes = $_POST['descripcion'];
	
	$msg = "<script>document.location.href='principal.php?pag=".substr($_REQUEST['pag'],0,6)."';</script>";
	
	//VALIDACION
	if(empty($dDes))
	{
		$msg = "<br><center><font style='color: #B31E21'>Todos los datos son necesarios</font></center>";
	}
	else
	{
		$sql  = "INSERT INTO entidad (descripcion) VALUES ('$dDes')";
		
		$con->retrieveQuery($sql);
		$id = $con->retrieveLastID();
	}
	
	echo $msg;
}
?>