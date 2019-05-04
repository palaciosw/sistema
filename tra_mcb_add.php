<script type="text/javascript">
jQuery(function($){
	$("#fecmov").mask("99/99/9999");
});
</script>
        
<?php
$idCta = $_REQUEST['ref'];
$con = new Conexion();

$sqlPer = "SELECT persona.id, persona.nombres FROM persona ORDER BY persona.nombres ASC";
$sqlCon = "SELECT concepto.id, concepto.descripcion FROM concepto ORDER BY concepto.descripcion ASC";
$sqlCta = "SELECT cuenta.id, cuenta.descripcion, cuenta.idmoneda FROM cuenta ORDER BY cuenta.descripcion ASC";
$sqlMon = "SELECT moneda.id, moneda.descripcion FROM moneda ORDER BY moneda.descripcion ASC";

$datosPer = $con->retrieveArray($sqlPer);
$datosCon = $con->retrieveArray($sqlCon);
$datosCta = $con->retrieveArray($sqlCta);
$datosMon = $con->retrieveArray($sqlMon);
?>

<br/>
<form name="frm" method="post">
<table border="0" width="96%" align="center" cellpadding="0" cellspacing="0">
	<tr height="31px">
    	<td width="25"><img src="img/addcoins.png"></td>
        <td style="font-size:14px; text-shadow: 0 0 150px #FFF, 0 0 60px #FFF, 0 0 10px #CCC">Registrar Mov. de Caja y Bancos</td>
    </tr>
</table>
<br>

<table border="0" align="center" cellpadding="0" cellspacing="0">
	<tr height="40px">
    	<td width="80px">Tipo</td>
        <td width="40px">
        	<select name="tipo" class="combo" style="width:100%">
            <option value="C">Egreso</option>
            <option value="P">Ingreso</option>
            </select>
        </td>
    	<td width="150px" align="right">Fecha&nbsp;</td>
        <td width="10px"><input type="text" name="fecmov" id="fecmov" value="<?php echo date("d/m/Y"); ?>" style="width:80px; text-align:center"/></td>
    </tr>
	<tr height="40px">
    	<td width="80px">Persona</td>
        <td colspan="3">
        	<select name="persona" class="combo" style="width:100%">
            <?php for($i=0;$i<count($datosPer);$i++){ ?>
            <option value="<?php echo $datosPer[$i]['id']; ?>"><?php echo $datosPer[$i]['nombres']; ?></option>
            <?php } ?>
            </select>
        </td>
    </tr>
	<tr height="40px">
    	<td>Concepto</td>
        <td colspan="3">
        	<select name="concepto" class="combo" style="width:100%">
            <?php for($i=0;$i<count($datosCon);$i++){ ?>
            <option value="<?php echo $datosCon[$i]['id']; ?>"><?php echo $datosCon[$i]['descripcion']; ?></option>
            <?php } ?>
            </select>
        </td>
    </tr>
	<tr height="40px">
    	<td>Cuenta</td>
        <td colspan="3">
        	<select name="cuenta" id="cuenta" class="combo" style="width:100%" onChange="document.getElementById('moneda').value = this.options[this.selectedIndex].text.substring(0,2);">
            <?php for($i=0;$i<count($datosCta);$i++){ ?>
            <option value="<?php echo $datosCta[$i]['id']; ?>" <?php if(!empty($idCta) && $datosCta[$i]['id'] == $idCta){ echo "selected"; } ?>><?php echo $datosCta[$i]['idmoneda']." - ".$datosCta[$i]['descripcion']; ?></option>
            <?php } ?>
            </select>
        </td>
    </tr>
    <tr height="40px">
    	<td>Importe</td>
        <td><input type="text" name="importe" id="importe" style="text-align:right"/></td>
        <td colspan="2">
        	<select name="moneda" id="moneda" class="combo" style="width:100%" onChange="this.value = document.getElementById('cuenta').options[document.getElementById('cuenta').selectedIndex].text.substring(0,2);" onChange="this.options[1].selected=true">
            <?php for($i=0;$i<count($datosMon);$i++){ ?>
            <option value="<?php echo $datosMon[$i]['id']; ?>"><?php echo $datosMon[$i]['descripcion']; ?></option>
            <?php } ?>
            </select>
        </td>
    </tr>
    <tr height="40px">
    	<td width="80px">Detalle</td>
        <td colspan="3"><input type="text" name="detalle" style="width:97%"/></td>
    </tr>
    <tr height="40px">
    	<td colspan="4" align="right">
	        <button type="button" onclick="document.location.href='principal.php?pag=tra_mcb&ref=<?php echo $idCta; ?>';" name="btnRegresa" class="button icon arrowleft">Regresar</button>
            <button type="submit" name="btnGuarda" class="button icon approve">Guardar</button>
        </td>
    </tr>
</table>
</form>

<?php
if(isset($_POST['btnGuarda']))
{
	//CAPTURAR DATOS
	$dTip = $_POST['tipo'];
	$dFec = $_POST['fecmov']; $dFec = substr($dFec,6,4) . "-" . substr($dFec,3,2) . "-" . substr($dFec,0,2);
	$dPer = $_POST['persona'];
	$dCon = $_POST['concepto'];
	$dCta = $_POST['cuenta'];
	$dMon = $_POST['moneda'];
	$dImp = $_POST['importe'];
	$dDet = $_POST['detalle'];
	
	$msg = "<script>document.location.href='principal.php?pag=tra_mcb&ref=$dCta';</script>";
	
	//VALIDACION
	if(empty($dTip) || empty($dFec) || empty($dPer) || empty($dCon) || empty($dCta) || empty($dMon) || empty($dImp) || empty($dDet))
	{
		$msg = "<br><center><font style='color: #B31E21'>Todos los datos son necesarios</font></center>";
	}
	else
	{
		$sql  = "INSERT INTO movimiento (idpersona,idmoneda,idconcepto,idcuenta,tipo,fecha,importe,descripcion) ";
		$sql .= "VALUES ($dPer,'$dMon',$dCon,$dCta,'$dTip','$dFec','$dImp','$dDet')";
		
		$con->retrieveQuery($sql);
		$id = $con->retrieveLastID();
	}
	
	echo $msg;
}
?>