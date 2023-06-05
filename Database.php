<?php

namespace Database;

use Exception;

//========================================================================================
/*                                                                                      *
 *                         CONFIGURACIONES DE LAS BASE DE DATOS                         *
 *                                                                                      */
//========================================================================================

/**
 * Database
 */
class Database
{

    public $dbHost;
    public $dbName;
    public $dbUser;
    public $dbPassword;
    public $dbConnection;

    public function __construct()
    {
        // Configuraciones de conexión dependiendo del entorno (local o no local)
        $dbName = 'voting_form';
        $dbUser = 'root';
        $dbPassword = '';
        $dbHost = 'localhost';

        // Asignar las configuraciones a las propiedades de la clase
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;

        // Intentar establecer la conexión con la base de datos
        if (!$this->dbConnect()) {
            throw new Exception("Error al conectar con la base de datos: " . mysqli_connect_error());
        }
    }

    public function __destruct()
    {
        // Cerrar la conexión cuando la instancia de Database se destruye
        if ($this->dbConnection) {
            mysqli_close($this->dbConnection);
        }
    }

    /**
     * Establecer la conexión con la base de datos
     *
     * @return mysqli|false Objeto de conexión o false si la conexión falla
     */
    private function dbConnect()
    {
        return $this->dbConnection = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);
    }

    /**
     * Crear y ejecutar una consulta de inserción en la base de datos
     *
     * @param string $table Nombre de la tabla
     * @param array $fieldsArray Array de campos
     * @param array $valuesArray Array de valores correspondientes a los campos
     * @return bool|mysqli_result Resultado de la consulta o false si falla
     */
    public function createSaveQuery($table, $fieldsArray, $valuesArray)
    {
        $valuesForMySQL = implode("', '", $valuesArray);
        $fieldsForMySQL = implode(', ', $fieldsArray);
        $query = "INSERT INTO $table ($fieldsForMySQL) VALUES ('$valuesForMySQL')";

        return mysqli_query($this->dbConnection, $query);
    }

    /**
     * Extraer datos de la base de datos
     *
     * @param string $table Nombre de la tabla
     * @param string $column Nombre de la columna a extraer
     * @param string $condition Condición opcional para filtrar los resultados
     * @param string $order Columna opcional para ordenar los resultados
     * @param bool $reverse Indicador para ordenar en orden descendente (opcional)
     * @param bool $isList Indicador para devolver una lista de objetos en lugar de un solo objeto (opcional)
     * @return mixed Resultados de la consulta: objeto, lista de objetos o false si falla
     */
    public function extractDataFromDatabase($table, $column, $condition = '', $order = '', $reverse = false, $isList = false)
    {
        $sqlQuery = "SELECT $column FROM $table ";
        $sqlQuery .= !empty($condition) ? "WHERE $condition " : '';
        $sqlQuery .= !empty($order) ? "ORDER BY $order " : '';
        $sqlQuery .= $reverse ? "DESC " : '';
        $result = mysqli_query($this->dbConnection, $sqlQuery);

        if (!$isList) {
            return mysqli_fetch_object($result);
        }

        return array_map(fn ($row) => (object)$row, mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    /**
     * Vaciar una tabla en la base de datos (eliminar todos los registros)
     *
     * @param string $table Nombre de la tabla a truncar
     * @return bool|mysqli_result Resultado de la consulta o false si falla
     */
    public function truncateTable($table)
    {
        return mysqli_query($this->dbConnection, "TRUNCATE TABLE $table");
    }
}
