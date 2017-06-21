<?php 
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");

	if(!permisos("au")){
		salir("../../");
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Cambio de Contrase&ntilde;a</title>
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

					<legend>Cambiar contrase&ntilde;a</legend>

					<?PHP 
							if(isset($_GET['E']) && $_GET['E'] == '1'){
								echo'
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong> Contrase&ntilde;a cambiada exitosamente. </strong>
								</div>';
							}
							if(isset($_GET['E']) && $_GET['E'] == '0'){
								echo'
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong> No se pudo cambiar la contrase&ntilde;a.</strong>
								</div>';
							}
							if(isset($_GET['E']) && $_GET['E'] == '2'){
								echo'
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong> Contrase&ntilde;a original erronea.</strong>
								</div>';
							}
						?>

					<form class="form-horizontal" id="cambioContraA" name="cambioContraA" action="../../modeloControlador/auditor/cambioContraA.php" method="post">
						<fieldset>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="pass">Contrase&ntilde;a:</label>  
						  <div class="col-md-4">
						  <input id="pass" name="pass" type="password" placeholder="********" class="form-control input-md" required="">					    
						  </div>
						</div>
						
						<div id="alerta"></div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="passN1">Contrase&ntilde;a nueva:</label>  
						  <div class="col-md-4">
						  <input id="passN1" name="passN1" type="password" placeholder="********" class="form-control input-md" required="">				    
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="passN2">Repita contrase&ntilde;a nueva:</label>  
						  <div class="col-md-4">
						  <input id="passN2" name="passN2" type="password" placeholder="********" class="form-control input-md" required="">				    
						  </div>
						</div>

						<!-- Button -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="cambiar"></label>
						  <div class="col-md-4">
						    <button id="cambiar" name="cambiar" type="submit" class="btn btn-primary">Cambiar</button>
						  </div>
						</div>

						</fieldset>
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
		if($("#passN2").val()!=$("#passN1").val()){
			$("#alerta").html('<div id="errorBU" class="alert alert-danger alert-dismissable">'+
			'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			'<strong> Las contrase&ntilde;as no coinciden </strong>'+
			'</div>');
			return false;
		}
		return true;	
	});
		
</script>