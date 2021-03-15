<?php

// Incluir las clases MySQL y Consulta
include 'MySQL.php';
include 'consulta.php';

// Conectamos con la base de datos
$bd = new MySQL("admin", "admin", "192.168.1.67", "campions");


//variable post externa
$post;

//creamos los array para los datos del post
$jugadorArgs = array(
    'id'        => FILTER_SANITIZE_ENCODED,
    'nombre'    => FILTER_SANITIZE_ENCODED,
    'nivel'     => FILTER_SANITIZE_ENCODED,
    'fecha'     => FILTER_SANITIZE_ENCODED,
);

$campioArgs = array(
    'id'        => FILTER_SANITIZE_ENCODED,
    'nombre'    => FILTER_SANITIZE_ENCODED,
    'tipo'      => FILTER_SANITIZE_ENCODED,
    'precio'    => FILTER_SANITIZE_ENCODED,
    'fecha'     => FILTER_SANITIZE_ENCODED,
);

$batallaArgs = array(
    'idJ'        => FILTER_SANITIZE_ENCODED,
    'idC'        => FILTER_SANITIZE_ENCODED,
    'cantidad'   => FILTER_SANITIZE_ENCODED,
);






//switch controler form------------------------------------


if(!empty($_POST)){
    action_campions($post, $bd);
}

function action_campions($post, $bd){
    switch ($_POST) {
        case $_POST["form"] == "jugador":
            //declaración variable global
            global $jugadorArgs;
           //permite introducir los datos del formulario a la query
            $post=filter_input_array(INPUT_POST, $jugadorArgs);
              
            //Controlamos si el value del form es crear, eliminar o modificar y depende de cual sea hacer la de la query,
            //con los datos del post y la conexión de la base de datos
            if($_POST["accion"] == 'crear'){insertJugador($post, $bd);}
            else if($_POST["accion"] == 'eliminar'){deleteJugador($post, $bd);}
            else if($_POST["accion"] == 'modificar'){updateJugador($post, $bd);}

            break;

        case $_POST["form"] == 'campio':
            //declaración variable global
            global $campioArgs;
            $post=filter_input_array(INPUT_POST, $campioArgs);

            //Controlamos si el value del form es crear, eliminar o modificar y depende de cual sea hacer la de la query,
            //con los datos del post y la conexión de la base de datos
            if($_POST["accion"] == 'crear'){insertCampeon($post, $bd);}
            else if($_POST["accion"] == 'eliminar'){deleteCampeon($post, $bd);}
            else if($_POST["accion"] == 'modificar'){updateCampeon($post, $bd);}
      
            break;

        case $_POST["form"] == 'batalla':
            //declaración variable global
            global $batallaArgs;
            $post=filter_input_array(INPUT_POST, $batallaArgs);

            //Controlamos si el value del form es crear, eliminar o modificar y depende de cual sea hacer la de la query,
            //con los datos del post y la conexión de la base de datos
            if($_POST["accion"] == 'crear'){insertBatalla($post, $bd);}
            else if($_POST["accion"] == 'eliminar'){deleteBatalla($post, $bd);}
            else if($_POST["accion"] == 'modificar'){updateBatalla($post, $bd);}
           
            break;
        default:
           echo"error switch";
    }

}


//JUGADOR-----

//INSERT JUGADOR
function insertJugador($jugadorinsert, $bd){
    $id=$jugadorinsert['id'];
    $nombre=$jugadorinsert['nombre'];
    $nivel=(int)$jugadorinsert['nivel'];
    $fecha=$jugadorinsert['fecha'];

    $query = "INSERT INTO jugador (id, nombre, nivel, fecha) VALUES ('$id', '$nombre', '$nivel', '$fecha')";
    new Consulta($query, $bd);
}

//DELETE JUGADOR
function deleteJugador($jugadordelete, $bd){
    $id=$jugadordelete['id'];

    $query = "DELETE FROM jugador WHERE id=$id";
    new Consulta($query, $bd);
}


//UPDATE JUGADOR
function updateJugador($jugadorupdate, $bd){
    $id=$jugadorupdate['id'];
    $nombre=$jugadorupdate['nombre'];
    $nivel=(int)$jugadorupdate['nivel'];
    $fecha=$jugadorupdate['fecha'];

    $query = "UPDATE jugador SET nombre='$nombre', nivel='$nivel', fecha='$fecha' WHERE id=$id";
    new Consulta($query, $bd);
}



//CAMPEON-----

//INSERT CAMPEON
    function insertCampeon($campioinsert, $bd){
        $id=$campioinsert['id'];
        $nombre=$campioinsert['nombre'];
        $tipo=$campioinsert['tipo'];
        $precio=(int)$campioinsert['precio'];
        $fecha=$campioinsert['fecha'];
    
        $query = "INSERT INTO campeon (id, nombre, tipo, precio, fecha) VALUES ('$id', '$nombre', '$tipo', '$precio', '$fecha')";
        new Consulta($query, $bd);
    }

//DELETE CAMPEON
function deleteCampeon($campiodelete, $bd){
    $id=$campiodelete['id'];

    $query = "DELETE FROM campeon WHERE id=$id";
    new Consulta($query, $bd);
}


//UPDATE CAMPEON
function updateCampeon($campioupdate, $bd){
    $id=$campioupdate['id'];
    $nombre=$campioupdate['nombre'];
    $tipo=$campioupdate['tipo'];
    $precio=(int)$campioupdate['precio'];
    $fecha=$campioupdate['fecha'];

    $query = "UPDATE campeon SET nombre='$nombre', tipo='$tipo', precio='$precio', fecha='$fecha' WHERE id=$id";
    new Consulta($query, $bd);
}


//BATALLA----

//INSERT BATALLA
function insertBatalla($batallainsert, $bd){
    $idJugador=$batallainsert['idJ'];
    $idCampeon=$batallainsert['idC'];
    $cantidad=(int)$batallainsert['cantidad'];

    $query = "INSERT INTO batalla (idJugador, idCampeon, cantidad) VALUES ('$idJugador', '$idCampeon', '$cantidad')";
    new Consulta($query, $bd);
}

//DELETE BATALLA
function deleteBatalla($batalladelete, $bd){
    $idJugador=$batalladelete['idJ'];
    $idCampeon=$batalladelete['idC'];

    $query = "DELETE FROM batalla WHERE idJugador='$idJugador' AND idCampeon='$idCampeon'";
    new Consulta($query, $bd);
}

//UPDATE BATALLA
function updateBatalla($batallaupdate, $bd){
    $idJugador=$batallaupdate['idJ'];
    $idCampeon=$batallaupdate['idC'];
    $cantidad=(int)$batallaupdate['cantidad'];
    
    $query = "UPDATE batalla SET cantidad='$cantidad' WHERE idJugador='$idJugador' AND idCampeon='$idCampeon'";
    new Consulta($query, $bd);
}




//GET DE LAS TABLAS----

//GET JUGADORES
function getJugadores($bd){
    $query = ("SELECT * FROM jugador");
    $query = new Consulta($query, $bd);
    return $query;
    
}

//GET CAMPEONES
function getCampeones($bd){
    $query = ("SELECT * FROM campeon");
    $query = new Consulta($query, $bd);
    return $query;
}

//GET BATALLAS
function getBatallas($bd){
    $query = ("SELECT * FROM batalla");
    $query = new Consulta($query, $bd);
    return $query;
}
//-----------------







?>