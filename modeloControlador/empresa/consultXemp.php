<?PHP
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("an")){
		salir("../../");
	}
	
	$bd=Conectarse();

	$retorno="<legend>Lista de solicitudes</legend>";

	$ban=0; 

	$pag=$_GET["p"];

	if($_GET["T"]=='A'){


		if($_POST["nombre"]!=""){	
			$sql2="select count(idSolicitud) as c from Solicitud where idEmpresa=(select idEmpresa from Empresa where razon='".$_POST["nombre"]."') and estado='1'";
		}
		else{
			$sql2="select count(idSolicitud) as c from Solicitud where estado='1'";
		}		

		$res2=mysql_query($sql2,$bd);
		$data=mysql_fetch_assoc($res2);
		
		$div=5;//5

		$cantidad=$data["c"];
		$n=ceil($cantidad/$div);

		$fin=($pag*$div);	
		$ini=($fin-$div);

		if($_POST["nombre"]!=""){	
			$sql="select idSolicitud, idEmpresa, fecha, nGuia, codigo from Solicitud where idEmpresa=(select idEmpresa from Empresa where razon='".$_POST["nombre"]."') and estado='1'";$sql="select count(idSolicitud) as c from Solicitud where idEmpresa=(select idEmpresa from Empresa where razon='".$_POST["nombre"]."') and estado='1' limit ".$ini." , ".$fin."";
		}
		else{
			$sql="select idSolicitud, idEmpresa, fecha, nGuia, codigo from Solicitud where estado='1' limit ".$ini." , ".$fin."";
		}
		$res=mysql_query($sql,$bd); //echo $sql;

		while($data=mysql_fetch_assoc($res)){
			$sql4="select razon from Empresa where idEmpresa=".$data["idEmpresa"]."";
			$res4=mysql_query($sql4,$bd);
			$data4=mysql_fetch_assoc($res4);
			$ban=1;
			$retorno=$retorno.'
				<div class="col-md-8">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Solicitud # '.$data["nGuia"].'</h3>
					  </div>
					  <div class="panel-body">
					    <p><strong>C&oacute;digo:</strong> '.$data["codigo"].' </p>
					    <p><strong>Empresa:</strong> '.$data4["razon"].'</p>
					    <p><strong>Fecha:</strong> '.$data["fecha"].'</p>	
					    <p><strong>Estado:</strong> EN ANALISIS</p>					    
					    <p><a class="btn btn-primary" href="../../vistas/empresa/verSolicitud.php?cod='.sha1($data["idSolicitud"]).'"><span class="glyphicon glyphicon-eye-open"></span> Ver</a></p>
					  </div>
					</div>
				</div>
			';	
		}
		if($n>1){
			if($pag==1){
				$l1='<li class="disabled"><a href="#">&laquo;</a></li>';
			}
			else{
				$l1='<li><a href="../../vistas/empresa/consultaSolicitud.php?p='.($pag-1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">&laquo;</a></li>';
			}
			for($i=0;$i<$n;$i++){ 	
				if($pag==($i+1)){					  	
					$l2=$l2.'<li class="active"><a href="../../vistas/empresa/consultaSolicitud.php?p='.($i+1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
		  		} else{
		  			$l2=$l2.'<li><a href="../../vistas/empresa/consultaSolicitud.php?p='.($i+1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
				}
		  	}
		  	if($pag==$n){ 
				$l3=$l3.'<li class="disabled"><a href="#">&raquo;</a></li>';
			} else{
				$l3=$l3.'<li><a href="../../vistas/empresa/consultaSolicitud.php?p='.($pag+1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">&raquo;</a></li>';
			}
			$retorno=$retorno.'
				<div class="col-md-8">
					<ul class="pagination">
						'.$l1.'
						'.$l2.'
					  	'.$l3.'						  	
					</ul>
				</div>
			';
		}
	}

	if($_GET["T"]=='P'){

		if($_POST["nombre"]!=""){	
			$sql2="select count(idSolicitud) as c from Solicitud as a where idEmpresa=(select idEmpresa from Empresa where razon='".$_POST["nombre"]."') and estado='2' and 'APROVADO'=(select estado from Estado_solicitud where idSolicitud=a.idSolicitud order by fecha, estado desc limit 1)";
		}
		else{
			$sql2="select count(idSolicitud) as c from Solicitud as a where estado='2' and 'APROVADO'=(select estado from Estado_solicitud where idSolicitud=a.idSolicitud order by fecha, estado desc limit 1)";
		}		

		$res2=mysql_query($sql2,$bd);
		$data=mysql_fetch_assoc($res2);
		
		$div=5;//5

		$cantidad=$data["c"];
		$n=ceil($cantidad/$div);

		$fin=($pag*$div);	
		$ini=($fin-$div);
		
		if($_POST["nombre"]!=""){
			$sql="select idSolicitud, idEmpresa, fecha, nGuia, codigo from Solicitud as a where idEmpresa=(select idEmpresa from Empresa where razon='".$_POST["nombre"]."') and estado='2' and 'APROVADO'=(select estado from Estado_solicitud where idSolicitud=a.idSolicitud order by fecha, estado desc limit 1) limit ".$ini." , ".$fin."";
		}
		else{
			$sql="select idSolicitud, idEmpresa, fecha, nGuia, codigo from Solicitud as a where estado='2' and 'APROVADO'=(select estado from Estado_solicitud where idSolicitud=a.idSolicitud order by fecha, estado desc limit 1) limit ".$ini." , ".$fin."";
		}
		$res=mysql_query($sql,$bd);

		while($data=mysql_fetch_assoc($res)){
			/*$sql="select estado from Estado_solicitud where idSolicitud=".$data["idSolicitud"]." order by fecha, estado desc limit 1";
			$res2=mysql_query($sql,$bd);
			$data2=mysql_fetch_assoc($res2);
			if($data2["estado"]=="APROVADO"){*/
				$sql4="select razon from Empresa where idEmpresa=".$data["idEmpresa"]."";
				$res4=mysql_query($sql4,$bd);
				$data4=mysql_fetch_assoc($res4);
				$ban=1;
				$retorno=$retorno.'
					<div class="col-md-8">
						<div class="panel panel-primary">
						  <div class="panel-heading">
						    <h3 class="panel-title">Solicitud # '.$data["nGuia"].'</h3>
						  </div>
						  <div class="panel-body">
						    <p><strong>C&oacute;digo:</strong> '.$data["codigo"].' </p>
						    <p><strong>Empresa:</strong> '.$data4["razon"].'</p>
						    <p><strong>Fecha:</strong> '.$data["fecha"].'</p>	
						    <p><strong>Estado:</strong> ACTIVA</p>					    
						    <p><a class="btn btn-primary" href="../../vistas/empresa/verSolicitud.php?cod='.sha1($data["idSolicitud"]).'"><span class="glyphicon glyphicon-eye-open"></span> Ver</a></p>
						  </div>
						</div>
					</div>
				';	
			//}
		}
		if($n>1){
			if($pag==1){
				$l1='<li class="disabled"><a href="#">&laquo;</a></li>';
			}
			else{
				$l1='<li><a href="../../vistas/empresa/consultaSolicitud.php?p='.($pag-1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">&laquo;</a></li>';
			}
			for($i=0;$i<$n;$i++){ 	
				if($pag==($i+1)){					  	
					$l2=$l2.'<li class="active"><a href="../../vistas/empresa/consultaSolicitud.php?p='.($i+1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
		  		} else{
		  			$l2=$l2.'<li><a href="../../vistas/empresa/consultaSolicitud.php?p='.($i+1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
				}
		  	}
		  	if($pag==$n){ 
				$l3=$l3.'<li class="disabled"><a href="#">&raquo;</a></li>';
			} else{
				$l3=$l3.'<li><a href="../../vistas/empresa/consultaSolicitud.php?p='.($pag+1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">&raquo;</a></li>';
			}
			$retorno=$retorno.'
				<div class="col-md-8">
					<ul class="pagination">
						'.$l1.'
						'.$l2.'
					  	'.$l3.'						  	
					</ul>
				</div>
			';
		}
	}

	if($_GET["T"]=='R'){

		if($_POST["nombre"]!=""){	
			$sql2="select count(idSolicitud) as c from Solicitud as a where idEmpresa=(select idEmpresa from Empresa where razon='".$_POST["nombre"]."') and estado='2' and 'RECHAZADO'=(select estado from Estado_solicitud where idSolicitud=a.idSolicitud order by fecha, estado desc limit 1)";
		}
		else{
			$sql2="select count(idSolicitud) as c from Solicitud as a where estado='2' and 'RECHAZADO'=(select estado from Estado_solicitud where idSolicitud=a.idSolicitud order by fecha, estado desc limit 1)";
		}		

		$res2=mysql_query($sql2,$bd); echo $sql;
		$data=mysql_fetch_assoc($res2);
		
		$div=5;//5

		$cantidad=$data["c"];
		$n=ceil($cantidad/$div);

		$fin=($pag*$div);	
		$ini=($fin-$div);
	
		if($_POST["nombre"]!=""){
			$sql="select idSolicitud, idEmpresa, fecha, nGuia, codigo from Solicitud as a where idEmpresa=(select idEmpresa from Empresa where razon='".$_POST["nombre"]."') and estado='2' and 'RECHAZADO'=(select estado from Estado_solicitud where idSolicitud=a.idSolicitud order by fecha, estado desc limit 1)";
		}
		else{
			$sql="select idSolicitud, idEmpresa, fecha, nGuia, codigo from Solicitud as a where estado='2' and 'RECHAZADO'=(select estado from Estado_solicitud where idSolicitud=a.idSolicitud order by fecha, estado desc limit 1)";
		}
		$res=mysql_query($sql,$bd);

		while($data=mysql_fetch_assoc($res)){
			$sql="select nota, estado from Estado_solicitud where idSolicitud=".$data["idSolicitud"]." order by fecha, estado desc limit 1";
			$res2=mysql_query($sql,$bd);
			$data2=mysql_fetch_assoc($res2);
			if($data2["estado"]=="RECHAZADO"){
				$sql4="select razon from Empresa where idEmpresa=".$data["idEmpresa"]."";
				$res4=mysql_query($sql4,$bd);
				$data4=mysql_fetch_assoc($res4);
				$ban=1;
				$retorno=$retorno.'
					<div class="col-md-8">
						<div class="panel panel-primary">
						  <div class="panel-heading">
						    <h3 class="panel-title">Solicitud # '.$data["nGuia"].'</h3>
						  </div>
						  <div class="panel-body">
						    <p><strong>C&oacute;digo:</strong> '.$data["codigo"].' </p>
						    <p><strong>Empresa:</strong> '.$data4["razon"].'</p>
						    <p><strong>Fecha:</strong> '.$data["fecha"].'</p>	
						    <p><strong>Nota:</strong> '.$data2["nota"].'</p>					    
						    <p><a class="btn btn-primary" href="../../vistas/empresa/verSolicitud.php?cod='.sha1($data["idSolicitud"]).'"><span class="glyphicon glyphicon-eye-open"></span> Ver</a></p>
						  </div>
						</div>
					</div>
				';	
			}
		}
		if($n>1){
			if($pag==1){
				$l1='<li class="disabled"><a href="#">&laquo;</a></li>';
			}
			else{
				$l1='<li><a href="../../vistas/empresa/consultaSolicitud.php?p='.($pag-1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">&laquo;</a></li>';
			}
			for($i=0;$i<$n;$i++){ 	
				if($pag==($i+1)){					  	
					$l2=$l2.'<li class="active"><a href="../../vistas/empresa/consultaSolicitud.php?p='.($i+1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
		  		} else{
		  			$l2=$l2.'<li><a href="../../vistas/empresa/consultaSolicitud.php?p='.($i+1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
				}
		  	}
		  	if($pag==$n){ 
				$l3=$l3.'<li class="disabled"><a href="#">&raquo;</a></li>';
			} else{
				$l3=$l3.'<li><a href="../../vistas/empresa/consultaSolicitud.php?p='.($pag+1).'&T='.$_GET["T"].'&n='.$_POST["nombre"].'">&raquo;</a></li>';
			}
			$retorno=$retorno.'
				<div class="col-md-8">
					<ul class="pagination">
						'.$l1.'
						'.$l2.'
					  	'.$l3.'						  	
					</ul>
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