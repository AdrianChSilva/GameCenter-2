<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../modelos/modeloLogin.php";
} else {
    require_once "./modelos/modeloLogin.php";
}

class controladorLogin extends modeloLogin
{


    //Con esta función registramos la sesión
    public function iniciarSesionController()
    {
        $user = modeloPrincipal::cleanInsert($_POST['user']);
        $pass = modeloPrincipal::cleanInsert($_POST['pass']);
        $pass = modeloPrincipal::encryption($pass);


        $dataLogin = [
            "alias" => $user,
            "pass" => $pass
        ];

        $dataAcc = modeloLogin::iniciarSesionModel($dataLogin);
        /**
         * Si hay valores en la base de datos, se iniciará sesión y se creará el histórico de la misma,
         * ese decir, se registrará la fecha de entrada, su código, etc.
         */
        if ($dataAcc->rowCount() == 1) {
            $row = $dataAcc->fetch();

            $fechActu = date("Y-m-d");
            $annoActu = date("Y");
            $horaActu = date("h:i:s a");

            $consulta = modeloPrincipal::executeQuery("SELECT id FROM historico");
            $num = ($consulta->rowCount()) + 1;

            $codigoHistorico = modeloPrincipal::primaryKey("CodH", 8, $num);

            $dataHist = [
                "codigo" => $codigoHistorico,
                "fecha" => $fechActu,
                "horaInicio" => $horaActu,
                "horaFinal" => "NO DATA",
                "tipo" => $row['cuentaTipo'],
                "anno" => $annoActu,
                "cuenta" => $row['cuentaCodigo']

            ];


            $insertHistorico = modeloPrincipal::almacenarHistoricoSesiones($dataHist);

            if ($insertHistorico->rowCount() >= 1) {

                if ($row['cuentaTipo'] == "Administrador") {
                    $query = modeloPrincipal::executeQuery("SELECT * FROM admin WHERE cuentaCodigo='" . $row['cuentaCodigo'] . "'");
                } else {
                    $query = modeloPrincipal::executeQuery("SELECT * FROM user WHERE cuentaCodigo='" . $row['cuentaCodigo'] . "'");
                }

                if ($query->rowCount() == 1) {

                    session_start(['name' => 'GC']); //GameCenter
                    $datosAdmCli = $query->fetch();

                    /**
                     * Esta condicional es simplemente para guardar el nombre real del usuario, que no su alias, en una
                     * variable de sesión. Lo tengo por si lo uso más tarde. Por ahora en el navegador lateral sólo voy a mostrar
                     * el alias del usuario (sea administrador o un usuario normal)
                     */
                    if ($row['cuentaTipo'] == "Administrador") {
                        $_SESSION['nombreGC'] = $datosAdmCli['adminNombre'];
                        $_SESSION['apellidoGC'] = $datosAdmCli['adminApellido'];
                    } else {
                        $_SESSION['nombreGC'] = $datosAdmCli['userNombre'];
                        $_SESSION['apellidoGC'] = $datosAdmCli['userApellido'];
                    }

                    $_SESSION['usuarioGC'] = $row['cuentaAlias'];
                    $_SESSION['tipoGC'] = $row['cuentaTipo'];
                    $_SESSION['privilegioGC'] = $row['cuentaPrivg'];
                    $_SESSION['fotoGC'] = $row['cuentaFoto'];
                    //le damos a la sesión un número único
                    $_SESSION['tokenGC'] = md5(uniqid(mt_rand(), true));
                    $_SESSION['cuentaCodigoGC'] = $row['cuentaCodigo'];
                    $_SESSION['histCodigoGC'] = $codigoHistorico;

                    //Redireccionamos al usuario según el tipo de cuenta que sea.
                    if ($row['cuentaTipo'] == "Administrador") {
                        $url = SERVERURL . "home/";
                    } else {
                        $url = SERVERURL . "catalogo/";
                    }
                    return $urlLocation = '<script> window.location="' . $url . '"</script>';
                } else {
                    $alert = [
                        "Alert" => "simple",
                        "Titulo" => "ERROR",
                        "Texto" => "No se ha podido iniciar sesión, inténtelo de nuevo",
                        "Tipo" => "error"
                    ];
                    return modeloPrincipal::sweetAlert($alert);
                }
            } else {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "No se ha podido iniciar sesión, inténtelo de nuevo[Problemas en el hstorico]",
                    "Tipo" => "error"
                ];
                return modeloPrincipal::sweetAlert($alert);
            }
        } else {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "El nombre de usuario o alias y contraseña no existe",
                "Tipo" => "error"
            ];
            return modeloPrincipal::sweetAlert($alert);
        }
    }
    //Con esta función deslogeamos al usuario (cerramos la sesión)
    public function cerrarSesionController()
    {
        session_start(['name' => 'GC']);
        $token = modeloPrincipal::decryption($_GET['token']);
        $hora = date("h:i:s a");
        $datosCerrS = [
            "alias" => $_SESSION['usuarioGC'],
            "tokenS" => $_SESSION['tokenGC'],
            "token" => $token,
            "codigo" => $_SESSION['histCodigoGC'],
            "hora" => $hora
        ];
        return modeloLogin::cerrarSesionModel($datosCerrS);
    }
    //Si un usuario itenta acceder a un sitio de la página donde no debería, se le cierra la sesión.
    
    public function forzarCierreSesionController()
    {
        session_start(['name' => 'GC']);
        session_unset();
        session_destroy();
        $redireccion = '<script> window.location.href="' . SERVERURL . 'login/"</script>';
        return $redireccion;
    }

    public function redireccionar($tipo)
    {
        if ($tipo == "Cliente") {
            $redireccion = '<script> window.location.href="' . SERVERURL . 'catalogo/"</script>';
        } else {
            $redireccion = '<script> window.location.href="' . SERVERURL . 'home/"</script>';
        }
        return $redireccion;
    }
}

