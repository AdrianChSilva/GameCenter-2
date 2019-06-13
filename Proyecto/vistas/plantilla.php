<!DOCTYPE html>
<html lang="es">

<head>
	<title><?php echo EMPRESA ?> </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>vistas/css/main.css">
	<?php include "vistas/modulos/script.php"; ?>
</head>

<body>
	<?php

	$peticionAjax = false;
	require_once "./controladores/controladorVistas.php";

	$vts = new controladorVistas();
	$vistasD = $vts->obtenerVistasController();
	session_start(['name' => 'GC']);
	if ($vistasD == "login" || $vistasD == "404" || $vistasD == "./vistas/contenidos/registro-vista.php") :
		if ($vistasD == "404") {
			require_once "./vistas/contenidos/404-vista.php";
		}
		if ($vistasD == "./vistas/contenidos/registro-vista.php") {
			require_once "./vistas/contenidos/registro-vista.php";
		} else {
			require_once "./vistas/contenidos/login-vista.php";
		} else :
		
		require_once "./controladores/controladorLogin.php";
		$loginController = new controladorLogin();
		//tal y como está construido el condicional, no tiene sentido, pero es como hace que funcione el login
		
		if (!isset($_SESSION['usuarioGC']) || !isset($_SESSION['tokenGC'])) {
			echo $loginController->forzarCierreSesionController();
		}


		?>
		<!-- SideBar -->
		<?php include "vistas/modulos/navlatrl.php"; ?>

		<!-- Content page-->
		<section class="full-box dashboard-contentPage">
			<!-- NavBar -->
			<?php include "vistas/modulos/navbar.php"; ?>

			<!-- Content page -->
			<?php require_once $vistasD; ?>
		</section>
		<?php
		include "vistas/modulos/logoutScript.php";
	endif;
	?>

	<!--====== Scripts -->
	<script>
		$.material.init();
	</script>
</body>

</html>