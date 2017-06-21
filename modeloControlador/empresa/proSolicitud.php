<?PHP
	session_start(); 

	require '../../php/PHPMailerAutoload.php';
	include("../../php/class.phpmailer.php"); 
	include("../../php/class.smtp.php");

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("an")){
		salir("../../");
	}
	
	$bd=Conectarse();

	$cod=$_GET["id"];
	$est=$_GET["e"];

	$sql="select idSolicitud, idEmpresa, nGuia, fecha from Solicitud where sha1(idSolicitud)='".$cod."'"; 
	$res=mysql_query($sql);	
	$data=mysql_fetch_assoc($res);
	
	if(isset($_POST["mot"])){
		$sql="insert into Estado_solicitud (nota, fecha, estado, idUsuario, idSolicitud) values ('".$_POST["mot"]."','".date("Y-m-d")."','".$est."',".$_SESSION["idUsuario"].",".$data["idSolicitud"].")";
	}
	else{
		$sql="insert into Estado_solicitud (fecha, estado, idUsuario, idSolicitud) values ('".date("Y-m-d")."','".$est."',".$_SESSION["idUsuario"].",".$data["idSolicitud"].")";
	}
	$res=mysql_query($sql,$bd);

	if(!$res){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/empresa/proSolicitud.php?c='.$cod.'&E=0";
			 </script>
		';	
	}
	else{

		$sql="update Solicitud set estado='2' where sha1(idSolicitud)='".$cod."'";
		$res=mysql_query($sql,$bd);

		$sql="select correo, razon from Empresa where idEmpresa=".$data["idEmpresa"].""; 
		$res2=mysql_query($sql);	
		$data2=mysql_fetch_assoc($res2); 

		$sql="insert into historico_accion (codigoAccion, fecha, codigo, tabla, idUsuario, nota)
	 	values (1, '".date("Y-m-d")."',".$data["idSolicitud"].",'ESTADO_SOLICITUD',".$_SESSION["idUsuario"].", 'Fue ".$est." la solicitud numero: ".$data["nGuia"]." de la empresa: ".$data2["razon"]."')";
		$res=mysql_query($sql,$bd);

		$sql="select tipo from Material where idSolicitud=".$data["idSolicitud"].""; 
		$res3=mysql_query($sql);	
		$data3=mysql_fetch_assoc($res3); 

		$sql="select razon from Destinatario where idSolicitud=".$data["idSolicitud"].""; 
		$res4=mysql_query($sql);	
		$data4=mysql_fetch_assoc($res4); 

		$mail = new PHPMailer(); 
	    $mail->IsSMTP(); 
	    $mail->SMTPAuth = true; 
	    $mail->SMTPSecure = "ssl"; 
	    $mail->Host = "smtp.gmail.com"; 
	    $mail->Port = 465; 
	    $mail->Username = "caimta@caimta.net.ve"; //cambiar
	    $mail->Password = "123456";// cambiar
	    $mail->From = "caimta@caimta.net.ve"; //cambiar
		$mail->FromName = "CAIMTA"; 
		$mail->Subject = "Su solicitud numero ".$data["nGuia"]." a sido procesada";
		if($est=="APROVADO"){
		$mensaje='
			<html>
				<head>
				  <title>Solicitud analizada</title>
				</head>
				<body>
				  	Su solicitud n&uacute;mero: '.$data["nGuia"].' realizada el '.$data["fecha"].' para transportar '.$data3["tipo"].' hacia '.$data4["razon"].' a sido <strong>aceptada</strong> 
					as click <a href="www.caimta.net.ve/gestion/vistas/empresa/planilla.php?c='.sha1($data["nGuia"]).'&e='.sha1($data["idEmpresa"]).'">aqui</a>
			    	para imprimir la gu&iacute;a o copia el siguiente enlace en el navegador 
			    	www.caimta.net.ve/gestion/vistas/empresa/planilla.php?c='.sha1($data["nGuia"]).'&e='.sha1("si").'
				</body>
			</html>
		';
		}
		else{
		$mensaje='
			<html>
				<head>
				  <title>Solicitud analizada</title>
				</head>
				<body>
				  	Su solicitud n&uacute;mero: '.$data["nGuia"].' realizada el '.$data["fecha"].' para transportar '.$data3["tipo"].' hacia '.$data4["razon"].' a sido <strong>rechazada</strong> 
				</body>
			</html>
		';
		}
		$mail->MsgHTML($mensaje); 
		$mail->AddAddress($data2["correo"], $data2["razon"]); 
		$mail->IsHTML(true); 
		$mail->Send(); 

		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/empresa/solicNuevas.php?E=1&p=1";
			 </script>
		';	
	}	

?>