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
	
	$sql="insert into Empresa (razon, rif, telefono, correo, direccion, tipo, idUsuario, limite)
	 values ('".$_POST["razon"]."','".$_POST["rif"]."','".$_POST["telefono"]."','".$_POST["mail"]."','".$_POST["dir"]."','".$_POST["tipoM"]."',".$_SESSION["idUsuario"].", ".$_POST["tonelada"].")";
	$res=mysql_query($sql,$bd);

	if(!$res){
		echo/*'
			 <script type="text/javascript">
  				window.location="../../vistas/empresa/registroEmpresa.php?E=0";
			 </script>
		'*/$sql;	
	}
	else{
		$sql="select idEmpresa from Empresa order by idEmpresa desc limit 1"; 
		$res=mysql_query($sql);	
		$data=mysql_fetch_assoc($res);

		$sql="insert into Login (usuario, pass, tipo, idEmpresa)
	 	values ('".$_POST["user"]."', sha1(".$_POST["pass"]."),'em',".$data["idEmpresa"].")";
		$res=mysql_query($sql,$bd);

		$sql="insert into Estado_empresa (estado, fecha, idEmpresa, idUsuario) values ('ACTIVA', '".date("Y-m-d")."',".$data["idEmpresa"].",".$_SESSION["idUsuario"].")";
		$res2=mysql_query($sql,$bd);

		if($res){
			$sql="insert into historico_accion (codigoAccion, fecha, codigo, tabla, idUsuario)
		 	values (1, '".date("Y-m-d")."',".$data["idEmpresa"].",'EMPRESA',".$_SESSION["idUsuario"].")";
			$res=mysql_query($sql,$bd);
			$mail = new PHPMailer(); 
		    $mail->IsSMTP(); 
		    $mail->SMTPAuth = true; 
		    $mail->SMTPSecure = "ssl"; 
		    $mail->Host = "smtp.gmail.com"; 
		    $mail->Port = 465; 
		    $mail->Username = "caimta@caimta.net.ve"; //cambiar el correo por el que se cree
		    $mail->Password = "123456";//colocar la contraseña
		    $mail->From = "caimta@caimta.net.ve"; //mismo correo de arriba
			$mail->FromName = "CAIMTA"; 
			$mail->Subject = "Su empresa a sido registrada con exito";
			$mensaje='
				<html>
					<head>
					  <title>Bienvenido a CAIMTA</title>
					</head>
					<body>
					  <p>
					    Su empresa a sido registrada existosamente en CAIMTA para ingresar al sistema as click <a href="www.caimta.net.ve/gestion/index.php?user='.$_POST["user"].'">aqui</a>
					    o copia el siguiente enlace en el navegador www.caimta.net.ve/gestion/index.php?user='.$_POST["user"].'
					  </p>
					  <p>Su usuario es: <strong>'.$_POST["user"].'</strong></p>
					  <p>Su contrase&ntilde;a es: <strong>'.$_POST["pass"].'</strong></p>
					</body>
				</html>
			';
			$mail->MsgHTML($mensaje); 
			$mail->AddAddress($_POST["mail"], $_POST["razon"]); 
			$mail->IsHTML(true); 
			$mail->Send();
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/empresa/registroEmpresa.php?E=1";
				 </script>
			';	
		}
		else{
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/empresa/registroEmpresa.php?E=0";
				 </script>
			';	
		}
	}	

?>