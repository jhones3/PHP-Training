<?php

namespace services;

include_once("database/Database.php");

use database\Database;

abstract class service
{
    public $auth = null;
    protected $database;

    /**
     * Create the class instance.
     */
    public function __construct()
    {
        if (!isset($_SESSION)) session_start();

        $this->database = new Database;

        $this->auth = $_SESSION["auth"] ?? null;
    }
}
