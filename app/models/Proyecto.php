<?php
/**
 * Modelo: Proyecto
 * Gestiona las operaciones CRUD de la tabla 'proyectos'
 * Cada proyecto está relacionado con un cliente
 */

class Proyecto
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Obtener todos los proyectos con datos del cliente
     * @return array
     */
    public function obtenerTodos()
    {
        $sql = "SELECT p.*, c.nombre AS cliente_nombre, c.empresa AS cliente_empresa
                FROM proyectos p
                INNER JOIN clientes c ON p.cliente_id = c.id
                ORDER BY p.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Obtener un proyecto por ID con datos del cliente
     * @param int $id
     * @return array|false
     */
    public function obtenerPorId($id)
    {
        $sql = "SELECT p.*, c.nombre AS cliente_nombre, c.empresa AS cliente_empresa
                FROM proyectos p
                INNER JOIN clientes c ON p.cliente_id = c.id
                WHERE p.id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crear un nuevo proyecto
     * @param array $datos
     * @return bool
     */
    public function crear($datos)
    {
        $sql = "INSERT INTO proyectos (nombre, descripcion, fecha_inicio, fecha_fin, estado, presupuesto, cliente_id)
                VALUES (:nombre, :descripcion, :fecha_inicio, :fecha_fin, :estado, :presupuesto, :cliente_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre'       => $datos['nombre'],
            ':descripcion'  => $datos['descripcion'] ?? null,
            ':fecha_inicio' => $datos['fecha_inicio'],
            ':fecha_fin'    => $datos['fecha_fin'] ?? null,
            ':estado'       => $datos['estado'] ?? 'Pendiente',
            ':presupuesto'  => $datos['presupuesto'] ?? 0,
            ':cliente_id'   => $datos['cliente_id']
        ]);
    }

    /**
     * Actualizar un proyecto existente
     * @param int $id
     * @param array $datos
     * @return bool
     */
    public function actualizar($id, $datos)
    {
        $sql = "UPDATE proyectos SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    fecha_inicio = :fecha_inicio,
                    fecha_fin = :fecha_fin,
                    estado = :estado,
                    presupuesto = :presupuesto,
                    cliente_id = :cliente_id
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'           => $id,
            ':nombre'       => $datos['nombre'],
            ':descripcion'  => $datos['descripcion'] ?? null,
            ':fecha_inicio' => $datos['fecha_inicio'],
            ':fecha_fin'    => $datos['fecha_fin'] ?? null,
            ':estado'       => $datos['estado'] ?? 'Pendiente',
            ':presupuesto'  => $datos['presupuesto'] ?? 0,
            ':cliente_id'   => $datos['cliente_id']
        ]);
    }

    /**
     * Eliminar un proyecto
     * @param int $id
     * @return bool
     */
    public function eliminar($id)
    {
        $sql = "DELETE FROM proyectos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Contar el total de proyectos
     * @return int
     */
    public function contar()
    {
        $sql = "SELECT COUNT(*) as total FROM proyectos";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    /**
     * Contar proyectos por estado
     * @param string $estado
     * @return int
     */
    public function contarPorEstado($estado)
    {
        $sql = "SELECT COUNT(*) as total FROM proyectos WHERE estado = :estado";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':estado' => $estado]);
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    /**
     * Obtener proyectos de un cliente específico
     * @param int $clienteId
     * @return array
     */
    public function obtenerPorCliente($clienteId)
    {
        $sql = "SELECT * FROM proyectos WHERE cliente_id = :cliente_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cliente_id' => $clienteId]);
        return $stmt->fetchAll();
    }
}
