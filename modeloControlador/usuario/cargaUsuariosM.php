<?PHP
	
	session_start(); 

	include("../../php/conex.php");
	include("../../php/funciones.php");

	isConnect("../../");
	if(!permisos("ad")){
		salir("../../");
	}
	
	$bd=Conectarse();

	$t=$_GET["t"];

	$pag=$_GET["p"];

	$ban = 0;
	$retorno="<legend>Lista de usuarios</legend>"; //$retorno=$retorno.$t;

	if($t=='I'){
		$sql="SELECT count(idUsuario) as c from Usuario where nombre LIKE '%".$_POST["nombre"]."%' OR apellido LIKE '%".$_POST["nombre"]."%'";
		$res=mysql_query($sql,$bd);
		$data=mysql_fetch_assoc($res);
		
		$div=5;//5

		$cantidad=$data["c"];
		$n=ceil($cantidad/$div);

		$fin=($pag*$div);	
		$ini=($fin-$div);

		$sql="SELECT idUsuario, nombre, apellido from Usuario where nombre LIKE '%".$_POST["nombre"]."%' OR apellido LIKE '%".$_POST["nombre"]."%' limit ".$ini." , ".$fin."";
		$res=mysql_query($sql); //echo $sql;
		while($data=mysql_fetch_assoc($res)){	
			$sql="SELECT usuario from Login where idUsuario=".$data["idUsuario"].""; 
			$res2=mysql_query($sql);	
			$data2=mysql_fetch_assoc($res2);
			if($data2){		
				$ban += 1;				  
				$retorno=$retorno.'
					<div class="col-md-8">
						<div class="panel panel-primary">
						  <div class="panel-heading">
						    <h3 class="panel-title"><span class="badge">'.$ban.'</span> '.$data["nombre"].' '.$data["apellido"].'</h3>
						  </div>
						  <div class="panel-body">
						    <p><strong>Usuario:</strong> '.$data2["usuario"].'</p>						    
						    <p><a href="../../vistas/usuario/modUsuarioI.php?u='.sha1($data["idUsuario"]).'" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modificar</a></p>
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
				$l1='<li><a href="../../vistas/usuario/modificarUsuario.php?p='.($pag-1).'&t='.$t.'&n='.$_POST["nombre"].'">&laquo;</a></li>';
			}
			for($i=0;$i<$n;$i++){ 	
				if($pag==($i+1)){					  	
					$l2=$l2.'<li class="active"><a href="../../vistas/usuario/modificarUsuario.php?p='.($i+1).'&t='.$t.'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
		  		} else{
		  			$l2=$l2.'<li><a href="../../vistas/usuario/modificarUsuario.php?p='.($i+1).'&t='.$t.'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
				}
		  	}
		  	if($pag==$n){ 
				$l3=$l3.'<li class="disabled"><a href="#">&raquo;</a></li>';
			} else{
				$l3=$l3.'<li><a href="../../vistas/usuario/modificarUsuario.php?p='.($pag+1).'&t='.$t.'&n='.$_POST["nombre"].'">&raquo;</a></li>';
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
	
	if($t=='E'){
		$sql="SELECT count(idEmpresa) as c from Empresa where razon LIKE '%".$_POST["nombre"]."%'";
		$res=mysql_query($sql,$bd);
		$data=mysql_fetch_assoc($res);
		
		$div=5;//5

		$cantidad=$data["c"];
		$n=ceil($cantidad/$div);

		$fin=($pag*$div);	
		$ini=($fin-$div);

		$sql2="SELECT idEmpresa, razon from Empresa where razon LIKE '%".$_POST["nombre"]."%' limit ".$ini." , ".$fin.""; 	
		$res3=mysql_query($sql2);

		while($data3=mysql_fetch_assoc($res3)){	
		$sql="SELECT usuario from Login where idEmpresa=".$data3["idEmpresa"].""; 
		$res2=mysql_query($sql);	
		$data2=mysql_fetch_assoc($res2);
		if($data2){		
			$ban += 1;				  
			$retorno=$retorno.'
				<div class="col-md-8">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title"><span class="badge">'.$ban.'</span> '.$data3["razon"].'</h3>
					  </div>
					  <div class="panel-body">
					    <p><strong>Usuario:</strong> '.$data2["usuario"].'</p>						    
					    <p><a href="../../vistas/empresa/modUsuarioE.php?u='.sha1($data3["idEmpresa"]).'" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modificar</a></p>
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
				$l1='<li><a href="../../vistas/usuario/modificarUsuario.php?p='.($pag-1).'&t='.$t.'&n='.$_POST["nombre"].'">&laquo;</a></li>';
			}
			for($i=0;$i<$n;$i++){ 	
				if($pag==($i+1)){					  	
					$l2=$l2.'<li class="active"><a href="../../vistas/usuario/modificarUsuario.php?p='.($i+1).'&t='.$t.'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
		  		} else{
		  			$l2=$l2.'<li><a href="../../vistas/usuario/modificarUsuario.php?p='.($i+1).'&t='.$t.'&n='.$_POST["nombre"].'">'.($i+1).'<span class="sr-only">(current)</span></a></li>';
				}
		  	}
		  	if($pag==$n){ 
				$l3=$l3.'<li class="disabled"><a href="#">&raquo;</a></li>';
			} else{
				$l3=$l3.'<li><a href="../../vistas/usuario/modificarUsuario.php?p='.($pag+1).'&t='.$t.'&n='.$_POST["nombre"].'">&raquo;</a></li>';
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
	
	if($ban == 0){echo "-1";}
	else{echo $retorno;}
?>