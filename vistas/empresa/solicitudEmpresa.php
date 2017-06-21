<?php 

	session_start(); 



	include("../../php/funciones.php");

	include("../../php/conex.php");



	isConnect("../../");



	if(!permisos("em")){

		salir("../../");

	}



	$bd=Conectarse();



	$sql="SELECT tipo, limite from Empresa where idEmpresa=".$_SESSION["idUsuario"].""; 

	$res=mysql_query($sql);	

	$data=mysql_fetch_assoc($res); 

	$limite = $data["limite"]; //nuevo



	$pesoEx=0;



	if($data["tipo"]=="e"){ 

		$totalP=0;

		$sql="SELECT idSolicitud from Solicitud where idEmpresa=".$_SESSION["idUsuario"]." and fecha >= '".date("Y-m")."-01' and fecha <= '".date("Y-m")."-31'"; 

		$res2=mysql_query($sql);

		/*$sqlLimit = "SELECT limite from Empresa where idEmpresa=".$_SESSION["idUsuario"]."";
		$resL = mysql_query($sql);
		$dataL = mysql_fetch_assoc($resL);
		$limite = $dataL["limite"];*/




		while($data2=mysql_fetch_assoc($res2)){


			$sqlNR ="SELECT idSolicitud FROM Estado_solicitud WHERE idSolicitud=".$data2["idSolicitud"]." AND estado = 'APROVADO'  ";
			$ejsqlNR =mysql_query($sqlNR);
			$dataNR = mysql_fetch_assoc($ejsqlNR);
			$IdSolApr = $dataNR["idSolicitud"];
			if($IdSolApr){

				$sql="select peso from Material where idSolicitud=".$IdSolApr."";

				$res3=mysql_query($sql);

				$data3=mysql_fetch_assoc($res3);

				$totalP+= $data3["peso"];
			}

		}
		// limite para empresas 100 toneladas
		if($totalP>$limite){$pesoEx=1;}

	}

?>

<!DOCTYPE html>

<html lang="es">

