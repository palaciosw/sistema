<script type="text/javascript">
jQuery(function($){
	$("#fecini").mask("99/99/9999");
	$("#fecfin").mask("99/99/9999");
});
</script>
        
<?php
$con = new Conexion();

if(isset($_POST['persona'])){ $tPer = $_POST['persona']; }else{ if(isset($_REQUEST['ref'])){ $tPer = $_REQUEST['ref']; }else{ $tPer = 1; } }
if(isset($_POST['fecini'])){ $fIni = $_POST['fecini']; $fFin = $_POST['fecfin']; }else{ $fIni = date('d-m-Y'); $fFin = $fIni; }

$f_ini = substr($fIni,6,4) . "-" . substr($fIni,3,2) . "-" . substr($fIni,0,2);
$f_fin = substr($fFin,6,4) . "-" . substr($fFin,3,2) . "-" . substr($fFin,0,2);

$sqlPer = "SELECT persona.id, persona.nombres FROM persona WHERE persona.id <> 3 ORDER BY persona.nombres ASC";

$sql  = "SELECT 1 AS mov, 0 AS id, '01/01/1900' AS fecha, (movimiento.importe * IF(movimiento.tipo='P',1,-1)) AS saldo,0 AS ingreso, 0 AS egreso, 'Saldo Anterior' AS detalle, '' AS concepto, '' AS moneda, '' AS tipo FROM movimiento WHERE movimiento.idpersona = $tPer AND movimiento.fecha < '$f_ini' UNION ALL ";
$sql .= "SELECT 0 AS mov, movimiento.id, movimiento.fecha, 0 AS saldo, if(movimiento.tipo='P',movimiento.importe,0) AS ingreso, if(movimiento.tipo='C',movimiento.importe,0) AS egreso, movimiento.descripcion AS detalle, concepto.descripcion AS concepto, moneda.descripcion AS moneda, movimiento.tipo FROM movimiento LEFT OUTER JOIN concepto ON ( movimiento.idconcepto = concepto.id ) LEFT OUTER JOIN moneda ON ( movimiento.idmoneda = moneda.id ) WHERE movimiento.idpersona = $tPer AND movimiento.fecha BETWEEN '$f_ini' AND '$f_fin' ORDER BY fecha";

$personas = $con->retrieveArray($sqlPer);
$datos = $con->retrieveArray($sql);
?>

<br>
<form name="frm" method="post">
<table border="0" width="96%" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="25"><img src="img/report.png"></td>
        <td style="font-size:14px; text-shadow: 0 0 150px #FFF, 0 0 60px #FFF, 0 0 10px #CCC">Reporte de Estado de Cuenta Detallado</td>
        <td width="300px">
        	<select name="persona" class="combo" style="width:300px" onchange="document.forms[0].submit();">
            <?php for($i=0;$i<count($personas);$i++){ ?>
            <option value="<?php echo $personas[$i]['id']; ?>" <?php if($personas[$i]['id']==$tPer){ echo "selected"; } ?>><?php echo $personas[$i]['nombres']; ?></option>
            <?php } ?>
            </select>
        </td>
        <td width="100px" align="right"><input type="text" value="<?php echo $fIni; ?>" name="fecini" id="fecini" style="width:80px; text-align:center"/></td>
        <td width="100px" align="right"><input type="text" value="<?php echo $fFin; ?>" name="fecfin" id="fecfin" style="width:80px; text-align:center"/></td>
        <td width="90px" align="right"><button type="submit" name="btnBusca" class="button icon search">Buscar</button></td>
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
        <td width="10px"></td>
        <td width="150px">CONCEPTO</td>
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
        <td class="lista_celda"><?php echo $datos[$i]['detalle']; ?></td>
    </tr>
    <?php } ?>
    <tr height="25px">
    	<td class="lista_celda" align="center"></td>
        <td class="lista_celda" align="center"></td>
        <td class="lista_celda" align="right"><?php echo number_format($tIng,2); ?></td>
        <td class="lista_celda" align="right"><?php echo number_format($tEgr,2); ?></td>
        <td class="lista_celda" align="right"><?php echo number_format($iSal,2); ?></td>
        <td class="lista_celda" width="10px"></td>
        <td class="lista_celda"></td>
        <td class="lista_celda"></td>
    </tr>
</table>