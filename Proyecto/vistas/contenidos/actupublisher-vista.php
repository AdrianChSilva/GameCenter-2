<?php
$datosUrl = explode("/", $_GET['vistas']);

//Devolvemos los datos del administrador
if ($datosUrl[0] == "actupublisher") :

    /**
     * Como esta vista es para registrar publishers, quedaría restringida su
     * visualización para usuarios normales. 
     */
    require_once "./controladores/controladorPublisher.php";
    $publisherClass = new controladorPublisher();

    $filasPublisher = $publisherClass->dataPublisherController("Uno", $datosUrl[1]);
    if ($filasPublisher->rowCount() == 1) {
        $camposForm = $filasPublisher->fetch();
        if ($_SESSION['tipoGC'] != "Administrador" || $_SESSION['privilegioGC'] < 1 || $_SESSION['privilegioGC'] > 2) {
            echo $loginController->forzarCierreSesionController();
        }

        ?>
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Actualizar <small>PUBLISHER</small></h1>
            </div>
            <p class="lead">Aquí podrás actualizar los datos del <b>publisher</b></p>
        </div>

        <div class="container-fluid">
            <ul class="breadcrumb breadcrumb-tabs">
                <li>
                    <a href="<?php echo SERVERURL ?>publisher/" class="btn btn-info">
                        <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO PUBLISHER
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL ?>publisherlists/" class="btn btn-success">
                        <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PUBLISHERS
                    </a>
                </li>
            </ul>
        </div>

        <!-- panel datos de la publisher -->
        <div class="container-fluid">
            <div class="panel panel-infoActu">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DEL PUBLISHER: <b><?php echo $camposForm['publisherNombre'] ?></b></h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo SERVERURL ?>ajax/publisherAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <!--AJAX-->
                        <fieldset>
                            <legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Información del publisher</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="hidden" name="codigo-up" value="<?php echo $camposForm['publisherCodigo'] ?>" required="" maxlength="30">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre del publisher *</label>
                                            <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-up" value="<?php echo $camposForm['publisherNombre'] ?>" required="" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Encargado*</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="encargado-up" value="<?php echo $camposForm['publisherEncargado'] ?>" required="" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Teléfono</label>
                                            <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-up" value="<?php echo $camposForm['publisherTlfn'] ?>" maxlength="15">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">E-mail</label>
                                            <input class="form-control" type="email" name="email-up" value="<?php echo $camposForm['publisherEmail'] ?>" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Dirección</label>
                                            <textarea name="direccion-up" class="form-control" rows="2" value="" maxlength="100"><?php echo $camposForm['publisherDir'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
                        </p>
                        <div class="RespuestaAjax"></div>
                    </form>
                </div>
            </div>
        </div>
    <?php
} else {



    ?>

        <h3>No existen datos de la publisher</h3>
        <tr>
            <td colspan="5">
                <a href="<?php echo SERVERURL ?>publisherlists/" class="btn btn-group-sm btn-info btn-raised">
                    Volver al catálogo
                </a>
            </td>
        </tr>
    <?php } else :

    ?>

    <h1>ERROR</h1>
    <h3>No se pueden mostrar los datos</h3>

<?php endif; ?>
</div>