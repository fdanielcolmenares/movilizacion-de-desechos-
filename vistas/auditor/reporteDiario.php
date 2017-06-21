<?php 
	session_start(); 
	include("../../php/funciones.php");
	include("../../php/conex.php");

	isConnect("../../");

	if(!permisos("au")){
		salir("../../");
	}

	if(isset($_POST["tipoC"])){//2014-01-08

	$bd=Conectarse(); //".date("Y-m-d")."

	$sql="select * from Solicitud as a where fecha='".date("Y-m-d")."' and '".$_POST["tipoC"]."'=(select tipo from Empresa where idEmpresa=a.idEmpresa)";
	$res=mysql_query($sql,$bd);	//echo $sql;

	$sql2="select count(idSolicitud) as c from Solicitud as a where fecha='".date("Y-m-d")."' and '".$_POST["tipoC"]."'=(select tipo from Empresa where idEmpresa=a.idEmpresa)";
	$res4=mysql_query($sql2,$bd);
	$data4=mysql_fetch_assoc($res4);
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Reporte diario de solicitudes</title>
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
</head>

<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column"> <!-- col-md-10 col-md-offset-2-->
			<!-- <div class="container"> -->
				<img alt="140x140" src="../../ima/baner.jpg" class="img-responsive"> <!--http://lorempixel.com/1140/140/-->
			<!-- </div> -->
			<div class="panel panel-default">
				<?PHP
					require ('../../vistas/usuario/usuario.php');
				?>				
			</div>
			<div class="row clearfix">
				<div class="col-md-3 column">
					<div class="panel-group" id="panelAnalista">
						<?PHP
							require ('../../menu/menuAuditor.php');
						?>
					</div>
				</div>
				<div class="col-md-9 column">

					<form class="form-horizontal" id="reporteDiario" name="reporteDiario" action="reporteDiario.php" method="post">
						<fieldset>

						<!-- Form Name -->
						<legend>Tipo de Empresa</legend>

						<!-- Multiple Radios (inline) -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="tipoC">Tipo de empresa:</label>
						  <div class="col-md-4"> 
						    <label class="radio-inline" for="tipoC-0">
						      <input type="radio" name="tipoC" id="tipoC-0" value="o" checked="checked">
						      No exenta
						    </label> 
						    <label class="radio-inline" for="tipoC-1">
						      <input type="radio" name="tipoC" id="tipoC-1" value="e">
						      Exenta
						    </label>
						  </div>
						</div>
						<!-- Button -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="guardar"></label>
						  <div class="col-md-4">
						    <button id="mostrar" type="submit" name="mostrar" class="btn btn-primary">Mostrar</button>
						  </div>
						</div>

						</fieldset>
					</form>

					<?PHP if(isset($_POST["tipoC"])){ ?>	
					<div id="resultados">					
						<legend>Lista de solicitudes realizadas hoy (<?PHP echo date("d/m/Y"); ?>) empresas <?PHP if($_POST["tipoC"]=='o') echo "no exentas"; else echo "exentas"; ?></legend>

						<?PHP if($data4["c"]!=0){ ?>
						<h4>Total solicitudes realizadas: <strong><?PHP echo $data4["c"]; ?></strong> </h4>

						<?PHP
							while($data=mysql_fetch_assoc($res)){ 
								$sql="select razon from Empresa where idEmpresa=".$data["idEmpresa"]."";
								$res2=mysql_query($sql,$bd);
								$data2=mysql_fetch_assoc($res2);
								$sql="select tipo from Material where idSolicitud=".$data["idSolicitud"]."";
								$res3=mysql_query($sql,$bd);
								$data3=mysql_fetch_assoc($res3);
						?>

							<div class="col-md-8">
								<div class="panel panel-primary">
								  <div class="panel-heading">
								    <h3 class="panel-title">Numerdo de guia <?PHP echo $data["nGuia"]; ?></h3>
								  </div>
								  <div class="panel-body">
								    <div><strong>C&oacute;digo:</strong> <?PHP echo $data["codigo"]; ?> </div>
								    <div><strong>Empresa:</strong> <?PHP echo $data2["razon"]; ?></div>
								    <div><strong>Material:</strong> <?PHP echo $data3["tipo"]; ?></div>						    
								    <div><strong>Fecha:</strong> <?PHP echo $data["fecha"]; ?> </div>
								    <div><a class="btn btn-primary" href="../../vistas/auditor/verPlanilla.php?cod=<?PHP echo sha1($data["idSolicitud"]); ?>"><span class="glyphicon glyphicon-eye-open"></span> Ver</a></div>
								  </div>
								</div>
							</div>

						<?PHP } ?>

						<div class="col-md-8">
							<h4>Total solicitudes realizadas: <strong><?PHP echo $data4["c"]; ?></strong> </h4>
						</div>
						<?PHP } else{ ?>
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong> No se realizaron solicitudes hoy.</strong>
							</div>
						<?PHP } ?>
					</div>
					<?PHP } ?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>