<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-wrench zmdi-hc-fw"></i> GESTIÓN DE VIDEOJUEGO</small></h1>
    </div>
    <p class="lead">Aquí podras actualizar los datos del videojuego seleccionado</p>
</div>

<?php
$datosUrl = explode("/", $_GET['vistas']);

//Devolvemos los datos del administrador
if ($datosUrl[0] == "videojuegoconfig") :

    /**
     * Como esta vista es para administradores, quedaría restringida su
     * visualización para usuarios normales. 
     */
    require_once "./controladores/controladorVideojuego.php";
    $videojuegoClass = new controladorVideojuego();

    $filasVideojuego = $videojuegoClass->dataVideojuegoController("Uno", $datosUrl[1]);
    if ($filasVideojuego->rowCount() == 1) {
        $camposForm = $filasVideojuego->fetch();
        if ($_SESSION['tipoGC'] != "Administrador" || $_SESSION['privilegioGC'] < 1 || $_SESSION['privilegioGC'] > 2) {
            echo $loginController->forzarCierreSesionController();
        }


        ?>
        <!-- Panel actualizar VIDEOJUEGO -->
        <div class="container-fluid">
            <div class="panel panel-infoActu">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR VIDEOJUEGO: <b><?php echo $camposForm['vidTitulo'] ?></b></h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo SERVERURL ?>ajax/videojuegoAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <fieldset>
                            <legend><i class="zmdi zmdi-library"></i> &nbsp; Información básica</legend>
                            <div class="container-fluid">
                                <div class="row">

                                    <input class="form-control" type="hidden" name="codigo-up" value="<?php echo $camposForm['vidCodigo'] ?>" required="" maxlength="30">

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Título *</label>
                                            <input class="form-control" type="text" name="titulo-up" value="<?php echo $camposForm['vidTitulo'] ?>" required="" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">País</label>
                                            <input class="form-control" type="text" name="pais-up" value="<?php echo $camposForm['vidPais'] ?>" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Año</label>
                                            <input pattern="[0-9]{1,4}" class="form-control" type="text" name="year-up" value="<?php echo $camposForm['vidAnno'] ?>" maxlength="4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <?php  ?>
                            <legend><i class="zmdi zmdi-labels"></i> &nbsp; Géneros, Publisher y Desarrolladora</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Género</label>
                                            <select name="genero-up" class="form-control">
                                                <?php echo $videojuegoClass->nombreGenVidController($camposForm['generoCodigo'], true) ?>
                                                <?php echo $videojuegoClass->dataGenVidController(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Publisher</label>
                                            <select name="publisher-up" class="form-control">
                                                <?php echo $videojuegoClass->nombrePublisherVidController($camposForm['publisherCodigo'], true) ?>
                                                <?php echo $videojuegoClass->dataPubVidController(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Desarrolladora</label>
                                            <select name="desarrolladora-up" class="form-control">
                                                <?php echo $videojuegoClass->nombreDesVidController($camposForm['desarrCodigo'], true) ?>
                                                <?php echo $videojuegoClass->dataDesVidController(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend><i class="zmdi zmdi-money-box"></i> &nbsp; Precio, Plataforma</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Precio</label>
                                            <input pattern="[0-9.]{1,7}" class="form-control" type="text" name="precio-up" value="<?php echo $camposForm['vidPrecio'] ?>" maxlength="7">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Plataforma</label>
                                            <input pattern="[0-9-a-zA-ZáéíóúÁÉÍÓÚñÑ]{1,40}" class="form-control" type="text" name="stock-up" value="<?php echo $camposForm['vidPlataforma'] ?>" maxlength="40">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Analisis o resumen del VIDEOJUEGO</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Analisis/Resumen</label>
                                            <textarea name="analisis-up" class="form-control" rows="8"><?php echo $camposForm['vidAnalisis'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend><i class="zmdi zmdi-code"></i> &nbsp; Insertar vídeo</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Copia y pega el <\iframe> del video de youtube que quieras insertar</label>
                                            <textarea name="video-up" class="form-control" rows="2"><?php echo $camposForm['vidVideo'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend><i class="zmdi zmdi-attachment-alt"></i> &nbsp; Imágen y archivo PDF</legend>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <span class="control-label">Imágen</span>
                                    <input type="file" name="imagen-up" accept=".jpg, .png, .jpeg" value="<?php echo $camposForm['vidImagen'] ?>">
                                    <div class="input-group">
                                        <input type="text" readonly="" class="form-control" placeholder="<?php echo $camposForm['vidImagen'] ?>">
                                        <span class="input-group-btn input-group-sm">
                                            <button type="button" class="btn btn-fab btn-fab-mini">
                                                <i class="zmdi zmdi-attachment-alt"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <span><small>Tipos de archivos permitidos imágenes: PNG, JPEG y JPG</small></span>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <span class="control-label">PDF</span><!-- No se que es mejor, si dejar que se muestre el nombre o no -->
                                    <input type="file" name="pdf-up" accept=".pdf" value="<?php echo $camposForm['vidGuiaPDF'] ?>">
                                    <div class="input-group">
                                        <input type="text" readonly="" class="form-control" placeholder="<?php echo $camposForm['vidGuiaPDF'] ?>">
                                        <span class="input-group-btn input-group-sm">
                                            <button type="button" class="btn btn-fab btn-fab-mini">
                                                <i class="zmdi zmdi-attachment-alt"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <span><small>Tipos de archivos permitidos: documentos PDF</small></span>
                                </div>
                            </div>
                        </fieldset>
                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i>Guardar</button>
                        </p>
                        <div class="RespuestaAjax"></div>
                    </form>
                </div>
            </div>

            <!-- Panel eliminar VIDEOJUEGO -->
            <?php if ($_SESSION['tipoGC'] == "Administrador" && $_SESSION['privilegioGC'] == 1) { ?>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="zmdi zmdi-delete"></i> &nbsp; ELIMINAR VIDEOJUEGO</h3>
                                </div>
                                <div class="panel-body">
                                    <p class="lead">
                                        CUIDADO. Si pulsas el botón eliminarás el videojuego de la base de datos, así como su código identificador
                                    </p>
                                    <form action="<?php echo SERVERURL ?>ajax/videojuegoAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
                                        <input type="hidden" name="codDelete" value="<?php echo $camposForm['vidCodigo'] ?>">
                                        <p class="text-center">
                                            <button class="btn btn-raised btn-danger">
                                                <i class="zmdi zmdi-delete"></i> &nbsp; ELIMINAR DEL SISTEMA
                                            </button>
                                        </p>
                                        <div class="RespuestaAjax"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php
    } else {
        ?>

            <h3>No existen datos del videojuego</h3>
            <tr>
                <td colspan="5">
                    <a href="<?php echo SERVERURL ?>catalogo/" class="btn btn-group-sm btn-info btn-raised">
                        Volver al catálogo
                    </a>
                </td>
            </tr>
        <?php

    } else :

    ?>

        <h1>ERROR</h1>
        <h3>No se pueden mostrar los datos</h3>

    <?php endif; ?>
</div>