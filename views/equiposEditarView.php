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
		<input type="hidden" name="controlador" value="Equipos">
		<input type="hidden" name="accion" value="editar">

		<label for="cod_equipo">Código</label>
		<input type="text" name="cod_equipo" value="<?php echo $equipo->getCOD_EQUIPO(); ?>" readonly>
		</br>

		<?php echo isset($errores["nombre_equipo"]) ? "*" : "" ?>
		<label for="nombre_equipo">Nombre</label>
		<input type="text" name="nombre_equipo" value="<?php echo $equipo->getNOMBRE_EQUIPO(); ?>">
		</br>

		<?php echo isset($errores["fecha_fundacion"]) ? "*" : "" ?>
		<label for="fecha_fundacion">Fundación:</label>
		<input type="text" name="fecha_fundacion" value="<?php echo $equipo->getFECHA_FUNDACION(); ?>">
		</br>
		<?php echo isset($errores["presupuesto"]) ? "*" : "" ?>
		<label for="presupuesto">Presupuesto</label>
		<input type="text" name="presupuesto" value="<?php echo $equipo->getPRESUPUESTO(); ?>">
		</br>
		<?php echo isset($errores["titulos"]) ? "*" : "" ?>
		<label for="titulos">Títulos</label>
		<input type="text" name="titulos" value="<?php echo $equipo->getTITULOS(); ?>">
		</br>

		<?php
		//La zona del equipo se elegirá de una lista desplegable
		// Desplegable de Zonas
		echo isset($errores["zona"]) ? "*" : "" ?>
      <label for="zona" >Zona:</label>
      <select id="zona" name="zona" >
        <?php 
		//Mostramos primero el equipo del equipo
		echo '<option value="'.$equipo->getZONA().'" >'.$equipo->getZONA().' '.$equipo->getNOMBRE_ZONA(). '</option>';  
          // Recorremos el array de socios para poblar el filtro con un bucle foreach
          foreach ($zonas as $zona){
			//Si la zona del equipo es distinto a la zona del desplegable la añadimos al desplegable
			if($zona->getCOD_ZONA()!=$equipo->getZONA()){
            echo "<option value=".$zona->getCOD_ZONA()." >".$zona->getCOD_ZONA()." ".$zona->getNOMBRE_ZONA()."
                  </option>";
			}
          }
        ?>
		</select>
		</br>
		<a href="index.php?controlador=Equipos&accion=listar" class="btnCancelar">Cancelar</a>
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