<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../archConfGeneral/database.php";
} else {
    require_once "./archConfGeneral/database.php";
}
class modeloPrincipal
{
    protected function conectDB()
    {
        $link = new PDO(SGBD, DBUSER, DBPASS);
        return $link;
    }
    protected function executeQuery($query)
    {
        $ejecucion = self::conectDB()->prepare($query);
        $ejecucion->execute();
        return $ejecucion;
    }
    //con esta función añadimos una cuenta en BD
    protected function addAccount($data)
    {
        $sql = self::conectDB()->prepare("INSERT INTO cuenta(cuentaCodigo,cuentaPrivg,cuentaAlias,cuentaPass,cuentaEmail,cuentaEstado,cuentaTipo,cuentaGenero,cuentaFoto)
         VALUES(:codigo,:privilegios,:alias,:pass,:email,:estado,:tipo,:genero,:foto)");
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->bindParam(":privilegios", $data['privilegios']);
        $sql->bindParam(":alias", $data['alias']);
        $sql->bindParam(":pass", $data['pass']);
        $sql->bindParam(":email", $data['email']);
        $sql->bindParam(":estado", $data['estado']);
        $sql->bindParam(":tipo", $data['tipo']);
        $sql->bindParam(":genero", $data['genero']);
        $sql->bindParam(":foto", $data['foto']);
        $sql->execute(); //quizás tengo que cambiar algo aquí
        return $sql;
    }
    //con esta función eliminamos una cuenta en BD
    protected function deleteAccount($codigo)
    {
        $sql = self::conectDB()->prepare("DELETE FROM cuenta WHERE cuentaCodigo=:codigo");
        $sql->bindParam(":codigo", $codigo);
        $sql->execute();
        return $sql;
    }

    //Con esta función traemos los datos de una cuenta en BD
    protected function dataAccount($codigo, $tipo)
    {
        $sql = modeloPrincipal::conectDB()->prepare("SELECT * FROM cuenta WHERE cuentaCodigo=:codigo AND cuentaTipo=:tipo");
        $sql->bindParam(":codigo", $codigo);
        $sql->bindParam(":tipo", $tipo);
        $sql->execute();
        return $sql;
    }
    //con esta función actualizamos una cuenta en BD
    protected function updateAccount($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("UPDATE cuenta SET cuentaPrivg=:privilegio,
         cuentaAlias=:alias, cuentaPass=:pass, cuentaEmail=:email, cuentaEstado=:estado,
         cuentaGenero=:genero, cuentaFoto=:foto WHERE cuentaCodigo=:codigo");
        $sql->bindParam(":privilegio", $data['cuentaPrivg']);
        $sql->bindParam(":alias", $data['cuentaAlias']);
        $sql->bindParam(":pass", $data['cuentaPass']);
        $sql->bindParam(":email", $data['cuentaEmail']);
        $sql->bindParam(":estado", $data['cuentaEstado']);
        $sql->bindParam(":genero", $data['cuentaGenero']);
        $sql->bindParam(":foto", $data['cuentaFoto']);
        $sql->bindParam(":codigo", $data['cuentaCodigo']);
        $sql->execute();
        return $sql;
    }
    //Encriptamos una contraseña con hash
    public function encryption($string)
    {
        $output = false;
        $key = hash("sha256", SECRET_KEY);
        $iv = substr(hash("sha256", SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
    //Desencriptamos una contraseña con hash
    protected function decryption($string)
    {
        $output = false;
        $key = hash("sha256", SECRET_KEY);
        $iv = substr(hash("sha256", SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }
    //generamos claves aleatorias
    protected function primaryKey($case, $length, $num)
    {
        for ($i = 1; $i <= $length; $i++) {
            $number = rand(0, 9); //quizás tenga que cambiar este numero a 5
            $case .= $number;
        }

        return $case . "-" . $num;
    }
    /**
     * Con esta función evitamos algunos errores a la hora de insertar datos
     * y también incluimos algo de seguridad
     * 
     */
    protected function cleanInsert($insert)
    {
        //quitamos los espacios "accidentales"
        $insert = trim($insert);
        //eliminamos el caracter slash "/"
        $insert = stripcslashes($insert);
        //Con esto reemplazamos el valor que queramos
        $insert = str_ireplace("<script>", "", $insert);
        $insert = str_ireplace("<script src", "", $insert);
        $insert = str_ireplace("</script>", "", $insert);
        $insert = str_ireplace("<script type=>", "", $insert);
        $insert = str_ireplace("DELETE * FROM", "", $insert);
        $insert = str_ireplace("SELECT * FROM", "", $insert);
        $insert = str_ireplace("INSERT * FROM", "", $insert);
        return $insert;
    }

    protected function almacenarHistoricoSesiones($data)
    {
        $sql = self::conectDB()->prepare("INSERT INTO historico(histCodigo,histFecha,histHoraInicio,histHoraFinal,histTipo,histAnno,cuentaCodigo)
         VALUES(:codigo,:fecha,:horaInicio,:horaFinal,:tipo,:anno,:cuenta)");
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->bindParam(":fecha", $data['fecha']);
        $sql->bindParam(":horaInicio", $data['horaInicio']);
        $sql->bindParam(":horaFinal", $data['horaFinal']);
        $sql->bindParam(":tipo", $data['tipo']);
        $sql->bindParam(":anno", $data['anno']);
        $sql->bindParam(":cuenta", $data['cuenta']);
        $sql->execute();
        return $sql;
    }

    protected function horaFinal($codigo, $hora)
    {
        $sql = self::conectDB()->prepare("UPDATE historico SET histHoraFinal=:hora WHERE histCodigo=:codigo");
        $sql->bindParam(":hora", $hora);
        $sql->bindParam(":codigo", $codigo);
        $sql->execute();
        return $sql;
    }

    protected function eliminarHistoricoSesiones($codigo)
    {
        $sql = self::conectDB()->prepare("DELETE FROM historico WHERE cuentaCodigo=:codigo");
        $sql->bindParam(":codigo", $codigo);
        $sql->execute();
        return $sql;
    }

    protected function sweetAlert($info) //version de sweetAlert2 6.11
    {
        if ($info['Alert'] == "simple") {
            $mensaje = "
                <script>
                swal(
                    '" . $info['Titulo'] . "',
                    '" . $info['Texto'] . "',
                    '" . $info['Tipo'] . "'
                );
                </script>
            ";
        } elseif ($info['Alert'] == "actualizar") {
            $mensaje = "
					<script>
						swal({
						  title: '" . $info['Titulo'] . "',
						  text: '" . $info['Texto'] . "',
						  type: '" . $info['Tipo'] . "',
						  confirmButtonText: 'Aceptar'
						}).then(function () {
							location.reload();
						});
					</script>
				";
        } elseif ($info['Alert'] == "registro") {
            $mensaje = "
					<script>
						swal({
						  title: '" . $info['Titulo'] . "',
						  text: '" . $info['Texto'] . "',
						  type: '" . $info['Tipo'] . "',
						  confirmButtonText: 'Aceptar'
						}).then(function () {
                            window.location.href=\"".SERVERURL."login/\";
						});
					</script>
				";
        } elseif ($info['Alert'] == "limpiar") {
            $mensaje = "
            <script>
            swal({
                title: '" . $info['Titulo'] . "',
                text: '" . $info['Texto'] . "',
                type: '" . $info['Tipo'] . "',
                confirmButtonText: 'Aceptar'
              }).then(function() {
                    $('.FormularioAjax')[0].reset();
            });
            </script>
        ";
        }
        return $mensaje;
    }

    protected function fotosPerfilGatosAPI()
    {
        $json = file_get_contents('https://aws.random.cat/meow');
        $datos = json_decode($json, true);
        $imagen = $datos['file'];
        return $imagen;
    }
    protected function fotosPerfilPerrosAPI()
    {
        $json = file_get_contents('https://dog.ceo/api/breeds/image/random');
        $datos = json_decode($json, true);
        $imagen = $datos['message'];
        return $imagen;
    }
}
