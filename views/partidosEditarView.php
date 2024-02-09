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
		<input type="hidden" name="controlador" value="Partidos">
		<input type="hidden" name="accion" value="editar">

		<label for="cod_partido">Código</label>
		<input type="text" name="cod_partido" value="<?php echo $partido->getCOD_PARTIDO(); ?>" readonly>
		</br>

		<?php echo isset($errores["fecha"]) ? "*" : "" ?>
		<label for="fecha">Fecha</label>
		<input type="text" name="fecha" value="<?php echo $partido->getFECHA(); ?>">
        </br>
        <?php
		//Los equipos del partido se elegirán de una lista desplegable con los distintos equipos.
		// Desplegable de cod_equipo1
		echo isset($errores["cod_equipo1"]) ? "*" : "" ?>
      <label for="cod_equipo1" >Equipo 1:</label>
      <select id="cod_equipo1" name="cod_equipo1" >
        <?php 
		//Mostramos primero el equipo del partido
		echo '<option value="'.$partido->getCOD_EQUIPO1().'" >'.$partido->getCOD_EQUIPO1().' '.$partido->getNOMBRE_EQUIPO1(). '</option>';  
          // Recorremos el array de socios para poblar el filtro con un bucle foreach
          foreach ($equipos as $equipo){
			//Si el equipo del partido es distinto al equipo del desplegable lo añadimos al desplegable
			if($equipo->getCOD_EQUIPO()!=$partido->getCOD_EQUIPO1()){
            //mostramos el socio seleccionado
            echo "<option value=".$equipo->getCOD_EQUIPO()." >".$equipo->getCOD_EQUIPO()." ".$equipo->getNOMBRE_EQUIPO()."
                  </option>";
			}
          }
        ?>
		</select>
		</br>
		
		<?php echo isset($errores["puntos_equipo1"]) ? "*" : "" ?>
		<label for="puntos_equipo1">Puntos Equipo 1: </label>
		<input type="text" name="puntos_equipo1" value="<?php echo $partido->getPUNTOS_EQUIPO1(); ?>">
		</br>
        <?php
		// Desplegable de cod_equipo2
		echo isset($errores["cod_equipo2"]) ? "*" : "" ?>
      <label for="cod_equipo2" >Equipo 2:</label>
      <select id="cod_equipo2" name="cod_equipo2" >
        <?php 
		//Mostramos primero el equipo del partido
		echo '<option value="'.$partido->getCOD_EQUIPO2().'" >'.$partido->getCOD_EQUIPO2().' '.$partido->getNOMBRE_EQUIPO2(). '</option>';  
          // Recorremos el array de socios para poblar el filtro con un bucle foreach
          foreach ($equipos as $equipo){
			//Si el equipo del partido es distinto al equipo del desplegable lo añadimos al desplegable
			if($equipo->getCOD_EQUIPO()!=$partido->getCOD_EQUIPO2()){
            //mostramos el socio seleccionado
            echo "<option value=".$equipo->getCOD_EQUIPO()." >".$equipo->getCOD_EQUIPO()." ".$equipo->getNOMBRE_EQUIPO()."
                  </option>";
			}
          }
        ?>
		</select>
		</br>
		
		<?php echo isset($errores["puntos_equipo2"]) ? "*" : "" ?>
		<label for="puntos_equipo2">Puntos Equipo 2:</label>
		<input type="text" name="puntos_equipo2" value="<?php echo $partido->getPUNTOS_EQUIPO2(); ?>">
		</br>
		
		<input type="submit" name="submit" value="Aceptar">
		<a href="index.php?controlador=Partidos&accion=listar" class="btnCancelar">Cancelar</a>
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