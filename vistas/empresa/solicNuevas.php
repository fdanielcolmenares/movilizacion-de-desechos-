<?php 
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");

	if(!permisos("an")){
		salir("../../");
	}

	$bd=Conectarse();

	$pag=$_GET["p"];

	$ban=false;

	$sql="select count(idSolicitud) as c from Solicitud where estado='1'"; 
	$res=mysql_query($sql);
	$data=mysql_fetch_assoc($res);

	$div=5;

	$cantidad=$data["c"];
	$n=ceil($cantidad/$div);
	
	$fin=$pag*$div;	
	$ini=$fin-$div;

	$sql="select idSolicitud, codigo, fecha, nGuia from Solicitud where estado='1' order by fecha asc limit ".$ini." , ".$fin.""; 
	$res=mysql_query($sql);	

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Solicitudes nuevas</title>
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
					<legend>Lista de solicitudes</legend> 

					<?PHP 
							if(isset($_GET['E']) && $_GET['E'] == '1'){
								echo'
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong> Solicitud procesada exitosamente. </strong>
								</div>';
							}
						?>

					<?PHP 
						while($data=mysql_fetch_assoc($res)){
							$ban=true;
							$sql="select razon from Empresa where idEmpresa=(select idEmpresa from Solicitud where idSolicitud=".$data["idSolicitud"].")"; 
							$res2=mysql_query($sql);
							$data2=mysql_fetch_assoc($res2); 
							echo '<div class="col-md-8">
									<div class="panel panel-primary">
									  <div class="panel-heading">
									    <h3 class="panel-title">Solicitud # <strong>'.$data["nGuia"].'</strong></h3>
									  </div>
									  <div class="panel-body">
									    <p><strong>C&oacute;digo:</strong> '.$data["codigo"].' </p>
									    <p><strong>Empresa:</strong> '.$data2["razon"].'</p>
									    <p><strong>Fecha:</strong> '.$data["fecha"].'</p>						    
									    <p><a href="../../vistas/empresa/proSolicitud.php?c='.sha1($data["idSolicitud"]).'" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span> Revisar</a></p>
									  </div>
									</div>
								</div>';							
						}
						if(!$ban){
							echo'
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong> No hay solicitudes nuevas. </strong>
							</div>';
						}
					?>
					<?PHP if($n>1){ ?>
					<div class="col-md-8">
						<ul class="pagination">
							<?PHP if($pag==1){ ?>
								<li class="disabled"><a href="#">&laquo;</a></li>
							<?PHP } else{?>
								<li><a href="solicNuevas.php?p=<?PHP echo $pag-1; ?>">&laquo;</a></li>
							<?PHP }?>
							<?PHP for($i=0;$i<$n;$i++){ ?>	
								<?PHP if($pag==($i+1)){ ?>					  	
	  								<li class="active"><a href="solicNuevas.php?p=<?PHP echo $i+1; ?>"><?PHP echo($i+1); ?><span class="sr-only">(current)</span></a></li>
						  		<?PHP } else{?>
						  			<li><a href="solicNuevas.php?p=<?PHP echo $i+1; ?>"><?PHP echo($i+1); ?><span class="sr-only">(current)</span></a></li>
								<?PHP }?>
						  	<?PHP }?>
						  	<?PHP if($pag==$n){ ?>
								<li class="disabled"><a href="#">&raquo;</a></li>
							<?PHP } else{?>
								<li><a href="solicNuevas.php?p=<?PHP echo $pag+1; ?>">&raquo;</a></li>
							<?PHP }?>						  	
						</ul>
					</div>
					<?PHP }?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>