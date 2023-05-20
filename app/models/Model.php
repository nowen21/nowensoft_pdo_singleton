<?php
class Model
{
    // Almacena la conexión PDO
    private static $connection;
    // Almacena el nombre de la tabla
    private static $tableName;
    // Almacena el nombre de la conexión
    private static $connecti = '';

    /**
     * Establece la conexión PDO.
     */
    private static function setConnection()
    {
        // Obtener una instancia de la conexión de base de datos
        $db = DBConnection::getInstance(self::$connecti);
        // Obtener la conexión PDO
        self::$connection = $db->getConnection();
    }

    /**
     * Establece el nombre de la tabla.
     *
     * @param string $tableName Nombre de la tabla.
     */
    public static function setTableName($tableName)
    {
        self::$tableName = $tableName;
    }

    /**
     * Establece el nombre de la conexión y devuelve una instancia de la clase Model.
     *
     * @param string $connecti Nombre de la conexión.
     * @return Model Instancia de la clase Model.
     */
    public static function connetion($connecti)
    {
        // Asigna el nombre de la conexión recibido como parámetro a la propiedad estática $connecti
        self::$connecti = $connecti;

        // Retorna una nueva instancia de la clase actual
        return new self();
    }

    /**
     * Crea un nuevo registro en la tabla.
     *
     * @param array $data Datos del registro a crear.
     * @return int ID del registro creado.
     */
    public static function create($data)
    {
        // Establece la conexión con la base de datos
        self::setConnection();

        // Obtiene los nombres de las columnas como una cadena separada por comas
        $fields = implode(',', array_keys($data));

        // Crea los marcadores de posición para los valores a insertar
        $placeholders = ':' . implode(',:', array_keys($data));

        // Construye la consulta INSERT
        $query = "INSERT INTO " . self::$tableName . " ($fields) VALUES ($placeholders)";

        // Prepara la consulta
        $statement = self::$connection->prepare($query);

        // Vincula cada valor del arreglo de datos a su marcador de posición correspondiente
        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        // Ejecuta la consulta
        $statement->execute();

        // Retorna el ID del último registro insertado
        return self::$connection->lastInsertId();
    }

    /**
     * Obtiene un registro por su ID.
     *
     * @param int $id ID del registro.
     * @return array Registro obtenido.
     */
    public static function getById($id)
    {
        // Establece la conexión con la base de datos
        self::setConnection();

        // Construye la consulta SELECT para obtener un registro por ID
        $query = "SELECT * FROM " . self::$tableName . " WHERE id = :id";

        // Prepara la consulta
        $statement = self::$connection->prepare($query);

        // Vincula el valor del ID a su parámetro correspondiente
        $statement->bindValue(':id', $id);

        // Ejecuta la consulta
        $statement->execute();

        // Retorna el resultado como un arreglo asociativo (solo el primer registro)
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los registros de la tabla.
     *
     * @param array $conditions Condiciones opcionales para filtrar los registros.
     * @return array Registros obtenidos.
     */
    public static function getAll($conditions = [])
    {
        // Establece la conexión con la base de datos
        self::setConnection();

        // Construye la consulta SELECT
        $query = "SELECT * FROM " . self::$tableName;

        // Verifica si hay condiciones de búsqueda
        if (!empty($conditions)) {
            // Agrega la cláusula WHERE a la consulta
            $query .= " WHERE ";
            $whereClauses = [];

            // Genera las cláusulas de igualdad para cada condición
            foreach ($conditions as $field => $value) {
                $whereClauses[] = $field . " = :" . $field;
            }

            // Une las cláusulas con el operador lógico AND
            $query .= implode(" AND ", $whereClauses);
        }

        // Prepara la consulta
        $statement = self::$connection->prepare($query);

        // Vincula los valores de las condiciones a los parámetros
        foreach ($conditions as $field => $value) {
            $statement->bindValue(":" . $field, $value);
        }

        // Ejecuta la consulta
        $statement->execute();

        // Retorna los resultados como un arreglo asociativo
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza un registro por su ID.
     *
     * @param int $id ID del registro a actualizar.
     * @param array $data Datos actualizados.
     * @return bool True si la actualización fue exitosa, False en caso contrario.
     */
    public static function update($id, $data)
    {
        // Establece la conexión con la base de datos
        self::setConnection();

        // Inicializa una cadena vacía para almacenar los campos a actualizar
        $updateFields = '';

        // Genera la cadena de campos y valores a actualizar
        foreach ($data as $key => $value) {
            $updateFields .= "$key = :$key,";
        }

        // Elimina la coma final de la cadena de campos y valores
        $updateFields = rtrim($updateFields, ',');

        // Construye la consulta UPDATE
        $query = "UPDATE " . self::$tableName . " SET $updateFields WHERE id = :id";

        // Prepara la consulta
        $statement = self::$connection->prepare($query);

        // Vincula el valor del ID a su parámetro correspondiente
        $statement->bindValue(':id', $id);

        // Vincula los valores de los campos a actualizar a sus parámetros correspondientes
        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        // Ejecuta la consulta y retorna el resultado
        return $statement->execute();
    }

    /**
     * Elimina un registro por su ID.
     *
     * @param int $id ID del registro a eliminar.
     * @return bool True si la eliminación fue exitosa, False en caso contrario.
     */
    public static function delete($id)
    {
        // Establece la conexión con la base de datos
        self::setConnection();

        // Construye la consulta DELETE
        $query = "DELETE FROM " . self::$tableName . " WHERE id = :id";

        // Prepara la consulta
        $statement = self::$connection->prepare($query);

        // Vincula el valor del ID a su parámetro correspondiente
        $statement->bindValue(':id', $id);

        // Ejecuta la consulta y retorna el resultado
        return $statement->execute();
    }
}
