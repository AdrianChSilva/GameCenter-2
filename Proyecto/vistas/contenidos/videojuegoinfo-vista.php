<?php

/**
 * Como esta vista es para administradores, quedaría restringida su
 * visualización para usuarios normales. 
 */

$datosUrl = explode("/", $_GET['vistas']);
if ($datosUrl[0] == "videojuegoinfo") :

    if ($_SESSION['tipoGC'] != "Administrador" && $_SESSION['tipoGC'] != "Cliente") {
        echo $loginController->forzarCierreSesionController();
    }

    require_once "./controladores/controladorVideojuego.php";
    $videojuegoClass = new controladorVideojuego();


    $filasVideojuego = $videojuegoClass->dataVideojuegoController("Uno", $datosUrl[1]);
    if ($filasVideojuego->rowCount() == 1) {
        $camposForm = $filasVideojuego->fetch();
        ?>
        <!-- Content page -->
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> INFORMACIÓN VIDEOJUEGO</small></h1>
            </div>
        </div>

        <!-- Panel info VIDEOJUEGO -->
        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-info"></i> &nbsp; <?php echo $camposForm['vidTitulo'] ?></h3>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <legend><i class="zmdi zmdi-library"></i> &nbsp; Información básica</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group label-floating">
                                        <span>Título</span>
                                        <input class="form-control" readonly="" value="<?php echo $camposForm['vidTitulo'] ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <img src="<?php echo $camposForm['vidImagen'] ?>" alt="videojuego" class="img-responsive">
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group label-floating">
                                                    <span>Género</span>
                                                    <input class="form-control" readonly="" value="<?php echo $videojuegoClass->nombreGenVidController($camposForm['generoCodigo'], false) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group label-floating">
                                                    <span>País</span>
                                                    <input class="form-control" readonly="" value="<?php echo $camposForm['vidPais'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group label-floating">
                                                    <span>Año</span>
                                                    <input class="form-control" readonly="" value="<?php echo $camposForm['vidAnno'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group label-floating">
                                                    <span>Desarrolladora</span>
                                                    <input class="form-control" readonly="" value="<?php echo $videojuegoClass->nombreDesVidController($camposForm['desarrCodigo'], false) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group label-floating">
                                                    <span>Publisher</span>
                                                    <input class="form-control" readonly="" value="<?php echo $videojuegoClass->nombrePublisherVidController($camposForm['publisherCodigo'], false) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group label-floating">
                                                    <span>Plataforma</span>
                                                    <input class="form-control" readonly="" value="<?php echo $camposForm['vidPlataforma'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group label-floating">
                                                    <span>Precio</span>
                                                    <input class="form-control" readonly="" value="<?php echo $camposForm['vidPrecio'] ?> €">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Análisis de <?php echo $camposForm['vidTitulo'] ?></legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group label-floating">

                                        <textarea readonly="" class="form-control" rows="8"><?php echo $camposForm['vidAnalisis'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <br>

                    <legend> &nbsp; Ver y descargar guía PDF</legend>
                    <?php if ($camposForm['vidGuiaPDF'] == "" || $camposForm['vidGuiaPDF'] == "../archivos/") {
                        echo "<p>No existe guía actualmente</p>";
                    } else { ?>
                        <fieldset style="height:900px">
                            <iframe src=<?php echo $camposForm['vidGuiaPDF'] ?> width="100%" style="height:100%"></iframe>
                        <?php } ?>
                    </fieldset>

                    <fieldset>
                        <legend><i class="zmdi zmdi-youtube-play"></i> &nbsp; Trailer <?php echo $camposForm['vidTitulo'] ?></legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="video">
                                        <?php echo $camposForm['vidVideo'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="banner banner1">
                        <h1 id="textbanner"> <?php echo EMPRESA ?> </h1>
                    </div>
                </div>
            </div>
        </div>

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
    <h3>No existen datos del videojuego</h3>
    <tr>
        <td colspan="5">
            <a href="<?php echo SERVERURL ?>catalogo/" class="btn btn-group-sm btn-info btn-raised">
                Volver al catálogo
            </a>
        </td>
    </tr>
<?php endif; ?>