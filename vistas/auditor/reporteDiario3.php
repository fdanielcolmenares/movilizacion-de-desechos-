<?php 
	session_start(); 
	include("../../php/funciones.php");
	include("../../php/conex.php");

	isConnect("../../");

	if(!permisos("au")){
		salir("../../");
	}

	if(isset($_POST["tipoC"])){ //2013-12-22

	$bd=Conectarse();

	$sql="select * from Solicitud as a where 'RECHAZADO'=(select estado from Estado_solicitud where  a.idSolicitud=idSolicitud and fecha='".date("Y-m-d")."' order by estado desc limit 1) and '".$_POST["tipoC"]."'=(select tipo from Empresa where idEmpresa=a.idEmpresa)";
	$res=mysql_query($sql,$bd);	

	$sql2="select count(idSolicitud) as c from Solicitud as a where 'RECHAZADO'=(select estado from Estado_solicitud where  a.idSolicitud=idSolicitud and fecha='".date("Y-m-d")."' order by estado desc limit 1) and '".$_POST["tipoC"]."'=(select tipo from Empresa where idEmpresa=a.idEmpresa)";
	$res6=mysql_query($sql2,$bd);
	$data6=mysql_fetch_assoc($res6);

	$cantidad=$data6["c"];

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
	<link rel="stylesheet" href="../../js/dist/css/bootstrap-image-gallery.min.css">
	<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">

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
    <script src="../../js/bootstrap-image-gallery.min.js"></script>
    <script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
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

					<form class="form-horizontal" id="reporteDiario3" name="reporteDiario3" action="reporteDiario3.php" method="post">
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
						<legend>Lista de solicitudes rechazadas hoy (<?PHP echo date("d/m/Y"); ?>) empresas <?PHP if($_POST["tipoC"]=='o') echo "no exentas"; else echo "exentas"; ?></legend>
						<?PHP if($cantidad!=0){ ?>
						<h4>Total solicitudes rechazadas: <strong><?PHP echo $cantidad; ?></strong> </h4>
						<?PHP
							while($data=mysql_fetch_assoc($res)){ 
								$sql="select razon, tipo from Empresa where idEmpresa=".$data["idEmpresa"]."";
								$res2=mysql_query($sql,$bd);
								$data2=mysql_fetch_assoc($res2);
								if($data2["tipo"]=='o'){
									$sql="select * from Deposito where idSolicitud=".$data["idSolicitud"]."";
									$res6=mysql_query($sql,$bd);
									$data6=mysql_fetch_assoc($res6);

									$dep='
										<p><strong>Banco:</strong> '.$data6["banco"].'</p>
									    <p><strong>Monto:</strong> '.$data6["monto"].'</p>
									    <p><strong>Fecha del deposito:</strong> '.$data6["fecha"].'</p>	
									    <p><strong>Numero de deposito:</strong> '.$data6["nDeposito"].'</p>
									    <p><strong>Deposito:</strong> <div id="links">
											    <a href="../../modeloControlador/imgBauches/'.$data6["bauche"].'" title="Bauche" data-gallery>
											        <img src="../../modeloControlador/imgBauches/'.$data6["bauche"].'" alt="Bauche" height="150" width="200">
											    </a>
											</div></p>
									';

									$ima='
										<div id="blueimp-gallery" class="blueimp-gallery">
											    <!-- The container for the modal slides -->
											    <div class="slides"></div>
											    <!-- Controls for the borderless lightbox -->
											    <h3 class="title"></h3>
											    <a class="prev">‹</a>
											    <a class="next">›</a>
											    <a class="close">×</a>
											    <a class="play-pause"></a>
											    <ol class="indicator"></ol>
											    <!-- The modal dialog, which will be used to wrap the lightbox content -->
											    <div class="modal fade">
											        <div class="modal-dialog">
											            <div class="modal-content">
											                <div class="modal-header">
											                    <button type="button" class="close" aria-hidden="true">&times;</button>
											                    <h4 class="modal-title"></h4>
											                </div>
											                <div class="modal-body next"></div>
											                <div class="modal-footer">
											                    <button type="button" class="btn btn-default pull-left prev">
											                        <i class="glyphicon glyphicon-chevron-left"></i>
											                        Previous
											                    </button>
											                    <button type="button" class="btn btn-primary next">
											                        Next
											                        <i class="glyphicon glyphicon-chevron-right"></i>
											                    </button>
											                </div>
											            </div>
											        </div>
											    </div>
											</div>
									';
								}
								$sql="select tipo from Material where idSolicitud=".$data["idSolicitud"]."";
								$res3=mysql_query($sql,$bd);
								$data3=mysql_fetch_assoc($res3);
								$sql="select nombre, apellido from Usuario where idUsuario=(select idUsuario from Estado_solicitud where idSolicitud=".$data["idSolicitud"].")";
								$res5=mysql_query($sql,$bd);
								$data5=mysql_fetch_assoc($res5);
						?>

						<div class="col-md-8">
								<div class="panel panel-primary">
								  <div class="panel-heading">
								    <h3 class="panel-title">N&uacute;mero de gu&iacute;a <?PHP echo $data["nGuia"]; ?></h3>
								  </div>
								  <div class="panel-body">
								    <p><strong>C&oacute;digo:</strong> <?PHP echo $data["codigo"]; ?> </p>
								    <p><strong>Empresa:</strong> <?PHP echo $data2["razon"]; ?></p>
								    <p><strong>Material:</strong> <?PHP echo $data3["tipo"]; ?></p>	
								    <?PHP echo $dep; ?>				    
								    <p><strong>Procesada por:</strong> <?PHP echo $data5["nombre"]." ".$data5["apellido"]; ?> </p>
								    <p><a class="btn btn-primary" href="../../vistas/auditor/verPlanilla.php?cod=<?PHP echo sha1($data["idSolicitud"]); ?>"><span class="glyphicon glyphicon-eye-open"></span> Ver</a></p>
								  </div>
								</div>
							</div>

						<?PHP }//} ?>

						<?PHP echo $ima; ?>

						<div class="col-md-8">
							<h4>Total solicitudes rechazadas: <strong><?PHP echo $cantidad; ?></strong> </h4>
						</div>

						<?PHP } else{ ?>
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong> No se rechazaron solicitudes hoy.</strong>
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