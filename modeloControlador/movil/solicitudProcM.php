<?PHP
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("mo")){
		salir("../../");
	}
	
	$bd=Conectarse();

	$sql="select estado, idSolicitud, fecha from Estado_solicitud where idSolicitud=(select idSolicitud from Solicitud where nGuia='".$_GET["N"]."') order by fecha, estado desc limit 1";
	$res=mysql_query($sql,$bd);
	$data=mysql_fetch_assoc($res);

	if(!$data){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/movil/procesarGuia.php?E=0";
			 </script>
		';	
	}

	if($data["estado"]=="RECHAZADO"){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/movil/procesarGuia.php?E=1";
			 </script>
		';
	}

	if($data["estado"]=="PROCESADA"){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/movil/procesarGuia.php?E=4";
			 </script>
		';
	}
	
	$fecha = $data["fecha"];
	$nuevafecha = strtotime ( '+5 day' , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

	if($data["estado"]=="APROVADO" && $nuevafecha<date("Y-m-d")){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/movil/procesarGuia.php?E=5";
			 </script>
		';
	}

	if($data["estado"]=="APROVADO" && $nuevafecha>=date("Y-m-d")){ 
		$sql="insert into Estado_solicitud (fecha, estado, idUsuario, idSolicitud) values ('".date("Y-m-d")."','PROCESADA',".$_SESSION["idUsuario"].",".$data["idSolicitud"].")";
		$res=mysql_query($sql,$bd);

		if(!$res){
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/movil/procesarGuia.php?E=2";
				 </script>
			';	
		}
		else{
			$sql="select razon from Empresa where idEmpresa=(select idEmpresa from Solicitud where idSolicitud=".$data["idSolicitud"].")"; 
			$res2=mysql_query($sql);	
			$data2=mysql_fetch_assoc($res2);

			$sql="select nGuia from Solicitud where idSolicitud=".$data["idSolicitud"].""; 
			$res3=mysql_query($sql);	
			$data3=mysql_fetch_assoc($res3);

			$sql="insert into historico_accion (codigoAccion, fecha, codigo, tabla, idUsuario, nota)
		 	values (1, '".date("Y-m-d")."',".$data["idSolicitud"].",'ESTADO_SOLICITUD',".$_SESSION["idUsuario"].", 'Finalizo la solicitud numero: ".$data3["nGuia"]." de la empresa: ".$data2["razon"]."')";
			$res=mysql_query($sql,$bd);
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/movil/procesarGuia.php?E=3";
				 </script>
			';	
		}
		
	}
?>