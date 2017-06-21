<?PHP
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("ad")){
		salir("../../");
	}
	
	$bd=Conectarse();
	
	$sql="insert into Usuario (nombre, apellido, correo, estado)
	 values ('".$_POST["nombre"]."','".$_POST["apellido"]."','".$_POST["mail"]."','".$_POST["estado"]."')";
	$res=mysql_query($sql,$bd); 

	if(!$res){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/usuario/registroUsuario.php?E=0";
			 </script>
		';	
	}
	else{
		$sql="select idUsuario from Usuario order by idUsuario desc limit 1"; 
		$res=mysql_query($sql);	
		$data=mysql_fetch_assoc($res);

		$sql="insert into Login (usuario, pass, tipo, idUsuario)
	 	values ('".$_POST["user"]."', '".sha1($_POST["pass"])."','".$_POST["tipo"]."',".$data["idUsuario"].")";
		$res=mysql_query($sql,$bd); 

		if($res){
			$sql="insert into historico_accion (codigoAccion, fecha, codigo, tabla, idUsuario)
		 	values (1, '".date("Y-m-d")."',".$data["idUsuario"].",'USUARIO',".$_SESSION["idUsuario"].")";
			$res=mysql_query($sql,$bd);
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/usuario/registroUsuario.php?E=1";
				 </script>
			';	
		}
		else{
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/usuario/registroUsuario.php?E=0";
				 </script>
			';	
		}
	}	

?>