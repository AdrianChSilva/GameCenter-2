<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../modelos/modeloGenero.php";
} else {
    require_once "./modelos/modeloGenero.php";
}
class controladorGenero extends modeloGenero
{
    //Con esta función añadimos un género
    public function addGeneroController()
    {
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-reg']);
        $codigo = modeloPrincipal::cleanInsert($_POST['codigo-reg']);

        if ($codigo != "") {
            $comprobacion2 = modeloPrincipal::executeQuery("SELECT generoCodigo FROM genero WHERE generoCodigo='$codigo'");
            $codigoGenero = $comprobacion2->rowCount();
        } else {
            $codigoGenero = 0;
        }
        if ($codigoGenero >= 1) {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "El CÓDIGO del género ya existe",
                "Tipo" => "error"
            ];
        } else {
            $comprobacion3 = modeloPrincipal::executeQuery("SELECT generoNombre FROM genero WHERE generoNombre='$nombre'");
            if ($comprobacion3->rowCount() >= 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "El NOMBRE del género ya existe",
                    "Tipo" => "error"
                ];
            } else {

                $dataGenero = [
                    "codigo" => $codigo,
                    "nombre" => $nombre

                ];
                $insertarGenero = modeloGenero::addGeneroModel($dataGenero);
                //Comprobamos si el Genero se ha registrado satisfactoriamente
                if ($insertarGenero->rowCount() >= 1) {
                    $alert = [
                        "Alert" => "limpiar",
                        "Titulo" => "ÉXITO",
                        "Texto" => "El Género se registró satisfactoriamente",
                        "Tipo" => "success"
                    ];
                } else {
                    $alert = [
                        "Alert" => "simple",
                        "Titulo" => "ERROR",
                        "Texto" => "No se ha registrado el Género",
                        "Tipo" => "error"
                    ];
                }
            }
        }
        return modeloPrincipal::sweetAlert($alert);
    }
    //Con esta función paginamos la lista de géneros
    public function paginadorGeneroController($pagina, $registros, $privilegio, $codigo, $busq)
    {
        //lo primero que hacemos es limpiar las cadenas
        $pagina = modeloPrincipal::cleanInsert($pagina);
        $registros = modeloPrincipal::cleanInsert($registros);
        $privilegio = modeloPrincipal::cleanInsert($privilegio);
        $codigo = modeloPrincipal::cleanInsert($codigo);
        $busq = modeloPrincipal::cleanInsert($busq);
        //creamos una variable más que nos permitirá retornar la tabla de los Géneros
        $tabla = "";

        /**
         * Calculamos la página en la que nos encontramos. No permitiremos que
         * alguien pueda escribir un numero de página con decimales
         */
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1; //el 1 sirve para que, si pone por ej: (...)generolists/paginaQueNoExiste, devuelva siempre la página 1 

        //con esta variable vamos a saber desde donde va a recoger los datos en la BD
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
        //comprobamos qué paginador usamos, si el de la pagina de desarrolladoras o el de busqueda
        if (isset($busq) && $busq != "") {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM genero 
                   WHERE generoCodigo!='$codigo' AND generoNombre LIKE '%$busq%'  
                   ORDER BY generoNombre ASC LIMIT $inicio,$registros";
            $paginaURL = "generobusq";
        } else {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM genero 
                   WHERE generoCodigo!='$codigo'
                   ORDER BY generoNombre ASC LIMIT $inicio,$registros";
            $paginaURL = "generolists";
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
                           <th class="text-center">CÓDIGO</th>
                           <th class="text-center">NOMBRE</th>';
        if ($privilegio <= 2) {
            $tabla .= '
                               <th class="text-center">ACTUALIZAR</th>
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
                       <td>' . $rows['generoCodigo'] . '</td>
                       <td>' . $rows['generoNombre'] . '</td>';
                if ($privilegio <= 2) {
                    $tabla .= '
    
                       <td>
                           <a href="' . SERVERURL . 'actugenero/' . modeloPrincipal::encryption($rows['generoCodigo']) . '/"  class="btn btn-success btn-raised btn-xs">
                               <i class="zmdi zmdi-refresh"></i>
                           </a>
                       </td>';
                }
                if ($privilegio == 1) {
                    $tabla .= '
                           <td>
                               <form action="' . SERVERURL . 'ajax/generoAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
                               <!-- No es estrictamente necesario encripar el value ya que el codigo del genero se ve, pero lo dejamos por si hubieran géneros escondidos que no queremos que se borren -->
                               <input type="hidden" name="codDelete" value="' . modeloPrincipal::encryption($rows['generoCodigo']) . '" >
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
    //Con este controlador traemos los datos de la tabla de Géneros
    //La consulta "Unico" NO va a estar disponible para esta version, pero la dejo para el futuro
    public function dataGeneroController($tipoConsulta, $codigoGenero)
    {
        $codigoGenero = modeloPrincipal::decryption($codigoGenero);
        $tipoConsulta = modeloPrincipal::cleanInsert($tipoConsulta);

        return modeloGenero::dataGeneroModel($tipoConsulta, $codigoGenero);
    }

    //Con este controlador eliminamos un género
    public function deleteGeneroController()
    {
        //primero desencriptamos los values del formulario de BORRAR
        $codigo = modeloPrincipal::decryption($_POST['codDelete']);
        $privAdm = modeloPrincipal::decryption($_POST['privilegioAdmin']);
        //limpiamos cualquier inserción de datos que pueda ocurrir
        $codigo = modeloPrincipal::cleanInsert($codigo);
        $privAdm = modeloPrincipal::cleanInsert($privAdm);

        if ($privAdm == 1) {
            $consulta = modeloPrincipal::executeQuery("SELECT id FROM genero Where generoCodigo='$codigo'");
            $dataGenero = $consulta->fetch();

            $delGenero = modeloGenero::deleteGeneroModel($codigo);

            if ($delGenero->rowCount() >= 1) {
                $alert = [
                    "Alert" => "actualizar",
                    "Titulo" => "ÉXITO",
                    "Texto" => "Genero eliminado correctamente",
                    "Tipo" => "success"
                ];
            } else {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "No se ha podido eliminar la Genero",
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

    //Con este controlador actualizamos el género
    public function updateGeneroController()
    {
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-up']);
        $codigo = modeloPrincipal::cleanInsert($_POST['codigo-up']);

            $comprobacionNombre = modeloPrincipal::executeQuery("SELECT generoNombre FROM genero WHERE generoNombre='$nombre'");
            if ($comprobacionNombre->rowCount() >= 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "El NOMBRE del género ya existe",
                    "Tipo" => "error"
                ];
            } else {

                $dataGenero = [
                    "codigo" => $codigo,
                    "nombre" => $nombre

                ];
                $actualizarGenero = modeloGenero::updateGeneroModel($dataGenero);
                //Comprobamos si el Genero se ha actualizado satisfactoriamente
                if ($actualizarGenero->rowCount() >= 1) {
                    $alert = [
                        "Alert" => "actualizar",
                        "Titulo" => "ÉXITO",
                        "Texto" => "El Género se Actualizó satisfactoriamente",
                        "Tipo" => "success"
                    ];
                } else {
                    $alert = [
                        "Alert" => "simple",
                        "Titulo" => "ERROR",
                        "Texto" => "No se ha actualizado el Género",
                        "Tipo" => "error"
                    ];
                }
            }
        
        return modeloPrincipal::sweetAlert($alert);
    }
    
}

