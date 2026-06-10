<?php
/**
 * Modelo: Cliente
 * Gestiona las operaciones CRUD de la tabla 'clientes'
 */

class Cliente
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Obtener todos los clientes
     * @return array
     */
    public function obtenerTodos()
    {
        $sql = "SELECT * FROM clientes ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Obtener un cliente por ID
     * @param int $id
     * @return array|false
     */
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM clientes WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crear un nuevo cliente
     * @param array $datos
     * @return bool
     */
    public function crear($datos)
    {
        $sql = "INSERT INTO clientes (nombre, email, telefono, empresa, direccion)
                VALUES (:nombre, :email, :telefono, :empresa, :direccion)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre'    => $datos['nombre'],
            ':email'     => $datos['email'],
            ':telefono'  => $datos['telefono'] ?? null,
            ':empresa'   => $datos['empresa'] ?? null,
            ':direccion' => $datos['direccion'] ?? null
        ]);
    }

    /**
     * Actualizar un cliente existente
     * @param int $id
     * @param array $datos
     * @return bool
     */
    public function actualizar($id, $datos)
    {
        $sql = "UPDATE clientes SET
                    nombre = :nombre,
                    email = :email,
                    telefono = :telefono,
                    empresa = :empresa,
                    direccion = :direccion
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'        => $id,
            ':nombre'    => $datos['nombre'],
            ':email'     => $datos['email'],
            ':telefono'  => $datos['telefono'] ?? null,
            ':empresa'   => $datos['empresa'] ?? null,
            ':direccion' => $datos['direccion'] ?? null
        ]);
    }

    /**
     * Eliminar un cliente
     * @param int $id
     * @return bool
     */
    public function eliminar($id)
    {
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Contar el total de clientes
     * @return int
     */
    public function contar()
    {
        $sql = "SELECT COUNT(*) as total FROM clientes";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return (int) $result['total'];
    }
}
