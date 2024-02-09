<?php
// Script para configurar mi aplicación web
// Establece las variables que indican los directorios de las clases
// Establece las variables para hacer la conexión a la base de datos

// Obtiene la instancia del objeto que guarda los datos de configuración
$config = Config::singleton();

// Carpetas para los Controladores, los Modelos y las Vistas
$config->set('controllersFolder', 'controllers/');
$config->set('modelsFolder', 'models/');
$config->set('viewsFolder', 'views/');

// Parámetros de conexión a la BD
$config->set('dbhost', 'roundhouse.proxy.rlwy.net');
$config->set('dbname', 'railway');
$config->set('dbuser', 'root');
$config->set('dbpass', 'GBF4CF62cAHaA14f2d5Ac-3ehc4f64fG');
?>
