<?php

namespace Api\Models;

use mysqli_sql_exception;


require_once './config/database.php';

/**
 * Description of DB
 *
 * @author Soumyanjan
 */
class DB {

    private $connection = null;
    private $username = "";
    private $password = "";
    private $database = "";
    private $host = "";

    public function __construct() {
        $this->host = HOSTNAME;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->database = DB_NAME;

        try {
            $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->connection;
    }

}
