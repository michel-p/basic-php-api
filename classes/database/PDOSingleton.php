<?php

namespace BasicPHPAPI\Database;

use PDO;
use PDOException;

/**
 * PDO SINGLETON CLASS
 */
class PDOSingleton
{
    static private $PDOInstance;

    /**
     * PDOSingleton constructor.
     * @param $dsn string eg: mysql:host=localhost;dbname=testdb
     * @param bool (optionnal) $username
     * @param bool (optionnal) $password
     * @param bool (optionnal) $driver_options
     */
    public function __construct($dsn, $username=false, $password=false, $driver_options=array())
    {
        if(!self::$PDOInstance) {
            try {
                self::$PDOInstance = new PDO($dsn, $username, $password, $driver_options);
            } catch (PDOException $e) {
                die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
            }
        }
        return self::$PDOInstance;
    }

    /**
     * @return bool
     */
    public function beginTransaction() {
        return self::$PDOInstance->beginTransaction();
    }

    /**
     * @return bool
     */
    public function commit() {
        return self::$PDOInstance->commit();
    }

    /**
     * @return string
     */
    public function errorCode() {
        return self::$PDOInstance->errorCode();
    }

    /**
     * Fetch extended error information associated with the last operation on the database handle
     * @return array
     */
    public function errorInfo() {
        return self::$PDOInstance->errorInfo();
    }

    /**
     * Execute an SQL statement and return the number of affected rows
     * @param $statement
     * @return int
     */
    public function exec($statement) {
        return self::$PDOInstance->exec($statement);
    }

    /**
     * @param $name
     * @return string
     */
    public function lastInsertId($name) {
        return self::$PDOInstance->lastInsertId($name);
    }

    /**
     * Executes an SQL statement, returning a result set as a PDOStatement object
     *
     * @param string $statement
     * @return PDOStatement
     */
    public function query($statement) {
        return self::$PDOInstance->query($statement);
    }

    /**
     * Execute query and return all rows in assoc array
     *
     * @param string $statement
     * @return array
     */
    public function queryFetchAllAssoc($statement) {
        return self::$PDOInstance->query($statement)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Rolls back a transaction
     *
     * @return bool
     */
    public function rollBack() {
        return self::$PDOInstance->rollBack();
    }

}