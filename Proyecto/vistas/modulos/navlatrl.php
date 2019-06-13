<section class="full-box cover dashboard-sideBar">
		<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
		<div class="full-box dashboard-sideBar-ct">
			<!--SideBar Title -->
			<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
				<?php echo EMPRESA ?> <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
			</div>
			<!-- SideBar User info -->
			<div class="full-box dashboard-sideBar-UserInfo">
				<figure class="full-box">
					<img src="<?php echo $_SESSION['fotoGC']; ?>" alt="UserIcon">
					<figcaption class="text-center text-titles"><?php echo $_SESSION['usuarioGC'] // $_SESSION['nombreGC']   ?></figcaption>
				</figure>

				<?php
			if ($_SESSION['tipoGC'] == "Administrador") {
				$tipoUsuario = "admin";
			} else {
				$tipoUsuario = "user";
			}
			?>
				
				<ul class="full-box list-unstyled text-center">
					<li>
						<a href="<?php echo SERVERURL ?>misdatos/<?php echo $tipoUsuario; ?>/<?php echo $loginController->encryption($_SESSION['cuentaCodigoGC']) ?>" title="Mis datos">
							<i class="zmdi zmdi-account-circle"></i>
						</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL ?>micuenta/<?php echo $tipoUsuario; ?>/<?php echo $loginController->encryption($_SESSION['cuentaCodigoGC']) ?>" title="Mi cuenta">
							<i class="zmdi zmdi-settings"></i>
						</a>
					</li>
					<li>
						<a href="<?php echo $loginController->encryption($_SESSION['tokenGC']) ?>" title="Salir del sistema" class="btn-exit-system">
							<i class="zmdi zmdi-power"></i>
						</a>
					</li>
				</ul>
			</div>
			<!-- SideBar Menu -->
			<!-- Quitamos opciones del nav según el tipo de usuario que sea -->
			<ul class="list-unstyled full-box dashboard-sideBar-Menu">
			<?php if ($_SESSION['tipoGC'] == "Administrador") : ?>
				<li>
					<a href="<?php echo SERVERURL ?>home/">
						<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Home
					</a>
				</li>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-case zmdi-hc-fw"></i> Administración <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL ?>desarrolladora/"><i class="zmdi zmdi-steam"></i> Desarrolladora</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL ?>genero/"><i class="zmdi zmdi-labels zmdi-hc-fw"></i> Géneros</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL ?>publisher/"><i class="zmdi zmdi-playstation"></i> Publishers</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL ?>videojuego/"><i class="zmdi zmdi-file"></i> Nuevo Videojuego</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Usuarios <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL ?>admin/"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Administradores</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL ?>user/"><i class="zmdi zmdi-male-female zmdi-hc-fw"></i> Clientes</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>
				<li>
					<a href="<?php echo SERVERURL ?>catalogo/">
						<i class="zmdi zmdi-gamepad zmdi-hc-fw"></i> Catálogo
					</a>
				</li>
			</ul>
		</div>
	</section>