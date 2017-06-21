<?PHP
session_start();
	function isConnect($pos){
		if($_SESSION["idUsuario"]==""){
			echo'
			 <script type="text/javascript">
  				window.location="'.$pos.'index.php?E=2";
			 </script>
			';
			return "FALLO";	
		}
	  	return "OK";
	}

	function permisos($pg){
		if($pg==$_SESSION["tipo"]){
			return 1;	
		}
	  	return 0;
	}

	function salir($pos){
		echo'
		 <script type="text/javascript">
				window.location="'.$pos.'index.php?E=3";
		 </script>
		';
	}

?>