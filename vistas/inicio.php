<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Bootstrap 3, from LayoutIt!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="../js/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../js/dist/css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../js/dist/img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../js/dist/img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../js/dist/img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="../js/dist/img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="../js/dist/img/favicon.png">
  
	<script type="text/javascript" src="../js/dist/js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/dist/js/scripts.js"></script>
</head>

<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column"> <!-- col-md-10 col-md-offset-2-->
			<!-- <div class="container"> -->
				<!--<img alt="140x140" src="../ima/baner.jpg" class="img-responsive">--> <!--http://lorempixel.com/1140/140/-->
			<!-- </div> -->
			<div class="panel panel-default">
				<?PHP
					require ('../vistas/usuario/usuario.php');
				?>				
			</div>
			<div class="row clearfix">
				<div class="col-md-3 column">
					<div class="panel-group" id="panelAnalista">
						<?PHP
							require ('../menu/menuAnalista.php');
						?>
					</div>
					<!--<div class="list-group">
						 <a href="#" class="list-group-item active">Home</a>
						<div class="list-group-item">
							List header
						</div>
						<div class="list-group-item">
							<h4 class="list-group-item-heading">
								List group item heading
							</h4>
							<p class="list-group-item-text">
								...
							</p>
						</div>
						<div class="list-group-item">
							<span class="badge">14</span>Help
						</div> <a class="list-group-item active"><span class="badge">14</span>Help</a>
					</div>-->
				</div>
				<div class="col-md-9 column">
					<div class="page-header">
						<h1>
							Example page header <small>Subtext for header</small>
						</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
