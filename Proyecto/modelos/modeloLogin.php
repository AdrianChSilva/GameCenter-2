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

class modeloLogin extends modeloPrincipal
{
    protected function iniciarSesionModel($data){
        $sql=modeloPrincipal::conectDB()->prepare("SELECT * FROM cuenta WHERE cuentaAlias=:alias 
        AND cuentaPASS=:pass AND cuentaEstado='Activo'");
        $sql->bindParam(':alias', $data['alias']);
        $sql->bindParam(':pass', $data['pass']);
        $sql->execute();
        return $sql;
    }
    //Le pedimos al controlador los datos de la sesión, y si coinciden se procederá al correcto cierre del mismo
    protected function cerrarSesionModel($data){
        if($data['alias']!="" && $data['tokenS']==$data['token']){

            $actHistorico=modeloPrincipal::horaFinal($data['codigo'],$data['hora']);
            if ($actHistorico->rowCount()==1) {
                session_unset();
                session_destroy();
                $logout="true";
                
            }else{
                $logout="false";
            }

        }else{
            $logout="false";
        }
        return $logout;

    }
}