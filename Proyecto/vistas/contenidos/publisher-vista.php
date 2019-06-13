<?php

/**
 * Como esta vista es para administradores, quedaría restringida su
 * visualización para usuarios normales. 
 */
if ($_SESSION['tipoGC'] != "Administrador") {
    echo $loginController->forzarCierreSesionController();
}
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Administración <small>PUBLISHERS</small></h1>
    </div>
    <p class="lead">Rellena los campos para insertar un nuevo <b>publisher</b></p>
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

<!-- Panel nuevo proveedor -->
<div class="container-fluid">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVO PUBLISHER</h3>
        </div>
        <div class="panel-body">
            <form action="<?php echo SERVERURL ?>ajax/publisherAjax.php" method="POST" data-form="insert" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"><!--AJAX-->
                <fieldset>
                    <legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Información del publisher</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombre del publisher *</label>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ -]{1,30}" class="form-control" type="text" name="nombre-reg" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Encargado*</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="encargado-reg" required="" maxlength="50">
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
                                    <textarea name="direccion-reg" class="form-control" rows="2" maxlength="100"></textarea>
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