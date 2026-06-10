<?php
/**
 * Configuración de conexión a la base de datos
 * Utiliza PDO para una conexión segura con MySQL
 */

class Database
{
    // Configuración de la base de datos
    // Lee variables de entorno (Render/producción) con fallback a XAMPP local
    private static $host = null;
    private static $dbname = null;
    private static $username = null;
    private static $password = null;

    /**
     * Inicializar configuración desde variables de entorno
     */
    private static function loadConfig()
    {
        if (self::$host === null) {
            self::$host     = getenv('DB_HOST') ?: 'localhost';
            self::$dbname   = getenv('DB_NAME') ?: 'caso_practico_backend';
            self::$username = getenv('DB_USER') ?: 'root';
            self::$password = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';
        }
    }
    private static $charset = 'utf8mb4';

    // Instancia de conexión (Singleton)
    private static $connection = null;

    /**
     * Obtener la conexión PDO
     * @return PDO
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            self::loadConfig();
            try {
                $port = getenv('DB_PORT') ?: '3306';
                $dsn = "mysql:host=" . self::$host . ";port=" . $port . ";dbname=" . self::$dbname . ";charset=" . self::$charset;

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . self::$charset
                ];

                self::$connection = new PDO($dsn, self::$username, self::$password, $options);

            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    /**
     * Evitar la clonación del objeto
     */
    private function __clone() {}

    /**
     * Evitar la deserialización del objeto
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
