<!-- Vista para añadir un nuevo item a la tabla -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./css/estilos.css" rel="stylesheet" type="text/css" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
	<!-- Formulario para insertar una nueva zona --> 
	<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="Zonas">
		<input type="hidden" name="accion" value="nuevo">

		<?php echo isset($errores["nombre_zona"]) ? "*" : "" ?>
		<label for="nombre_zona">Nombre</label>
		<input type="text" name="nombre_zona">
		</br>
		<input type="submit" name="submit" value="Aceptar">
		<a href="index.php?controlador=Zonas&accion=listar" class="btnCancelar">Cancelar</a>
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