<?PHP
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("ad")){
		salir("../../");
	}
	
	$bd=Conectarse();

	$id=$_POST["idU"];
	
	$sql="update Usuario set nombre='".$_POST["nombre"]."', apellido='".$_POST["apellido"]."', correo='".$_POST["mail"]."', estado='".$_POST["estado"]."' where sha1(idUsuario)='".$id."'";
	$res=mysql_query($sql,$bd);

	if(!$res){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/usuario/modUsuarioI.php?E=0&u='.$id.'";
			 </script>
		';	
	}
	else{

		$sql="select idUsuario from Usuario where sha1(idUsuario)='".$id."'"; 
		$res=mysql_query($sql);	
		$data=mysql_fetch_assoc($res);

		if($_POST["pass"]!=""){
			$sql="update Login set pass='".sha1($_POST["pass"])."', tipo='".$_POST["tipo"]."' where sha1(idUsuario)='".$id."'";
			$res=mysql_query($sql,$bd);
		}
		else{
			$sql="update Login set tipo='".$_POST["tipo"]."' where sha1(idUsuario)='".$id."'";
			$res=mysql_query($sql,$bd);
		}

		if($res){
			$sql="insert into historico_accion (codigoAccion, fecha, codigo, tabla, idUsuario)
		 	values (2, '".date("Y-m-d")."',".$data["idUsuario"].",'USUARIO',".$_SESSION["idUsuario"].")";
			$res=mysql_query($sql,$bd);
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/usuario/modUsuarioI.php?E=1&u='.$id.'";
				 </script>
			';	
		}
		else{
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/usuario/modUsuarioI.php?E=0&u='.$id.'";
				 </script>
			';	
		}
	}	

?>