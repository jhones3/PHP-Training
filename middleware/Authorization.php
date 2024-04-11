<?php

namespace middleware;

include_once("services/PostService.php");

use services\PostService;

class Authorization
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
     * 
     * @param int|string|null $id
     */
    public function handle($id = null)
    {
        if (
            isset($_SESSION['auth']) &&
            $_SESSION['auth']
        ) {
            $postService = new PostService;

            $post = $postService->show($id ?? $_GET['id'] ?? $_POST['id']);

            if ($_SESSION['auth']->id === $post->user_id) {
                return $this;
            }
        }

        header("location: ../login.php");

        die();
    }
}
