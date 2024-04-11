<?php

namespace middleware;

class Guest
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
        ) {
            header("location: ../home.php");

            die();
        }

        return $this;
    }
}
