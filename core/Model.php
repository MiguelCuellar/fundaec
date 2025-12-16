<?php
/**
 * Clase Base para Modelos
 * Proporciona métodos comunes de acceso a datos
 */

class Model {
    
    protected $tabla;
    protected $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    
    /**
     * Obtener todos los registros
     */
    public function obtenerTodos($condicion = '', $orden = '') {
        $sql = "SELECT * FROM {$this->tabla}";

        if (!empty($condicion)) {
            $sql .= " WHERE {$condicion}";
        }

        // Sólo añadir ORDER BY si se especificó una columna/orden
        if (!empty($orden)) {
            $sql .= " ORDER BY {$orden}";
        }

        return $this->conn->query($sql);
    }
    
    /**
     * Obtener un registro por ID
     */
    public function obtenerPorId($id) {
        // Intentar varias convenciones de llave primaria: id_{tabla}, id_{singular}, id
        $singular = rtrim($this->tabla, 's');
        $candidates = ["id_{$this->tabla}", "id_{$singular}", 'id'];

        foreach ($candidates as $pk) {
            $sql = "SELECT * FROM {$this->tabla} WHERE {$pk} = ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                // La columna/consulta no es válida para esta tabla, probar siguiente candidato
                continue;
            }

            $stmt->bind_param('i', $id);
            $stmt->execute();

            $res = $stmt->get_result();
            if ($res) {
                $row = $res->fetch_assoc();
                // Si encontramos una fila (o la consulta fue válida), devolvemos lo obtenido (puede ser null)
                return $row;
            }
        }

        return null;
    }
    
    /**
     * Buscar registros
     */
    public function buscar($campo, $valor) {
        $sql = "SELECT * FROM {$this->tabla} WHERE {$campo} = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $valor);
        $stmt->execute();
        
        return $stmt->get_result();
    }
    
    /**
     * Contar registros
     */
    public function contar($condicion = '') {
        $sql = "SELECT COUNT(*) as total FROM {$this->tabla}";
        
        if (!empty($condicion)) {
            $sql .= " WHERE {$condicion}";
        }
        
        $resultado = $this->conn->query($sql);
        $fila = $resultado->fetch_assoc();
        
        return $fila['total'];
    }
    
    /**
     * Crear registro
     */
    public function crear($datos) {
        $campos = implode(',', array_keys($datos));
        $valores = implode(',', array_fill(0, count($datos), '?'));
        $tipos = $this->generarTipos(array_values($datos));
        
        $sql = "INSERT INTO {$this->tabla} ({$campos}) VALUES ({$valores})";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($tipos, ...array_values($datos));
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        
        return false;
    }
    
    /**
     * Actualizar registro
     */
    public function actualizar($id, $datos) {
        $campos = [];
        foreach (array_keys($datos) as $campo) {
            $campos[] = "{$campo} = ?";
        }
        
        $campos_str = implode(',', $campos);
        $tipos = $this->generarTipos(array_values($datos)) . 'i';
        
        $sql = "UPDATE {$this->tabla} SET {$campos_str} WHERE id_{$this->tabla} = ?";
        
        $stmt = $this->conn->prepare($sql);
        $valores = array_merge(array_values($datos), [$id]);
        $stmt->bind_param($tipos, ...$valores);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar registro
     */
    public function eliminar($id) {
        $sql = "DELETE FROM {$this->tabla} WHERE id_{$this->tabla} = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        
        return $stmt->execute();
    }
    
    /**
     * Generar tipos para bind_param
     */
    protected function generarTipos($valores) {
        $tipos = '';
        foreach ($valores as $valor) {
            if (is_int($valor)) {
                $tipos .= 'i';
            } elseif (is_float($valor)) {
                $tipos .= 'd';
            } else {
                $tipos .= 's';
            }
        }
        return $tipos;
    }
    
    /**
     * Ejecutar consulta personalizada
     */
    public function consulta($sql, $tipos = '', $parametros = []) {
        $stmt = $this->conn->prepare($sql);
        
        if (!empty($tipos) && !empty($parametros)) {
            $stmt->bind_param($tipos, ...$parametros);
        }
        
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
