<?php
class DBConnection
{
    // Almacena las instancias de conexión
    private static $instances = [];
    // Conexión PDO
    private $connection;

    /**
     * Constructor de la clase DBConnection.
     *
     * @param array $config Configuración de la conexión.
     */
    private function __construct($config)
    {
        // Obtener los detalles de la conexión de la configuración
        $driver = $config['driver'];
        $host = $config['host'];
        $port = $config['port'];
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];

        // Construir la cadena de conexión DSN
        $dsn = "$driver:host=$host;port=$port;dbname=$database;charset=utf8mb4";

        try {
            // Crear una instancia de PDO para la conexión
            $this->connection = new PDO($dsn, $username, $password);
            // Establecer el modo de error y excepción
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Manejar errores de conexión
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * Obtiene una instancia de la conexión de base de datos.
     *
     * @param string $connectionName Nombre de la conexión (opcional).
     * @return DBConnection Instancia de la conexión de base de datos.
     * @throws Exception Si el nombre de conexión no es válido.
     */
    public static function getInstance($connectionName = '')
    {
        // Obtener la configuración de la base de datos
        $config = require_once 'app/config/database.php';

        // Verificar si se proporcionó un nombre de conexión
        if (empty($connectionName)) {
            $connectionName = $config['default'];
        }

        // Verificar si la instancia de conexión ya existe
        if (!isset(self::$instances[$connectionName])) {
            // Verificar si el nombre de conexión es válido
            if (isset($config['connections'][$connectionName])) {
                // Crear una nueva instancia de conexión si no existe
                self::$instances[$connectionName] = new self($config['connections'][$connectionName]);
            } else {
                throw new Exception("Invalid connection name: $connectionName");
            }
        }

        // Devolver la instancia de conexión existente o recién creada
        return self::$instances[$connectionName];
    }

    /**
     * Obtiene la conexión PDO.
     *
     * @return PDO Conexión PDO.
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
