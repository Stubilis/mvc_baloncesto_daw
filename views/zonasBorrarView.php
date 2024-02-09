<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./css/estilos.css" rel="stylesheet" type="text/css" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
	<h2>¿Seguro que quiere eliminar <?php echo $zona->getNOMBRE_ZONA()?>?</h2>
	<p>Está acción es definitiva</p>
	<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="Zonas">
		<input type="hidden" name="accion" value="borrar">
		<input type="hidden" name="cod_zona" value="<?php echo $zona->getCOD_ZONA()?>">

		<button type="submit" name="submit" <?php if($errores!=null)echo'disabled' ?>>Aceptar</button>
		<a href="index.php?controlador=Zonas&accion=listar">Cancelar</a>
	</form>

	<?php
	// Si hay errores se muestran
	if (isset($errores)) {
		if($errores['borrarEquipos']!=null){
			echo "<h3>Hay equipos con esta zona asociada</h3>";
			echo "<table>";
                echo "<tr>";
                echo "<th>Código</th>";
                echo "<th>Equipo</th>";
				echo "<th>Cód. Zona</th>";
				echo "<th>Zona</th>";
				echo "<th></th>";
				echo "</tr>";
				foreach ($equipos as $equipo) {

					echo "<tr>";
					echo "<td>" . $equipo->getCOD_EQUIPO() . "</td>";
					echo "<td>" . $equipo->getNOMBRE_EQUIPO() . "</td>";
					echo "<td>" . $equipo->getZONA() . "</td>";
					echo "<td>" . $equipo->getNOMBRE_ZONA() . "</td>";
					//Añadimos un botón que nos lleva a la vista de borrado del equipo
					echo "<td><a class='btnBorrar' href='index.php?controlador=Equipos&accion=borrar&cod_equipo=" . $equipo->getCOD_EQUIPO() . "'>Borrar</a></td>";
					echo "</tr>";
				}
                
                echo "</table>";
				echo "<h3>Para borrar la zona deber eliminar los equipos asociados primero</h3>";
			
		}
	}
	?>
</body>

</html>
