<script type="text/javascript">
jQuery(function($){
	$("#fecini").mask("99/99/9999");
	$("#fecfin").mask("99/99/9999");
});
</script>
        
<?php
$con = new Conexion();

if(isset($_POST['fecini'])){ $fIni = $_POST['fecini']; $fFin = $_POST['fecfin']; }else{ $fIni = '01-01-2013'; $fFin = date('d-m-Y'); }
$f_ini = substr($fIni,6,4) . "-" . substr($fIni,3,2) . "-" . substr($fIni,0,2);
$f_fin = substr($fFin,6,4) . "-" . substr($fFin,3,2) . "-" . substr($fFin,0,2);

//QUERY PARA CONTENIDO
$sql = "SELECT persona.id, persona.nombres AS persona, SUM(movimiento.importe * IF(movimiento.tipo='P',1,-1)) AS importe FROM movimiento INNER JOIN persona ON ( movimiento.idpersona = persona.id ) WHERE movimiento.idpersona <> 3 AND movimiento.fecha BETWEEN '$f_ini' AND '$f_fin' GROUP BY persona.id, persona.nombres ORDER BY importe DESC";
$datos = $con->retrieveArray($sql);
?>

<br>
<form name="frm" method="post">
<table border="0" width="96%" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="25"><img src="img/report.png"></td>
        <td style="font-size:14px; text-shadow: 0 0 150px #FFF, 0 0 60px #FFF, 0 0 10px #CCC">Reporte de Deudas por Cobrar y Pagar</td>
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
        <td>PERSONA</td>
        <td align="right">IMPORTE</td>
        <td width="10px"></td>
        <td width="270px">&nbsp;</td>
    </tr>
	<?php for($i=0;$i<count($datos);$i++){ ?>
    <?php if($color==constant("COLOR_LISTA_02")){$color=constant("COLOR_LISTA_01");}else{$color=constant("COLOR_LISTA_02");} ?>
    <?php
	$iIng = $datos[$i]['ingreso'];
	?>
    <tr height="25px" style="background-color: #<?php echo $color; ?>">
    	<td class="lista_celda" align="center"><?php echo $datos[$i]['id']; ?></td>
		<td class="lista_celda"><?php echo $datos[$i]['persona']; ?></td>
        <td class="lista_celda" align="right"><?php echo number_format($datos[$i]['importe'],2); ?></td>
        <td class="lista_celda"></td>
        <td class="lista_celda">A favor de <?php if($datos[$i]['importe']<0){ echo $_SESSION['nombre']; }else{ echo $datos[$i]['persona']; } ?></td>
    </tr>
    <?php } ?>
    <tr height="25px">
    	<td class="lista_celda" align="center"></td>
        <td class="lista_celda" align="center"></td>
        <td class="lista_celda" align="right"><?php echo number_format($tIng,2); ?></td>
        <td class="lista_celda" align="center"></td>
        <td class="lista_celda" align="center"></td>
    </tr>
</table>