<?php
/**
 * RentaTurista - Configuración de Base de Datos
 * 
 * Clase singleton para manejar la conexión a la base de datos
 * usando PDO con prepared statements para seguridad
 */

class Database {
    private static $instance = null;
    private $connection;
    
    // Configuración de la base de datos
    private $host = 'localhost';
    private $dbname = 'yvytsfpx_rentaturista';
    private $username = 'yvytsfpx_rentaturista';
    private $password = 'Alcorte22..';
    private $charset = 'utf8mb4';
    
    /**
     * Constructor privado para patrón Singleton
     */
    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$this->charset}"
        ];
        
        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Error de conexión a la base de datos");
        }
    }
    
    /**
     * Obtener instancia única de la base de datos
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Obtener conexión PDO
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Prevenir clonación del objeto
     */
    private function __clone() {}
    
    /**
     * Prevenir deserialización del objeto
     */
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

?>