<?php
/**
 * Sistema de Enrutamiento Simple
 * Maneja las URL y las direcciona a los controladores correctos
 */

class Router {
    
    private $rutas = [];
    private $controlador = 'dashboard';
    private $metodo = 'index';
    private $parametros = [];
    
    public function __construct() {
        $this->procesarURL();
    }
    
    /**
     * Procesar la URL y extraer controlador, método y parámetros
     */
    private function procesarURL() {
        $url = isset($_GET['url']) ? $_GET['url'] : 'dashboard';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        
        // Primer elemento es el controlador
        if (!empty($url[0])) {
            $this->controlador = $url[0];
        }
        
        // Segundo elemento es el método
        if (!empty($url[1])) {
            $this->metodo = $url[1];
        }
        
        // Resto son parámetros
        unset($url[0], $url[1]);
        $this->parametros = array_values($url);
    }
    
    /**
     * Ejecutar el controlador y método
     */
    public function ejecutar() {
        $archivo = APP_PATH . '/app/controllers/' . ucfirst($this->controlador) . 'Controller.php';
        if (file_exists($archivo)) {
            require_once $archivo;
            $class = ucfirst($this->controlador) . 'Controller';
            
            if (class_exists($class)) {
                $controlador = new $class();
                
                if (method_exists($controlador, $this->metodo)) {
                    call_user_func_array(
                        [$controlador, $this->metodo],
                        $this->parametros
                    );
                } else {
                    die("El método {$this->metodo} no existe en {$class}");
                }
            } else {
                die("La clase {$class} no existe");
            }
        } else {
            // Redirigir a 404 o dashboard
            header('Location: ' . APP_URL . 'dashboard');
            exit();
        }
    }
}
?>
