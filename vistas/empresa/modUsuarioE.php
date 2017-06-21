<?php 
	session_start(); 

	include("../../php/funciones.php");
	include("../../php/conex.php");

	isConnect("../../");

	if(!permisos("ad") && !permisos("an")){
		salir("../../");
	}

	$id=$_GET["u"];

	$bd=Conectarse();

	$sql="select * from Empresa where sha1(idEmpresa)='".$id."'"; 
	$res=mysql_query($sql);	
	$data=mysql_fetch_assoc($res);

	$sql="SELECT fecha, estado from Estado_empresa where sha1(idEmpresa)='".$id."' order by fecha desc limit 1";
	$res2=mysql_query($sql);	
	$data2=mysql_fetch_assoc($res2);

	$fecha = $data2["fecha"];
	$nuevafecha = strtotime ( '+24 week' , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

	if($nuevafecha<date("Y-m-d") || $data2["estado"]!="ACTIVA"){
		$est=0;
	}else{$est=1;}

	$sql="select * from Login where sha1(idEmpresa)='".$id."'"; 
	$res2=mysql_query($sql);	
	$data2=mysql_fetch_assoc($res2);	

	if(isset($_GET["p"])){
		if($_GET["p"]=='1') $menu=1;
		else $menu=0;
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Modificar empresa</title>
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
							if($menu==0)
								require ('../../menu/menuAdmin.php');
							else
								require ('../../menu/menuAnalista.php');
						?>
					</div>
				</div>
				<div class="col-md-9 column">
					<form class="form-horizontal" id="registroEmpresa" name="registroEmpresa" action="../../modeloControlador/empresa/modEmpresa.php?p=<?PHP echo $menu; ?>" method="post">
						<fieldset>

						<!-- Form Name -->
						<legend>Modificar Empresa</legend>

						<?PHP 
							if(isset($_GET['E']) && $_GET['E'] == '1'){
								echo'
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong> Empresa modificada exitosamente. </strong>
								</div>';
							}
							if(isset($_GET['E']) && $_GET['E'] == '0'){
								echo'
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong> No se pudo modificar la empresa.</strong>
								</div>';
							}
						?>

						<input type="hidden" name="idU" id="idU" value="<?php echo $id; ?>" />

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="razon">Raz&oacute;n social:</label>  
						  <div class="col-md-4">
						  <input id="razon" name="razon" type="text" placeholder="Comercializadora ..." class="form-control input-md" required="" value="<?php echo $data['razon']; ?>">
						    
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="rif">Rif o C.I:</label>  
						  <div class="col-md-4">
						  <input id="rif" name="rif" type="text" placeholder="V-5555555-3" class="form-control input-md" required="" value="<?php echo $data['rif']; ?>">
						    
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="telefono">Tel&eacute;fono:</label>  
						  <div class="col-md-4">
						  <input id="telefono" name="telefono" type="text" placeholder="0276-5555895" class="form-control input-md" required="" value="<?php echo $data['telefono']; ?>">
						    
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="mail">Correo:</label>  
						  <div class="col-md-4">
						  <input id="mail" name="mail" type="text" placeholder="empresa@correo.com" class="form-control input-md" required="" value="<?php echo $data['correo']; ?>">
						    
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="tonelada">Limite de peso (Toneladas):</label>  
						  <div class="col-md-4">
						  <input id="tonelada" name="tonelada" type="text" placeholder="120" class="form-control input-md number" required="" value="<?php echo $data['limite']; ?>">						    
						  </div>
						</div>

						<!-- Textarea -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="dir">Direcci&oacute;n:</label>
						  <div class="col-md-4">                     
						    <textarea class="form-control" id="dir" name="dir"><?php echo $data['direccion']; ?></textarea>
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="user">Usuario:</label>  
						  <div class="col-md-4">
						  <input id="user" name="user" type="text" placeholder="empresa" class="form-control input-md" required="" value="<?php echo $data2['usuario']; ?>">
						    
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="pass">Contrase&ntilde;a:</label>  
						  <div class="col-md-4">
						  <input id="pass" name="pass" type="password" placeholder="********" class="form-control input-md" >
						    
						  </div>
						</div>

						<!-- Select Basic -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="tipo">Tipo</label>
						  <div class="col-md-4">
						    <select id="tipo" name="tipo" class="form-control">
						    	<?php if($data['tipo']=='o'){ ?>
						      		<option value="o">Ordinario</option>
						      	<?php }else{ ?>
						      		<option value="e">Exento</option>
						      	<?php } ?>
						      	<option value="o">Ordinario</option>
						      	<option value="e">Exento</option>
						    </select>
						  </div>
						</div>

						<!-- Multiple Radios (inline) -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="tipoC">Estado de la empresa:</label>
						  <div class="col-md-4"> 
						  <?PHP if($est==1){ ?>
						    <label class="radio-inline" for="tipoC-0">
						      <input type="radio" name="tipoC" id="tipoC-0" value="ACTIVA" checked="checked">
						      Activa
						    </label> 
						    <label class="radio-inline" for="tipoC-1">
						      <input type="radio" name="tipoC" id="tipoC-1" value="INACTIVA">
						      Inactiva
						    </label>
						  <?PHP }else{ ?>
						  	<label class="radio-inline" for="tipoC-0">
						      <input type="radio" name="tipoC" id="tipoC-0" value="ACTIVA">
						      Activa
						    </label> 
						    <label class="radio-inline" for="tipoC-1">
						      <input type="radio" name="tipoC" id="tipoC-1" value="INACTIVA" checked="checked">
						      Inactiva
						    </label>
						  <?PHP } ?>
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