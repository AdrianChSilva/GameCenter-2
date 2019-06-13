<?php
$datosUrl = explode("/", $_GET['vistas']);

//Devolvemos los datos del administrador
if ($datosUrl[0] == "actugenero") :

    /**
     * Como esta vista es para registrar Desarrolladoras, quedaría restringida su
     * visualización para usuarios normales. 
     */
    require_once "./controladores/controladorGenero.php";
    $generoClass = new controladorGenero();

    $filasGenero = $generoClass->dataGeneroController("Uno", $datosUrl[1]);
    if ($filasGenero->rowCount() == 1) {
        $camposForm = $filasGenero->fetch();
        if ($_SESSION['tipoGC'] != "Administrador" || $_SESSION['privilegioGC'] < 1 || $_SESSION['privilegioGC'] > 2) {
            echo $loginController->forzarCierreSesionController();
        }

        ?>
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="zmdi zmdi-labels zmdi-hc-fw"></i> Actualizar <small>GÉNERO</small></h1>
            </div>
            <p class="lead">Aquí podrás actualizar los datos del <b>género</b> seleccionado</p>
        </div>

        <div class="container-fluid">
            <ul class="breadcrumb breadcrumb-tabs">
                <li>
                    <a href="<?php echo SERVERURL ?>genero/" class="btn btn-info">
                        <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO GÉNERO
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL ?>generolists/" class="btn btn-success">
                        <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE GÉNEROS
                    </a>
                </li>
            </ul>
        </div>

        <!-- panel datos de la desarrolladora -->
        <div class="container-fluid">
            <div class="panel panel-infoActu">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DEL GÉNERO</h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo SERVERURL ?>ajax/generoAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <!--AJAX-->
                        <fieldset>
                            <fieldset>
                                <legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Información del género</legend>
                                <div class="container-fluid">
                                    <div class="row">


                                        <input pattern="[0-9]{1,7}" class="form-control" type="hidden" name="codigo-up" value="<?php echo $camposForm['generoCodigo'] ?>" required="" maxlength="7">

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre *</label>
                                                <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ -]{1,30}" class="form-control" type="text" name="nombre-up" required="" value="<?php echo $camposForm['generoNombre'] ?>" maxlength="30">
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

        <h3>No existen datos del genero</h3>
        <tr>
            <td colspan="5">
                <a href="<?php echo SERVERURL ?>generolists/" class="btn btn-group-sm btn-info btn-raised">
                    Volver a la lista de géneros
                </a>
            </td>
        </tr>
    <?php } else :

    ?>

    <h1>ERROR</h1>
    <h3>No se pueden mostrar los datos</h3>

<?php endif; ?>
</div>