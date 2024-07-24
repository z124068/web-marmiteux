<?php
// Database.php

namespace Core;

use mysqli;
use mysqli_stmt;
use Exception;

class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "marmiteux";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    public function close()
    {
        $this->conn->close();
    }


    public function getConnection()
    {
        return $this->conn;
    }

}
