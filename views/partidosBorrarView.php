<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./css/estilos.css" rel="stylesheet" type="text/css" />
	<title>Microframework MVC - Modelo, Vista, Controlador</title>
</head>
<body>
<h2>¿Seguro que quiere eliminar el partido?</h2>
    <p>Está acción es definitiva</p>
<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="Partidos">
		<input type="hidden" name="accion" value="borrar">
        <input type="hidden" name="cod_partido" value="<?php echo $partido->getCOD_PARTIDO()?>">

    <button type="submit" name="submit">Aceptar</button>
    <a href="index.php?controlador=Partidos&accion=listar">Cancelar</a>
</form>
</body>

</html>
