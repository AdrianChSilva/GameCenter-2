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

class controladorRegistro extends modeloUser
{   //Con este controlador añadimos a los clientes
    public function registerController()
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
                                    "Alert" => "registro",
                                    "Titulo" => "ÉXITO",
                                    "Texto" => "Te has registrado correctamente. Redireccionándote a la página de login",
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
                                    "Texto" => "No te has registrado correctamente",
                                    "Tipo" => "error"
                                ];
                            }
                        } else {
                            $alert = [
                                "Alert" => "simple",
                                "Titulo" => "ERROR",
                                "Texto" => "No te has registrado correctamente",
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
}
