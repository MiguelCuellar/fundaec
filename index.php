<?php
/**
 * Punto de entrada principal de la aplicación
 * Carga la configuración y ejecuta el router
 */

// Cargar configuración
require_once 'config/config.php';
require_once 'config/database.php';

// Cargar autoload de Composer (para librerías como Dompdf)
if (is_readable(__DIR__ . '/vendor/autoload.php')) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Cargar clases base
require_once 'core/Controller.php';
require_once 'core/Model.php';
require_once 'core/Router.php';

// Ejecutar router
$router = new Router();
$router->ejecutar();

// Cerrar conexión
cerrarConexion();
?>
