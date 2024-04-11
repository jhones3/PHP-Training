<?php

namespace middleware;

class Authentication
{
    /**
     * Create the class instance.
     */
    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
    }

    /**
     * Perform middleware.
     */
    public function handle()
    {
        if (
            isset($_SESSION['auth']) &&
            $_SESSION['auth']
        ) return $this;

        header("location: ../login.php");

        die();
    }
}
