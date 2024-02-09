<!-- Vista para listar los registros de un determinado modelo -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="./css/estilos.css" rel="stylesheet" type="text/css" />
    <title>MVC - Modelo, Vista, Controlador - Jourmoly</title>
</head>

<body>
    <table>
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Nacimiento</th>
            <th>Estatura</th>
            <th>Posición</th>
            <th>Equipo</th>
            <th colspan="2">Acciones</th>

        </tr>
        <tr>
            <td colspan="9">
                <a href="index.php?controlador=Jugadores&accion=nuevo">Nuevo</a>
            </td>
            
        
        </tr>

        <?php
        //Recorremos los jugadores y los mostramos en la tabla
        foreach ($jugadores as $jugador) {
            ?>
            <tr>
                <td>
                    <?php echo $jugador->getCOD_JUGADOR() ?>
                </td>
                <td>
                    <?php echo $jugador->getNOMBRE_JUGADOR() ?>
                </td>
                <td>
                    <?php echo $jugador->getFECHA_NACIMIENTO() ?>
                </td>
                <td>
                    <?php echo $jugador->getESTATURA() ?>
                </td>
                <td>
                    <?php echo $jugador->getPOSICION() ?>
                </td>
                <td>
                    <?php echo $jugador->getNOMBRE_EQUIPO() ?>
                </td>
                <td>
                    <a href="index.php?controlador=Jugadores&accion=editar&cod_jugador=<?php echo $jugador->getCOD_JUGADOR() ?>">Editar</a>
                </td>
                <td>
                    <a href="index.php?controlador=Jugadores&accion=borrar&cod_jugador=<?php echo $jugador->getCOD_JUGADOR() ?>">Borrar</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
   
</body>

</html>