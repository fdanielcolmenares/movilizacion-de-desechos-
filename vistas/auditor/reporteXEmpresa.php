<?php 
	session_start(); 
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
  <title>Reporte solicitudes por empresa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Daniel">

	<!--link rel="stylesheet/less" href="../../less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="../../less/responsive.less" type="text/css" /-->
	<!--script src="../../js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="../../js/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../../js/dist/css/style.css" rel="stylesheet">
	<link href="../../js/dist/css/datepicker.css" rel="stylesheet">
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
	<script src="../../js/bootstrap-datepicker.js"></script>
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
					<form class="form-horizontal" id="consultaSolicitudF" name="consultaSolicitudF" action="#" method="post">
						<fieldset>

						<!-- Form Name -->
						<legend>Consulta solicitudes por empresa</legend>

						<div id="alerta"></div>

						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="empresa">Empresa:</label>
							<div class="col-md-4">
						    	<input id="empresa" name="empresa" type="text" placeholder="empresa" class="form-control input-md" required="">
						    </div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="f1">Fecha inicio:</label>
							<div class="input-group date" id="fechaI" data-date="2014-01-02" data-date-format="yyyy-mm-dd">       
	                            <input id="f1" name="f1" type="text" placeholder="2013-01-19" class="form-control input-md" readonly>
	                            <span class="input-group-addon glyphicon glyphicon-search"></span>
                          	</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="f2">Fecha fin:</label>
							<div class="input-group date" id="fechaF" data-date="2014-01-02" data-date-format="yyyy-mm-dd">       
	                            <input id="f2" name="f2" type="text" placeholder="2013-01-29" class="form-control input-md" readonly>
	                            <span class="input-group-addon glyphicon glyphicon-search"></span>
                          	</div>
						</div>
						<!-- Button -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="buscar"></label>
						  <div class="col-md-4">
						    <button id="buscar" name="buscar" type="button" class="btn btn-primary">Buscar</button>
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

	$(document).ready(function(){
		
		var startDate = new Date(1900,1,20);
      	var endDate = new Date(3000,1,25);
      	var ban = false;      	

		$('#fechaI').datepicker()
        .on('changeDate', function(ev){
          if (ev.date.valueOf() > endDate.valueOf()){
            $("#alerta").html('<div id="errorBU" class="alert alert-danger alert-dismissable">'+
			'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			'<strong> La fecha de inicio no puede ser mayor a la final. </strong>'+
			'</div>');
            ban=true;
          } else {
            $("#alerta").html("");
			ban=false;
            startDate = new Date(ev.date);
          }
          $('#fechaI').datepicker('hide');
        });
      $('#fechaF').datepicker()
        .on('changeDate', function(ev){
          if (ev.date.valueOf() < startDate.valueOf()){
            $("#alerta").html('<div id="errorBU" class="alert alert-danger alert-dismissable">'+
			'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			'<strong> La fecha de final no puede ser menor a la inicial. </strong>'+
			'</div>');
            ban=true;
          } else {
            $("#alerta").html("");
			ban=false;
            endDate = new Date(ev.date);
          }
          $('#fechaF').datepicker('hide');
        });

		$('#buscar').click(function(){ 

			$('#resultados').html("");
			$("#alerta").html("");

			if($('#empresa').val()!="" && !ban){ 
				var emp = $('#empresa').val();        
				var dataString = 'empresa='+emp;	 
				var p;
				//var t = $("input:radio[name ='tipoC']:checked").val(); 
				if($('#f1').val()=="" && $('#f2').val()==""){
					p = '1';
				}
				if($('#f1').val()!="" && $('#f2').val()==""){
					p = '2';
				}
				if($('#f1').val()=="" && $('#f2').val()!=""){
					p = '3';
				}
				if($('#f1').val()!="" && $('#f2').val()!=""){
					p = '4';
				}

				$.ajax({ 
					type: "POST",
					url: "../../modeloControlador/auditor/consultSolXEmp.php?P="+p+"&f1="+$('#f1').val()+"&f2="+$('#f2').val(),
					data: dataString,
					success: function(data) {	
						if(data=="-1"){ 
							$("#alerta").html('<div id="errorBU" class="alert alert-danger alert-dismissable">'+
							'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
							'<strong> No se encontro la empresa </strong>'+
							'</div>');
						}
						else{
							$('#resultados').fadeIn(1000).html(data);
						}
					}
				});		
	        }
		})
	});
	
</script>