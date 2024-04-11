<?php

namespace services\support\post;

trait Show
{
    /**
     * Display a specific resource.
     * 
     * @param int|string $id
     * @return object
     */
    public function show($id)
    {
        $response = (object) [];

        $this->database->connect();

        $sql = "
            SELECT 
                posts.id,
                posts.user_id,
                posts.title,
                posts.body,
                posts.file,
                posts.created_at,
                users.firstname,
                users.lastname,
                users.username,
                users.email,
                users.profile_picture
            FROM posts 
            INNER JOIN users ON users.id = posts.user_id
            WHERE posts.id = '$id'
        ";

        $result = $this->database->conn->query($sql);

        if ($result->num_rows) {
            $response = (object) $result->fetch_assoc();
        } else {
            $this->hasError = true;
        }

        $this->database->close();

        if ($this->hasError) $this->redirect("home.php?a=" . $id);

        return $response;
    }
}
