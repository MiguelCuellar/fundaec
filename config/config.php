<?php
/**
 * Configuración General del Sistema
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Información de la aplicación
define('APP_NAME', 'Sistema de Inventarios Empresarial');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/fundaec/');
define('APP_PATH', realpath(dirname(dirname(__FILE__))));

// Configuración de sesiones
define('SESSION_LIFETIME', 3600); // 1 hora
define('SESSION_PATH', APP_PATH . '/sessions/');
define('SESSION_NAME', 'fundaec_session');

// Configuración de seguridad
define('HASH_ALGORITMO', 'bcrypt');
define('HASH_COST', 10);
define('MAX_LOGIN_INTENTOS', 5);
define('TIEMPO_BLOQUEO', 900); // 15 minutos
define('TOKEN_LENGTH', 64);
define('TOKEN_EXPIRACION', 86400); // 24 horas
// Bandera para desactivar temporalmente verificación de permisos (true = desactivar)
define('DISABLE_PERMISSIONS', true);

// Configuración de directorios
define('DIR_UPLOADS', APP_PATH . '/uploads/');
define('DIR_MAPAS', DIR_UPLOADS . 'mapas/');
define('DIR_BACKUPS', APP_PATH . '/backups/');
define('DIR_LOGS', APP_PATH . '/logs/');

// Crear directorios si no existen
$directorios = [DIR_UPLOADS, DIR_MAPAS, DIR_BACKUPS, DIR_LOGS, SESSION_PATH];
foreach ($directorios as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', DIR_LOGS . 'php_errors.log');

// Zona horaria
date_default_timezone_set('America/Lima');

// Configuración de CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: text/html; charset=utf-8');

// Token opcional para endpoints públicos de reportes (déjalo vacío para desactivar)
define('REPORT_SECRET', getenv('REPORT_SECRET') ?: '');
?>
