<?php

/**
 * Como esta vista es para registrar Desarrolladoras, quedaría restringida su
 * visualización para usuarios normales. 
 */
if ($_SESSION['tipoGC'] != "Administrador") {
    echo $loginController->forzarCierreSesionController();
}
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Administración <small>DESARROLLADORA</small></h1>
    </div>
    <p class="lead">Rellena los campos para insertar una nueva desarrolladora</p>
</div>

<div class="container-fluid">
    <ul class="breadcrumb breadcrumb-tabs">
        <li>
            <a href="<?php echo SERVERURL ?>desarrolladora/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVA DESARROLLADORA
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL ?>desarrolladoralists/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE DESARROLLADORAS
            </a>
        </li>
    </ul>
</div>

<!-- panel datos de la desarrolladora -->
<div class="container-fluid">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DE LA DESARROLLADORA</h3>
        </div>
        <div class="panel-body">
            <form action="<?php echo SERVERURL ?>ajax/desarrolladoraAjax.php" method="POST" data-form="insert" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"><!--AJAX-->
                <fieldset>
                    <legend><i class="zmdi zmdi-assignment"></i> &nbsp; Datos básicos</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">DNI/CÓDIGO/NÚMERO DE REGISTRO *</label>
                                    <input pattern="[0-9-]{1,30}" class="form-control" type="text" name="dni-reg" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombre de la desarrolladora *</label>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" type="text" name="nombre-reg" required="" maxlength="40">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Teléfono</label>
                                    <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-reg" maxlength="15">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">E-mail</label>
                                    <input class="form-control" type="email" name="email-reg" maxlength="50">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Dirección</label>
                                    <input class="form-control" type="text" name="direccion-reg" maxlength="170">
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>
                <fieldset>
                    <legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Otros datos</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombre del gerente o director *</label>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="director-reg" required="" maxlength="50">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Año *</label>
                                    <input pattern="[0-9]{4,4}" class="form-control" type="text" name="year-reg" required="" maxlength="4">
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>
                <p class="text-center" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
                </p>
                <div class="RespuestaAjax"></div>
            </form>
        </div>
    </div>
</div>