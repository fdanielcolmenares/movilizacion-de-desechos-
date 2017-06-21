<?PHP
session_start();

include("../../php/conex.php");

$bd=Conectarse();


if($_GET['I']=='E'){	
	$sql="SELECT idUsuario, idEmpresa, tipo from Login where usuario='".$_POST['usuario']."' and pass='".sha1($_POST["pass"])."'"; 
	$res=mysql_query($sql);	
	$data=mysql_fetch_assoc($res);	
	if(!$data){
		echo'
			 <script type="text/javascript">
  				window.location="../../index.php?E=1";
			 </script>
		';	
	}
	else{				
		$_SESSION["tipo"]=$data["tipo"]; 
		if($data["tipo"]!='em'){ 
			$sql="SELECT idUsuario, nombre, apellido from Usuario where idUsuario=".$data['idUsuario']." and estado='a'";
			$res=mysql_query($sql);	
			$data=mysql_fetch_assoc($res);	
			$_SESSION["nombre"]=$data["nombre"]." ".$data["apellido"];
			$_SESSION["idUsuario"]=$data["idUsuario"]; 
		}
		else{
			$sql="SELECT idEmpresa, razon from Empresa where idEmpresa=".$data['idEmpresa']."";
			$res=mysql_query($sql);	
			$data=mysql_fetch_assoc($res);
			// $sql="SELECT fecha, estado from Estado_empresa where idEmpresa=".$data['idEmpresa']." order by fecha, estado desc limit 1";
			$sql="SELECT fecha, estado from Estado_empresa where idEmpresa=".$data['idEmpresa']." order by fecha desc limit 1";
			$res2=mysql_query($sql);	
			$data2=mysql_fetch_assoc($res2); echo "fecha".$data['idEmpresa'];

			$fecha = $data2["fecha"];
			$nuevafecha = strtotime ( '+24 week' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

			/*echo'
				 <script type="text/javascript">
	  				alert('.$nuevafecha.'****'.date("Y-m-d").');
				 </script>
			';*/

			if($nuevafecha<date("Y-m-d") || $data2["estado"]!="ACTIVA"){
				echo'
					 <script type="text/javascript">
		  				window.location="../../index.php?E=4";
					 </script>
				';	
			}

			$_SESSION["nombre"]=$data["razon"];
			$_SESSION["idUsuario"]=$data["idEmpresa"];
		}

		$sql="insert into Historico_conexion (tipo, fecha, hora, idUsuario)
	 	values ('c', '".date("Y-m-d")."','".date("H:i:s")."',".$_SESSION["idUsuario"].")";
		$res=mysql_query($sql,$bd);

		if($_SESSION["tipo"]=='ad'){
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/usuario/registroUsuario.php";
				 </script>
			';	
		}
		if($_SESSION["tipo"]=='an'){
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/empresa/registroEmpresa.php";
				 </script>
			';	
		}
		if($_SESSION["tipo"]=='au'){
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/auditor/reporteDiario.php";
				 </script>
			';	
		}
		if($_SESSION["tipo"]=='mo'){
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/movil/procesarGuia.php";
				 </script>
			';	
		}
		if($_SESSION["tipo"]=='em'){
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/empresa/solicitudEmpresa.php";
				 </script>
			';	
		}
	}
}

if($_GET['I']=='S'){	
	$sql="insert into Historico_conexion (tipo, fecha, hora, idUsuario)
 	values ('d', '".date("Y-m-d")."','".date("H:i:s")."',".$_SESSION["idUsuario"].")";
	$res=mysql_query($sql,$bd);
	session_destroy();	
	echo'
		 <script type="text/javascript">
			window.location="../../index.php";
		 </script>
	';	
}

?>