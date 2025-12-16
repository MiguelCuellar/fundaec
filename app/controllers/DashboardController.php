<?php
require_once APP_PATH . '/core/Controller.php';

class DashboardController extends Controller
{
    public function __construct()
    {
        // No requiere sesión para la pantalla de verificación inicial
        parent::__construct(false);
    }

    public function index()
    {
        echo $this->vista('dashboard', [
            'mensaje' => 'La aplicación y la conexión se cargaron correctamente.'
        ]);
    }
}
