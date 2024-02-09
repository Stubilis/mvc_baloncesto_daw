<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./css/estilos.css" rel="stylesheet" type="text/css" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>
<body>
<h2>¿Seguro que quiere eliminar <?php echo $equipo->getNOMBRE_EQUIPO()?>?</h2>
    <p>Está acción NO se puede deshacer</p>
<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="Equipos">
		<input type="hidden" name="accion" value="borrar">
        <input type="hidden" name="cod_equipo" value="<?php echo $equipo->getCOD_EQUIPO()?>">

    <button type="submit" name="submit" <?php if($errores!=null)echo'disabled' ?>>Aceptar</button>
    <a href="index.php?controlador=Equipos&accion=listar">Cancelar</a>
</form>
<?php
if($errores!=null){
	// Si hay errores se muestran
	//if (isset($errores)) {
        echo "<h3>Para poder Borrar el equipo ".$equipo->getNOMBRE_EQUIPO()." tiene que eliminar:</h3>";
		
            if(isset($jugadores) && isset($errores['borrarJugadores'])){
               
                //Mostramos los jugadores asociados al equipo en forma de tabla
                echo '<h3>Jugadores asociados al equipo</h3>
                    <form action="index.php" method="post">
                    <input type="hidden" name="controlador" value="Equipos">
		            <input type="hidden" name="accion" value="borrarJugadores">
                    <input type="hidden" name="cod_equipo_jugador" value="'.$equipo->getCOD_EQUIPO().'">';
                echo '<button type="submit" class="btnBorrar" name="submitJugadores" title="Esta acción es definitiva" >Borrar Jugadores</button>';
                echo "</form>";                           
                echo "<table>";
                echo "<tr>";
                echo "<th>Código</th>";
                echo "<th>Nombre</th>";
                echo "<th>Fecha de nacimiento</th>";
                echo "<th>Equipo</th>";
                echo "</tr>";
                foreach ($jugadores as $jugador){
                    echo "<tr>";
                    echo "<td>" . $jugador->getCOD_JUGADOR() . "</td>";
                    echo "<td>" . $jugador->getNOMBRE_JUGADOR() . "</td>";
                    echo "<td>" . $jugador->getFECHA_NACIMIENTO() . "</td>";

                    echo "<td>" . $jugador->getNOMBRE_EQUIPO() . "</td>";
                    echo "</tr>";

            
                }
                echo "</table>
                </br>
                </br>";
	}
    
    if(isset($errores['borrarPartidos']) && isset($partidos)){
        //Mostramos los partidos asociados al equipo en forma de tabla
        echo '<h3>Partidos asociados al equipo</h3>
        <form action="index.php" method="post">
        <input type="hidden" name="controlador" value="Equipos">
        <input type="hidden" name="accion" value="borrarPartidos">
        <input type="hidden" name="cod_equipo_partido" value="'.$equipo->getCOD_EQUIPO().'">';
        echo '<button type="submit" class="btnBorrar" name="submitPartidos" title="Esta acción es definitiva" >Borrar Partidos</button>
             </form>';
        echo "<table>";
        echo "<tr>";
        echo "<th>Código</th>";
        echo "<th>Fecha</th>";
        echo "<th>Equipo 1</th>";
        echo "<th>Equipo 2</th>";
        echo "</tr>";
        foreach ($partidos as $partido){
            echo "<tr>";
            echo "<td>" . $partido->getCOD_PARTIDO() . "</td>";
            echo "<td>" . $partido->getFECHA() . "</td>";
            echo "<td>" . $partido->getNOMBRE_EQUIPO1() . "</td>";
            echo "<td>" . $partido->getNOMBRE_EQUIPO2() . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}


	?>
</body>

</html>
