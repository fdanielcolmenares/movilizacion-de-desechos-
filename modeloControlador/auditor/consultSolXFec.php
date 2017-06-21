<?PHP
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("au")){
		salir("../../");
	}
	
	$bd=Conectarse();

	$retorno="<legend>Lista de solicitudes por fecha</legend>";

	$ban=0; 

	if($_GET["P"]=='1'){	
		$sql="select * from Solicitud as a where fecha<='".$_GET["f2"]."' and '".$_POST["tipo"]."'=(select tipo from Empresa where idEmpresa=a.idEmpresa)";		
	}
	if($_GET["P"]=='2'){	
		$sql="select * from Solicitud as a where fecha>='".$_GET["f1"]."' and '".$_POST["tipo"]."'=(select tipo from Empresa where idEmpresa=a.idEmpresa)";		
	}
	if($_GET["P"]=='3'){	
		$sql="select * from Solicitud as a where (fecha>='".$_GET["f1"]."' and fecha<='".$_GET["f2"]."') and '".$_POST["tipo"]."'=(select tipo from Empresa where idEmpresa=a.idEmpresa)";			
	}

	$res=mysql_query($sql,$bd);

	while($data=mysql_fetch_assoc($res)){
		$ban=1;
		if($data["estado"]==1){
			$sql="select tipo from Material where idSolicitud=".$data["idSolicitud"]."";
			$res2=mysql_query($sql,$bd);
			$data2=mysql_fetch_assoc($res2);

			$sql="select razon, tipo from Empresa where idEmpresa=".$data["idEmpresa"]."";
			$res5=mysql_query($sql,$bd);
			$data5=mysql_fetch_assoc($res5);			

			if($data5["tipo"]=='o'){
				$sql="select * from Deposito where idSolicitud=".$data["idSolicitud"]."";
				$res3=mysql_query($sql,$bd);
				$data3=mysql_fetch_assoc($res3);

				$dep='
					<p><strong>Banco:</strong> '.$data3["banco"].'</p>
				    <p><strong>Monto:</strong> '.$data3["monto"].'</p>
				    <p><strong>Fecha del deposito:</strong> '.$data3["fecha"].'</p>	
				    <p><strong>N&uacute;mero de deposito:</strong> '.$data3["nDeposito"].'</p>
				    <p><strong>Deposito:</strong> <div id="links">
						    <a href="../../modeloControlador/imgBauches/'.$data3["bauche"].'" title="Bauche" data-gallery>
						        <img src="../../modeloControlador/imgBauches/'.$data3["bauche"].'" alt="Bauche" height="150" width="200">
						    </a>
						</div></p>
				';

				$ima='
					<div id="blueimp-gallery" class="blueimp-gallery">
						    <!-- The container for the modal slides -->
						    <div class="slides"></div>
						    <!-- Controls for the borderless lightbox -->
						    <h3 class="title"></h3>
						    <a class="prev">‹</a>
						    <a class="next">›</a>
						    <a class="close">×</a>
						    <a class="play-pause"></a>
						    <ol class="indicator"></ol>
						    <!-- The modal dialog, which will be used to wrap the lightbox content -->
						    <div class="modal fade">
						        <div class="modal-dialog">
						            <div class="modal-content">
						                <div class="modal-header">
						                    <button type="button" class="close" aria-hidden="true">&times;</button>
						                    <h4 class="modal-title"></h4>
						                </div>
						                <div class="modal-body next"></div>
						                <div class="modal-footer">
						                    <button type="button" class="btn btn-default pull-left prev">
						                        <i class="glyphicon glyphicon-chevron-left"></i>
						                        Previous
						                    </button>
						                    <button type="button" class="btn btn-primary next">
						                        Next
						                        <i class="glyphicon glyphicon-chevron-right"></i>
						                    </button>
						                </div>
						            </div>
						        </div>
						    </div>
						</div>
				';
			}

			$retorno=$retorno.'
				<div class="col-md-8">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Numero de guia '.$data["nGuia"].'</h3>
					  </div>
					  <div class="panel-body">
					  	<p><strong>Empresa:</strong> '.$data5["razon"].'</p>
					    <p><strong>C&oacute;digo:</strong> '.$data["codigo"].' </p>
					    <p><strong>Material:</strong> '.$data2["tipo"].'</p>
					    <p><strong>Fecha de la solicitud:</strong> '.$data["fecha"].'</p>	
					    '.$dep.'				    
					    <p><strong>Estado:</strong> EN PROCESO </p>
					    <p><a class="btn btn-primary" href="../../vistas/auditor/verPlanilla.php?cod='.sha1($data["idSolicitud"]).'"><span class="glyphicon glyphicon-eye-open"></span> Ver</a></p>
					  </div>
					</div>
				</div>
			'.$ima;
		}
		if($data["estado"]==2){
			$sql="select tipo from Material where idSolicitud=".$data["idSolicitud"]."";
			$res2=mysql_query($sql,$bd);
			$data2=mysql_fetch_assoc($res2);

			$sql="select nota, idUsuario, fecha, estado from Estado_solicitud where idSolicitud=".$data["idSolicitud"]." order by fecha, estado desc limit 1";
			$res3=mysql_query($sql,$bd);
			$data3=mysql_fetch_assoc($res3);

			$sql="select nombre, apellido from Usuario where idUsuario=".$data3["idUsuario"]."";
			$res4=mysql_query($sql,$bd);
			$data4=mysql_fetch_assoc($res4);

			$sql="select razon, tipo from Empresa where idEmpresa=".$data["idEmpresa"]."";
			$res5=mysql_query($sql,$bd);
			$data5=mysql_fetch_assoc($res5);

			$dep="";
			$ima="";

			if($data5["tipo"]=='o'){
				$sql="select * from Deposito where idSolicitud=".$data["idSolicitud"]."";
				$res6=mysql_query($sql,$bd);
				$data6=mysql_fetch_assoc($res6);

				$dep='
					<p><strong>Banco:</strong> '.$data6["banco"].'</p>
				    <p><strong>Monto:</strong> '.$data6["monto"].'</p>
				    <p><strong>Fecha del deposito:</strong> '.$data6["fecha"].'</p>	
				    <p><strong>N&uacute;mero de deposito:</strong> '.$data6["nDeposito"].'</p>
				    <p><strong>Deposito:</strong> <div id="links">
						    <a href="../../modeloControlador/imgBauches/'.$data6["bauche"].'" title="Bauche" data-gallery>
						        <img src="../../modeloControlador/imgBauches/'.$data6["bauche"].'" alt="Bauche" height="150" width="200">
						    </a>
						</div></p>
				';

				$ima='
					<div id="blueimp-gallery" class="blueimp-gallery">
						    <!-- The container for the modal slides -->
						    <div class="slides"></div>
						    <!-- Controls for the borderless lightbox -->
						    <h3 class="title"></h3>
						    <a class="prev">‹</a>
						    <a class="next">›</a>
						    <a class="close">×</a>
						    <a class="play-pause"></a>
						    <ol class="indicator"></ol>
						    <!-- The modal dialog, which will be used to wrap the lightbox content -->
						    <div class="modal fade">
						        <div class="modal-dialog">
						            <div class="modal-content">
						                <div class="modal-header">
						                    <button type="button" class="close" aria-hidden="true">&times;</button>
						                    <h4 class="modal-title"></h4>
						                </div>
						                <div class="modal-body next"></div>
						                <div class="modal-footer">
						                    <button type="button" class="btn btn-default pull-left prev">
						                        <i class="glyphicon glyphicon-chevron-left"></i>
						                        Previous
						                    </button>
						                    <button type="button" class="btn btn-primary next">
						                        Next
						                        <i class="glyphicon glyphicon-chevron-right"></i>
						                    </button>
						                </div>
						            </div>
						        </div>
						    </div>
						</div>
				';
			}

			if($data3["nota"]!=""){
				$ag="<p><strong>Nota:</strong> ".$data3["nota"]."</p>";
			}

			if($data3["estado"]=="APROVADO"){
				$pan='<div class="panel panel-success">';
			}
			else{
				$pan='<div class="panel panel-danger">';
			}
			if($data3["estado"]=="APROVADO"){$estadoC="APROBADO";}
			else{$estadoC=$data3["estado"];}

			$retorno=$retorno.'
				<div class="col-md-8">
					'.$pan.'
					  <div class="panel-heading">
					    <h3 class="panel-title">Numero de guia '.$data["nGuia"].'</h3>
					  </div>
					  <div class="panel-body">
					  	<p><strong>Empresa:</strong> '.$data5["razon"].'</p>
					    <p><strong>C&oacute;digo:</strong> '.$data["codigo"].' </p>
					    <p><strong>Material:</strong> '.$data2["tipo"].'</p>
					    '.$dep.'
					    <p><strong>Fecha de analisis de solicitud:</strong> '.$data3["fecha"].'</p>						    
					    <p><strong>Estado:</strong> '.$estadoC.' </p>
					    '.$ag.'
					    <p><strong>Procesada por:</strong> '.$data4["nombre"].' '.$data4["apellido"].' </p>
					    <p><a class="btn btn-primary" href="../../vistas/auditor/verPlanilla.php?cod='.sha1($data["idSolicitud"]).'"><span class="glyphicon glyphicon-eye-open"></span> Ver</a></p>
					  </div>
					</div>
				</div>
			'.$ima;
		}	
	}

	if($ban==0){
		echo "-1";
	}
	else{
		echo $retorno;
	}
?>