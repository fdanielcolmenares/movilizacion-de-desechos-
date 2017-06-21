<?PHP
	include("../../php/conex.php");
	include("../../php/funciones.php");
	
	isConnect("../../");
	if(!permisos("an")){
		salir("../../");
	}
	
	$bd=Conectarse();
	
	$sql="SELECT rif from Empresa where rif='".$_POST['rif']."'"; 
	$res=mysql_query($sql);	
	$data=mysql_fetch_assoc($res);
	
	if(!$data){
		echo 'Disponible';
	}
	else{
		echo 'No disponible';	
	}
?>