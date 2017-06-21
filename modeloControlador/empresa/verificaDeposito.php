<?PHP
	include("../../php/conex.php");
	include("../../php/funciones.php");
	
	isConnect("../../");
	if(!permisos("em")){
		salir("../../");
	}
	
	$bd=Conectarse();
	
	$sql="SELECT idSolicitud from Deposito where nDeposito='".$_POST['numero']."'"; 
	$res=mysql_query($sql);	
	$data=mysql_fetch_assoc($res);
	
	if(!$data){
		echo 'OK';
	}
	else{
		$sql="SELECT estado from Estado_solicitud where idSolicitud=".$data['idSolicitud']." order by fecha desc limit 1"; //echo $sql;
		$res=mysql_query($sql);	
		$data=mysql_fetch_assoc($res);
		if(!$data){echo 'Deposito ya utilizado';}
		else{
			if($data["estado"]=="RECHAZADO"){
				echo "OK";
			}
			else{
				echo 'Deposito ya utilizado';
			}
		}
	}
?>