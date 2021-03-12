<?php
/**
 * Clase MySQL: nos facilita la conexión a la bd y
 * controla sql-injection.
 * 
 */
class MySQL{
    var $usuario;   //nombre de usuario de la base de datos
    var $clave;     //contrasenia del usuario
    var $servidor;  //nombre del servidor, normalmente localhost
    var $nomBD;     //nombre de la base de datos
    var $conn;      //necesario para la conexion y desconexion de la base de datos
    var $debug;     //modo depuracion, mostrara los errores y los querys


    public function __construct($usuario, $clave, $servidor, $nomBD, $debug=1){
        //al llamarla conecta directametne a la base de datos

        $this->usuario      = $usuario;
        $this->clave        = $clave;
        $this->servidor     = $servidor;
        $this->nomBD        = $nomBD;
        $this->debug        = $debug;

        
	$this->conn = mysqli_connect($this->servidor, $this->usuario, $this->clave, $this->nomBD) or $this->error_mysql(mysqli_connect_error());
	mysqli_select_db($this->conn, $this->nomBD) or $this->error_mysql(mysqli_connect_errno());
	
        $this->selectCharset();
    }

    // De esta manera insertaremos los datos con una codificación determinada.
    function selectCharset( $charset = "utf8" ){

        $query = "SET NAMES '". $charset."'";
        mysqli_query( $this->conn, $query );
    }

    function MySQL($usuario, $clave, $servidor, $nomBD, $debug=0){
        //para que en php 4 haya un destructor como en php 5
        register_shutdown_function(array(&$this, '__destruct'));

        //constructor
        $argcv = func_get_args();
        call_user_func_array(array(&$this, '__construct'), $argcv);
    }

    function x(){
    //para cerrar la conexion mysql
    //se debe utilizar SIEMPRE al final del documento.
        if(isset($this->conn))mysqli_close($this->conn);
        unset($this->conn);
    }

    function error_mysql($msg,$query=''){
        //muestra el error
        if($this->debug==1 && !empty($query)) $msg .= '<br><b />QUERY:</b><br />'.$query;
        $this->enmarcar($msg);
        $this->x();
        die();
    }

    function enmarcar($str){
        //para mostrar los errores dentro de un rectangulo
        echo '<span style="display:block;border:1px red solid;padding:5px;">'.$str.'</span>';
    }

    function noInjection( $valor ){
        /*
        funcion para evitar ataques sql-injection, se debe utilizar al hacer querys.
        Ejemplo:
        $query1 = new query("select * from usuarios where nombre='".$bd->noInjection($_POST['nombre'])."' and password='".$bd->noInjection($_POST['password'])."'",$bd);
        */
        if(get_magic_quotes_gpc())
            $valor = stripslashes($valor);
        if( function_exists('mysql_real_escape_string') )
            return mysqli_real_escape_string( $valor );
        else //para PHP inferior a 4.3.0
            return addslashes( $valor );
    }

    function __destruct(){
        //el destructor se ejecuta antes de cerrar la ejecucion y con esto cerramos la conexion a la base de datos
        $this->x();
    }
}

?>