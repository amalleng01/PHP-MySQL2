<?php
/**
 * Clase Consulta: para facilitar la realización de consultas.
 * Retorna un array con los resultados.
 * 
 */
class Consulta {
    var $bd;                    //conexion mysql, requerido para llamar funciones de la clase MySQL
    var $consulta;              //query introducida
    var $numResultados;         //numero de resultados
    var $tablaResultados;       //los resultados en una tabla de objetos
    var $numFilasObtenidas;     //numero de filas afectadas por la query

    function __construct($consulta,$bd){
        //ejecuta la consulta y rellena las propiedades del objeto
        $this->consulta                 = $consulta;
        $this->bd                       = $bd;
        $mysql_result                   = mysqli_query($bd->conn, $consulta) or $this->bd->error_mysql($bd->conn->error, $consulta );
        $this->numResultados            = @mysqli_num_rows($mysql_result);
        $this->numFilasObtenidas        = mysqli_affected_rows($bd->conn);

        if( $this->numResultados ) 
            for( $i=0; $i<$this->numResultados; $i++)   $tabla[$i] = mysqli_fetch_object($mysql_result);
        else $tabla = null;

        $this->tablaResultados = $tabla;
        if(  $this->numResultados > 0  ) mysqli_free_result($mysql_result);
    }
    public function Consulta($consulta,$conexion){
            //constructor
            $argcv = func_get_args();
            call_user_func_array(array(&$this, '__construct'), $argcv);
    } 
}
?>