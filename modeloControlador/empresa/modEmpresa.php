<?PHP
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");

	if(!permisos("ad") && !permisos("an")){
		salir("../../");
	}
	
	$bd=Conectarse();

	if(isset($_GET["p"])){
		if($_GET["p"]=='1') $menu=1;
		else $menu=0;
	}

	$id=$_POST["idU"];
	
	$sql="update Empresa set razon='".$_POST["razon"]."', rif='".$_POST["rif"]."', telefono='".$_POST["telefono"]."', correo='".$_POST["mail"]."', direccion='".$_POST["dir"]."', limite=".$_POST["tonelada"].", tipo='".$_POST["tipo"]."' where sha1(idEmpresa)='".$id."'";
	$res=mysql_query($sql,$bd);

	if(!$res){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/empresa/modUsuarioE.php?E=0&u='.$id.'";
			 </script>
		';	
	}
	else{

		$sql="select idEmpresa from Empresa where sha1(idEmpresa)='".$id."'"; 
		$res=mysql_query($sql);	
		$data=mysql_fetch_assoc($res);

		$sql2="insert into Estado_empresa (estado, fecha, idEmpresa, idUsuario) values ('".$_POST["tipoC"]."', '".date("Y-m-d")."',".$data["idEmpresa"].",".$_SESSION["idUsuario"].")";
		$res2=mysql_query($sql2,$bd);

		if($_POST["pass"]!=""){
			$sql="update Login set pass='".sha1($_POST["pass"])."' where sha1(idEmpresa)='".$id."'";
			$res=mysql_query($sql,$bd);

			if($res){
				$sql="insert into Historico_accion (codigoAccion, fecha, codigo, tabla, idUsuario)
			 	values (2, '".date("Y-m-d")."',".$data["idEmpresa"].",'EMPRESA',".$_SESSION["idUsuario"].")";
				$res=mysql_query($sql,$bd);
				echo'
					 <script type="text/javascript">
		  				window.location="../../vistas/empresa/modUsuarioE.php?p=1&E=1&u='.$id.'";
					 </script>
				';	
			}
			else{
				echo'
					 <script type="text/javascript">
		  				window.location="../../vistas/empresa/modUsuarioE.php?p=1&E=0&u='.$id.'";
					 </script>
				';	
			}
		}
		else{
			$sql="insert into Historico_accion (codigoAccion, fecha, codigo, tabla, idUsuario)
		 	values (2, '".date("Y-m-d")."',".$data["idEmpresa"].",'EMPRESA',".$_SESSION["idUsuario"].")";
			$res=mysql_query($sql,$bd);
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/empresa/modUsuarioE.php?E=1&u='.$id.'&p='.$menu.'";
				 </script>
			';
		}
		
	}	

?>