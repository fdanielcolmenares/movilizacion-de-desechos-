<?PHP
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");

	if(!permisos("mo")){
		salir("../../");
	}
	
	$bd=Conectarse();

	$sql="select idLogin from Login where pass='".sha1($_POST["pass"])."' and idUsuario='".$_SESSION["idUsuario"]."'";
	$res=mysql_query($sql);	
	$data=mysql_fetch_assoc($res);

	if(!$data){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/movil/cambioContrasenaM.php?E=2";
			 </script>
		';
	}
	else{
		$sql="update Login set pass='".sha1($_POST["passN1"])."' where idLogin=".$data["idLogin"]."";
		$res=mysql_query($sql,$bd);

		if($res){
			$sql="insert into historico_accion (codigoAccion, fecha, codigo, tabla, idUsuario, nota)
		 	values (2, '".date("Y-m-d")."',".$data["idLogin"].",'LOGIN',".$_SESSION["idUsuario"].", 'Cambio de contraseña del usuario: ".$_SESSION["nombre"]."')";
			$res=mysql_query($sql,$bd);
			echo'
			 <script type="text/javascript">
  				window.location="../../vistas/movil/cambioContrasenaM.php?E=1";
			 </script>
		';
		}
		else{
			echo'
			 <script type="text/javascript">
  				window.location="../../vistas/movil/cambioContrasenaM.php?E=0";
			 </script>
		';
		}
	}

?>