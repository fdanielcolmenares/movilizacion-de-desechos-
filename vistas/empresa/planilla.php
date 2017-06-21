<?php 
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");

	if(!isset($_GET["e"])){
		if(!permisos("em")){
			salir("../../");
		}
	}

	$bd=Conectarse();

	$sql="select idSolicitud from Solicitud where sha1(nGuia)='".$_GET["c"]."'";
	$res=mysql_query($sql);
	$data=mysql_fetch_assoc($res);	
	
	$cod=$data["idSolicitud"];

	$sql="select estado from Estado_solicitud where idSolicitud=".$cod."";
	$res=mysql_query($sql);
	$data=mysql_fetch_assoc($res);

	if($data["estado"]!="APROVADO"){
		echo'
				 <script type="text/javascript">
	  				window.location="../../index.php";
				 </script>
			';
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Imprimir solicitud</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Daniel">

	<!--link rel="stylesheet/less" href="../../less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="../../less/responsive.less" type="text/css" /-->
	<!--script src="../../js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="../../js/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../../js/dist/css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="../../js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../js/dist/img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../js/dist/img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../js/dist/img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="../../js/dist/img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="../../js/dist/img/favicon.png">
  
	<script type="text/javascript" src="../../js/dist/js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../js/dist/js/scripts.js"></script>	
	<script type="text/javascript" src="../../js/dist/js/jquery-barcode.js"></script>	
</head>
<!--style="background-image: url('../../ima/caimta_logo.png'); background-repeat: no-repeat; background-position: 50% 50%;"-->
<body onload="window.print();"> <!--onload="window.print();"-->
<div class="container">
	<div class="row clearfix">		
		<div class="col-md-12 column"> <!-- col-md-10 col-md-offset-2-->
			<!-- <div class="container"> -->
				<img src="../../ima/banerPlanilla.png" class="img-responsive"> <!--http://lorempixel.com/1140/140/-->
			<!-- </div> -->
			<div class="row clearfix">
				<div class="col-md-12 column">

					<?PHP 
						$sql="select * from Solicitud where idSolicitud='".$cod."'"; 
						$res=mysql_query($sql);
						$data=mysql_fetch_assoc($res);

						$sql="select fecha from Estado_solicitud where idSolicitud='".$cod."'"; 
						$res2=mysql_query($sql);
						$data2=mysql_fetch_assoc($res2); 

						$fecha = $data2["fecha"];
						$nuevafecha = strtotime ( '+5 day' , strtotime ( $fecha ) ) ;
						$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

						$sql="select * from Empresa where idEmpresa='".$data["idEmpresa"]."'"; 
						$res3=mysql_query($sql);
						$data3=mysql_fetch_assoc($res3);

						$sql="select * from Vehiculo where idSolicitud='".$cod."'"; 
						$res4=mysql_query($sql);
						$data4=mysql_fetch_assoc($res4);

						$sql="select * from Conductor where idSolicitud='".$cod."'"; 
						$res5=mysql_query($sql);
						$data5=mysql_fetch_assoc($res5);

						$sql="select * from Material where idSolicitud='".$cod."'"; 
						$res6=mysql_query($sql);
						$data6=mysql_fetch_assoc($res6);

						$sql="select * from Destinatario where idSolicitud='".$cod."'";
						$res7=mysql_query($sql);
						$data7=mysql_fetch_assoc($res7);
					?>

					<div style="position:absolute; top:180px; right:200px; z-index: 0;" class="visible-print">
						<img src="../../ima/caimta_logo.png">
					</div>

					<table class="table table-bordered">
					  <tr>
					  	<th><div id="barra" class="col-md-4"></div></th>
					  	<th><strong>N. Gu&iacute;a:</strong> <?PHP echo $data["nGuia"]; ?></th>
					  	<th><strong>C&oacute;digo:</strong> <?PHP echo $data["codigo"]; ?></th>
					  </tr>
					</table>

					<script type="text/javascript">
						$("#barra").barcode("<?PHP echo $data["nGuia"]; ?>", "code11",{barWidth:3, barHeight:30, showHRI:false});
					</script>

					<table class="table table-bordered">
					  <tr class="success">
					  	<th>Estatus: APROBADA</th>
					  	<th>Fecha de emisi&oacute;n: <?PHP echo $data2["fecha"]; ?></th>
					  	<th>Fecha de Vencimiento: <?PHP echo $nuevafecha; ?></th>
					  </tr>
					  <tr class="active">
					    <th colspan="3">Datos de la empresa</th>
					  </tr>
					  <tr>
					    <th colspan="3">Raz&oacute;n social: <?PHP echo $data3["razon"]; ?></th>
					  </tr>
					  <tr>
					  	<th>RIF o C.I: <?PHP echo $data3["rif"]; ?></th>
					  	<th>Tel&eacute;fono: <?PHP echo $data3["telefono"]; ?></th>
					  	<th>Correo: <?PHP echo $data3["correo"]; ?></th>
					  </tr>
					  <tr>
					    <th colspan="3">Direcci&oacute;n: <?PHP echo $data3["direccion"]; ?></th>
					  </tr>
					  <tr class="active">
					    <th colspan="3">Datos del veh&iacute;culo</th>
					  </tr>
					  <tr>
					  	<th>Tipo: <?PHP echo $data4["tipo"]; ?></th>
					  	<th>Modelo del Veh&iacute;culo: <?PHP echo $data4["modelo"]; ?></th>
					  	<th>Color: <?PHP echo $data4["color"]; ?></th>
					  </tr>
					  <tr>
					  	<th>Placa chuto: <?PHP echo $data4["pChuto"]; ?></th>
					  	<th>Placa Batea: <?PHP echo $data4["pBatea"]; ?></th>
					  	<th>A&ntilde;o: <?PHP echo $data4["ano"]; ?></th>
					  </tr>
					  <tr class="active">
					    <th colspan="3">Datos del conductor</th>
					  </tr>
					  <tr>
					    <th colspan="2">Nombre y apellido: <?PHP echo $data5["nombre"]." ".$data5["apellido"]; ?></th>
					    <th>C&eacute;dula: <?PHP echo $data5["cedula"]; ?></th>
					  </tr>
					  <tr class="active">
					    <th colspan="3">Tipo de material</th>
					  </tr>
					  <tr>
					    <th colspan="2">Material: <?PHP echo $data6["tipo"]; ?></th>
					    <th>Toneladas: <?PHP echo $data6["peso"]; ?></th>
					  </tr>
					  <tr class="active">
					    <th colspan="3">Datos del Destinatario</th>
					  </tr>
					  <tr>
					    <th colspan="2">RIF o Cedula: <?PHP echo $data7["rif"]; ?></th>
					    <th>Tel&eacute;fono: <?PHP echo $data7["telefono"]; ?></th>
					  </tr>
					  <tr>
					    <th colspan="3">Raz&oacute;n social: <?PHP echo $data7["razon"]; ?></th>
					  </tr>
					  <tr>
					    <th colspan="3">Direcci&oacute;n: <?PHP echo $data7["direccion"]; ?></th>
					  </tr>
					  <tr>
					    <th colspan="3">Finalidad: <?PHP echo $data7["finalidad"]; ?></th>
					  </tr>
					</table>
					<table style="width:900px">
						<tr>
							<td align="center">Contacto: <b>amorales.caimta@gmail.com</b>  Tel&eacute;fono: <b>(0424)-6925396</b> </td>
						</tr>
					</table>
					<div class="form-group hidden-print">	
						<label class="col-md-4 control-label" for="buscar"></label>	
						<div class="col-md-4">
							<a href="../../vistas/empresa/listadoSolE.php" class="btn btn-primary hidden-print">Regresar</a>
							<button id="buscar" type="button" name="buscar" class="btn btn-success hidden-print" onclick="window.print();"><span class="glyphicon glyphicon-print">Imprimir</span></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>