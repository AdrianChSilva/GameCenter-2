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
        <h1 class="text-titles"><i class="zmdi zmdi-labels zmdi-hc-fw"></i> Administración <small>GÉNEROS</small></h1>
    </div>
    <p class="lead">Rellena los campos para insertar un nuevo género</p>
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

<!-- Panel nueva categoria -->
<div class="container-fluid">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVO GÉNERO</h3>
        </div>
        <div class="panel-body">
            <form action="<?php echo SERVERURL ?>ajax/generoAjax.php" method="POST" data-form="insert" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"><!--AJAX-->
                <fieldset>
                    <legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Información del género</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Código *</label>
                                    <input pattern="[0-9]{1,7}" class="form-control" type="text" name="codigo-reg" required="" maxlength="7">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombre *</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ -]{1,30}" class="form-control" type="text" name="nombre-reg" required="" maxlength="30">
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