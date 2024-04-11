<?php

namespace database;

use mysqli;

class Database
{

    protected $servername;
    protected $username;
    protected $password;
    protected $database;
    public $conn;

    /**
     * Create the class instance.
     */
    public function __construct()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->database = "blog_native";
    }

    /**
     * Initialize database connection.
     */
    public function connect()
    {
        // Create connection
        $this->conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->database
        );

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * Close database connection.
     */
    public function close()
    {
        $this->conn->close();
    }
}
