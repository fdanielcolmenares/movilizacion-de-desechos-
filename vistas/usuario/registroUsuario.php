<?php 
	session_start(); 
	include("../../php/funciones.php");
	isConnect("../../");
	if(!permisos("ad")){
		salir("../../");
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registro de Usuario</title>
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
    <script type="text/javascript" src="../../js/jquery.validate.js"></script>
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
					<form class="form-horizontal" id="registroUsuario" name="registroUsuario" action="../../modeloControlador/usuario/registro.php" method="post">
						<fieldset>

						<!-- Form Name -->
						<legend>Registro de usuario</legend>

						<?PHP 
							if(isset($_GET['E']) && $_GET['E'] == '1'){
								echo'
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong> Usuario registrado exitosamente. </strong>
								</div>';
							}
							if(isset($_GET['E']) && $_GET['E'] == '0'){
								echo'
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong> No se pudo registrar el usuario.</strong>
								</div>';
							}
						?>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="nombre">Nombre:</label>  
						  <div class="col-md-4">
						  <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre" class="form-control input-md" required="">
						    
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="apellido">Apellido:</label>  
						  <div class="col-md-4">
						  <input id="apellido" name="apellido" type="text" placeholder="Ingrese apellido" class="form-control input-md" required="">
						    
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="mail">Correo:</label>  
						  <div class="col-md-4">
						  <input id="mail" name="mail" type="text" placeholder="alguien@gmail.com" class="form-control input-md email">
						    
						  </div>
						</div>

						<!-- Select Basic -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="estado">Estado:</label>
						  <div class="col-md-4">
						    <select id="estado" name="estado" class="form-control">
						      <option value="a">Activo</option>
						      <option value="i">Inactivo</option>
						    </select>
						  </div>
						</div>

						<!-- Select Basic -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="tipo">Tipo:</label>
						  <div class="col-md-4">
						    <select id="tipo" name="tipo" class="form-control">
						      <option value="ad">Administrador</option>
						      <option value="au">Auditor</option>
						      <option value="an">Analista</option>
						      <option value="mo">M&oacute;vil</option>
						    </select>
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="user">Usuario:</label>  
						  <div class="col-md-4">
						  <input id="user" name="user" type="text" placeholder="Luis.Chacon" class="form-control input-md" required="">
						  <div id="Info"></div>  
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="pass">Contrase&ntilde;a:</label>  
						  <div class="col-md-4">
						  <input id="pass" name="pass" type="password" placeholder="********" class="form-control input-md" required="">
						    
						  </div>
						</div>

						<!-- Button -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="guardar"></label>
						  <div class="col-md-4">
						    <button id="guardar" name="guardar" type="submit" class="btn btn-primary">Guardar</button>
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
		if($('#Info').html()=="Disponible" && $('#mail').valid())
			return true;
		return false;	
	});
	
	$(document).ready(function(){
		$('#mail').blur(function(){ 
			$(this).valid();			
        })
		$('#user').blur(function(){      	
       		var usern = $(this).val();        
        	var dataString = 'usuario='+usern;
        	if(usern!=""){
				$.ajax({
					type: "POST",
				   	url: "../../modeloControlador/usuario/verificarUsuario.php",
				   	data: dataString,
					success: function(data) {
						if(data=="Disponible"){
							$("#Info").removeClass("text-danger");
							$("#Info").addClass("text-success");
							$('#Info').html(data).fadeIn(1000);
						}
						else{
							$("#Info").removeClass("text-success");
							$("#Info").addClass("text-danger");
							$('#Info').html(data).fadeIn(1000);
						}
					}					
				});
			}
        })
	});
	
</script>