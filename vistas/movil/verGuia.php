<?php 
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");

	if(!permisos("mo")){
		salir("../../");
	}

	$bd=Conectarse();

	//$cod2=$_POST["NGuia"];

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pocesar solicitud</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Daniel">

	<!--link rel="stylesheet/less" href="../../less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="../../less/responsive.less" type="text/css" /-->
	<!--script src="../../js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="../../js/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../../js/dist/css/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../js/dist/css/bootstrap-fileupload.css">
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
    <script type="text/javascript" src="../../js/jquery.validate.js"></script>
    <script type="text/javascript" src="../../js/bootstrap-fileupload.js"></script>
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
							require ('../../menu/menuMovil.php');
						?>
					</div>
				</div>
				<div class="col-md-9 column">
					
						<legend>Datos del veh&iacute;culo</legend>

						<?PHP 
							$sql="SELECT tipo from Empresa where idEmpresa=(select idEmpresa from Solicitud where nGuia='".$_POST["NGuia"]."')"; 
							$res=mysql_query($sql);	
							$data=mysql_fetch_assoc($res);
							$tE=$data["tipo"]; 

							$sql="select idSolicitud from Solicitud where nGuia='".$_POST["NGuia"]."'"; 
							$res=mysql_query($sql);	
							$data=mysql_fetch_assoc($res);
							if(!$data){
								echo'
									 <script type="text/javascript">
						  				window.location="../../vistas/movil/procesarGuia.php?E=0";
									 </script>
								';	
							}
							$cod=$data["idSolicitud"];

							$sql="select * from Vehiculo where idSolicitud='".$cod."'"; 
							$res=mysql_query($sql);
							$data=mysql_fetch_assoc($res);
						?>

						<p><strong>Tipo:</strong> <?PHP echo $data["tipo"]; ?></p>
						<p><strong>Modelo del vehiculo:</strong> <?PHP echo $data["modelo"]; ?></p>
						<p><strong>Color:</strong> <?PHP echo $data["color"]; ?></p>
						<p><strong>Placa chuto:</strong> <?PHP echo $data["pChuto"]; ?></p>
						<p><strong>Placa Batea:</strong> <?PHP echo $data["pBatea"]; ?></p>
						<p><strong>A&ntilde;o:</strong> <?PHP echo $data["ano"]; ?></p>

						<br>

						<legend>Datos del conductor</legend>

						<?PHP 
							$sql="select * from Conductor where idSolicitud='".$cod."'"; 
							$res=mysql_query($sql);
							$data=mysql_fetch_assoc($res);
						?>

						<p><strong>Nombre:</strong> <?PHP echo $data["nombre"]; ?></p>
						<p><strong>Apellido:</strong> <?PHP echo $data["apellido"]; ?></p>
						<p><strong>C&eacute;dula:</strong> <?PHP echo $data["cedula"]; ?></p>

						<br>

						<legend>Tipo de material</legend>

						<?PHP 
							$sql="select * from Material where idSolicitud='".$cod."'"; 
							$res=mysql_query($sql);
							$data=mysql_fetch_assoc($res);
							$mat=$data["tipo"];
						?>

						<p><strong>Tipo de material:</strong> <?PHP echo $data["tipo"]; ?></p>
						<p><strong>Toneladas:</strong> <?PHP echo $data["peso"]; ?></p>

						<br>

						<legend>Datos del Destinatario</legend>

						<?PHP 
							$sql="select * from Destinatario where idSolicitud='".$cod."'"; 
							$res=mysql_query($sql);
							$data=mysql_fetch_assoc($res);
							$dest=$data["razon"];
						?>

						<p><strong>RIF o C&eacute;dula:</strong> <?PHP echo $data["rif"]; ?></p>
						<p><strong>Tel&eacute;fono:</strong> <?PHP echo $data["telefono"]; ?></p>
						<p><strong>Raz&oacute;n social:</strong> <?PHP echo $data["razon"]; ?></p>
						<p><strong>Direcci&oacute;n:</strong> <?PHP echo $data["direccion"]; ?></p>
						<p><strong>Finalidad:</strong> <?PHP echo $data["finalidad"]; ?></p>

						<br>

						<?PHP if($tE=="o"){ ?>

						<legend>Datos del Deposito</legend>

						<?PHP 
							$sql="select * from Deposito where idSolicitud='".$cod."'"; 
							$res=mysql_query($sql);
							$data=mysql_fetch_assoc($res);

							$sql="select razon from Empresa where idEmpresa=(select idEmpresa from Solicitud where idSolicitud=".$data["idSolicitud"].")"; 
							$res2=mysql_query($sql);
							$data2=mysql_fetch_assoc($res2);
						?>

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

						<p><strong>Banco:</strong> <?PHP echo $data["banco"]; ?></p>
						<p><strong>Fecha:</strong> <?PHP echo $data["fecha"]; ?></p>
						<p><strong>N&uacute;mero de deposito:</strong> <?PHP echo $data["nDeposito"]; ?></p>
						<p><strong>Monto:</strong> <?PHP echo $data["monto"]; ?></p>

						<div id="links">
						    <a href="../../modeloControlador/imgBauches/<?PHP echo $data["bauche"]; ?>" title="Bauche" data-gallery>
						        <img src="../../modeloControlador/imgBauches/<?PHP echo $data["bauche"]; ?>" alt="Bauche" height="200" width="250">
						    </a>
						</div>

						<?PHP } ?>

						<br><br>

						<!-- Button (Double) -->
						<!--
						<div class="form-group">
						  <div class="col-md-8">
						    <button id="aceptar" name="aceptar" type="button" class="btn btn-success" data-toggle="modal" data-target="#acept">Aceptar solicitud</button>
						    <button id="rechazar" name="rechazar" type="button" class="btn btn-danger" data-toggle="modal" data-target="#dene">Rechazar solicitud</button>
						  </div>
						</div>
						<br>
						
						<div class="modal fade" id="acept">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						        <h4 class="modal-title">Pregunta</h4>
						      </div>
						      <form class="form-horizontal" id="registroPSolicitudA" name="registroPSolicitudA" action="../../modeloControlador/empresa/proSolicitud.php?id=<?PHP echo $cod; ?>&e=APROVADO" method="post">
						      <div class="modal-body">
						        <div class="alert alert-success">
						        <p>¿Esta seguro que desea aceptar la solicitud de 
						        <?PHP echo $data2["razon"];?> para transportar <?PHP echo $mat;?> hacia <?PHP echo $dest;?>?
						        </p>
						        </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						        <button type="submit" name="aceptar" id="aceptar" class="btn btn-primary">Aceptar solicitud</button>
						      </div>
						      </form>
						    </div>
						  </div>
						</div>
						-->

						<form class="form-horizontal" id="registroPSolicitud" name="registroPSolicitud" action="../../modeloControlador/movil/solicitudProcM.php?N=<?PHP echo $_POST["NGuia"]; ?>" method="post">
							<!-- Button -->
							<div class="form-group">
							  <div class="col-md-4">
							    <button id="registro" name="registro" type="submit" class="btn btn-primary">Procesar</button>
							  </div>
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<script>
	$("form").submit(function() {
		if($('#ano').valid() && ('#tonelada').valid() && ('#monto').valid() && ('#imgB').val()!='')
			return true;
		return false;	
	});	

	$(document).ready(function(){ 
		$('#aceptar').click(function(){ 
			$(this).valid();
        })
	});
	
</script>