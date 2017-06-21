<?php 
	session_start(); 

	include("../../php/funciones.php");

	isConnect("../../");

	if(!permisos("an")){
		salir("../../");
	}

	if(isset($_GET["p"])){
		$pag=$_GET["p"];
	}
	else{$pag=1;}

	if(isset($_GET["T"])){
		$op=$_GET["T"];
	}else{$op="no";}

	if(isset($_GET["n"])){
		$n=$_GET["n"];
	}else{$n="";}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Consulta de solicitud</title>
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
							require ('../../menu/menuAnalista.php');
						?>
					</div>
				</div>
				<div class="col-md-9 column">	
					<form class="form-horizontal" id="consultaSolicitud" name="consultaSolicitud" action="#" method="post">
						<fieldset>

						<!-- Form Name -->
						<legend>Consulta de solicitud por empresa</legend>

						<div id="alerta"></div>

						<?PHP 
							if(isset($_GET['E']) && $_GET['E'] == '0'){
								echo'
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong> No se encontro la empresa.</strong>
								</div>';
							}
						?>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="nombre">Razon social:</label>  
						  <div class="col-md-4">
						  <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre" class="form-control input-md">						    
						  </div>
						</div>

						<!-- Multiple Radios (inline) -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="tipoC">Tipo consulta:</label>
						  <div class="col-md-4"> 
						    <label class="radio-inline" for="tipoC-0">
						      <input type="radio" name="tipoC" id="tipoC-0" value="A" checked="checked">
						      Solicitudes en an&aacute;lisis
						    </label> 
						    <label class="radio-inline" for="tipoC-1">
						      <input type="radio" name="tipoC" id="tipoC-1" value="P">
						      Solicitudes aprobadas
						    </label>
						    <label class="radio-inline" for="tipoC-1">
						      <input type="radio" name="tipoC" id="tipoC-1" value="R">
						      Solicitudes rechazadas
						    </label>
						  </div>
						</div>

						<!-- Button -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="guardar"></label>
						  <div class="col-md-4">
						    <button id="buscar" type="button" name="buscar" class="btn btn-primary">Buscar</button>
						  </div>
						</div>

						</fieldset>
					</form>
					<br><br>
					<div id="resultados">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<script>

	function carga(){
		$("#resultados").html("");
		$("#alerta").html("");

		var dataString = "nombre="+<?PHP echo "'".$n."'"; ?>;	

		$.ajax({ 
			type: "POST",
			url: "../../modeloControlador/empresa/consultXemp.php?T="+<?PHP echo "'".$op."'"; ?>+"&p="+<?PHP echo $pag; ?>,
			data: dataString,
			success: function(data) {	
				$("#resultados").fadeIn(1000).html(data);
			}
		});
	}

	$(document).ready(function(){
		var ban=0;
		$('#buscar').click(function(){ 
			ban=1;
			$('#resultados').html("");
			$("#alerta").html("");

			//if($('#nombre').val()!=""){ 
				var nombre = $('#nombre').val();        
				var dataString = 'nombre='+nombre;	 
				var t = $("input:radio[name ='tipoC']:checked").val();

				$.ajax({ 
					type: "POST",
					url: "../../modeloControlador/empresa/consultXemp.php?T="+t+"&p=1",
					data: dataString,
					success: function(data) {	
						if(data=="-1"){ 
							$("#alerta").html('<div id="errorBU" class="alert alert-danger alert-dismissable">'+
							'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
							'<strong> No se encontro la empresa, o no tiene solicitudes en el estado seleccionado </strong>'+
							'</div>');
						}
						else{
							$('#resultados').fadeIn(1000).html(data);
						}
					}
				});		
	        //}
		})
		<?PHP //+<?PHP echo $pag; esto estaba en p=1
			if(isset($_GET["p"])){
				echo "if(!ban){carga();}";
			}
		?>
	});
	
</script>