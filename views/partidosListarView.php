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
            <th>Fecha</th>
            <th>Cod.Equipo 1</th>
            <th>Equipo 1</th>
            <th>Cod.Equipo 2</th>
            <th>Equipo 2</th>
            <th>Puntos 1</th>
            <th>Puntos 2</th>
            <th colspan="2">Acciones</th>

        </tr>
        <tr>
            <td colspan="10">
                <a href="index.php?controlador=Partidos&accion=nuevo">Nuevo</a>
            </td>
            
        
        </tr>

        <?php
        //Recorremos los partidos y los mostramos en la tabla
        foreach ($partidos as $partido) {
            ?>
            <tr>
                <td>
                    <?php echo $partido->getCOD_PARTIDO() ?>
                </td>
                <td>
                    <?php echo $partido->getFECHA() ?>
                </td>
                <td>
                    <?php echo $partido->getCOD_EQUIPO1() ?>
                </td>
                <td>
                    <?php echo $partido->getNOMBRE_EQUIPO1() ?>
                </td>
                <td>
                    <?php echo $partido->getCOD_EQUIPO2() ?>
                </td>
                <td>
                  
                    <?php echo $partido->getNOMBRE_EQUIPO2() ?>
                </td>
                <td>
                    <?php echo $partido->getPUNTOS_EQUIPO1() ?>
                </td>
                <td>
                    <?php echo $partido->getPUNTOS_EQUIPO2() ?>
                </td>
                <td>
                    <a href="index.php?controlador=Partidos&accion=editar&cod_partido=<?php echo $partido->getCOD_PARTIDO() ?>">Editar</a>
                </td>
                <td>
                    <a href="index.php?controlador=Partidos&accion=borrar&cod_partido=<?php echo $partido->getCOD_PARTIDO() ?>">Borrar</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
   
</body>

</html>