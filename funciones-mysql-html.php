<?php
/**
 * Method creaTabla
 *
 * @param $datosConsulta $datosConsulta [proveniente de una consulta select en mysqli_query]
 *
 * @return una tabla con todas las filas de la consulta
 */
function creaTabla($datosConsulta){
    $html="<table>\n";
    $primera=true;
    while($fila=mysqli_fetch_array($datosConsulta,MYSQLI_ASSOC)){
        if($primera){
            $html.="<tr>";
            foreach(array_keys($fila) as $v){
                $html.="<th>$v</th>";
            }
            $html.="</tr>";
            $primera=false;
        }
        $html.="<tr>";
        foreach($fila as $k=>$v){
            $html.="<td>$v</td>";
        }
        $html.="</tr>\n";
    }
    $html.="</table>\n";
    return $html;
}

/**
 * Función para limpar variables evitando sql-injection
 *
 * @param [string] $array  array dónde estan las variables que quieres limpiar
 * @param [link Database] $conexionBD
 * @return[string]
 */
function escapaVariables($array,$conexionBD){
    $escapadas=array();
    foreach($array as $k => $v){
        $escapadas['$k']=mysqli_real_escape_string($conexionBD,$v);
    }
    return $escapadas;
}
