<?php
	session_start();
?>
<div class="panel-body">
	<div class="pull-left"> <strong>Usuario:</strong> <?php echo $_SESSION["nombre"]; ?> </div>
	<div class="pull-right"> <?php echo date("d/m/Y") ?> </div>
</div>