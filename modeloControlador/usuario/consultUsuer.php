<?PHP
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("ad")){
		salir("../../");
	}
	
	$bd=Conectarse();

	$retorno="<legend>Lista de transaciones por usuario</legend>";

	$ban=0; 

	if($_GET["P"]=='1'){	
		$sql="select * from historico_accion where idUsuario=(select idUsuario from Login where usuario='".$_POST["user"]."') or idEmpresa=(select idEmpresa from Login where usuario='".$_POST["user"]."')";		
	}
	if($_GET["P"]=='2'){	
		$sql="select * from historico_accion where (idUsuario=(select idUsuario from Login where usuario='".$_POST["user"]."') or idEmpresa=(select idEmpresa from Login where usuario='".$_POST["user"]."')) and fecha>='".$_GET["f1"]."'";		
	}
	if($_GET["P"]=='3'){	
		$sql="select * from historico_accion where (idUsuario=(select idUsuario from Login where usuario='".$_POST["user"]."') or idEmpresa=(select idEmpresa from Login where usuario='".$_POST["user"]."') ) and fecha<='".$_GET["f2"]."'";		
	}
	if($_GET["P"]=='4'){	
		$sql="select * from historico_accion where (idUsuario=(select idUsuario from Login where usuario='".$_POST["user"]."') or idEmpresa=(select idEmpresa from Login where usuario='".$_POST["user"]."') ) and (fecha>='".$_GET["f1"]."' and fecha<='".$_GET["f2"]."')";		
	}

	$res=mysql_query($sql,$bd);

	while($data=mysql_fetch_assoc($res)){
		$ban++;
		if($data["nota"]!=""){
			$add="<p><strong>Nota:</strong> ".$data["nota"]."</p>";
		}
		if($data["codigoAccion"]==1){
			$retorno=$retorno.'
				<div class="col-md-8">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Transacion # '.$ban.'</h3>
					  </div>
					  <div class="panel-body">
					    <p><strong>Acci&oacute;n:</strong> INSERTO</p>
					    <p><strong>C&oacute;digo modificado:</strong> '.$data["codigo"].'</p>
					    <p><strong>Tabla:</strong> '.$data["tabla"].'</p>						    
					    <p><strong>Fecha:</strong> '.$data["fecha"].'</p>
					    '.$add.'
					  </div>
					</div>
				</div>
			';
		}
		if($data["codigoAccion"]==2){
			$retorno=$retorno.'
				<div class="col-md-8">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Transacion # '.$ban.'</h3>
					  </div>
					  <div class="panel-body">
					    <p><strong>Acci&oacute;n:</strong> MODIFICO</p>
					    <p><strong>C&oacute;digo modificado:</strong> '.$data["codigo"].'</p>
					    <p><strong>Tabla:</strong> '.$data["tabla"].'</p>						    
					    <p><strong>Fecha:</strong> '.$data["fecha"].'</p>
					    '.$add.'
					  </div>
					</div>
				</div>
			';
		}	
	}

	if($ban==0){
		echo "-1"; 
	}
	else{
		echo $retorno;
	}
?>