<!-- Vista para editar un elemento de la tabla -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./css/estilos.css" rel="stylesheet" type="text/css" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>

<body>
	<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="Jugadores">
		<input type="hidden" name="accion" value="editar">

		<label for="cod_jugador">Código</label>
		<input type="text" name="cod_jugador" value="<?php echo $jugador->getCOD_JUGADOR(); ?>" readonly>
		</br>

		<?php echo isset($errores["nombre_jugador"]) ? "*" : "" ?>
		<label for="nombre_jugador">Nombre</label>
		<input type="text" name="nombre_jugador" value="<?php echo $jugador->getNOMBRE_JUGADOR(); ?>">
		</br>

		<?php echo isset($errores["fecha_nacimiento"]) ? "*" : "" ?>
		<label for="fecha_nacimiento">Nacimiento</label>
		<input type="text" name="fecha_nacimiento" value="<?php echo $jugador->getFECHA_NACIMIENTO(); ?>">
		</br>
		<?php echo isset($errores["estatura"]) ? "*" : "" ?>
		<label for="estatura">Estatura</label>
		<input type="text" name="estatura" value="<?php echo $jugador->getESTATURA(); ?>">
		</br>
		<?php echo isset($errores["posicion"]) ? "*" : "" ?>
		<label for="posicion">Posición</label>
		<input type="text" name="posicion" value="<?php echo $jugador->getPOSICION(); ?>">
		</br>
		<?php
		//El equipo del jugador se elegirá de una lista desplegable con los distintos equipos.
		// Desplegable de Equipos
		echo isset($errores["equipo"]) ? "*" : "" ?>
      <label for="equipo" >Equipo:</label>
      <select id="equipo" name="equipo" >
        <?php 
		//Mostramos primero el equipo del jugador
		echo '<option value="'.$jugador->getEQUIPO().'" >'.$jugador->getEQUIPO().' '.$jugador->getNOMBRE_EQUIPO(). '</option>';  
          // Recorremos el array de socios para poblar el filtro con un bucle foreach
          foreach ($equipos as $equipo){
			//Si el equipo del jugador es distinto al equipo del desplegable lo añadimos al desplegable
			if($equipo->getCOD_EQUIPO()!=$jugador->getEQUIPO()){
            //mostramos el socio seleccionado
            echo "<option value=".$equipo->getCOD_EQUIPO()." >".$equipo->getCOD_EQUIPO()." ".$equipo->getNOMBRE_EQUIPO()."
                  </option>";
			}
          }
        ?>
		</select>
		</br>
		<a href="index.php?controlador=Jugadores&accion=listar" class="btnCancelar">Cancelar</a>
		<input type="submit" name="submit" value="Aceptar">
	</form>
	</br>
	
	<?php
	// Si hay errores los mostramos.
	if (isset($errores)):
		foreach ($errores as $key => $error):
			echo $error . "</br>";
		endforeach;
	endif;
	?>
</body>

</html>