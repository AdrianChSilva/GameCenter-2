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
class controladorHistorico extends modeloPrincipal
{

    //Controlador que nos trae el histórico de sesiones al HOME, ordenado por los más recientes.
    public function HistoricoController($registros)
    {
        $registros = modeloPrincipal::cleanInsert($registros);
        $tabla = "";
        $consulta1 = "SELECT SQL_CALC_FOUND_ROWS * FROM historico 
        ORDER BY id DESC LIMIT $registros";
        $consulta2="SELECT cuenta.cuentaFoto, cuenta.cuentaAlias, historico.histHoraInicio, historico.histHoraFinal, historico.histFecha
        FROM cuenta
        INNER JOIN historico ON cuenta.cuentaCodigo = historico.cuentaCodigo
        ORDER BY historico.id DESC LIMIT $registros";

        $conex = modeloPrincipal::conectDB();
        $datos = $conex->query($consulta2);
        $fotos = $conex->query($consulta2);
        $datos = $datos->fetchAll();
        $fotos = $fotos->fetchAll();
        $pics = [];
        foreach($fotos as $rows2){
            $pics = $rows2;
        }
        $contador = 1;
        foreach($datos as $rows){
        $tabla .='  
            <div class="cd-timeline-block">
                <div class="cd-timeline-img">
                    <img src="'. $rows['cuentaFoto'].'" alt="user-picture">
                </div>
                <div class="cd-timeline-content">
                    <h4 class="text-center text-titles">'.$contador .' '.$rows['cuentaAlias'] .'</h4>
                    <p class="text-center">
                        <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>'.$rows['histHoraInicio'] .'</em> &nbsp;&nbsp;&nbsp; 
                        <i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>'.$rows['histHoraFinal'] .'</em>
                    </p>
                    <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> '.$rows['histFecha'].'</span>
                </div>
            </div>  ';
            $contador++;
        }
    
        return $tabla;

    }
}

