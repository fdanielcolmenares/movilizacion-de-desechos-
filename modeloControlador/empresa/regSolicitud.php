<?PHP
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("em")){
		salir("../../");
	}
	
	$bd=Conectarse(); 

	if($_POST["materiales"]==""){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/empresa/solicitudEmpresa.php?E=2";
			 </script>
		';	
	}

	else{

	$sql="SELECT tipo from Empresa where idEmpresa=".$_SESSION["idUsuario"].""; 
	$res=mysql_query($sql);	
	$data=mysql_fetch_assoc($res); 
	$tE=$data["tipo"];

	if($data["tipo"]=='e' && $_POST["pesoT"]=='1'){
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/empresa/solicitudEmpresa.php?E=3";
			 </script>
		';
	}
	else{

	$sql="select count(idSolicitud) as c from Solicitud";
	$res=mysql_query($sql,$bd);
	$data=mysql_fetch_assoc($res);
	$ng=$data["c"];
	$ng2=$ng;

	while(strlen($ng)<9){
		$ng="0".$ng;
	}

	$cod = hash("adler32", $ng2, false);
	
	$sql="insert into Solicitud (fecha, hora, nGuia, codigo, estado, idEmpresa)
	 values ('".date("Y-m-d")."','".date("H:i:s")."','".$ng."','".$cod."','1',".$_SESSION["idUsuario"].")";
	$res=mysql_query($sql,$bd);

	if(!$res){ 
		echo'
			 <script type="text/javascript">
  				window.location="../../vistas/empresa/solicitudEmpresa.php?E=0";
			 </script>
		';	
	}
	else{
		$sql="select idSolicitud from Solicitud order by idSolicitud desc limit 1"; 
		$res=mysql_query($sql);	
		$data=mysql_fetch_assoc($res);

		$idSolicitudG=$data["idSolicitud"];

		$sql="insert into Vehiculo (tipo, modelo, color, pChuto, pBatea, ano, idSolicitud)
	 	values ('".$_POST["tipo"]."', '".$_POST["modelo"]."','".$_POST["color"]."','".$_POST["placaCH"]."','".$_POST["placaBA"]."',".$_POST["ano"].",".$data["idSolicitud"].")";
		$res=mysql_query($sql,$bd);

		if(!$res){
			echo'
				 <script type="text/javascript">
	  				window.location="../../vistas/empresa/solicitudEmpresa.php?E=0";
				 </script>
			';
		}
		else{
			$sql="insert into Conductor (nombre, apellido, cedula, idSolicitud)
	 		values ('".$_POST["nombre"]."', '".$_POST["apellido"]."','".$_POST["cedula"]."', ".$data["idSolicitud"].")";
			$res=mysql_query($sql,$bd);

			if(!$res){
				echo'
					 <script type="text/javascript">
		  				window.location="../../vistas/empresa/solicitudEmpresa.php?E=0";
					 </script>
				';
			}
			else{
				$sql="insert into Material (tipo, peso, idSolicitud)
		 		values ('".$_POST["materiales"]."', ".$_POST["tonelada"].", ".$data["idSolicitud"].")";
				$res=mysql_query($sql,$bd);

				if(!$res){
					echo'
						 <script type="text/javascript">
			  				window.location="../../vistas/empresa/solicitudEmpresa.php?E=0";
						 </script>
					';
				}
				else{
					$sql="insert into Destinatario (rif, telefono, razon, direccion, finalidad, idSolicitud)
			 		values ('".$_POST["cedulaD"]."', '".$_POST["telefonoD"]."', '".$_POST["razonD"]."', '".$_POST["dirD"]."', '".$_POST["finalidad"]."', ".$data["idSolicitud"].")";
					$res=mysql_query($sql,$bd);

					if(!$res){
						echo'
							 <script type="text/javascript">
				  				window.location="../../vistas/empresa/solicitudEmpresa.php?E=0";
							 </script>
						';
					}
					else{
						if($tE=="o"){
						if($_FILES['imgB']['tmp_name']!=""){
							$rutaEnServidor='../../modeloControlador/imgBauches';
							$rutaTemporal=$_FILES['imgB']['tmp_name'];
							$ext=explode(".",$_FILES['imgB']['name']);
							$num=count($ext)-1;
							$nombre=$data["idSolicitud"].$_SESSION["idUsuario"].".".$ext[$num];
							$rutaDestino=$rutaEnServidor.'/'.$nombre;
							move_uploaded_file($rutaTemporal,$rutaDestino);
							// cargo imagen guardada
							$ruta_imagen = "../../modeloControlador/imgBauches/".$nombre;
							$miniatura_ancho_maximo = 600;
							$miniatura_alto_maximo = 600;
							$info_imagen = getimagesize($ruta_imagen);
							$imagen_ancho = $info_imagen[0];
							$imagen_alto = $info_imagen[1];
							$imagen_tipo = $info_imagen['mime'];
							$proporcion_imagen = $imagen_ancho / $imagen_alto;
							$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;
							if ( $proporcion_imagen > $proporcion_miniatura ){
							  $miniatura_ancho = $miniatura_ancho_maximo;
							  $miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
							} else if ( $proporcion_imagen < $proporcion_miniatura ){
							  $miniatura_ancho = $miniatura_alto_maximo * $proporcion_imagen;
							  $miniatura_alto = $miniatura_alto_maximo;
							} else {
							  $miniatura_ancho = $miniatura_ancho_maximo;
							  $miniatura_alto = $miniatura_alto_maximo;
							}
							//creo una imagen para redimencionar
							$lienzo = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );
							// tipo de la imagen
							switch ( $imagen_tipo ){
								case "image/jpg":
								case "image/jpeg":
								$imagen = imagecreatefromjpeg( $ruta_imagen );
								break;
								case "image/png":
								$imagen = imagecreatefrompng( $ruta_imagen );
								break;
								case "image/gif":
								$imagen = imagecreatefromgif( $ruta_imagen );
								break;
							}
							//guardo imagen redimencionada
							imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
							imagejpeg($lienzo, $rutaDestino, 90);
						}
						$sql="insert into Deposito (banco, monto, bauche, idEmpresa, idSolicitud, fecha, nDeposito)
				 		values ('".$_POST["banco"]."', '".$_POST["monto"]."', '".$nombre."', ".$_SESSION["idUsuario"].", ".$data["idSolicitud"].", '".$_POST["fecha"]."','".$_POST["nDeposito"]."')";
						$res=mysql_query($sql,$bd);
						}

						if(!$res){
							echo'
								 <script type="text/javascript">
					  				window.location="../../vistas/empresa/solicitudEmpresa.php?E=0";
								 </script>
							';
						}
						else{
							$sql="insert into historico_accion (codigoAccion, fecha, codigo, tabla, idEmpresa,nota)
						 	values (1, '".date("Y-m-d")."',".$idSolicitudG.",'SOLICITUD',".$_SESSION["idUsuario"].",'la empresa: ".$_SESSION["nombre"]." creo solicitud')";
							$res=mysql_query($sql,$bd);
							echo'
								 <script type="text/javascript">
					  				window.location="../../vistas/empresa/solicitudEmpresa.php?E=1";
								 </script>
							';
							//echo $sql;
						}
					}
				}
			}
		}
	}
	}//fin del else si se paso de peso
	}// fin del else materiales	

?>