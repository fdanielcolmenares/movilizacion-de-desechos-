<?PHP
	
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("em")){
		salir("../../");
	}
	
	$bd=Conectarse();

	$t=$_POST["t"];

	$pag=$_GET["p"];

	$ban = 0;

	if($t=='E'){
		$sql="select count(idSolicitud) as c from Solicitud where idEmpresa=".$_SESSION["idUsuario"]." and estado='1' order by fecha desc";
		$res=mysql_query($sql,$bd);
		$data=mysql_fetch_assoc($res);
		
		$div=5;//5

		$cantidad=$data["c"];
		$n=ceil($cantidad/$div);

		$fin=($pag*$div);	
		$ini=($fin-$div);

		$sql="select * from Solicitud where idEmpresa=".$_SESSION["idUsuario"]." and estado='1' order by fecha desc limit ".$ini." , ".$fin."";
		$res=mysql_query($sql,$bd);
		while($data=mysql_fetch_assoc($res)){
			$ban=1;
			$sql="select banco, monto from Deposito where idSolicitud=".$data["idSolicitud"]."";
			$res2=mysql_query($sql,$bd);
			$data2=mysql_fetch_assoc($res2);

			$retorno=$retorno.'
				<div class="col-md-8">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Numero de guia '.$data["nGuia"].'</h3>
					  </div>
					  <div class="panel-body">
					    <div><strong>Estado:</strong> EN ANALISIS</div>
					    <div><strong>Fecha solicitud:</strong> '.$data["fecha"].'</div>	
					    <div><strong>Banco del deposito:</strong> '.$data2["banco"].' </div>
					    <div><strong>Monto:</strong> '.$data2["monto"].' Bf</div>
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
				$l1='<li><a href="../../vistas/empresa/listadoSolE.php?p='.($pag-1).'&t='.$t.'">&laquo;</a></li>';
			}
			for($i=0;$i<$n;$i++){ 	
				if($pag==($i+1)){					  	
					$l2=$l2.'<li class="active"><a href="../../vistas/empresa/listadoSolE.php?p='.($i+1).'&t='.$t.'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
		  		} else{
		  			$l2=$l2.'<li><a href="../../vistas/empresa/listadoSolE.php?p='.($i+1).'&t='.$t.'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
				}
		  	}
		  	if($pag==$n){ 
				$l3=$l3.'<li class="disabled"><a href="#">&raquo;</a></li>';
			} else{
				$l3=$l3.'<li><a href="../../vistas/empresa/listadoSolE.php?p='.($pag+1).'&t='.$t.'">&raquo;</a></li>';
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
	else{
		if($t=='A'){
		$sql="select count(idSolicitud) as c from Solicitud as a where 'APROVADO'=(select estado from Estado_solicitud where  a.idSolicitud=idSolicitud order by fecha, estado desc limit 1) and idEmpresa=".$_SESSION["idUsuario"]." and estado='2' order by a.fecha desc";
		$res2=mysql_query($sql,$bd);
		$data2=mysql_fetch_assoc($res2);
		
		$div=5;//5

		$cantidad=$data2["c"];
		$n=ceil($cantidad/$div);

		$fin=($pag*$div);	
		$ini=($fin-$div);

		$sql="select * from Solicitud as a where 'APROVADO'=(select estado from Estado_solicitud where  a.idSolicitud=idSolicitud order by fecha, estado desc limit 1) and idEmpresa=".$_SESSION["idUsuario"]." and estado='2' order by a.fecha desc limit ".$ini." , ".$fin."";		
		//$sql="select * from Solicitud where idEmpresa=".$_SESSION["idUsuario"]." and estado='2' order by fecha desc";
		$res=mysql_query($sql,$bd);
		while($data=mysql_fetch_assoc($res)){
			
			$sql="select nota, idUsuario, fecha, estado from Estado_solicitud where idSolicitud=".$data["idSolicitud"]." order by fecha, estado desc limit 1";
			$res2=mysql_query($sql,$bd);
			$data2=mysql_fetch_assoc($res2);

			$sql="select banco, monto from Deposito where idSolicitud=".$data["idSolicitud"]."";
			$res3=mysql_query($sql,$bd);
			$data3=mysql_fetch_assoc($res3);

			$fecha = $data2["fecha"];
			$nuevafecha = strtotime ( '+5 day' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha ); 

			/*if($t=='A'){
				if($data2["estado"]=='APROVADO'){*/
					$ban=1;
					if($nuevafecha>=date("Y-m-d")){					    
				    	$enl='<div><a href="../../vistas/empresa/planilla.php?c='.sha1($data["nGuia"]).'" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>';					    
				  	}else{$enl='';}
					$retorno=$retorno.'
						<div class="col-md-8">
							<div class="panel panel-info">
							  <div class="panel-heading">
							    <h3 class="panel-title">Numero de guia '.$data["nGuia"].'</h3>
							  </div>
							  <div class="panel-body">
							    <div><strong>Estado:</strong> APROBADA </div>
							    <div><strong>Fecha solicitud:</strong> '.$data["fecha"].'</div>
							    <div><strong>Fecha validación:</strong> '.$data2["fecha"].'</div>						    
							    <div><strong>Fecha vencimiento:</strong> '.$nuevafecha.'</div>
							    <div><strong>Banco del deposito:</strong> '.$data3["banco"].' </div>
							    <div><strong>Monto:</strong> '.$data3["monto"].' Bf</div>	
							    '.$enl.'
							  </div>
							</div>
						</div>
					';
				/*}
			}*/
		}
		if($n>1){
			if($pag==1){
				$l1='<li class="disabled"><a href="#">&laquo;</a></li>';
			}
			else{
				$l1='<li><a href="../../vistas/empresa/listadoSolE.php?p='.($pag-1).'&t='.$t.'">&laquo;</a></li>';
			}
			for($i=0;$i<$n;$i++){ 	
				if($pag==($i+1)){					  	
					$l2=$l2.'<li class="active"><a href="../../vistas/empresa/listadoSolE.php?p='.($i+1).'&t='.$t.'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
		  		} else{
		  			$l2=$l2.'<li><a href="../../vistas/empresa/listadoSolE.php?p='.($i+1).'&t='.$t.'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
				}
		  	}
		  	if($pag==$n){ 
				$l3=$l3.'<li class="disabled"><a href="#">&raquo;</a></li>';
			} else{
				$l3=$l3.'<li><a href="../../vistas/empresa/listadoSolE.php?p='.($pag+1).'&t='.$t.'">&raquo;</a></li>';
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

	if($t=='R'){
		$sql="select count(idSolicitud) as c from Solicitud as a where 'RECHAZADO'=(select estado from Estado_solicitud where  a.idSolicitud=idSolicitud order by fecha, estado desc limit 1) and idEmpresa=".$_SESSION["idUsuario"]." and estado='2' order by a.fecha desc";
		$res2=mysql_query($sql,$bd);
		$data2=mysql_fetch_assoc($res2);
		
		$div=5;//5

		$cantidad=$data2["c"];
		$n=ceil($cantidad/$div);

		$fin=($pag*$div);	
		$ini=($fin-$div);

		$sql="select * from Solicitud as a where 'RECHAZADO'=(select estado from Estado_solicitud where  a.idSolicitud=idSolicitud order by fecha, estado desc limit 1) and idEmpresa=".$_SESSION["idUsuario"]." and estado='2' order by a.fecha desc limit ".$ini." , ".$fin."";	
		$res=mysql_query($sql,$bd);
		while($data=mysql_fetch_assoc($res)){
			
			$sql="select nota, idUsuario, fecha, estado from Estado_solicitud where idSolicitud=".$data["idSolicitud"]." order by fecha, estado desc limit 1";
			$res2=mysql_query($sql,$bd);
			$data2=mysql_fetch_assoc($res2);

			$sql="select banco, monto from Deposito where idSolicitud=".$data["idSolicitud"]."";
			$res3=mysql_query($sql,$bd);
			$data3=mysql_fetch_assoc($res3);

			/*$fecha = $data2["fecha"];
			$nuevafecha = strtotime ( '+5 day' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha ); */

			$ban=1;
		/*if($data2["estado"]=='RECHAZADO'){
			$ban=1;*/
			$retorno=$retorno.'
				<div class="col-md-8">
					<div class="panel panel-danger">
					  <div class="panel-heading">
					    <h3 class="panel-title">Numero de guia '.$data["nGuia"].'</h3>
					  </div>
					  <div class="panel-body">
					    <div><strong>Estado:</strong> RECHAZADA </div>
					    <div><strong>Fecha validación:</strong> '.$data2["fecha"].'</div>	
					    <div><strong>Banco del deposito:</strong> '.$data3["banco"].'</div>
					    <div><strong>Monto:</strong> '.$data3["monto"].' Bf</div>
					    <div><strong>Nota:</strong> '.$data2["nota"].'</div>						    
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
				$l1='<li><a href="../../vistas/empresa/listadoSolE.php?p='.($pag-1).'&t='.$t.'">&laquo;</a></li>';
			}
			for($i=0;$i<$n;$i++){ 	
				if($pag==($i+1)){					  	
					$l2=$l2.'<li class="active"><a href="../../vistas/empresa/listadoSolE.php?p='.($i+1).'&t='.$t.'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
		  		} else{
		  			$l2=$l2.'<li><a href="../../vistas/empresa/listadoSolE.php?p='.($i+1).'&t='.$t.'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
				}
		  	}
		  	if($pag==$n){ 
				$l3=$l3.'<li class="disabled"><a href="#">&raquo;</a></li>';
			} else{
				$l3=$l3.'<li><a href="../../vistas/empresa/listadoSolE.php?p='.($pag+1).'&t='.$t.'">&raquo;</a></li>';
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

	if($t=='F'){
		/*if($data2["estado"]=='PROCESADA'){
			$ban=1;*/
		$sql="select count(idSolicitud) as c from Solicitud as a where 'PROCESADA'=(select estado from Estado_solicitud where  a.idSolicitud=idSolicitud order by fecha, estado desc limit 1) and idEmpresa=".$_SESSION["idUsuario"]." and estado='2' order by a.fecha desc";
		$res2=mysql_query($sql,$bd);
		$data2=mysql_fetch_assoc($res2);
		
		$div=5;//5

		$cantidad=$data2["c"];
		$n=ceil($cantidad/$div);

		$fin=($pag*$div);	
		$ini=($fin-$div);

		$sql="select * from Solicitud as a where 'PROCESADA'=(select estado from Estado_solicitud where  a.idSolicitud=idSolicitud order by fecha, estado desc limit 1) and idEmpresa=".$_SESSION["idUsuario"]." and estado='2' order by a.fecha desc limit ".$ini." , ".$fin."";	
		$res=mysql_query($sql,$bd);
		while($data=mysql_fetch_assoc($res)){
			
			$sql="select nota, idUsuario, fecha, estado from Estado_solicitud where idSolicitud=".$data["idSolicitud"]." order by fecha, estado desc limit 1";
			$res2=mysql_query($sql,$bd);
			$data2=mysql_fetch_assoc($res2);

			$sql="select banco, monto from Deposito where idSolicitud=".$data["idSolicitud"]."";
			$res3=mysql_query($sql,$bd);
			$data3=mysql_fetch_assoc($res3);

			/*$fecha = $data2["fecha"];
			$nuevafecha = strtotime ( '+5 day' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha ); */

			$ban=1;
			$retorno=$retorno.'
				<div class="col-md-8">
					<div class="panel panel-info">
					  <div class="panel-heading">
					    <h3 class="panel-title">Numero de guia '.$data["nGuia"].'</h3>
					  </div>
					  <div class="panel-body">
					    <div><strong>Estado:</strong> FINALIZADA </div>
					    <div><strong>Fecha solicitud:</strong> '.$data["fecha"].'</div>
					    <div><strong>Fecha verificacion:</strong> '.$data2["fecha"].'</div>
					    <div><strong>Banco del deposito:</strong> '.$data3["banco"].' </div>
					    <div><strong>Monto:</strong> '.$data3["monto"].' Bf</div>	
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
				$l1='<li><a href="../../vistas/empresa/listadoSolE.php?p='.($pag-1).'&t='.$t.'">&laquo;</a></li>';
			}
			for($i=0;$i<$n;$i++){ 	
				if($pag==($i+1)){					  	
					$l2=$l2.'<li class="active"><a href="../../vistas/empresa/listadoSolE.php?p='.($i+1).'&t='.$t.'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
		  		} else{
		  			$l2=$l2.'<li><a href="../../vistas/empresa/listadoSolE.php?p='.($i+1).'&t='.$t.'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
				}
		  	}
		  	if($pag==$n){ 
				$l3=$l3.'<li class="disabled"><a href="#">&raquo;</a></li>';
			} else{
				$l3=$l3.'<li><a href="../../vistas/empresa/listadoSolE.php?p='.($pag+1).'&t='.$t.'">&raquo;</a></li>';
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
	}
	
	if($ban == 0){echo "-1";}//
	else{echo $retorno;}
?>