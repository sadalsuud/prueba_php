<?php

class DBTools
{
    private $_conn = null;

    private static $_instances = [];

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        $class = basename(get_called_class());
        if (!isset(self::$_instances[$class]) || get_class(self::$_instances[$class]) !== $class) {
            self::$_instances[$class] = new static();
        }
        return self::$_instances[$class];
    }

    private function _connect()
    {
        if ($this->_conn === null) {
            $this->_conn = new mysqli();
            $this->_conn->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
            $this->_conn->real_connect('127.0.0.1', 'root', '', 'phptest');

            if (mysqli_connect_errno()) {
                throw new Exception('Error connecting to database: ' . mysqli_connect_error());
                exit;
            }
        }
    }

    private function _disconnect()
    {
        if ($this->_conn !== null) {
            $this->_conn->close();
            $this->_conn = null;
        }
    }
    
    /**
     * Ejecuta una consulta SQL.
     *
     * @param string $query La sentencia SQL a ejecutar.
     * @return bool|int|array En caso de realizar un `SELECT` devuelve los resultados de la consulta en un array. En caso de `UPDATE` o `DELETE` devuelve la cantidad de rows afectados. En caso de `INSERT` devuelve el ID del nuevo registro.
     * 
     * @throws Exception Si la sentencia SQL es invalida, la consulta falla o no se puede conectar a la base de datos.
     */
    public function exec($query)
    {
        $this->_connect();

        $result = $this->_conn->query($query);

        if ($result === false) {
            throw new Exception($this->_conn->error . ' || ' . $query);
        }

        // Todos los verbos principales de SQL tienen la misma longitud de 6 caracteres
        // select
        // insert
        // update
        // delete
        $action = substr($query, 0, 6);

        $res = false;

        switch ($action) {
            case 'SELECT':
                while ($row = $result->fetch_assoc()) {
                    $res[] = $row;
                }
                break;

            case 'DELETE':
            case 'UPDATE':
                $res = $this->_conn->affected_rows;
                break;

            case 'INSERT':
                $res = $this->_conn->insert_id;
                break;

            default:
                throw new Exception('Consulta SQL no soportada: ', $query);
                break;
        }

        if (is_object($result)) {
            $result->free();
        }
        $this->_disconnect();

        return $res;
    }
}
