<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../modelos/modeloUser.php";
} else {
    require_once "./modelos/modeloUser.php";
}

class controladorUser extends modeloUser
{   //Con este controlador añadimos a los clientes
    public function addUserController()
    {
        //Datos del usuario o cliente
        $dni = modeloPrincipal::cleanInsert($_POST['dni-reg']);
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-reg']);
        $apellido = modeloPrincipal::cleanInsert($_POST['apellido-reg']);
        $telefono = modeloPrincipal::cleanInsert($_POST['telefono-reg']);
        $ocupacion = modeloPrincipal::cleanInsert($_POST['ocupacion-reg']);
        $direccion = modeloPrincipal::cleanInsert($_POST['direccion-reg']);
        //Datos de la cuentaCuenta
        $alias = modeloPrincipal::cleanInsert($_POST['alias-reg']);
        $password1 = modeloPrincipal::cleanInsert($_POST['password1-reg']);
        $password2 = modeloPrincipal::cleanInsert($_POST['password2-reg']);
        $email = modeloPrincipal::cleanInsert($_POST['email-reg']);
        $genero = modeloPrincipal::cleanInsert($_POST['optionsGenero']);
        //los usuarios normales siempre tienen el mismo nvl de privilegio
        $privilegio = 4;


        //Elegimos foto según el género
        if ($genero == "Masculino") {
            $foto = modeloPrincipal::fotosPerfilPerrosAPI();
        } elseif ($genero == "Femenino") {
            $foto = modeloPrincipal::fotosPerfilGatosAPI();
        } else {
            $foto = "https://cdn4.iconfinder.com/data/icons/twitter-ui-set/128/Egg_Proffile_And_Settings_Twitter-512.png";
        }

        if ($password1 == $password2) {
            $compruebaDNI = modeloPrincipal::executeQuery("SELECT userDNI FROM user WHERE userDNI='$dni'");
            if ($compruebaDNI->rowCount() >= 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "El DNI ya existe",
                    "Tipo" => "error"
                ];
            } else {
                if ($email != "") {
                    $compruebaEmail = modeloPrincipal::executeQuery("SELECT cuentaEmail FROM cuenta WHERE cuentaEmail='$email'");
                    $emailCuenta = $compruebaEmail->rowCount();
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
                    $compruebaAlias = modeloPrincipal::executeQuery("SELECT cuentaAlias FROM cuenta WHERE cuentaAlias='$alias'");
                    if ($compruebaAlias->rowCount() >= 1) {
                        $alert = [
                            "Alert" => "simple",
                            "Titulo" => "ERROR",
                            "Texto" => "El USUARIO o ALIAS ya existe",
                            "Tipo" => "error"
                        ];
                    } else {
                        $compruebaID = modeloPrincipal::executeQuery("SELECT id FROM cuenta");
                        //pongo +1 porque id de la primera cuenta es 0. Sirve para hacer bien las comparaciones
                        $numero = ($compruebaID->rowCount()) + 1;

                        $codigoCuenta = modeloPrincipal::primaryKey("Usr", 7, $numero);
                        $clave = modeloPrincipal::encryption($password1);
                        $dataAccount = [
                            "codigo" => $codigoCuenta,
                            "privilegios" => $privilegio,
                            "alias" => $alias,
                            "pass" => $clave,
                            "email" => $email,
                            "estado" => "Activo",
                            "tipo" => "Cliente",
                            "genero" => $genero,
                            "foto" => $foto
                        ];
                        $insertarCuenta = modeloPrincipal::addAccount($dataAccount);
                        //Comprobamos si la cuenta se ha registrado satisfactoriamente
                        if ($insertarCuenta->rowCount() >= 1) {
                            $dataUser = [
                                "DNI" => $dni,
                                "nombre" => $nombre,
                                "apellido" => $apellido,
                                "tlfn" => $telefono,
                                "ocup" => $ocupacion,
                                "dir" => $direccion,
                                "codigo" => $codigoCuenta
                            ];
                            $guardarUsuario = modeloUser::addUserModel($dataUser);

                            if ($guardarUsuario->rowCount() >= 1) {
                                $alert = [
                                    "Alert" => "limpiar",
                                    "Titulo" => "ÉXITO",
                                    "Texto" => "El Cliente se registró satisfactoriamente",
                                    "Tipo" => "success"
                                ];
                            } else {
                                /**Eliminamos la cuenta porque no podemos dejar que se cree ésta si hay algún error a la hora de
                                 * crear el cliente, ya que éste hereda la clave primaria de la tabla cuenta como identificador o 
                                 * clave primaria.
                                 */
                                modeloPrincipal::deleteAccount($codigoCuenta);
                                $alert = [
                                    "Alert" => "simple",
                                    "Titulo" => "ERROR",
                                    "Texto" => "No se ha registrado la cuenta del Cliente",
                                    "Tipo" => "error"
                                ];
                            }
                        } else {
                            $alert = [
                                "Alert" => "simple",
                                "Titulo" => "ERROR",
                                "Texto" => "No se ha registrado el Cliente",
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

        return modeloPrincipal::sweetAlert($alert);
    }

    //Con este controlador paginamos a los clientes
    public function paginadorUserController($pagina, $registros, $privilegio, $busq)
    {
        //lo primero que hacemos es limpiar las cadenas
        $pagina = modeloPrincipal::cleanInsert($pagina);
        $registros = modeloPrincipal::cleanInsert($registros);
        $privilegio = modeloPrincipal::cleanInsert($privilegio);
        // $codigo = modeloPrincipal::cleanInsert($codigo);
        $busq = modeloPrincipal::cleanInsert($busq);
        //creamos una variable más que nos permitirá retornar la tabla de los clientes o usuarios
        $tabla = "";

        /**
         * Calculamos la página en la que nos encontramos. No permitiremos que
         * alguien pueda escribir un numero de página con decimales
         */
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1; //el 1 sirve para que, si pone por ej: (...)adminlists/paginaQueNoExiste, devuelva siempre la página 1 

        //con esta variable vamos a saber desde donde va a recoger los datos en la BD
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
        //comprobamos qué paginador usamos, si el de la pagina de clientes o el de busqueda
        if (isset($busq) && $busq != "") {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM user 
            WHERE (userApellido LIKE '%$busq%' OR userTlfn LIKE '%$busq%'
            OR userNombre LIKE '%$busq%' OR userDNI LIKE '%$busq%')  
            ORDER BY userApellido ASC LIMIT $inicio,$registros";
            $paginaURL = "userbusq";
        } else {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM user 
            ORDER BY userApellido ASC LIMIT $inicio,$registros";
            $paginaURL = "userlists";
        }

        $conex = modeloPrincipal::conectDB();
        $datos = $conex->query($consulta2);

        $datos = $datos->fetchAll();
        $total = $conex->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn(); //con esa funcion solo cuenta los registros de la tabla

        //con esto obtendremos el numero total de páginas según los registros que haya en BD
        //usamos ceil() porque coge un int y lo redondea
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
                    <th class="text-center">TELÉFONO</th>';
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

        /**Con esto hacemos que si alguien escribe un numero mayor al total de páginas (según la cantidad de registros)
         * ésto muestre la tabla de que no hay registros en la BD
         */
        if ($total >= 1 && $pagina <= $totalPaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
            <tr>
                <td>' . $contador . '</td>
                <td>' . $rows['userDNI'] . '</td>
                <td>' . $rows['userNombre'] . '</td>
                <td>' . $rows['userApellido'] . '</td>
                <td>' . $rows['userTlfn'] . '</td>';
                if ($privilegio <= 2) {
                    $tabla .= '
                <td>
                    <a href="' . SERVERURL . 'micuenta/user/' . modeloPrincipal::encryption($rows['cuentaCodigo']) . '/" class="btn btn-success btn-raised btn-xs">
                        <i class="zmdi zmdi-refresh"></i>
                    </a>
                </td>
                <td>
                    <a href="' . SERVERURL . 'misdatos/user/' . modeloPrincipal::encryption($rows['cuentaCodigo']) . '/" class="btn btn-success btn-raised btn-xs">
                        <i class="zmdi zmdi-refresh"></i>
                    </a>
                </td>';
                }
                if ($privilegio == 1) {
                    $tabla .= '
                    <td>
                        <form action="' . SERVERURL . 'ajax/userAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
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
            //si se borra en una página donde solo se muestra 1 registro (pero siguen existiendo más, lógicamente)
            //mostraremos un botón para recargar la tabla
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

    //Con este controlador eliminamos a los clientes (usuarios normales)
    public function deleteUserController()
    {
        //primero desencriptamos los values del formulario de BORRAR
        $codigo = modeloPrincipal::decryption($_POST['codDelete']);
        $privAdm = modeloPrincipal::decryption($_POST['privilegioAdmin']);
        //limpiamos cualquier inserción de datos que pueda ocurrir
        $codigo = modeloPrincipal::cleanInsert($codigo);
        $privAdm = modeloPrincipal::cleanInsert($privAdm);
        //si el administrados tiene privilegio de nvl1, podrá borrar al cliente
        if ($privAdm == 1) {
            $delUsr = modeloUser::deleteUserModel($codigo);
            modeloPrincipal::eliminarHistoricoSesiones($codigo);

            //comprobamos que se ha eliminado el cliente de la tabla de usuarios (tabla user en BD)
            if ($delUsr->rowCount() >= 1) {
                $delCuenta = modeloPrincipal::deleteAccount($codigo);
                if ($delCuenta->rowCount() == 1) {
                    $alert = [
                        "Alert" => "actualizar",
                        "Titulo" => "Éxito",
                        "Texto" => "El Cliente se eliminó satisfactoriamente",
                        "Tipo" => "success"
                    ];
                } else {
                    $alert = [
                        "Alert" => "simple",
                        "Titulo" => "ERROR",
                        "Texto" => "No se ha podido eliminar la CUENTA del Cliente",
                        "Tipo" => "error"
                    ];
                }
            } else {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "No se ha podido eliminar el cliente",
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

    //Con este controlador traemos los datos de la tabla de usuarios
    public function dataUserController($tipoConsulta, $codigoUser)
    {
        $codigoUser = modeloPrincipal::decryption($codigoUser);
        $tipoConsulta = modeloPrincipal::cleanInsert($tipoConsulta);

        return modeloUser::dataUserModel($tipoConsulta, $codigoUser);
    }

    //Con este controlador actualizamos a los clientes o usuarios
    public function updateUserController()
    {
        $cuenta = modeloPrincipal::decryption($_POST['cuenta-up']);
        $dni = modeloPrincipal::cleanInsert($_POST['dni-up']);
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-up']);
        $apellido = modeloPrincipal::cleanInsert($_POST['apellido-up']);
        $telefono = modeloPrincipal::cleanInsert($_POST['telefono-up']);
        $ocupacion = modeloPrincipal::cleanInsert($_POST['ocupacion-up']);
        $direccion = modeloPrincipal::cleanInsert($_POST['direccion-up']);

        //Realizamos las comprobaciones
        $comprobacion1 = modeloPrincipal::executeQuery("SELECT * FROM user where cuentaCodigo='$cuenta'");

        $datosUser = $comprobacion1->fetch();


        if ($dni != $datosUser['userDNI']) {

            $query1 = modeloPrincipal::executeQuery("SELECT userDNI FROM user where userDNI='$dni'");
            //comprobamos que el DNI que se introduce (actualiza) no existe ya dentro de la BD
            $query2 = modeloPrincipal::executeQuery("SELECT adminDNI FROM admin where adminDNI='$dni'");
            if ($query1->rowCount() == 1 || $query2->rowCount() == 1) {
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
        $datosUser = [
            "DNI" => $dni,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "tlfn" => $telefono,
            "ocup" => $ocupacion,
            "dir" => $direccion,
            "codigo" => $cuenta
        ];

        if (modeloUser::updateUserModel($datosUser)) {
            $alert = [
                "Alert" => "actualizar",
                "Titulo" => "ÉXITO",
                "Texto" => "Se han actualizado los datos del cliente satisfactoriamente",
                "Tipo" => "success"
            ];
        } else {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "No se ha podido actualizar los datos del cliente",
                "Tipo" => "error"
            ];
        }
        return modeloPrincipal::sweetAlert($alert);
    }
}
