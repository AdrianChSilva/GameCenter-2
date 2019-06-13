<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../modelos/modeloAdmin.php";
} else {
    require_once "./modelos/modeloAdmin.php";
}
class controladorAdmin extends modeloAdmin
{
    //Con esta función añadimos al administrador en la base de datos, con sus
    //correspondientes comprobaciones.
    public function addAdminController()
    {
        $dni = modeloPrincipal::cleanInsert($_POST['dni-reg']);
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-reg']);
        $apellido = modeloPrincipal::cleanInsert($_POST['apellido-reg']);
        $telefono = modeloPrincipal::cleanInsert($_POST['telefono-reg']);
        $direccion = modeloPrincipal::cleanInsert($_POST['direccion-reg']);
        $alias = modeloPrincipal::cleanInsert($_POST['alias-reg']);
        $password1 = modeloPrincipal::cleanInsert($_POST['password1-reg']);
        $password2 = modeloPrincipal::cleanInsert($_POST['password2-reg']);
        $email = modeloPrincipal::cleanInsert($_POST['email-reg']);
        $genero = modeloPrincipal::cleanInsert($_POST['optionsGenero']);

        $privilegio = modeloPrincipal::decryption($_POST['optionsPrivilegio']);
        $privilegio = modeloPrincipal::cleanInsert($privilegio);


        //Elegimos foto según el género
        if ($genero == "Masculino") {
            $foto = modeloPrincipal::fotosPerfilPerrosAPI();
        } elseif ($genero == "Femenino") {
            $foto = modeloPrincipal::fotosPerfilGatosAPI();
        } else {
            $foto = "https://cdn4.iconfinder.com/data/icons/twitter-ui-set/128/Egg_Proffile_And_Settings_Twitter-512.png";
        }
        //comprobamos que el administrador tenga privilegios para registrar otros administradores
        if ($privilegio < 1 || $privilegio > 3) {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "Los privilegios no son los correctos",
                "Tipo" => "error"
            ];
        } else {
            if ($password1 == $password2) {
                $compruebaDNI = modeloPrincipal::executeQuery("SELECT adminDNI FROM admin WHERE adminDNI='$dni'");
                if ($compruebaDNI->rowCount() >= 1) {
                    $alert = [
                        "Alert" => "simple",
                        "Titulo" => "ERROR",
                        "Texto" => "El DNI ya existe",
                        "Tipo" => "error"
                    ];
                } else {
                    if ($email != "") {
                        $comprobacion2 = modeloPrincipal::executeQuery("SELECT cuentaEmail FROM cuenta WHERE cuentaEmail='$email'");
                        $emailCuenta = $comprobacion2->rowCount();
                    } else {
                        $emailCuenta = 0;
                    }
                    if ($emailCuenta >= 1) {
                        $alert = [
                            "Alert" => "simple",
                            "Titulo" => "ERROR",
                            "Texto" => "El EMAIL ya existe",
                            "Tipo" => "error"
                        ];
                    } else {
                        $comprobacion3 = modeloPrincipal::executeQuery("SELECT cuentaAlias FROM cuenta WHERE cuentaAlias='$alias'");
                        if ($comprobacion3->rowCount() >= 1) {
                            $alert = [
                                "Alert" => "simple",
                                "Titulo" => "ERROR",
                                "Texto" => "El USUARIO o ALIAS ya existe",
                                "Tipo" => "error"
                            ];
                        } else {
                            $comprobacion4 = modeloPrincipal::executeQuery("SELECT id FROM cuenta");
                            $numero = ($comprobacion4->rowCount()) + 1;
                            //Especificamos un "patrón" para las claves primarias del administrador (para el resto de tablas, que lo requieran, será igual)
                            $codigoCuenta = modeloPrincipal::primaryKey("Adm", 5, $numero);
                            $clave = modeloPrincipal::encryption($password1);
                            $dataAccount = [
                                "codigo" => $codigoCuenta,
                                "privilegios" => $privilegio,
                                "alias" => $alias,
                                "pass" => $clave,
                                "email" => $email,
                                "estado" => "Activo",
                                "tipo" => "Administrador",
                                "genero" => $genero,
                                "foto" => $foto
                            ];
                            $insertarCuenta = modeloPrincipal::addAccount($dataAccount);
                            //Comprobamos si la cuenta se ha registrado satisfactoriamente
                            if ($insertarCuenta->rowCount() >= 1) {
                                $dataAdmin = [
                                    "DNI" => $dni,
                                    "nombre" => $nombre,
                                    "apellido" => $apellido,
                                    "tlfn" => $telefono,
                                    "dir" => $direccion,
                                    "codigo" => $codigoCuenta
                                ];
                                $guardarAdministrador = modeloAdmin::addAdminModel($dataAdmin);

                                if ($guardarAdministrador->rowCount() >= 1) {
                                    $alert = [
                                        "Alert" => "limpiar",
                                        "Titulo" => "ÉXITO",
                                        "Texto" => "El administrador se registró satisfactoriamente",
                                        "Tipo" => "success"
                                    ];
                                } else {
                                    /**
                                     * Eliminamos la cuenta porque no podemos dejar que se cree ésta si hay algún error a la hora de
                                     * crear el administrador, ya que éste hereda la clave primaria de la tabla cuenta como identificador.
                                     */
                                    modeloPrincipal::deleteAccount($codigoCuenta);
                                    $alert = [
                                        "Alert" => "simple",
                                        "Titulo" => "ERROR",
                                        "Texto" => "No se ha registrado el Administrador",
                                        "Tipo" => "error"
                                    ];
                                }
                            } else {
                                $alert = [
                                    "Alert" => "simple",
                                    "Titulo" => "ERROR",
                                    "Texto" => "No se ha registrado el Administrador",
                                    "Tipo" => "error"
                                ];
                            }
                        }
                    }
                }
            } else {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "Las contraseñas no coinciden",
                    "Tipo" => "error"
                ];
            }
        }

        return modeloPrincipal::sweetAlert($alert);
    }

    //Con este controlador paginamos la lista de administradores
    public function paginadorAdminController($pagina, $registros, $privilegio, $codigo, $busq)
    {
        //Lo primero que hacemos es limpiar las cadenas
        $pagina = modeloPrincipal::cleanInsert($pagina);
        $registros = modeloPrincipal::cleanInsert($registros);
        $privilegio = modeloPrincipal::cleanInsert($privilegio);
        $codigo = modeloPrincipal::cleanInsert($codigo);
        $busq = modeloPrincipal::cleanInsert($busq);
        //Creamos una variable más que nos permitirá retornar la tabla de los admin
        $tabla = "";

        /**
         * Calculamos la página en la que nos encontramos. No permitiremos que
         * alguien pueda escribir un numero de página con decimales
         */
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1; //el 1 sirve para que, si pone por ej: (...)adminlists/paginaQueNoExiste, devuelva siempre la página 1 

        //Con esta variable vamos a saber desde donde va a recoger los datos en la BD
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
        //Comprobamos qué paginador usamos, si el de la pagina de administradores o el de busqueda
        if (isset($busq) && $busq != "") {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM admin 
            WHERE ((cuentaCodigo!='$codigo' AND id!='13') AND (adminApellido LIKE '%$busq%' 
            OR adminNombre LIKE '%$busq%' OR adminDNI LIKE '%$busq%'))  
            ORDER BY adminApellido ASC LIMIT $inicio,$registros";
            $paginaURL = "adminbusq";
        } else {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM admin 
            WHERE cuentaCodigo!='$codigo' AND id!='13' 
            ORDER BY adminApellido ASC LIMIT $inicio,$registros";
            $paginaURL = "adminlists";
        }
        //El id=13 pertenece al administrador principal, por lo cual ese no se podrá eliminar

        $conex = modeloPrincipal::conectDB();

        $datos = $conex->query($consulta2);

        $datos = $datos->fetchAll();
        $total = $conex->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn(); //con esa funcion solo cuenta los registros de la tabla

        //Con esto obtendremos el numero total de páginas según los registros que haya en BD
        //Usamos ceil() porque coge un int y lo redondea
        $totalPaginas = ceil($total / $registros);


        //A PARTIR DE AQUÍ HACEMOS LA PARTE GRÁFICA DE LA TABLA///
        $tabla .= '<div class="table-responsive">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">DNI</th>
                    <th class="text-center">NOMBRE</th>
                    <th class="text-center">APELLIDOS</th>
                    <th class="text-center">TELÉFONO</th>
                    <th class="text-center">DIRECCIÓN</th>';
        if ($privilegio <= 2) {
            $tabla .= '
                        <th class="text-center">A. CUENTA</th>
                        <th class="text-center">A. DATOS</th>
                        ';
        }
        if ($privilegio == 1) {
            $tabla .= '
                        <th class="text-center">ELIMINAR</th>
            ';
        }

        $tabla .= '</tr>
            </thead>
            <tbody>';

        /**
         * Con esto hacemos que si alguien escribe un numero mayor al total de páginas (según la cantidad de registros)
         * ésto muestre la tabla de que no hay registros en la BD
         */
        if ($total >= 1 && $pagina <= $totalPaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
            <tr>
                <td>' . $contador . '</td>
                <td>' . $rows['adminDNI'] . '</td>
                <td>' . $rows['adminNombre'] . '</td>
                <td>' . $rows['adminApellido'] . '</td>
                <td>' . $rows['adminTlfn'] . '</td>
                <td>' . $rows['adminDir'] . '</td>';
                if ($privilegio <= 2) {
                    $tabla .= '
                <td>
                    <a href="' . SERVERURL . 'micuenta/admin/' . modeloPrincipal::encryption($rows['cuentaCodigo']) . '/" class="btn btn-success btn-raised btn-xs">
                        <i class="zmdi zmdi-refresh"></i>
                    </a>
                </td>
                <td>
                    <a href="' . SERVERURL . 'misdatos/admin/' . modeloPrincipal::encryption($rows['cuentaCodigo']) . '/" class="btn btn-success btn-raised btn-xs">
                        <i class="zmdi zmdi-refresh"></i>
                    </a>
                </td>';
                }
                if ($privilegio == 1) {
                    $tabla .= '
                    <td>
                        <form action="' . SERVERURL . 'ajax/adminAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
                        <input type="hidden" name="codDelete" value="' . modeloPrincipal::encryption($rows['cuentaCodigo']) . '" >
                        <input type="hidden" name="privilegioAdmin" value="' . modeloPrincipal::encryption($privilegio) . '" >
                            <button type="submit" class="btn btn-danger btn-raised btn-xs">
                                <i class="zmdi zmdi-delete"></i>
                            </button>
                            <div class="RespuestaAjax"></div>
                        </form>
                    </td>';
                }

                $tabla .= '</tr>';
                $contador++;
            }
        } else {
            /**
             * Si se borra en una página donde solo se muestra 1 registro (pero siguen existiendo más, lógicamente)
             * mostraremos un botón para recargar la tabla 
             */
            if ($total >= 1) {
                $tabla .= '
                <tr>
                    <td colspan="5">
                        <a href="' . SERVERURL . $paginaURL . '/" class="btn btn-group-sm btn-info btn-raised">
                            Recargar tabla
                        </a>
                    </td>
                </tr>
                ';
            } else {
                $tabla .= '
                <tr>
                    <td colspan="5">No hay registros en la Base de Datos</td>
                </tr>
                ';
            }
        }
        $tabla .= '</tbody></table></div>';

        if ($total >= 1 && $pagina <= $totalPaginas) {
            $tabla .= '
                <nav class="text-center">
                <ul class="pagination pagination-sm">
            ';
            if ($pagina == 1) {
                $tabla .= '<li class="disabled"><a><i class="zmdi zmdi-chevron-left"></i></a></li>';
            } else {
                $tabla .= '<li><a href="' . SERVERURL . $paginaURL . '/' . ($pagina - 1) . '/"><i class="zmdi zmdi-chevron-left"></i></a></li>';
            }
            //Esto es para marcar con un color al número de la página que nos encontramos
            for ($i = 1; $i <= $totalPaginas; $i++) {
                if ($pagina == $i) {
                    $tabla .= '<li class="active"><a href="' . SERVERURL . $paginaURL . '/' . $i . '/">' . $i . '</a></li>';
                } else {
                    $tabla .= '<li><a href="' . SERVERURL . $paginaURL . '/' . $i . '/">' . $i . '</a></li>';
                }
            }

            if ($pagina == $totalPaginas) {
                $tabla .= '<li class="disabled"><a><i class="zmdi zmdi-chevron-right"></i></a></li>';
            } else {
                $tabla .= '<li><a href="' . SERVERURL . $paginaURL . '/' . ($pagina + 1) . '/"><i class="zmdi zmdi-chevron-right"></i></a></li>';
            }

            $tabla .= '
                </ul>
                </nav>
        ';
        }


        return $tabla;
    }

    //Con este controlador eliminamos a los administradores
    public function deleteAdminController()
    {
        //primero desencriptamos los values del formulario de BORRAR
        $codigo = modeloPrincipal::decryption($_POST['codDelete']);
        $privAdm = modeloPrincipal::decryption($_POST['privilegioAdmin']);
        //limpiamos cualquier inserción de datos que pueda ocurrir
        $codigo = modeloPrincipal::cleanInsert($codigo);
        $privAdm = modeloPrincipal::cleanInsert($privAdm);

        if ($privAdm == 1) {
            $consulta = modeloPrincipal::executeQuery("SELECT id FROM admin Where cuentaCodigo='$codigo'");
            $dataAdmin = $consulta->fetch();
            //comprobamos que no se pueda eliminar el administrador MASTER
            if ($dataAdmin['id'] != 13) {

                $delAdm = modeloAdmin::deleteAdminModel($codigo);
                modeloPrincipal::eliminarHistoricoSesiones($codigo);

                //comprobamos que se ha eliminado el administrador de la tabla de administradores
                if ($delAdm->rowCount() >= 1) { //quizás haya que poner >=1
                    $delCuenta = modeloPrincipal::deleteAccount($codigo);
                    if ($delCuenta->rowCount() == 1) {
                        $alert = [
                            "Alert" => "actualizar",
                            "Titulo" => "ÉXITO",
                            "Texto" => "El administrador se eliminó satisfactoriamente",
                            "Tipo" => "success"
                        ];
                    } else {
                        $alert = [
                            "Alert" => "simple",
                            "Titulo" => "ERROR",
                            "Texto" => "No se ha podido eliminar la CUENTA del administrador",
                            "Tipo" => "error"
                        ];
                    }
                } else {
                    $alert = [
                        "Alert" => "simple",
                        "Titulo" => "ERROR",
                        "Texto" => "No se ha podido eliminar el administrador",
                        "Tipo" => "error"
                    ];
                }
            } else {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "No se puede eliminar al administrador MASTER",
                    "Tipo" => "error"
                ];
            }
        } else {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "No tienes permiso para realizar esta acción",
                "Tipo" => "error"
            ];
        }
        return modeloPrincipal::sweetAlert($alert);
    }

    //Con este controlador traemos los datos de la tabla de administradores
    public function dataAdminController($tipoConsulta, $codigoAdmin)
    {
        $codigoAdmin = modeloPrincipal::decryption($codigoAdmin);
        $tipoConsulta = modeloPrincipal::cleanInsert($tipoConsulta);

        return modeloAdmin::dataAdminModel($tipoConsulta, $codigoAdmin);
    }

    //Con esta función actualizamos a los administradores
    public function updateAdminController()
    {
        $cuenta = modeloPrincipal::decryption($_POST['cuenta-up']);
        $dni = modeloPrincipal::cleanInsert($_POST['dni-up']);
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-up']);
        $apellido = modeloPrincipal::cleanInsert($_POST['apellido-up']);
        $telefono = modeloPrincipal::cleanInsert($_POST['telefono-up']);
        $direccion = modeloPrincipal::cleanInsert($_POST['direccion-up']);

        //Realizamos las comprobaciones
        $comprobacion1 = modeloPrincipal::executeQuery("SELECT * FROM admin where cuentaCodigo='$cuenta'");
        $datosAdmin = $comprobacion1->fetch();

        if ($dni != $datosAdmin['adminDNI']) {
            //comprobamos que el DNI que se introduce (actualiza) no existe ya dentro de la BD
            $query1 = modeloPrincipal::executeQuery("SELECT adminDNI FROM admin where adminDNI='$dni'");
            if ($query1->rowCount() == 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "El DNI que has escrito ya se encuentra registrado",
                    "Tipo" => "error"
                ];
                return modeloPrincipal::sweetAlert($alert);
                exit(); //esta función lo que hace es parar la ejecución del codigo PHP
            }
        }
        $datosAdmin = [
            "DNI" => $dni,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "tlfn" => $telefono,
            "dir" => $direccion,
            "codigo" => $cuenta
        ];

        if (modeloAdmin::updateAdminModel($datosAdmin)) {
            $alert = [
                "Alert" => "actualizar",
                "Titulo" => "ÉXITO",
                "Texto" => "Se han actualizado los datos del administrador satisfactoriamente",
                "Tipo" => "success"
            ];
        } else {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "No se ha podido actualizar los datos del aldministrador",
                "Tipo" => "error"
            ];
        }
        return modeloPrincipal::sweetAlert($alert);
    }
}

