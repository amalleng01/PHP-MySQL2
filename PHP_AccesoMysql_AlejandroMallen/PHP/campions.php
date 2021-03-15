
<?php
    include 'controlador.php';
?> 



<!DOCTYPE html>
<html>
    <head>
        <title>Campions</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styleGestor.css" rel="stylesheet"/>
        <script src=""></script>
    </head>
    <body>
	<header>
            <h1>Gestor Campions</h1>
	</header>
	<section>
            <div class="crearModificarJugador">
                <h3>Crear/Modificar Jugador</h3>
                <form action="campions.php" method="post">
                    <input type="hidden" name="form" value="jugador">
                    <input type="text" name="id" placeholder="Id" /><br /><br />
                    <input type="text" name="nombre" placeholder="Nom"/><br /><br />
                    <input type="number" name="nivel" placeholder="Nivell"/><br /><br />
                    <input type="date" name="fecha" placeholder="Data alta" /><br /><br />
                    <label><input type="radio" name="accion" value="crear" checked> Crear</label><br />
                    <label><input type="radio" name="accion" value="modificar"> Modificar<br /></label><br />
                    <input type="submit" value="Aceptar" name="btnJugador">
                </form>
                
            </div>
            <div class="crearModificarCampio">
                <h3>Crear/Modificar Campió</h3>
                <form action="campions.php" method="post">
                    <input type="hidden" name="form" value="campio">
                    <input type="text" name="id" placeholder="Id"/><br /><br />
                    <input type="text" name="nombre" placeholder="Nom"/><br /><br />
                    <input type="text" name="tipo" placeholder="Tipus"/><br /><br />
                    <input type="number" name="precio" placeholder="Preu" /><br /><br />
                    <input type="date" name="fecha" placeholder="Data alta" /><br /><br />
                    <label><input type="radio" name="accion" value="crear" checked> Crear</label><br />
                    <label><input type="radio" name="accion" value="modificar"> Modificar<br /></label><br />
                    <input type="submit" value="Aceptar">
                </form>
            </div>
            <div class="crearModificarBatalla">
                <h3>Crear / Modificar Batalla</h3>
                <form action="campions.php" method="post">
                    <input type="hidden" name="form" value="batalla">
                    <input type="text" name="idJ" placeholder="Id jugador"/><br /><br />
                    <input type="text" name="idC" placeholder="Id Campió"/><br /><br />
                    <input type="number" name="cantidad" placeholder="Cantitat" /><br /><br />
                    <label><input type="radio" name="accion" value="crear" checked> Crear</label><br />
                    <label><input type="radio" name="accion" value="modificar"> Modificar<br /></label><br />
                    <input type="submit" value="Aceptar">
                </form>
            </div>
            <div class="eliminar">
                <h3>Eliminar</h3>
                <form action="campions.php" method="post">
                    <input type="hidden" name="form" value="jugador">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="text" name="id" placeholder="Id jugador"/><br />
                    <input type="submit" value="Eliminar"><br>
                </form>
                <form action="campions.php" method="post">
                    <input type="hidden" name="form" value="campio">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="text" name="id" placeholder="Id campió"/><br />
                    <input type="submit" value="Eliminar"><br>
                </form>
                <form action="campions.php" method="post">
                    <input type="hidden" name="form" value="batalla">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="text" name="idJ" placeholder="Id jugador"/><br /><br />
                    <input type="text" name="idC" placeholder="Id campió"/><br /><br />
                    <input type="submit" value="Eliminar">
                </form>
                
            </div>
        </section>
      
        <aside>
            <div class="jugadors">
                <h3>Jugadors</h3>
                <?php
                    $jugadores = getJugadores($bd);
                    if( !is_null($jugadores) ){
                        echo '<table class="tablaJugador">';
                        echo '<tr><th>Id</th><th>Nom</th><th>Nivell</th><th>Data</th></tr>';

                        // Bucle foreach que recorre cada posicion del array $jugadores
                        // y escribe una fila con tantas columnas como atributos tiene jugadores
                        for ($i = 0; $i < $jugadores->numFilasObtenidas; $i++)
                            echo "<tr><td>".$jugadores->tablaResultados[$i]->id.
                                "</td><td>".$jugadores->tablaResultados[$i]->nombre.
                                "</td><td>".$jugadores->tablaResultados[$i]->nivel.
                                "</td><td>".$jugadores->tablaResultados[$i]->fecha."</td></tr>";
                        
                        echo '</table>';
                    }
                ?>
            </div>
            <div class="relacions">
                <h3>Batalles</h3>
                <?php
                    $batallas = getBatallas($bd);
                    if( !is_null($batallas) ){
                        echo '<table class="tablaBatalla">';
                        echo '<tr><th>Id Jugador</th><th>Id Campeón</th><th>Cantidad</th>';
                        
                        // Bucle foreach que recorre cada posicion del array $batallas
                        // y escribe una fila con tantas columnas como atributos tiene un una batalla
                        for ($i = 0; $i < $batallas->numFilasObtenidas; $i++)
                            echo "<tr><td>".$batallas->tablaResultados[$i]->idJugador.
                                "</td><td>".$batallas->tablaResultados[$i]->idCampeon.
                                "</td><td>".$batallas->tablaResultados[$i]->cantidad."</td></tr>";
                              
                        echo '</table>';
                    }
                ?>
            </div>
            <div class="campions">
                <h3>Campions</h3>
                <?php
                    $campeones = getCampeones($bd);
                    if( !is_null($campeones) ){
                        echo '<table class="tablaCampeon">';
                        echo '<tr><th class="campeon">Id</th><th>Nom</th><th>Tipus</th><th>Preu</th><th>Data</th></tr>';
                        
                        // Bucle foreach que recorre cada posicion del array $campeones
                        // y escribe una fila con tantas columnas como atributos tiene un campeon
                        for ($i = 0; $i < $campeones->numFilasObtenidas; $i++)
                            echo "<tr><td>".$campeones->tablaResultados[$i]->id.
                                "</td><td>".$campeones->tablaResultados[$i]->nombre.
                                "</td><td>".$campeones->tablaResultados[$i]->tipo.
                                "</td><td>".$campeones->tablaResultados[$i]->precio.
                                "</td><td>".$campeones->tablaResultados[$i]->fecha."</td></tr>";
                        
                        echo '</table>';
                    }
                ?>
            </div>
	</aside>
   
    </body>
</html>

