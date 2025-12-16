<?php
/**
 * Configuración de Base de Datos
 * Conexión a MySQL para XAMPP
 */

// Datos de conexión
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'inventario_empresarial');
define('DB_CHARSET', 'utf8mb4');
define('DB_PORT', 3306);

// Crear conexión
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Error de conexión a base de datos: ' . $conn->connect_error
    ]));
}

// Configurar charset
$conn->set_charset(DB_CHARSET);

// Desabilitar autocommit para transacciones
$conn->autocommit(true);

// Variables globales para manejo de errores
$GLOBALS['db_connection'] = $conn;

// Función auxiliar para ejecutar consultas seguras
function ejecutarConsulta($sql, $tipos = '', $parametros = []) {
    global $conn;
    
    try {
        if (empty($tipos)) {
            $resultado = $conn->query($sql);
            if ($resultado === false) {
                throw new Exception('Error en consulta: ' . $conn->error);
            }
            return $resultado;
        } else {
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error preparando consulta: ' . $conn->error);
            }
            
            if (!empty($parametros)) {
                $stmt->bind_param($tipos, ...$parametros);
            }
            
            if (!$stmt->execute()) {
                throw new Exception('Error ejecutando consulta: ' . $stmt->error);
            }
            
            return $stmt;
        }
    } catch (Exception $e) {
        registrarError($e->getMessage());
        return false;
    }
}

// Función para obtener última inserción
function obtenerUltimoId() {
    global $conn;
    return $conn->insert_id;
}

// Función para cerrar conexión
function cerrarConexion() {
    global $conn;
    if (isset($conn)) {
        $conn->close();
    }
}

// Registrar errores
function registrarError($mensaje) {
    $archivo = 'logs/errores_' . date('Y-m-d') . '.log';
    if (!is_dir('logs')) {
        mkdir('logs', 0755, true);
    }
    error_log('[' . date('Y-m-d H:i:s') . '] ' . $mensaje . PHP_EOL, 3, $archivo);
}
?>
