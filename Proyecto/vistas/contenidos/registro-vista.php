<section class="dashboard-contentRegistro">
    <div class="container-fluid">
        <div class="page-header">
            <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i> REGISTRO</h1>
        </div>
        <p class="lead">Regístrate para poder acceder a miles de guías de videojuegos en formato PDF</p>
    </div>
    <!-- Panel nuevo cliente -->
    <div class="container-fluid">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVO CLIENTE</h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo SERVERURL ?>ajax/registroAjax.php" method="POST" data-form="insert" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    <!--AJAX-->
                    <fieldset>
                        <legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">DNI/NIE *</label>
                                        <input pattern="[0-9-a-zA-ZáéíóúÁÉÍÓÚñÑ]{1,30}" class="form-control" type="text" name="dni-reg" required="" maxlength="30">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nombre *</label>
                                        <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-reg" required="" maxlength="30">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Apellidos *</label>
                                        <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-reg" required="" maxlength="30">
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
                                        <label class="control-label">Plataforma Preferida </label>
                                        <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="ocupacion-reg" maxlength="30">
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
                    <br>
                    <fieldset>
                        <legend><i class="zmdi zmdi-key"></i> &nbsp; Datos de la cuenta</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nombre de usuario *</label>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,15}" class="form-control" type="text" name="alias-reg" required="" maxlength="15">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Contraseña *</label>
                                        <input class="form-control" type="password" name="password1-reg" required="" maxlength="70">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Repita la contraseña *</label>
                                        <input class="form-control" type="password" name="password2-reg" required="" maxlength="70">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">E-mail</label>
                                        <input class="form-control" type="email" name="email-reg" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Género</label>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="optionsGenero" id="optionsRadios1" value="Masculino" checked="">
                                                <i class="zmdi zmdi-male-alt"></i> &nbsp; Masculino
                                            </label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="optionsGenero" id="optionsRadios2" value="Femenino">
                                                <i class="zmdi zmdi-female"></i> &nbsp; Femenino
                                            </label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="optionsGenero" id="optionsRadios3" value="Indefinido">
                                                <i class="zmdi zmdi-male-female"></i> &nbsp; Indefinido
                                            </label>
                                        </div>
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
    <footer>
        <div class="logo"> 
            <img src="../archivos/logo.png" class="img-responsive">
        </div>
    </footer>
</section>