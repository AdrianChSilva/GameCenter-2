<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../archConfGeneral/modeloPrincipal.php";
} else {
    require_once "./archConfGeneral/modeloPrincipal.php";
}

class controladorCuenta extends modeloPrincipal
{
    //Con esta función devolveremos los datos de una cuenta dependiendo de si es administrador o usuario normal
    public function dataAccountController($codigo,$tipo)
    {
        $codigoCuenta = modeloPrincipal::decryption($codigo);
        $tipo=modeloPrincipal::cleanInsert($tipo);
        
        if($tipo=="admin"){
            $tipo="Administrador";
        }else{
            $tipo="Cliente";
        }
        return modeloPrincipal::dataAccount($codigoCuenta,$tipo);
    }

    //Con esta función actualizamos la cuenta del administrador o usuario
    public function updateAccountController()
    {
        $codigoCuenta = modeloPrincipal::decryption($_POST['codigoCuenta-up']);
        $tipoCuenta = modeloPrincipal::decryption($_POST['tipoCuenta-up']);
        /**
         * A la hora de actualizar una cuenta es necesario volver a introducir tus datos de sesión (login),
         * por ello comprobamos que los datos introducidos estén en base de datos y sean los del usuario
         * que está realizando los cambios
         */
        $consulta1 = modeloPrincipal::executeQuery("SELECT * FROM cuenta WHERE cuentaCodigo='$codigoCuenta'");
        $dataAccount = $consulta1->fetch();

        $userLogin = modeloPrincipal::cleanInsert($_POST['user-Log']); //recoge los datos del usuario que tiene la sesión iniciada y va a realizar los cambios.
        $passwordLog = modeloPrincipal::cleanInsert($_POST['pass-Log']); //siempre limpiamos las cadenas de texto que se introduzcan en los formularios, para evitar así imprevistos.
        $passwordLog = modeloPrincipal::encryption($passwordLog);

        if ($userLogin != "" && $passwordLog != "") {
            //hay que comprobar que si se está actualizando una cuenta, que no es la del usuario que tiene la sesión iniciada, se tenga los privilegios necesarios
            if (isset($_POST['privilegio-up'])) {//validamos que la clase micuenta-vista traiga el privilegio-up (linea 34). si lo trae es porque es un administrador y va a cambiar datos de una cuenta que no es suya, y si NO lo trae comprobamos que el usuario cambia SUS PROPIOS datos de cuenta
                $login = modeloPrincipal::executeQuery("SELECT id FROM cuenta WHERE cuentaAlias='$userLogin' AND cuentaPass='$passwordLog'");

            } else {
                $login = modeloPrincipal::executeQuery("SELECT id FROM cuenta WHERE cuentaAlias='$userLogin' AND cuentaPass='$passwordLog' AND cuentaCodigo='$codigoCuenta'");
            }

            //comprobamos que el usuario está registrado en la BD
            if ($login->rowCount() == 0) {

                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "No has introducido las credenciales correctamente",
                    "Tipo" => "error"
                ];
                return modeloPrincipal::sweetAlert($alert);
                exit();
            }

        } else {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "Debes introducir tus credenciales para actualizar los datos de la cuenta",
                "Tipo" => "error"
            ];
            return modeloPrincipal::sweetAlert($alert);
            exit();

        }


        //VERIFICAMOS EL EMAIL//
        $cuentaEmail = modeloPrincipal::cleanInsert($_POST['email-up']);
        if ($cuentaEmail != $dataAccount['cuentaEmail']) {
            $consulta2 = modeloPrincipal::executeQuery("SELECT cuentaEmail FROM cuenta WHERE cuentaEmail='$cuentaEmail'");
            if ($consulta2->rowCount() >= 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "Ese Email ya existe en la BD",
                    "Tipo" => "error"
                ];
                return modeloPrincipal::sweetAlert($alert);
                exit();

            }
        }


        //VERIFICAMOS EL ALIAS O NOMBRE DE USUARIO///
        $cuentaAlias = modeloPrincipal::cleanInsert($_POST['usuario-up']);
        if ($cuentaAlias != $dataAccount['cuentaAlias']) {
            $consulta3 = modeloPrincipal::executeQuery("SELECT cuentaAlias FROM cuenta WHERE cuentaAlias='$cuentaAlias'");
            if ($consulta3->rowCount() >= 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "Ese alias o nombre de usuario ya existe en la BD",
                    "Tipo" => "error"
                ];
                return modeloPrincipal::sweetAlert($alert);
                exit();

            }
        }


        //VERIFICAMOS EL CAMBIO DE CONTRASEÑA////
        $newPass1 = modeloPrincipal::cleanInsert($_POST['newPassword1-up']);
        $newPass2 = modeloPrincipal::cleanInsert($_POST['newPassword2-up']);
        /**
         * Esto quiere decir que si no hacemos un cambio en la contraseña, mantendremos (else) la que tenemos en la base de datos
         *  */
        if ($newPass1 != "" || $newPass2 != "") {
            if ($newPass1 != $newPass2) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "Las nueva contraseña no coincide, repita de nuevo",
                    "Tipo" => "error"
                ];
                return modeloPrincipal::sweetAlert($alert);
                exit();
            } else {
                $passCuenta=modeloPrincipal::encryption($newPass1);
            }
        } else {
            $passCuenta = $dataAccount['cuentaPass'];
        }


        $cuentaGenero = modeloPrincipal::cleanInsert($_POST['optionsGenero-up']);
        if (isset($_POST['optionsEstado-up'])) {
            $estadoCuenta = modeloPrincipal::cleanInsert($_POST['optionsEstado-up']);
        } else {
            $estadoCuenta = $dataAccount['cuentaEstado'];
        }

        if ($tipoCuenta == "admin") {
            if (isset($_POST['optionsPrivilegio-up'])) {
                $privilegioCuenta = modeloPrincipal::decryption($_POST['optionsPrivilegio-up']);
            } else {
                $privilegioCuenta = $dataAccount['cuentaPrivg'];
            }

            if ($cuentaGenero == "Femenino") {
                $fotoCuenta = modeloPrincipal::fotosPerfilGatosAPI();
            } elseif ($cuentaGenero == "Masculino") {
                $fotoCuenta = modeloPrincipal::fotosPerfilPerrosAPI();
            } else {
                $fotoCuenta = "https://cdn4.iconfinder.com/data/icons/twitter-ui-set/128/Egg_Proffile_And_Settings_Twitter-512.png";
            }

        } else {
            $privilegioCuenta = $dataAccount['cuentaPrivg'];
            if ($cuentaGenero == "Femenino") {
                $fotoCuenta = modeloPrincipal::fotosPerfilGatosAPI();
            } elseif ($cuentaGenero == "Masculino") {
                $fotoCuenta = modeloPrincipal::fotosPerfilPerrosAPI();
            } else {
                $fotoCuenta = "https://cdn4.iconfinder.com/data/icons/twitter-ui-set/128/Egg_Proffile_And_Settings_Twitter-512.png";
            }

        }

        //ENVIAMOS LOS DATOS AL MODELO
        $datosUpdate=[
            "cuentaPrivg"=>$privilegioCuenta,
            "cuentaCodigo"=>$codigoCuenta,
            "cuentaAlias"=>$cuentaAlias,
            "cuentaPass"=> $passCuenta,
            "cuentaEmail"=>$cuentaEmail,
            "cuentaEstado"=>$estadoCuenta,
            "cuentaGenero"=>$cuentaGenero,
            "cuentaFoto"=>$fotoCuenta
        ];

        if(modeloPrincipal::updateAccount($datosUpdate)){
            //si la variable privilegio viene definida, quiere decir que la cuenta que se está actualizando no es la mía, es decir, el que tiene la sesión ahora mismo
            /**
             * En este caso estoy diciendo que si la variable no viene definida, quiere decir que la cuenta que estoy intentando actualizar es la mía
             * entonces si hago cambios en ella, éstos se verán reflejados en el navegador lateral.
             */
            if(!isset($_POST['privilegio-up'])){
                session_start(['name' => 'GC']);
                $_SESSION['usuarioGC']=$cuentaAlias;
                $_SESSION['fotoGC']=$fotoCuenta;
            }
            $alert = [
                "Alert" => "actualizar",
                "Titulo" => "ÉXITO",
                "Texto" => "Se han actualizado los datos de la cuenta satisfactoriamente",
                "Tipo" => "success"
            ];
        }else{
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "No se pudo actualizar los datos de la cuenta",
                "Tipo" => "error"
            ];
        }
        return modeloPrincipal::sweetAlert($alert);

    }


}