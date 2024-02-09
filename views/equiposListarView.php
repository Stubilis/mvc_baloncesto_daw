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
            <th>Fecha Fundación</th>
            <th>Presupuesto</th>
            <th>Num. Títulos</th>
            <th>Cod. Zona</th>
            <th>Zona</th>
            <th colspan="2">Acciones</th>

        </tr>
        <tr>
            <td colspan="9">
                <a href="index.php?controlador=Equipos&accion=nuevo">Nuevo</a>
            </td>
            
        
        </tr>

        <?php
        //Recorremos los equipos y los mostramos en la tabla
        foreach ($equipos as $equipo) {
            ?>
            <tr>
                <td>
                    <?php echo $equipo->getCOD_EQUIPO() ?>
                </td>
                <td>
                    <?php echo $equipo->getNOMBRE_EQUIPO() ?>
                </td>
                <td>
                    <?php echo $equipo->getFECHA_FUNDACION() ?>
                </td>
                <td>
                    <?php echo $equipo->getPRESUPUESTO() ?>
                </td>
                <td>
                    <?php echo $equipo->getTITULOS() ?>
                </td>
                <td>
                    <?php echo $equipo->getZONA() ?>
                </td>
                <td>
                    <?php echo $equipo->getNOMBRE_ZONA() ?>
                </td>
                <td>
                    <a href="index.php?controlador=Equipos&accion=editar&cod_equipo=<?php echo $equipo->getCOD_EQUIPO() ?>">Editar</a>
                </td>
                <td>
                    <a href="index.php?controlador=Equipos&accion=borrar&cod_equipo=<?php echo $equipo->getCOD_EQUIPO() ?>">Borrar</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
 
</body>

</html>