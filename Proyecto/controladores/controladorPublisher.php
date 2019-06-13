<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../modelos/modeloPublisher.php";
} else {
    require_once "./modelos/modeloPublisher.php";
}
class controladorPublisher extends modeloPublisher
{
    //Con esta función añadimos al Publisher en la base de datos, con sus
    //correspondientes comprobaciones.
    public function addPublisherController()
    {
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-reg']);
        $encargado = modeloPrincipal::cleanInsert($_POST['encargado-reg']);
        $telefono = modeloPrincipal::cleanInsert($_POST['telefono-reg']);
        $direccion = modeloPrincipal::cleanInsert($_POST['direccion-reg']);
        $email = modeloPrincipal::cleanInsert($_POST['email-reg']);


        //Se podrían hacer MÁS comprobaciones con los emails, pero lo dejamos para el futuro

        if ($email != "") {
            $comprobacion2 = modeloPrincipal::executeQuery("SELECT publisherEmail FROM publisher WHERE publisherEmail='$email'");
            $emailPublisher = $comprobacion2->rowCount();
        } else {
            $emailPublisher = 0;
        }
        if ($emailPublisher >= 1) {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "El EMAIL del publisher ya existe",
                "Tipo" => "error"
            ];
        } else {
            $comprobacion3 = modeloPrincipal::executeQuery("SELECT publisherNombre FROM publisher WHERE publisherNombre='$nombre'");
            if ($comprobacion3->rowCount() >= 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "El NOMBRE del publisher ya existe",
                    "Tipo" => "error"
                ];
            } else {
                $comprobacion4 = modeloPrincipal::executeQuery("SELECT id FROM publisher");
                //pongo +1 porque id de la primera cuenta es 0. Sirve para hacer bien las comparaciones
                $numero = ($comprobacion4->rowCount()) + 1;

                $publisherCodigo = modeloPrincipal::primaryKey("Pub", 5, $numero);
                $dataPublisher = [
                    "codigo" => $publisherCodigo,
                    "nombre" => $nombre,
                    "encargado" => $encargado,
                    "tlfn" => $telefono,
                    "email" => $email,
                    "dir" => $direccion

                ];
                $insertarPublisher = modeloPublisher::addPublisherModel($dataPublisher);
                //Comprobamos si el publisher se ha registrado satisfactoriamente
                if ($insertarPublisher->rowCount() >= 1) {
                    $alert = [
                        "Alert" => "limpiar",
                        "Titulo" => "ÉXITO",
                        "Texto" => "El Publisher se registró satisfactoriamente",
                        "Tipo" => "success"
                    ];
                } else {
                    $alert = [
                        "Alert" => "simple",
                        "Titulo" => "ERROR",
                        "Texto" => "No se ha registrado el Publisher",
                        "Tipo" => "error"
                    ];
                }
            }
        }
        return modeloPrincipal::sweetAlert($alert);
    }

    //Con este controlador paginamos a los publishers
    public function paginadorPublisherController($pagina, $registros, $privilegio, $codigo, $busq)
    {
        //lo primero que hacemos es limpiar las cadenas
        $pagina = modeloPrincipal::cleanInsert($pagina);
        $registros = modeloPrincipal::cleanInsert($registros);
        $privilegio = modeloPrincipal::cleanInsert($privilegio);
        $codigo = modeloPrincipal::cleanInsert($codigo);
        $busq = modeloPrincipal::cleanInsert($busq);
        //creamos una variable más que nos permitirá retornar la tabla de los publishers
        $tabla = "";

        /**
         * Calculamos la página en la que nos encontramos. No permitiremos que
         * alguien pueda escribir un numero de página con decimales
         */
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1; //el 1 sirve para que, si pone por ej: (...)adminlists/paginaQueNoExiste, devuelva siempre la página 1 

        //con esta variable vamos a saber desde donde va a recoger los datos en la BD
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
        //comprobamos qué paginador usamos, si el de la pagina de desarrolladoras o el de busqueda
        if (isset($busq) && $busq != "") {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM publisher 
                   WHERE ((publisherCodigo!='$codigo') AND (publisherNombre LIKE '%$busq%' 
                   OR publisherEncargado LIKE '%$busq%' OR publisherCodigo LIKE '%$busq%'))  
                   ORDER BY publisherNombre ASC LIMIT $inicio,$registros";
            $paginaURL = "publisherbusq";
        } else {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM publisher 
                   WHERE publisherCodigo!='$codigo'
                   ORDER BY publisherNombre ASC LIMIT $inicio,$registros";
            $paginaURL = "publisherlists";
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
                           <th class="text-center">NOMBRE</th>
                           <th class="text-center">TELÉFONO</th>
                           <th class="text-center">EMAIL</th>
                           <th class="text-center">ENCARGADO</th>';
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

        /**Con esto hacemos que si alguien escribe un numero mayor al total de páginas (según la cantidad de registros)
         * ésto muestre la tabla de que no hay registros en la BD
         */
        if ($total >= 1 && $pagina <= $totalPaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
                   <tr>
                       <td>' . $contador . '</td>
                       <td>' . $rows['publisherNombre'] . '</td>
                       <td>' . $rows['publisherTlfn'] . '</td>
                       <td>' . $rows['publisherEmail'] . '</td>
                       <td>' . $rows['publisherEncargado'] . '</td>';
                if ($privilegio <= 2) {
                    $tabla .= '
    
                       <td>
                           <a href="' . SERVERURL . 'actupublisher/' . modeloPrincipal::encryption($rows['publisherCodigo']) . '/"  class="btn btn-success btn-raised btn-xs">
                               <i class="zmdi zmdi-refresh"></i>
                           </a>
                       </td>';
                }
                if ($privilegio == 1) {
                    $tabla .= '
                           <td>
                               <form action="' . SERVERURL . 'ajax/publisherAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
                               <input type="hidden" name="codDelete" value="' . modeloPrincipal::encryption($rows['publisherCodigo']) . '" >
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


    //Con este controlador traemos los datos de la tabla de Publishers
    //La consulta "Unico" NO va a estar disponible para esta version, pero la dejo para el futuro
    public function dataPublisherController($tipoConsulta, $codigoPublisher)
    {
        $codigoPublisher = modeloPrincipal::decryption($codigoPublisher);
        $tipoConsulta = modeloPrincipal::cleanInsert($tipoConsulta);

        return modeloPublisher::dataPublisherModel($tipoConsulta, $codigoPublisher);
    }

    //Con este controlador eliminamos al publisher
    public function deletePublisherController()
    {
        //primero desencriptamos los values del formulario de BORRAR
        $codigo = modeloPrincipal::decryption($_POST['codDelete']);
        $privAdm = modeloPrincipal::decryption($_POST['privilegioAdmin']);
        //limpiamos cualquier inserción de datos que pueda ocurrir
        $codigo = modeloPrincipal::cleanInsert($codigo);
        $privAdm = modeloPrincipal::cleanInsert($privAdm);

        if ($privAdm == 1) {
            $consulta = modeloPrincipal::executeQuery("SELECT id FROM publisher Where publisherCodigo='$codigo'");
            $dataPublisher = $consulta->fetch();

            $delPublisher = modeloPublisher::deletePublisherModel($codigo);

            if ($delPublisher->rowCount() >= 1) {
                $alert = [
                    "Alert" => "actualizar",
                    "Titulo" => "ÉXITO",
                    "Texto" => "Publisher eliminado correctamente",
                    "Tipo" => "success"
                ];
            } else {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "No se ha podido eliminar la Publisher",
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

    public function updatePublisherController()
    {
        $nombre = modeloPrincipal::cleanInsert($_POST['nombre-up']);
        $encargado = modeloPrincipal::cleanInsert($_POST['encargado-up']);
        $telefono = modeloPrincipal::cleanInsert($_POST['telefono-up']);
        $direccion = modeloPrincipal::cleanInsert($_POST['direccion-up']);
        $email = modeloPrincipal::cleanInsert($_POST['email-up']);
        $publisherCodigo = modeloPrincipal::cleanInsert($_POST['codigo-up']);

        $dataPublisher = [
            "codigo" => $publisherCodigo,
            "nombre" => $nombre,
            "encargado" => $encargado,
            "tlfn" => $telefono,
            "email" => $email,
            "dir" => $direccion

        ];
        $insertarPublisher = modeloPublisher::updatePublisherModel($dataPublisher);
        //Comprobamos si el publisher se ha registrado satisfactoriamente
        if ($insertarPublisher->rowCount() >= 1) {
            $alert = [
                "Alert" => "actualizar",
                "Titulo" => "ÉXITO",
                "Texto" => "El Publisher se actualizó satisfactoriamente",
                "Tipo" => "success"
            ];
        } else {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "No se ha actualizado el Publisher",
                "Tipo" => "error"
            ];
        }
        return modeloPrincipal::sweetAlert($alert);
    }
}
