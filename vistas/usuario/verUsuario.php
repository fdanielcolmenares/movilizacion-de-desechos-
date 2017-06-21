<?php 
	session_start(); 

	include("../../php/funciones.php");
	include("../../php/conex.php");

	isConnect("../../");

	if(!permisos("ad")){
		salir("../../");
	}

	$id=$_GET["u"];
	$t=$_GET["t"];

	$bd=Conectarse();

	if($t=='I'){
		$sql="select * from Usuario where sha1(idUsuario)='".$id."'"; 
		$res=mysql_query($sql);	
		$data=mysql_fetch_assoc($res); //echo $sql;

		$sql="select * from Login where sha1(idUsuario)='".$id."'"; 
		$res2=mysql_query($sql);	
		$data2=mysql_fetch_assoc($res2);
	}

	if($t=='E'){
		$sql="select * from Empresa where sha1(idEmpresa)='".$id."'"; 
		$res=mysql_query($sql);	
		$data=mysql_fetch_assoc($res);

		$sql="select * from Login where sha1(idEmpresa)='".$id."'"; 
		$res2=mysql_query($sql);	
		$data2=mysql_fetch_assoc($res2);
	}	
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Consulta de Usuario</title>
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
							require ('../../menu/menuAdmin.php');
						?>
					</div>
				</div>
				<div class="col-md-9 column">

				<?php if($t=='I'){ ?>
					<!-- Form Name -->
					<legend>Datos de <?PHP echo $data["nombre"]." ".$data["apellido"]; ?></legend>

					<p><strong>Correo:</strong> <?PHP echo $data["correo"]; ?></p>
					<?PHP if($data["estado"]=='a'){ ?>
						<p><strong>Estado:</strong> ACTIVO</p>
					<?PHP } else{ ?>
						<p><strong>Estado:</strong> INACTIVO</p>
					<?PHP } ?>
					<p><strong>Usuario:</strong> <?PHP echo $data2["usuario"]; ?> </p>
					<?PHP if($data2["tipo"]=='ad'){ ?>
						<p><strong>Tipo:</strong> ADMINISTRADOR </p>
					<?PHP } if($data2["tipo"]=='au'){ ?>
						<p><strong>Tipo:</strong> AUDITOR </p>
					<?PHP } if($data2["tipo"]=='an'){ ?>
						<p><strong>Tipo:</strong> ANALISTA </p>
					<?PHP } if($data2["tipo"]=='mo'){ ?>
						<p><strong>Tipo:</strong> M&Oacute;VIL </p>
					<?PHP } ?>

				<?PHP } ?>	

				<?php if($t=='E'){ ?>
					<!-- Form Name -->
					<legend>Datos de <?PHP echo $data["razon"];?></legend>

					<p><strong>rif:</strong> <?PHP echo $data["rif"]; ?></p>
					<p><strong>tel&eacute;fono:</strong> <?PHP echo $data["telefono"]; ?></p>
					<p><strong>correo:</strong> <?PHP echo $data["correo"]; ?></p>
					<p><strong>direccio&oacute;n:</strong> <?PHP echo $data["direccion"]; ?></p>
					<?PHP if($data["tipo"]=='o'){ ?>
						<p><strong>tipo:</strong> ORDINARIO</p>
					<?PHP }else{ ?>
						<p><strong>tipo:</strong> EXENTO</p>
					<?PHP } ?>
					<p><strong>Usuario:</strong> <?PHP echo $data2["usuario"]; ?> </p>

				<?PHP } ?>				

				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<script>