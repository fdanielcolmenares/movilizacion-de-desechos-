<?PHP
	if(isset($_GET["user"])){
		$user=$_GET["user"];
	}else{$user="";}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Inicio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Daniel">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="js/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="js/dist/css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="js/dist/img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="js/dist/img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="js/dist/img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="js/dist/img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="js/dist/img/favicon.png">
  
	<script type="text/javascript" src="js/dist/js/jquery.min.js"></script>
	<script type="text/javascript" src="js/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/dist/js/scripts.js"></script>
</head>

<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column"> <!-- col-md-10 col-md-offset-2-->
			<img alt="140x140" src="ima/baner.jpg" class="img-responsive"> 		
			<div class="row clearfix">
				<br><br><br><br>				
				<div class="col-md-4 col-md-offset-4">
					<?PHP 
						if(isset($_GET['E']) && $_GET['E'] == '1'){
							echo'
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong> Usuario o contrase&ntilde;a invalidos.</strong>
							</div>';
						}
						if(isset($_GET['E']) && $_GET['E'] == '2'){
							echo'
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong> Debes iniciar sesion.</strong>
							</div>';
						}
						if(isset($_GET['E']) && $_GET['E'] == '3'){
							echo'
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong> Permiso denegado.</strong>
							</div>';
						}
						if(isset($_GET['E']) && $_GET['E'] == '4'){
							echo'
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong> La inscripci&oacute;n de su empresa ha caducado, por favor, dir&iacute;jase a CAIMTA para actulizar datos.</strong>
							</div>';
						}
					?>
					<div class="well">
						<form class="form-horizontal" id="inicio" name="inicio" action="modeloControlador/usuario/inicio.php?I=E" method="post">
							<fieldset>

								<!-- Form Name -->
								<legend>Inicio de sesión</legend>

								<!-- Text input-->
								<div class="form-group">
								  <label class="col-md-4 control-label" for="usuario">Usuario:</label>  
								  <div class="col-md-6">
								  <input id="usuario" name="usuario" type="text" placeholder="usuario" class="form-control input-md" required="" value="<?PHP echo $user; ?>">
								    
								  </div>
								</div>

								<!-- Password input-->
								<div class="form-group">
								  <label class="col-md-4 control-label" for="pass">Contraseña</label>
								  <div class="col-md-6">
								    <input id="pass" name="pass" type="password" placeholder="******" class="form-control input-md" required="">
								    
								  </div>
								</div>

								<!-- Button -->
								<div class="form-group">
								  <label class="col-md-4 control-label" for="entrar"></label>
								  <div class="col-md-4">
								    <button id="entrar" name="entrar" class="btn btn-primary" type="submit">Entrar</button>
								  </div>
								</div>

							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>