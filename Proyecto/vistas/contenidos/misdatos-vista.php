<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account-circle zmdi-hc-fw"></i> MIS DATOS</small></h1>
    </div>
    <p class="lead">Aquí podrás actualizar tus datos personales</p></div>

<!-- Panel mis datos -->
<div class="container-fluid">
    <?php
    $datosUrl = explode("/", $_GET['vistas']);

    //Devolvemos los datos del administrador
    if ($datosUrl[1] == "admin") :

        /**
         * Como esta vista es para administradores, quedaría restringida su
         * visualización para usuarios normales. 
         */
        if ($_SESSION['tipoGC'] != "Administrador") {
            echo $loginController->forzarCierreSesionController();
        }
        require_once "./controladores/controladorAdmin.php";
        require_once "./controladores/controladorUser.php";
        $adminClass = new controladorAdmin();
        $userClass = new controladorUser();

        $filasAdmin = $adminClass->dataAdminController("Uno", $datosUrl[2]);
        $filasUser = $userClass->dataUserController("Uno", $datosUrl[2]);
        //
        if ($filasAdmin->rowCount() == 1) {
            $camposForm = $filasAdmin->fetch();
            //comprobamos que el codigo de cuenta coincida con el codigo de la sesión y también que tenga los privilegios necesarios para actualizar
            //si no son los mismos códigos, quiere decir que se está actualizando a un usuario diferente, y por ello necesitará los privilegios necesarios
            if ($camposForm['cuentaCodigo'] != $_SESSION['cuentaCodigoGC']) {
                if ($_SESSION['privilegioGC'] > 2 || $_SESSION['privilegioGC'] < 1) {
                    echo $loginController->forzarCierreSesionController();
                }
            }
            ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; MIS DATOS</h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo SERVERURL ?>ajax/adminAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="cuenta-up" value="<?php echo $datosUrl[2] ?>">
                        <fieldset>
                            <legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">DNI/NIE *</label>
                                            <input pattern="[0-9-]{1,30}" class="form-control" type="text" name="dni-up" value="<?php echo $camposForm['adminDNI'] ?>" required="" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre *</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-up" value="<?php echo $camposForm['adminNombre'] ?>" required="" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Apellidos *</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-up" required="" value="<?php echo $camposForm['adminApellido'] ?>" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Teléfono</label>
                                            <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-up" value="<?php echo $camposForm['adminTlfn'] ?>" maxlength="15">
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Dirección</label>
                                            <textarea name="direccion-up" class="form-control" rows="2" maxlength="100"><?php echo $camposForm['adminDir'] ?></textarea>
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
        <?php
    } else { ?>
            <h1>ERROR</h1>
            <h3>No existen datos del administrador</h3>
        <?php

    }

//Devolvemos los datos del usuario
elseif ($datosUrl[1] == "user") :
    if ($_SESSION['tipoGC'] != "Administrador") {
        if ($_SESSION['tipoGC'] != "Cliente") {
            echo $loginController->forzarCierreSesionController();
        }
    }

    require_once "./controladores/controladorUser.php";

    $userClass = new controladorUser();

    $filasUser = $userClass->dataUserController("Uno", $datosUrl[2]);

    if (
        $filasUser->rowCount() == 1
    ) {
        $camposForm = $filasUser->fetch();
        //comprobamos que el codigo coincida con el codigo de la sesión y también que tenga los privilegios necesarios para actualizar
        if ($camposForm['cuentaCodigo'] != $_SESSION['cuentaCodigoGC']) {
            if ($_SESSION['privilegioGC'] > 2 || $_SESSION['privilegioGC'] < 1) {
                echo $loginController->forzarCierreSesionController();
            }
        }
        ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; MIS DATOS</h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo SERVERURL ?>ajax/userAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="cuenta-up" value="<?php echo $datosUrl[2] ?>">
                        <fieldset>
                            <legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">DNI/NIE *</label>
                                            <input pattern="[0-9-a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="dni-up" value="<?php echo $camposForm['userDNI'] ?>" required="" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre *</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-up" value="<?php echo $camposForm['userNombre'] ?>" required="" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Apellidos *</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-up" required="" value="<?php echo $camposForm['userApellido'] ?>" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Teléfono</label>
                                            <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-up" value="<?php echo $camposForm['userTlfn'] ?>" maxlength="15">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Plataforma Preferida</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="ocupacion-up" value="<?php echo $camposForm['userOcup'] ?>" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Dirección</label>
                                            <textarea name="direccion-up" class="form-control" rows="2" maxlength="100"><?php echo $camposForm['userDir'] ?></textarea>
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
        <?php
                                                                                                                                } else { ?>
            <h1>ERROR</h1>
            <h3>No se encontraron datos del cliente</h3>
        <?php

            } else :

            ?>
        <h1>ERROR</h1>
        <h3>No se pueden mostrar los datos</h3>

    <?php endif; ?>

</div>