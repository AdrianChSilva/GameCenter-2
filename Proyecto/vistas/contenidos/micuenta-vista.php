<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-settings zmdi-hc-fw"></i> MI CUENTA</small></h1>
    </div>
    <p class="lead">Aquí tienes los datos de tu cuenta. Si quieres actualizar algo deberás introducir tus credenciales</p>
</div>
<?php
$datosUrl = explode("/", $_GET['vistas']);

if (isset($datosUrl[1]) && ($datosUrl[1] == "admin" || $datosUrl[1] == "user")) :
    require_once "./controladores/controladorCuenta.php";
$instCuenta = new controladorCuenta();
//comprobamos que nadie pueda manipular la url para que accedan a una cuenta que no es suya
$filasCuenta = $instCuenta->dataAccountController($datosUrl[2],$datosUrl[1]);


if ($filasCuenta->rowCount() == 1) {
    $datosCampos = $filasCuenta->fetch();
    ?>

<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; MI CUENTA</h3>
        </div>
        <div class="panel-body">
            <form action="<?php echo SERVERURL ?>ajax/cuentaAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <?php 
                /** 
                 * comprueba que el codigo de la cuenta de la sesión sea igual que
                 * el codigo de la cuenta que quiere actualizar. Si fuera distinto
                 * comprobamos que se tengan los privilegios necesarios para actualizar cuenta. 
                 * */
                if ($_SESSION['cuentaCodigoGC'] != $datosCampos['cuentaCodigo']) {
                    if($_SESSION['tipoGC']!="Administrador" || $_SESSION['privilegioGC']<1 || $_SESSION['privilegioGC']>2){
                        echo $loginController->forzarCierreSesionController();

                    }else{
                        echo '<input type="hidden" name="privilegio-up" value="true">';
                    }
                } else {

                }
                ?>
                <input type="hidden" name="codigoCuenta-up" value="<?php echo $datosUrl[2] ?>">
                <input type="hidden" name="tipoCuenta-up" value="<?php echo $loginController->encryption($datosUrl[1]); ?>">
                <fieldset>
                    <legend><i class="zmdi zmdi-key"></i> &nbsp; Datos de la cuenta</legend>
                    <div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12 col-sm-6">
					    		<div class="form-group label-floating">
								  	<label class="control-label">Nombre de usuario</label>
								  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,15}" class="form-control" type="text" name="usuario-up" value="<?php echo $datosCampos['cuentaAlias']; ?>" required="" maxlength="15">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">E-mail</label>
								  	<input class="form-control" type="email" name="email-up" value="<?php echo $datosCampos['cuentaEmail']; ?>" maxlength="50">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<label class="control-label">Genero</label>
									<div class="radio radio-primary">
										<label><!--Marcamos el género con codigo PHP según el genero que tenga asociado la cuenta-->
											<input type="radio" name="optionsGenero-up" <?php if($datosCampos['cuentaGenero']=="Masculino"){ echo 'checked=""'; } ?> value="Masculino" >
											<i class="zmdi zmdi-male-alt"></i> &nbsp; Masculino
										</label>
									</div>
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsGenero-up" <?php if($datosCampos['cuentaGenero']=="Femenino"){ echo 'checked=""'; } ?>  value="Femenino" >
											<i class="zmdi zmdi-female"></i> &nbsp; Femenino
										</label>
									</div>
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsGenero-up" <?php if($datosCampos['cuentaGenero']=="Indefinido"){ echo 'checked=""'; } ?>  value="Indefinido" >
											<i class="zmdi zmdi-male-female"></i> &nbsp; Indefinido
										</label>
									</div>
								</div>
		    				</div>
							<!--Comprobamos que el administrador tiene los privilegios necesarios para poder ver estas opciones del formulario-->
							<?php if($_SESSION['tipoGC']=="Administrador" && $_SESSION['privilegioGC']==1 && $datosCampos['id']!=13): ?>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<label class="control-label">Estado de la cuenta</label>
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsEstado-up"  <?php if($datosCampos['cuentaEstado']=="Activo"){ echo 'checked=""'; }?> value="Activo" >
											<i class="zmdi zmdi-lock-open"></i> &nbsp; Activo
										</label>
									</div>
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsEstado-up" <?php if($datosCampos['cuentaEstado']=="Deshabilitado"){ echo 'checked=""'; }?> value="Deshabilitado"  >
											<i class="zmdi zmdi-lock"></i> &nbsp; Deshabilitado
										</label>
									</div>
								</div>
		    				</div>
							<?php endif; ?>
		    			</div>
		    		</div>
		    	</fieldset>
		    	<br>
		    	<fieldset>
		    		<legend><i class="zmdi zmdi-lock"></i> &nbsp; Actualizar Contraseña</legend>
		    		<p>
		    			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo minima cupiditate tempore nobis. Dolor, blanditiis, mollitia. Alias fuga fugiat molestias debitis odit, voluptatibus explicabo quia sequi doloremque numquam dignissimos quis.
		    		</p>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Nueva contraseña *</label>
								  	<input class="form-control" type="password" name="newPassword1-up" maxlength="50">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Repita la nueva contraseña *</label>
								  	<input class="form-control" type="password" name="newPassword2-up" maxlength="50">
								</div>
		    				</div>
		    			</div>
		    		</div>
		    	</fieldset>
		    	<br>
				<!--Comprobamos que el administrador tiene los privilegios necesarios para poder ver estas opciones del formulario-->
				<?php if($_SESSION['tipoGC']=="Administrador" && $_SESSION['privilegioGC']==1 && $datosCampos['id']!=13 && $datosCampos['cuentaTipo']=="Administrador" && ($datosUrl[1] == "admin")): ?><!--No permitiremos que el Admin Principal pueda cambiarse los privilegios -->
		    	<fieldset>
		    		<legend><i class="zmdi zmdi-star"></i> &nbsp; Nivel de privilegios</legend>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12 col-sm-6">
					    		<p class="text-left">
			                        <div class="label label-success">Nivel 1</div> Control total del sistema
			                    </p>
			                    <p class="text-left">
			                        <div class="label label-primary">Nivel 2</div> Permiso para registro y actualización
			                    </p>
			                    <p class="text-left">
			                        <div class="label label-info">Nivel 3</div> Permiso para registro
			                    </p>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="radio radio-primary">
									<label>
										<input type="radio" name="optionsPrivilegio-up"  value="<?php echo $loginController->encryption(1); ?>" <?php if($datosCampos['cuentaPrivg'] ==1){ echo 'checked=""';} ?> >
										<i class="zmdi zmdi-star"></i> &nbsp; Nivel 1
									</label>
								</div>
								<div class="radio radio-primary">
									<label>
										<input type="radio" name="optionsPrivilegio-up"  value="<?php echo $loginController->encryption(2); ?>" <?php if($datosCampos['cuentaPrivg'] ==2){ echo 'checked=""';} ?> >
										<i class="zmdi zmdi-star"></i> &nbsp; Nivel 2
									</label>
								</div>
								<div class="radio radio-primary">
									<label>
										<input type="radio" name="optionsPrivilegio-up"  value="<?php echo $loginController->encryption(3); ?>" <?php if($datosCampos['cuentaPrivg'] ==3){ echo 'checked=""';} ?> >
										<i class="zmdi zmdi-star"></i> &nbsp; Nivel 3
									</label>
								</div>
		    				</div>
		    			</div>
		    		</div>
		    	</fieldset>
				<br>
				<?php endif; ?>
				<fieldset>
		    		<legend><i class="zmdi zmdi-account-circle"></i> &nbsp; Datos de la cuenta</legend>
		    		<p>
						Para poder actualizar los datos de la cuenta por favor ingrese su nombre de usuario y contraseña.
		    		</p>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Nombre de usuario</label>
								  	<input class="form-control" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,15}" type="text" name="user-Log" maxlength="15"  >
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Contraseña</label>
								  	<input class="form-control" type="password" name="pass-Log" maxlength="50" >
								</div>
		    				</div>
		    			</div>
		    		</div>
		    	</fieldset>
			    <p class="text-center" style="margin-top: 20px;">
			    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Actualizar</button>
			    </p>
				<div class="RespuestaAjax"></div>
		    </form>
		</div>
	</div>
</div>

 <?php 
} else { ?>

<h1>La cuenta no existe</h1>
<?php

} else :
?>
<h1>Error en la ruta</h1>
<?php endif; ?>