<head>

  <meta charset="utf-8">

  <title>Realizar solicitud</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="description" content="">

  <meta name="author" content="Daniel">



	<!--link rel="stylesheet/less" href="../../less/bootstrap.less" type="text/css" /-->

	<!--link rel="stylesheet/less" href="../../less/responsive.less" type="text/css" /-->

	<!--script src="../../js/less-1.3.3.min.js"></script-->

	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->

	

	<link href="../../js/dist/css/bootstrap.min.css" rel="stylesheet">

	<!--<link href="../../js/dist/css/style.css" rel="stylesheet">-->

	<link rel="stylesheet" type="text/css" href="../../js/dist/css/bootstrap-fileupload.css">

	<link href="../../js/dist/css/datepicker.css" rel="stylesheet">



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

	<script src="../../js/bootstrap-datepicker.js"></script>

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

							require ('../../menu/menuEmpresa.php');

						?>

					</div>

				</div>

				<div class="col-md-9 column"> <!--  -->

					<form class="form-horizontal" id="registroSolicitud" name="registroSolicitud" action="../../modeloControlador/empresa/regSolicitud.php" method="post" enctype="multipart/form-data">

						<fieldset>



						<!-- Form Name -->

						<legend>Datos del veh&iacute;culo</legend>



						<?PHP 

							if(isset($_GET['E']) && $_GET['E'] == '1'){

								echo'

								<div class="alert alert-success alert-dismissable">

									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

									<strong> Solicitud realizada exitosamente. </strong>

								</div>';

							}

							if(isset($_GET['E']) && $_GET['E'] == '0'){

								echo'

								<div class="alert alert-danger alert-dismissable">

									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

									<strong> No se pudo registrar la solicitud.</strong>

								</div>';

							}							

							if(isset($_GET['E']) && $_GET['E'] == '2'){

								echo'

								<div class="alert alert-danger alert-dismissable">

									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

									<strong>  Debe seleccionar al menos un tipo de material. </strong>

								</div>';

							}

							if(isset($_GET['E']) && $_GET['E'] == '3'){

								echo'

								<div class="alert alert-danger alert-dismissable">

									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

									<strong>  Su limite de peso permitido mensualmente es '. $limite .'toneladas. </strong>

								</div>';

							}

							if($pesoEx==1){

								echo'

								<div class="alert alert-danger alert-dismissable">

									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

									<strong> Ud ya alcanzo el limite de peso permitido mensualmente.</strong>

								</div>';

							}

						?>

						<?PHP if($pesoEx==0){ ?>

						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="tipo">Tipo:</label>  

						  <div class="col-md-4">

						  <input id="tipo" name="tipo" type="text" placeholder="Gandola" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="modelo">Modelo del veh&iacute;culo:</label>  

						  <div class="col-md-4">

						  <input id="modelo" name="modelo" type="text" placeholder="Internacional" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="color">Color:</label>  

						  <div class="col-md-4">

						  <input id="color" name="color" type="text" placeholder="Negro" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="placaCH">Placa chuto:</label>  

						  <div class="col-md-4">

						  <input id="placaCH" name="placaCH" type="text" placeholder="89XAAJ" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="placaBA">Placa Batea:</label>  

						  <div class="col-md-4">

						  <input id="placaBA" name="placaBA" type="text" placeholder="A92AE3C" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="ano">A&ntilde;o:</label>  

						  <div class="col-md-4">

						  <input id="ano" name="ano" type="text" placeholder="1985" class="form-control input-md number" required="">

						    

						  </div>

						</div>



						<legend>Datos del conductor</legend>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="nombre">Nombre:</label>  

						  <div class="col-md-4">

						  <input id="nombre" name="nombre" type="text" placeholder="José" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="apellido">Apellido:</label>  

						  <div class="col-md-4">

						  <input id="apellido" name="apellido" type="text" placeholder="Chacon" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="cedula">C&eacute;dula:</label>  

						  <div class="col-md-4">

						  <input id="cedula" name="cedula" type="text" placeholder="V-12345678" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<legend>Tipo de material</legend>



						<div id="alerta2"></div>

						<div id="alerta5"></div>



						<!-- Multiple Checkboxes -->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="tipoM">Tipo de material:</label>

						  <div class="col-md-4">

						  	<div class="checkbox">

							    <label for="tipo-0">

							      <input type="checkbox" name="tipoM" id="tipo-0" value="Aluminio">

							      Aluminio

							    </label>

							</div>

						  	<div class="checkbox">

							    <label for="tipo-1">

							      <input type="checkbox" name="tipoM" id="tipo-1" value="Hierro colado">

							      Hierro colado

							    </label>

							</div>

							<div class="checkbox">

							    <label for="tipo-1">

							      <input type="checkbox" name="tipoM" id="tipo-2" value="Cobre">

							      Cobre

							    </label>

							</div>

							<div class="checkbox">

							    <label for="tipo-1">

							      <input type="checkbox" name="tipoM" id="tipo-3" value="Bronce">

							      Bronce

							    </label>

							</div>

							<div class="checkbox">

							    <label for="tipo-1">

							      <input type="checkbox" name="tipoM" id="tipo-4" value="Hierro dulce">

							      Hierro dulce

							    </label>

							</div>

							<div class="checkbox">

							    <label for="tipo-1">

							      <input type="checkbox" name="tipoM" id="tipo-5" value="Vidrio">

							      Vidrio

							    </label>

							</div>

							<div class="checkbox">

							    <label for="tipo-1">

							      <input type="checkbox" name="tipoM" id="tipo-6" value="Plastico">

							      Plastico

							    </label>

							</div>

							<div class="checkbox">

							    <label for="tipo-1">

							      <input type="checkbox" name="tipoM" id="tipo-7" value="Carton">

							      Carton

							    </label>

							</div>

							<div class="checkbox">

							    <label for="tipo-1">

							      <input type="checkbox" name="tipoM" id="tipo-8" value="Papel">

							      Papel

							    </label>

							</div>

							<div class="checkbox">

							    <label for="tipo-1">

							      <input type="checkbox" name="tipoM" id="tipo-9" value="Otros">

							      Otros

							    </label>

							</div>

						  </div>

						</div>



						<!-- Text input-->

						<div class="hide" id="oth">

						  <label class="col-md-4 control-label" for="otros">Otros:</label>  

						  <div class="col-md-4">

						  <input id="otros" name="otros" type="text" placeholder="opcion1 opcion2 opcion3" class="form-control input-md">						    

						  </div>

						</div>



						<input type="hidden" name="materiales" id="materiales" value="">

						<input type="hidden" name="pesoT" id="pesoT" value="">



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="tonelada">Toneladas:</label>  

						  <div class="col-md-4">

						  <input id="tonelada" name="tonelada" type="text" placeholder="30" class="form-control input-md number" min="1" max="<?php echo $limite; ?>" required="">				    

						  </div>

						</div>
						

						<legend>Datos del Destinatario</legend>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="cedulaD">RIF o C&eacute;dula:</label>  

						  <div class="col-md-4">

						  <input id="cedulaD" name="cedulaD" type="text" placeholder="V-12345678-3" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="telefonoD">Tel&eacute;fono:</label>  

						  <div class="col-md-4">

						  <input id="telefonoD" name="telefonoD" type="text" placeholder="0276-4158920" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="razonD">Raz&oacute;n social:</label>  

						  <div class="col-md-4">

						  <input id="razonD" name="razonD" type="text" placeholder="" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<!-- Textarea -->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="dirD">Direcci&oacute;n: </label>

						  <div class="col-md-4">                     

						    <textarea class="form-control" id="dirD" name="dirD"></textarea>

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="finalidad">Finalidad:</label>  

						  <div class="col-md-4">

						  <input id="finalidad" name="finalidad" type="text" placeholder="Fudición" class="form-control input-md" required="">

						    

						  </div>

						</div>



						<?PHP if($data["tipo"]=="o"){ ?>



						<legend>Datos del Deposito</legend>



						<div id="alerta"></div>

						<div id="alerta3"></div>

						<div id="alerta4"></div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="banco">Banco:</label>  

						  <div class="col-md-4">

						  <input id="banco" name="banco" type="text" placeholder="Venezuela" class="form-control input-md" required="">						    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

							<label class="col-md-4 control-label" for="monto">Fecha del deposito:</label>

							<div class="input-group date" id="fechaD" data-date="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd">       

	                            <input id="fecha" name="fecha" type="text" placeholder="<?php echo date("Y-m-d"); ?>" class="form-control input-md" readonly>

	                            <span class="input-group-addon glyphicon glyphicon-search"></span>

                          	</div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="nDeposito">N&uacute;mero del deposito:</label>  

						  <div class="col-md-4">

						  <input id="nDeposito" name="nDeposito" type="text" placeholder="985624" class="form-control input-md number" required="">	

						  <div id="Info"></div>					    

						  </div>

						</div>



						<!-- Text input-->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="monto">Monto:</label>  

						  <div class="col-md-4">

						  <input id="monto" name="monto" type="text" placeholder="80" class="form-control input-md number" required="">						    

						  </div>

						</div>

						

						<div class="form-group">	

							<label class="col-md-4 control-label" for="banco">Deposito:</label>						

			                <div class="fileupload fileupload-new col-md-4" data-provides="fileupload" align="center">

			                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="../../ima/image.gif" /></div>

			                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

			                    <div>

			                      <span class="btn btn-file btn-primary">

			                      	<span class="fileupload-new">Seleccionar imagen</span>

			                        <span class="fileupload-exists">Cambiar</span><input type="file" name="imgB" id="imgB" Accept="image/*"/>

			                      </span>

			                      <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Quitar</a>

			                    </div>

			                </div>

			            </div>



			            <?PHP } ?>



						<!-- Button -->

						<div class="form-group">

						  <label class="col-md-4 control-label" for="guardar"></label>

						  <button type="submit" id="guardar" name="guardar" data-loading-text="Procesando..." class="btn btn-primary">

						  	Guardar

						  </button>

						  <!--<div class="col-md-4">

						    <button id="guardar" name="guardar" type="submit" class="btn btn-primary">Guardar</button>

						  </div>-->

						</div>



					<?PHP }//fin el if si se excedio del peso permitido ?>

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

		var bnad=true;

		var b2=false;

		var mats = "";



		$('input[name="tipoM"]:checked').each(function() {

			if($(this).val()=="Otros"){				

				mats+=$("#otros").val();

			}

			else{

				mats += $(this).val() + " ";

			}	

			$("#materiales").val(mats);		

		});



		<?PHP if($data["tipo"]=="e"){echo "b2=true;";} ?>		



		if(!b2){

		if($("#alerta").html()=='' && $('#imgB').val()!=''){

			if(!$('#ano').valid()){

				bnad=false;

			}

			if(!$('#tonelada').valid()){

				bnad=false;

			}

			if(!$('#monto').valid()){			

				bnad=false; 

			}

			if($('#fecha').val()==""){

				$("#alerta3").html('<div id="errorBU" class="alert alert-danger alert-dismissable">'+

				'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+

				'<strong> Debe ingresar una fecha. </strong>'+

				'</div>');			

				bnad=false; 

			}

			if($('#Info').html()!="OK"){

				if($('#Info').html()==""){
					$("#alerta4").html('<div id="errorBU2" class="alert alert-danger alert-dismissable">'+

					'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+

					'<strong> Debe escribir un numero de deposito. </strong>'+

					'</div>');
				}
				else{

					$("#alerta4").html('<div id="errorBU2" class="alert alert-danger alert-dismissable">'+

					'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+

					'<strong> El numero de deposito ya fue usado. </strong>'+

					'</div>');
				}

				bnad=false;

			}

			//return bnad;

		}

		else{

			$("#alerta").html('<div id="errorBU" class="alert alert-danger alert-dismissable">'+

			'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+

			'<strong> Debe seleccionar una imagen. </strong>'+

			'</div>');

			bnad=false;

		}

		}

		else{

			if(!$('#ano').valid()){

				bnad=false;

			}					

			if($('#tonelada').val()><?php echo $limite; ?>){

				$("#alerta5").html('<div id="errorBU5" class="alert alert-danger alert-dismissable">'+

				'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+

				'<strong> Su limite de peso permitido mensualmente es <?php echo $limite; ?> toneladas. </strong>'+

				'</div>');	

				$("#pesoT").val("1");			

				bnad=false; 

			}

			if(!$('#tonelada').valid()){

				bnad=false;

			}

			if(!$('#monto').valid()){			

				bnad=false; 

			}

		}

		

		if(mats==""){

			$("#alerta2").html('<div id="errorBU2" class="alert alert-danger alert-dismissable">'+

			'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+

			'<strong> Debe seleccionar al menos un tipo de material. </strong>'+

			'</div>');

			bnad=false;

		}

		return bnad;	

	});	



	$(document).ready(function(){ 



		$('#fechaD').datepicker();



		var mats = "";



		$('#tipo-9').change(function(){ 

			$("#oth").attr('class', 'form-group');

        })



        $('#nDeposito').blur(function(){ 

        	if($('#nDeposito').valid()){	

        	$("#Info").removeClass("text-success");

			$("#Info").addClass("text-danger");

			$('#Info').html("Por favor espere...").fadeIn(1000);			

       		var numero = $(this).val();        

        	var dataString = 'numero='+numero;

        	if(numero!=""){

				$.ajax({

					type: "POST",

				   	url: "../../modeloControlador/empresa/verificaDeposito.php",

				   	data: dataString,

					success: function(data) {

						if(data=="OK"){

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

			} 

        })



		$('#imgB').change(function(){ 

			if (!$(this).val().match(/(?:gif|jpg|png|PNG|JPG|GIF)$/)) {

			    $("#alerta").html('<div id="errorBU" class="alert alert-danger alert-dismissable">'+

				'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+

				'<strong> Archivo invalido, deben ser imagenes jpg, gif o png </strong>'+

				'</div>');

			}

			else{

				$("#alerta").html("");

				//$("#valIMG").val()="OK";

			}

        })

		$('#ano').blur(function(){ 

			$(this).valid();

        })

        $('#tonelada').blur(function(){ 

			$(this).valid();

        })

        $('#monto').blur(function(){ 

			$(this).valid();

        })

        $("#registroSolicitud").validate({  
               /* errorContainer: "#errores",  
                errorLabelContainer: "#errores ul",  
                wrapper: "li",  
                errorElement: "em",  */
                /*rules: {  
                        login:   {required: true, remote: {url: "check-login.php", type: "get"}},  
                        pass:    {required: true, minlength: 4},  
                        pass2:   {required: true, minlength: 4, equalTo: "#pass"},  
                        name:    {required: true},  
                        email:   {required: true,  email: true},  
                        website: {required: false, url: true},  
                        fnac:    {required: false, date: true},  
                        antiguedad:  {required: true, number: true, min: 1, max: 50},  
                        numPersonas: {required: true, range: [0, 1000]},  
                        secreto:     {basicoCaptcha: 10}  
                },*/  
                messages: {  
                        tonelada:   {  
                                min: "Debe ingresar un peso mayor a 0",  
                                max: "Excedio su limite de peso mensual (<?php echo $limite; ?> Toneladas)"
                                //remote:   "Ya existe un usuario con ese login"  
                        }/*,  
                        email:       {  
                                required: "Campo requerido: E-Mail",  
                                email:    "Formato no valido: E-Mail"  
                        },  
                        secreto: {  
                                basicoCaptcha: "Introduzca el secreto"  
                        }  */
                }  
        });  

	});

	

</script>