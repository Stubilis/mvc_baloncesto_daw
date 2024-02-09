<!-- Vista para añadir un nuevo item a la tabla -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./css/estilos.css" rel="stylesheet" type="text/css" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
	<!-- Formulario para insertar un nuevo partido --> 
	<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="Partidos">
		<input type="hidden" name="accion" value="nuevo">

		<?php echo isset($errores["fecha"]) ? "*" : "" ?>
		<label for="fecha">Fecha</label>
		<input type="date" name="fecha">
		</br>

        <?php
		// Desplegable cod_equipo1
		echo isset($errores["cod_equipo1"]) ? "*" : "" ?>
      <label for="cod_equipo1" >Equipo:</label>
      <select id="equipo" name="cod_equipo1" >
        <?php 
          // Recorremos el array de equipos para poblar el filtro con un bucle foreach
          foreach ($equipos as $equipo){
            echo "<option value=".$equipo->getCOD_EQUIPO()." >".$equipo->getCOD_EQUIPO()." ".$equipo->getNOMBRE_EQUIPO()."
                  </option>";
          }
        ?>
		</select>
		<?php echo isset($errores["puntos_equipo1"]) ? "*" : "" ?>
		<label for="puntos_equipo1">Puntos primer equipo:</label>
		<input type="number" name="puntos_equipo1">
		</br>
        <?php
        // Desplegable cod_equipo2
		echo isset($errores["cod_equipo2"]) ? "*" : "" ?>
      <label for="cod_equipo2" >Equipo:</label>
      <select id="cod_equipo2" name="cod_equipo2" >
        <?php 
          // Recorremos el array de equipos para poblar el filtro con un bucle foreach
          foreach ($equipos as $equipo){
            echo "<option value=".$equipo->getCOD_EQUIPO()." >".$equipo->getCOD_EQUIPO()." ".$equipo->getNOMBRE_EQUIPO()."
                  </option>";
          }
        ?>
		</select>
        <?php echo isset($errores["puntos_equipo2"]) ? "*" : "" ?>
		<label for="puntos_equipo2">Puntos segundo equipo:</label>
		<input type="number" name="puntos_equipo2">
		</br>

		<input type="submit" name="submit" value="Aceptar">
		<a href="index.php?controlador=Partidos&accion=listar" class="btnCancelar">Cancelar</a>
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