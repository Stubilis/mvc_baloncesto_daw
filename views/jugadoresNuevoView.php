<!-- Vista para añadir un nuevo item a la tabla -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./css/estilos.css" rel="stylesheet" type="text/css" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
	<!-- Formulario para insertar un nuevo jugador --> 
	<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="Jugadores">
		<input type="hidden" name="accion" value="nuevo">

		<?php echo isset($errores["nombre_jugador"]) ? "*" : "" ?>
		<label for="nombre_jugador">Nombre</label>
		<input type="text" name="nombre_jugador">
		</br>

		<?php echo isset($errores["fecha_nacimiento"]) ? "*" : "" ?>
		<label for="fecha_nacimiento">Nacimiento</label>
		<input type="date" name="fecha_nacimiento">
		</br>
		
		<?php echo isset($errores["estatura"]) ? "*" : "" ?>
		<label for="estatura">Estatura</label>
		<input type="number" name="estatura">
		</br>
		<?php echo isset($errores["posicion"]) ? "*" : "" ?>
		<label for="posicion">Posición</label>
		<input type="text" name="posicion">
		</br>
		<?php
		// Desplegable de Equipos
		echo isset($errores["equipo"]) ? "*" : "" ?>
      <label for="equipo" >Equipo:</label>
      <select id="equipo" name="equipo" >
        <?php 
          // Recorremos el array de equipos para poblar el filtro con un bucle foreach
          foreach ($equipos as $equipo){
            echo "<option value=".$equipo->getCOD_EQUIPO()." >".$equipo->getCOD_EQUIPO()." ".$equipo->getNOMBRE_EQUIPO()."
                  </option>";
          }
        ?>
		</select>
		</br>

		<input type="submit" name="submit" value="Aceptar">
		<a href="index.php?controlador=Jugadores&accion=listar" class="btnCancelar">Cancelar</a>
	</form>
	</br>

	<?php
	// Si hay errores se muestran
	if (isset($errores)):
		foreach ($errores as $key => $error):
			echo $error . "</br>";
		endforeach;
	endif;
	?>

</body>

</html>