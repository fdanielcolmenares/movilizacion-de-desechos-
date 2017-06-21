<?PHP
	include("../../php/conex.php");
	include("../../php/funciones.php");
	
	isConnect("../../");
	if(!permisos("ad") && !permisos("an")){
		salir("../../");
	}
	
	$bd=Conectarse();
	
	$sql="SELECT usuario from Login where usuario='".$_POST['usuario']."'"; 
	$res=mysql_query($sql);	
	$data=mysql_fetch_assoc($res);
	
	if(!$data){
		echo 'Disponible';
	}
	else{
		echo 'No disponible';	
	}
?>