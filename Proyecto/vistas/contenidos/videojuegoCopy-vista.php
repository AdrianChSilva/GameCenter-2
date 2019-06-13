<?php

/**
 * Como esta vista es para administradores, quedaría restringida su
 * visualización para usuarios normales. 
 */
if ($_SESSION['tipoGC'] != "Administrador") {
    echo $loginController->forzarCierreSesionController();
}
?>
<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Administración <small>NUEVO VIDEOJUEGO</small></h1>
    </div>
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>

<!-- Panel nuevo videojuego -->
<div class="container-fluid">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVO VIDEOJUEGO</h3>
        </div>
        <div class="panel-body">
        <form action="<?php echo SERVERURL ?>ajax/videojuegoAjax.php" method="POST" data-form="insert" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"><!--AJAX-->
                <fieldset>
                    <legend><i class="zmdi zmdi-library"></i> &nbsp; Información básica</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Código de VIDEOJUEGO *</label>
                                    <input pattern="[a-zA-Z0-9-]{1,30}" class="form-control" type="text" name="codigo-reg" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Título *</label>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="titulo-reg" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">País</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="pais-reg" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Año</label>
                                    <input pattern="[0-9]{1,4}" class="form-control" type="text" name="year-reg" maxlength="4">
                                </div>
                            </div>

                        </div>
                    </div>
                </fieldset>
                <br>
                <?php 
                    require_once "./controladores/controladorVideojuego.php";
                    $videojuego = new controladorVideojuego();
                ?>
                <fieldset>
                    <legend><i class="zmdi zmdi-labels"></i> &nbsp; Desarrolladora, Género y Publisher</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Género</label>
                                    <select name="genero-reg" class="form-control">
                                    <option>Seleccione el género</option>
                                        <?php echo $videojuego->dataGenVidController(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Desarrolladora</label>
                                    <select name="desarrolladora-reg" class="form-control">
                                    <option>Seleccione la desarrolladora</option>
                                         <?php echo $videojuego->dataDesVidController(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Publisher</label>
                                    <select name="publisher-reg" class="form-control">
                                    <option>Seleccione el publisher</option>
                                         <?php echo $videojuego->dataPubVidController(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>
                <fieldset>
                    <legend><i class="zmdi zmdi-money-box"></i> &nbsp; Precio, Stock</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Precio</label>
                                    <input pattern="[0-9.]{1,7}" class="form-control" type="text" name="precio-reg" maxlength="7">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Stock</label>
                                    <input pattern="[0-9]{1,9}" class="form-control" type="text" name="stock-reg" maxlength="9">
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>
                <fieldset>
                    <legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Análisis o resumen del VIDEOJUEGO</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Esribe aquí el análisis o resumen del videojuego</label>
                                    <textarea name="analisis-reg" class="form-control" rows="3"></textarea>
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
                            <input type="file" name="imagen-reg" accept=".jpg, .png, .jpeg">
                            <div class="input-group">
                                <input type="text" readonly="" class="form-control" placeholder="Elija la imágen...">
                                <span class="input-group-btn input-group-sm">
                                    <button type="button" class="btn btn-fab btn-fab-mini">
                                        <i class="zmdi zmdi-attachment-alt"></i>
                                    </button>
                                </span>
                            </div>
                            <span><small>Tamaño máximo de los archivos adjuntos 5MB. Tipos de archivos permitidos imágenes: PNG, JPEG y JPG</small></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <span class="control-label">PDF</span>
                            <input type="file" name="pdf-reg" accept=".pdf">
                            <div class="input-group">
                                <input type="text" readonly="" class="form-control" placeholder="Elija el PDF...">
                                <span class="input-group-btn input-group-sm">
                                    <button type="button" class="btn btn-fab btn-fab-mini">
                                        <i class="zmdi zmdi-attachment-alt"></i>
                                    </button>
                                </span>
                            </div>
                            <span><small>Tamaño máximo de los archivos adjuntos 5MB. Tipos de archivos permitidos: documentos PDF</small></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="control-label">¿El archivo PDF será descargable para los clientes?</label>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" name="optionsPDF" id="optionsRadios1" value="Si" checked="">
                                    <i class="zmdi zmdi-cloud-download"></i> &nbsp; Si, PDF descargable
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" name="optionsPDF" id="optionsRadios2" value="No">
                                    <i class="zmdi zmdi-cloud-off"></i> &nbsp; No, PDF no descargable
                                </label>
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