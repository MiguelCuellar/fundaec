<?php
/**
 * Clase Base para Controladores
 * Proporciona funcionalidad común a todos los controladores
 */

class Controller {
    
    protected $modelo;
    protected $usuario;
    protected $permisos = [];
    
    public function __construct($requiere_sesion = true) {
        if ($requiere_sesion) {
            $this->verificarSesion();
            if (isset($_SESSION['usuario_id'])) {
                $this->cargarPermisosUsuario();
            }
        }
    }
    
    /**
     * Verificar si la sesión es válida
     */
    protected function verificarSesion() {
        if (!isset($_SESSION['usuario_id'])) {
            // Evitar bucles infinitos
            if ($_SERVER['REQUEST_URI'] !== '/inventario/' && 
                strpos($_SERVER['REQUEST_URI'], 'login') === false) {
                header('Location: ' . APP_URL . 'login', true, 302);
                exit();
            }
            return;
        }
        
        // Verificar tiempo de inactividad
        if (isset($_SESSION['ultima_actividad']) && 
            (time() - $_SESSION['ultima_actividad'] > SESSION_LIFETIME)) {
            session_destroy();
            $this->redirigir('login?error=sesion_expirada');
        }
        
        $_SESSION['ultima_actividad'] = time();
        $this->usuario = $_SESSION['usuario_id'];
    }
    
    /**
     * Cargar permisos del usuario
     */
    protected function cargarPermisosUsuario() {
        global $conn;
        
        $sql = "SELECT p.nombre_permiso 
                FROM roles_permisos rp
                JOIN usuarios u ON u.id_rol = rp.id_rol
                JOIN permisos p ON p.id_permiso = rp.id_permiso
                WHERE u.id_usuario = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $this->usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        while ($fila = $resultado->fetch_assoc()) {
            $this->permisos[] = $fila['nombre_permiso'];
        }
        
        $stmt->close();
    }
    
    /**
     * Verificar si el usuario tiene un permiso específico
     */
    protected function tienePermiso($permiso) {
        return in_array($permiso, $this->permisos);
    }
    
    /**
     * Verificar y negar acceso si no tiene permiso
     */
    protected function verificarPermiso($permiso) {
        // Si la bandera global está activada, omitir la verificación (temporal)
        if (defined('DISABLE_PERMISSIONS') && DISABLE_PERMISSIONS) {
            return;
        }

        if (!$this->tienePermiso($permiso)) {
            http_response_code(403);
            die(json_encode([
                'success' => false,
                'message' => 'No tienes permiso para acceder a este recurso'
            ]));
        }
    }
    
    /**
     * Cargar una vista con variables
     */
    protected function vista($nombre, $datos = []) {
        extract($datos);
        $archivo = APP_PATH . '/app/views/' . $nombre . '.php';
        
        if (file_exists($archivo)) {
            ob_start();
            include $archivo;
            return ob_get_clean();
        } else {
            return '<div class="alert alert-danger">Vista no encontrada: ' . $nombre . '</div>';
        }
    }
    
    /**
     * Cargar un modelo
     */
    protected function modelo($nombre) {
        $archivo = APP_PATH . '/app/models/' . ucfirst($nombre) . 'Model.php';
        
        if (file_exists($archivo)) {
            require_once $archivo;
            $class = ucfirst($nombre) . 'Model';
            return new $class();
        }
        
        return null;
    }
    
    /**
     * Redirigir a otra página
     */
    protected function redirigir($url = '') {
        header('Location: ' . APP_URL . $url);
        exit();
    }
    
    /**
     * Responder con JSON
     */
    protected function json($datos, $codigo = 200) {
        http_response_code($codigo);
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    /**
     * Registrar acción en auditoría
     */
    protected function registrarAuditoria($accion, $tabla, $id_registro = null, $detalles = []) {
        global $conn;
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $detalles_json = json_encode($detalles);
        
        $sql = "INSERT INTO logs_auditoria 
                (id_usuario, accion, tabla_afectada, id_registro, ip_address, user_agent, detalles)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            'issiiss',
            $this->usuario,
            $accion,
            $tabla,
            $id_registro,
            $ip,
            $user_agent,
            $detalles_json
        );
        $stmt->execute();
        $stmt->close();
    }
    
    /**
     * Validar entrada POST
     */
    protected function validarEntrada($requeridos = []) {
        $datos = [];
        
        foreach ($requeridos as $campo) {
            if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
                return ['error' => "El campo {$campo} es requerido"];
            }
            $datos[$campo] = trim($_POST[$campo]);
        }
        
        return $datos;
    }
    
    /**
     * Sanitizar entrada
     */
    protected function sanitizar($entrada) {
        return htmlspecialchars(trim($entrada), ENT_QUOTES, 'UTF-8');
    }
}
?>
