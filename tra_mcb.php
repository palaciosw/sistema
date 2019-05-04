<script type="text/javascript">
jQuery(function($){
	$("#fecini").mask("99/99/9999");
	$("#fecfin").mask("99/99/9999");
});
</script>
        
<?php
$con = new Conexion();

if(isset($_POST['cuenta'])){ $tCta = $_POST['cuenta']; }else{ if(isset($_REQUEST['ref'])){ $tCta = $_REQUEST['ref']; }else{ $tCta = $con->retrieveField("SELECT cuenta.id FROM cuenta WHERE cuenta.defecto = '1'"); } }
if(isset($_POST['fecini'])){ $fIni = $_POST['fecini']; $fFin = $_POST['fecfin']; }else{ $fIni = date('d-m-Y'); $fFin = $fIni; }

$f_ini = substr($fIni,6,4) . "-" . substr($fIni,3,2) . "-" . substr($fIni,0,2);
$f_fin = substr($fFin,6,4) . "-" . substr($fFin,3,2) . "-" . substr($fFin,0,2);

//QUERY PARA COMBO
$sqlCta = "SELECT cuenta.id, cuenta.descripcion FROM cuenta ORDER BY cuenta.descripcion ASC";

//QUERY PARA CONTENIDO
$sql  = "SELECT 1 AS mov, '' AS persona, '' AS moneda, '' AS concepto, '' AS cuenta, 0 AS id, '' AS tipo, '1900-01-01' AS fecha,SUM(movimiento.importe * IF(movimiento.tipo='P',1,-1)) AS saldo, 0 AS ingreso, 0 AS egreso, 'Saldo Anterior' AS descripcion FROM movimiento WHERE movimiento.idcuenta = $tCta AND movimiento.fecha < '$f_ini' UNION ALL ";
$sql .= "SELECT 0 AS mov, persona.nombres AS persona, moneda.descripcion AS moneda, concepto.descripcion AS concepto, cuenta.descripcion AS cuenta, movimiento.id, movimiento.tipo, movimiento.fecha, 0 AS saldo, if(movimiento.tipo='P',movimiento.importe,0) AS ingreso, if(movimiento.tipo='C',movimiento.importe,0) AS egreso, movimiento.descripcion FROM movimiento LEFT OUTER JOIN persona ON ( movimiento.idpersona = persona.id ) INNER JOIN moneda ON ( movimiento.idmoneda = moneda.id ) INNER JOIN concepto ON ( movimiento.idconcepto = concepto.id ) LEFT OUTER JOIN cuenta ON ( movimiento.idcuenta = cuenta.id ) WHERE movimiento.idcuenta = $tCta AND movimiento.fecha BETWEEN '$f_ini' AND '$f_fin' ORDER BY fecha ASC, tipo DESC, id ASC";

$datos = $con->retrieveArray($sql);
$cuentas = $con->retrieveArray($sqlCta);
?>

<br>
<form name="frm" method="post">
<table border="0" width="96%" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="25"><img src="img/money.png"></td>
        <td style="font-size:14px; text-shadow: 0 0 150px #FFF, 0 0 60px #FFF, 0 0 10px #CCC">Listado de Mov. de Caja y Bancos</td>
        <td width="120px" align="right">Seleccione Cuenta&nbsp;</td>
        <td width="200px">
        	<select name="cuenta" id="cuenta" class="combo" style="width:200px" onchange="document.forms[0].submit();">
            <?php for($i=0;$i<count($cuentas);$i++){ ?>
            <option value="<?php echo $cuentas[$i]['id']; ?>" <?php if($cuentas[$i]['id']==$tCta){ echo "selected"; } ?>><?php echo $cuentas[$i]['descripcion']; ?></option>
            <?php } ?>
            </select>
        </td>
        <td width="100px" align="right"><input type="text" value="<?php echo $fIni; ?>" name="fecini" id="fecini" style="width:80px; text-align:center"/></td>
        <td width="100px" align="right"><input type="text" value="<?php echo $fFin; ?>" name="fecfin" id="fecfin" style="width:80px; text-align:center"/></td>
        <td width="90px" align="right"><button type="submit" name="btnBusca" class="button icon search">Buscar</button></td>
        <td width="90px" align="right"><button type="button" onclick="document.location.href='principal.php?pag=tra_mcb_add&ref=' + document.getElementById('cuenta').value;" name="btnNuevo" class="button icon add">Nuevo</button></td>
    </tr>
</table>
</form>
<br>

<table border="0" width="96%" align="center" cellpadding="0" cellspacing="0" class="lista_tabla">
    <tr height="26px" class="lista_header">
    	<td align="center" width="50px">ID</td>
        <td align="center" width="80px">FECHA</td>
        <td width="75px" align="right">INGRESO</td>
        <td width="75px" align="right">EGRESO</td>
        <td width="75px" align="right">SALDO</td>
        <td width="15px"></td>
        <td width="150px">CONCEPTO</td>
        <td width="150px">PERSONA</td>
        <td>DETALLE</td>
    </tr>
	<?php for($i=0;$i<count($datos);$i++){ ?>
    <?php if($datos[$i]['mov']=='1'){$color=constant("COLOR_MOV_SALDO");}else{if($datos[$i]['tipo']=='P'){$color=constant("COLOR_MOV_EGRESO");}else{$color=constant("COLOR_MOV_INGRESO");}} ?>
    <?php
	$iIng = $datos[$i]['ingreso']; $tIng = $tIng + $iIng;
	$iEgr = $datos[$i]['egreso']; $tEgr = $tEgr + $iEgr;
	$iSal = $iSal + $datos[$i]['saldo'] + $iIng - $iEgr;
	?>
    <tr height="25px" style="background-color: #<?php echo $color; ?>">
    	<td class="lista_celda" align="center"><?php echo $datos[$i]['id']; ?></td>
        <td class="lista_celda" align="center"><?php if($datos[$i]['id']!=0){ echo $datos[$i]['fecha']; } ?></td>
        <td class="lista_celda" align="right"><?php echo number_format($iIng,2); ?></td>
        <td class="lista_celda" align="right"><?php echo number_format($iEgr,2); ?></td>
        <td class="lista_celda" align="right"><?php echo number_format($iSal,2); ?></td>
        <td class="lista_celda"></td>
        <td class="lista_celda"><?php echo $datos[$i]['concepto']; ?></td>
        <td class="lista_celda"><?php echo $datos[$i]['persona']; ?></td>
        <td class="lista_celda"><?php echo $datos[$i]['descripcion']; ?></td>
    </tr>
    <?php } ?>
    <tr height="25px">
    	<td class="lista_celda" align="center"></td>
        <td class="lista_celda" align="center"></td>
        <td class="lista_celda" align="right"><?php echo number_format($tIng,2); ?></td>
        <td class="lista_celda" align="right"><?php echo number_format($tEgr,2); ?></td>
        <td class="lista_celda" align="right"><?php echo number_format($iSal,2); ?></td>
        <td class="lista_celda" width="15px"></td>
        <td class="lista_celda"></td>
        <td class="lista_celda"></td>
        <td class="lista_celda"></td>
    </tr>
</table>