<?php
$con = new Conexion();

$sqlEnt = "SELECT entidad.id, entidad.descripcion FROM entidad ORDER BY entidad.descripcion ASC";
$sqlMon = "SELECT moneda.id, moneda.descripcion FROM moneda ORDER BY moneda.descripcion ASC";

$datosEnt = $con->retrieveArray($sqlEnt);
$datosMon = $con->retrieveArray($sqlMon);
?>

<br/>
<form name="frm" method="post">
<table border="0" width="96%" align="center" cellpadding="0" cellspacing="0">
	<tr height="31px">
    	<td width="25"><img src="img/bank_add.png"></td>
        <td style="font-size:14px; text-shadow: 0 0 150px #FFF, 0 0 60px #FFF, 0 0 10px #CCC">Registrar de Cajas y Bancos</td>
    </tr>
</table>
<br>

<table border="0" align="center" cellpadding="0" cellspacing="0">
	<tr height="40px">
    	<td>Entidad Financiera</td>
        <td width="300px">
        	<select name="entidad" class="combo" style="width:100%">
            <?php for($i=0;$i<count($datosEnt);$i++){ ?>
            <option value="<?php echo $datosEnt[$i]['id']; ?>"><?php echo $datosEnt[$i]['descripcion']; ?></option>
            <?php } ?>
            </select>
        </td>
    </tr>
    <tr height="40px">
    	<td>Moneda</td>
        <td>
        	<select name="moneda" class="combo" style="width:100%" >
            <?php for($i=0;$i<count($datosMon);$i++){ ?>
            <option value="<?php echo $datosMon[$i]['id']; ?>"><?php echo $datosMon[$i]['descripcion']; ?></option>
            <?php } ?>
            </select>
        </td>
    </tr>
    <tr height="40px">
    	<td width="120px">Descripcion</td>
        <td><input type="text" name="descripcion" style="width:96%"/></td>
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
	$dEnt = $_POST['entidad'];
	$dMon = $_POST['moneda'];
	$dDes = $_POST['descripcion'];
	
	$msg = "<script>document.location.href='principal.php?pag=".substr($_REQUEST['pag'],0,6)."';</script>";
	
	//VALIDACION
	if(empty($dEnt) || empty($dMon) || empty($dDes))
	{
		$msg = "<br><center><font style='color: #B31E21'>Todos los datos son necesarios</font></center>";
	}
	else
	{
		$sql  = "INSERT INTO cuenta (identidad,idmoneda,descripcion,defecto) ";
		$sql .= "VALUES ($dEnt,'$dMon','$dDes','0')";
		
		$con->retrieveQuery($sql);
		$id = $con->retrieveLastID();
	}
	
	echo $msg;
}
?>