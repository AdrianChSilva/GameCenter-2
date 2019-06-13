<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../modelos/modeloDesarrolladora.php";
} else {
    require_once "./modelos/modeloDesarrolladora.php";
}
class controladorDesarrolladora extends modeloDesarrolladora
{
    //Con esta función añadimos a la desarrolladora en la base de datos, con sus correspondientes comprobaciones.
    public function addDesarrController()
    {
        $dni = modeloPrincipal::cleanInsert($_POST['dni-reg']);
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-reg']);
        $telefono = modeloPrincipal::cleanInsert($_POST['telefono-reg']);
        $email = modeloPrincipal::cleanInsert($_POST['email-reg']);
        $direccion = modeloPrincipal::cleanInsert($_POST['direccion-reg']);
        $ceo = modeloPrincipal::cleanInsert($_POST['director-reg']);
        $anno = modeloPrincipal::cleanInsert($_POST['year-reg']);




        $compruebaDNIAdm = modeloPrincipal::executeQuery("SELECT adminDNI FROM admin WHERE adminDNI='$dni'");
        $compruebaDNIUsr = modeloPrincipal::executeQuery("SELECT userDNI FROM user WHERE userDNI='$dni'");
        //la empresa puede ser un particular y que use su DNI como código
        $compruebaDNIDes = modeloPrincipal::executeQuery("SELECT desarrCodigo FROM desarrolladora WHERE desarrCodigo='$dni'");

        if ($compruebaDNIAdm->rowCount() >= 1 || $compruebaDNIUsr->rowCount() >= 1 || $compruebaDNIDes->rowCount() >= 1) {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "El DNI/CÓDIGO/NÚMERO DE REGISTRO ya existe",
                "Tipo" => "error"
            ];
        } else {
            if ($email != "") {
                $comprobacion2 = modeloPrincipal::executeQuery("SELECT desarrEmail FROM desarrolladora WHERE desarrEmail='$email'");
                $emailDesar = $comprobacion2->rowCount();
            } else {
                $emailDesar = 0;
            }
            if ($emailDesar >= 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "El EMAIL de la empresa ya existe",
                    "Tipo" => "error"
                ];
            } else {
                $comprobacion3 = modeloPrincipal::executeQuery("SELECT desarrNombre FROM desarrolladora WHERE desarrNombre='$nombre'");
                if ($comprobacion3->rowCount() >= 1) {
                    $alert = [
                        "Alert" => "simple",
                        "Titulo" => "ERROR",
                        "Texto" => "El NOMBRE de la empresa ya existe",
                        "Tipo" => "error"
                    ];
                } else {
                    $comprobacion4 = modeloPrincipal::executeQuery("SELECT desarrCEO FROM desarrolladora WHERE desarrCEO='$ceo'");
                    if ($comprobacion4->rowCount() >= 1) {
                        $alert = [
                            "Alert" => "simple",
                            "Titulo" => "ERROR",
                            "Texto" => "El nombre del DIRECTOR O CEO de la empresa ya existe",
                            "Tipo" => "error"
                        ];
                    } else {

                        $comprobacion5 = modeloPrincipal::executeQuery("SELECT id FROM desarrolladora");

                        $numero = ($comprobacion5->rowCount()) + 1;

                        // $codigoDesarr = modeloPrincipal::primaryKey("Des", 5, $numero);
                        $dataDesarr = [
                            "codigo" => $dni,
                            "nombre" => $nombre,
                            "tlfn" => $telefono,
                            "email" => $email,
                            "dir" => $direccion,
                            "ceo" => $ceo,
                            "anno" => $anno
                        ];
                        $insertarDesarr = modeloDesarrolladora::addDesarrModel($dataDesarr);
                        if ($insertarDesarr->rowCount() >= 1) {
                            $alert = [
                                "Alert" => "limpiar",
                                "Titulo" => "ÉXITO",
                                "Texto" => "La desarrolladora se registró satisfactoriamente",
                                "Tipo" => "success"
                            ];
                        } else {
                            $alert = [
                                "Alert" => "simple",
                                "Titulo" => "ERROR",
                                "Texto" => "No se ha registrado la desarrolladora",
                                "Tipo" => "error"
                            ];
                        }
                    }
                }
            }
        }
        return modeloPrincipal::sweetAlert($alert);
    }

    //Con este controlador paginamos a las desarrolladoras
    public function paginadorDesarrController($pagina, $registros, $privilegio, $codigo, $busq)
    {
        //lo primero que hacemos es limpiar las cadenas
        $pagina = modeloPrincipal::cleanInsert($pagina);
        $registros = modeloPrincipal::cleanInsert($registros);
        $privilegio = modeloPrincipal::cleanInsert($privilegio);
        $codigo = modeloPrincipal::cleanInsert($codigo);
        $busq = modeloPrincipal::cleanInsert($busq);
        //creamos una variable más que nos permitirá retornar la tabla de las desarrolladoras
        $tabla = "";

        /**
         * Calculamos la página en la que nos encontramos. No permitiremos que
         * alguien pueda escribir un numero de página con decimales
         */
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1; //el 1 sirve para que, si pone por ej: (...)desarrlists/paginaQueNoExiste, devuelva siempre la página 1 

        //con esta variable vamos a saber desde donde va a recoger los datos en la BD
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
        //comprobamos qué paginador usamos, si el de la pagina de desarrolladoras o el de busqueda
        if (isset($busq) && $busq != "") {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM desarrolladora 
               WHERE ((desarrCodigo!='$codigo') AND (desarrNombre LIKE '%$busq%' 
               OR desarrCEO LIKE '%$busq%' OR desarrCodigo LIKE '%$busq%'))  
               ORDER BY desarrNombre ASC LIMIT $inicio,$registros";
            $paginaURL = "desarrolladorabusq";
        } else {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM desarrolladora 
               WHERE desarrCodigo!='$codigo'
               ORDER BY desarrNombre ASC LIMIT $inicio,$registros";
            $paginaURL = "desarrolladoralists";
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
                       <th class="text-center">CÓDIGO DE REGISTRO o DNI</th>
                       <th class="text-center">NOMBRE</th>
                       <th class="text-center">EMAIL</th>
                       <th class="text-center">TELÉFONO</th>';
        if ($privilegio <= 2) {
            $tabla .= '
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
                   <td>' . $rows['desarrCodigo'] . '</td>
                   <td>' . $rows['desarrNombre'] . '</td>
                   <td>' . $rows['desarrEmail'] . '</td>
                   <td>' . $rows['desarrTlfn'] . '</td>';
                if ($privilegio <= 2) {
                    $tabla .= '

                   <td>
                       <a href="' . SERVERURL . 'actudesarrolladora/' . modeloPrincipal::encryption($rows['desarrCodigo']) . '/"  class="btn btn-success btn-raised btn-xs">
                           <i class="zmdi zmdi-refresh"></i>
                       </a>
                   </td>';
                }
                if ($privilegio == 1) {
                    $tabla .= '
                       <td>
                           <form action="' . SERVERURL . 'ajax/desarrolladoraAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
                           <input type="hidden" name="codDelete" value="' . modeloPrincipal::encryption($rows['desarrCodigo']) . '" >
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

    //Con este controlador traemos los datos de la tabla de desarrolladoras
    //La consulta "Unico" no va a estar disponible para esta version, pero la dejo para el futuro
    public function dataDesarrController($tipoConsulta, $codigoDesarr)
    {
        $codigoDesarr = modeloPrincipal::decryption($codigoDesarr);
        $tipoConsulta = modeloPrincipal::cleanInsert($tipoConsulta);

        return modeloDesarrolladora::dataDesarrModel($tipoConsulta, $codigoDesarr);
    }

    //Con este controlador eliminamos a las desarrolladoras
    public function deleteDesarrController()
    {
        //primero desencriptamos los values del formulario de BORRAR
        $codigo = modeloPrincipal::decryption($_POST['codDelete']);
        $privAdm = modeloPrincipal::decryption($_POST['privilegioAdmin']);
        //limpiamos cualquier inserción de datos que pueda ocurrir
        $codigo = modeloPrincipal::cleanInsert($codigo);
        $privAdm = modeloPrincipal::cleanInsert($privAdm);

        if ($privAdm == 1) {
            $consulta = modeloPrincipal::executeQuery("SELECT id FROM desarrolladora Where desarrCodigo='$codigo'");
            $dataDesarr = $consulta->fetch();

            $delDesr = modeloDesarrolladora::deleteDesarrModel($codigo);

            //comprobamos que se ha eliminado la Desarrolladora de la tabla
            if ($delDesr->rowCount() >= 1) {
                $alert = [
                    "Alert" => "actualizar",
                    "Titulo" => "ÉXITO",
                    "Texto" => "Desarrolladora eliminada correctamente",
                    "Tipo" => "success"
                ];
            } else {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "No se ha podido eliminar la Desarrolladora",
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

    public function updateDesarrController()
    {
        $dni = modeloPrincipal::cleanInsert($_POST['dni-up']);
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-up']);
        $telefono = modeloPrincipal::cleanInsert($_POST['telefono-up']);
        $email = modeloPrincipal::cleanInsert($_POST['email-up']);
        $direccion = modeloPrincipal::cleanInsert($_POST['direccion-up']);
        $ceo = modeloPrincipal::cleanInsert($_POST['director-up']);
        $anno = modeloPrincipal::cleanInsert($_POST['year-up']);





        // $codigoDesarr = modeloPrincipal::primaryKey("Des", 5, $numero);
        $dataDesarr = [
            "codigo" => $dni,
            "nombre" => $nombre,
            "tlfn" => $telefono,
            "email" => $email,
            "dir" => $direccion,
            "ceo" => $ceo,
            "anno" => $anno
        ];
        $insertarDesarr = modeloDesarrolladora::updateDesarrModel($dataDesarr);
        if ($insertarDesarr->rowCount() >= 1) {
            $alert = [
                "Alert" => "actualizar",
                "Titulo" => "ÉXITO",
                "Texto" => "La desarrolladora se actualizó satisfactoriamente",
                "Tipo" => "success"
            ];
        } else {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "No se ha actualizado la desarrolladora",
                "Tipo" => "error"
            ];
        }
        return modeloPrincipal::sweetAlert($alert);
    }
}
