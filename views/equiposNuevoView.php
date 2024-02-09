<!-- Vista para añadir un nuevo item a la tabla -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./css/estilos.css" rel="stylesheet" type="text/css" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
	<!-- Formulario para insertar un nuevo equipo --> 
	<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="Equipos">
		<input type="hidden" name="accion" value="nuevo">

		<?php echo isset($errores["nombre_equipo"]) ? "*" : "" ?>
		<label for="nombre_equipo">Nombre</label>
		<input type="text" name="nombre_equipo">
		</br>

		<?php echo isset($errores["fecha_fundacion"]) ? "*" : "" ?>
		<label for="fecha_fundacion">Fundación</label>
		<input type="date" name="fecha_fundacion">
		</br>
		
		<?php echo isset($errores["presupuesto"]) ? "*" : "" ?>
		<label for="presupuesto">Presupuesto</label>
		<input type="number" name="presupuesto">
		</br>
        <?php echo isset($errores["titulos"]) ? "*" : "" ?>
		<label for="titulos">Titulo</label>
		<input type="number" name="titulos">
		</br>
		
		<?php
		// Desplegable de Zonas
		echo isset($errores["zona"]) ? "*" : "" ?>
      <label for="zona" >Zona:</label>
      <select id="zona" name="zona" >
        <?php 
          // Recorremos el array de zonas para poblar el filtro con un bucle foreach
          foreach ($zonas as $zona){
            echo "<option value=".$zona->getCOD_ZONA()." >".$zona->getCOD_ZONA()." ".$zona->getNOMBRE_ZONA()."
                  </option>";
          }
        ?>
		</select>
        </br>

		<input type="submit" name="submit" value="Aceptar">
		<a href="index.php?controlador=Equipos&accion=listar">Cancelar</a>
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