<?php
/**
 * Modelo: Usuario
 * Gestiona las operaciones de base de datos para la tabla 'usuarios'
 */

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Registrar un nuevo usuario
     * @param string $nombre
     * @param string $email
     * @param string $password (texto plano, se cifrará aquí)
     * @return bool
     */
    public function registrar($nombre, $email, $password)
    {
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)";
        $stmt = $this->db->prepare($sql);

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':nombre'   => $nombre,
            ':email'    => $email,
            ':password' => $passwordHash
        ]);
    }

    /**
     * Buscar usuario por email
     * @param string $email
     * @return array|false
     */
    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Buscar usuario por ID
     * @param int $id
     * @return array|false
     */
    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Verificar si un email ya está registrado
     * @param string $email
     * @return bool
     */
    public function emailExiste($email)
    {
        $usuario = $this->buscarPorEmail($email);
        return $usuario !== false;
    }

    /**
     * Verificar contraseña
     * @param string $password Texto plano
     * @param string $hash Hash almacenado
     * @return bool
     */
    public function verificarPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
