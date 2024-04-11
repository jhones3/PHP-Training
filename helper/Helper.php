<?php

namespace helper;

trait Helper
{
    /**
     * Sanitize inputs.
     * 
     * @param string $data
     * @return string
     */
    private function filter($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    /**
     * Handle redirection.
     * 
     * @param string $page
     * @param int $statusCode
     */
    private function redirect($page, $statusCode = 200)
    {
        header('Location: ' . $page, true, $statusCode);
        die();
    }
}
