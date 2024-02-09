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
            <th colspan="2">Acciones</th>

        </tr>
        <tr>
            <td colspan="4">
                <a href="index.php?controlador=Zonas&accion=nuevo">Nuevo</a>
            </td>
            
        
        </tr>

        <?php
        //Recorremos las zonas y los mostramos en la tabla
        foreach ($zonas as $zona) {
            ?>
            <tr>
                <td>
                    <?php echo $zona->getCOD_ZONA() ?>
                </td>
                <td>
                    <?php echo $zona->getNOMBRE_ZONA() ?>
                </td>
                <td>
                    <a href="index.php?controlador=Zonas&accion=editar&cod_zona=<?php echo $zona->getCOD_ZONA() ?>">Editar</a>
                </td>
                <td>
                    <a href="index.php?controlador=Zonas&accion=borrar&cod_zona=<?php echo $zona->getCOD_ZONA() ?>">Borrar</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
  
</body>

</html>