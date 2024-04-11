<?php

namespace services\support\post;

trait GetPosts
{
    /**
     * Display list of all posts.
     * 
     * @return array
     */
    public function getPosts()
    {
        $response = [];

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
        ";

        $result = $this->database->conn->query($sql);

        if ($result->num_rows) {
            while ($query = $result->fetch_assoc()) {
                $response[] = (object) $query;
            }
        }

        $this->database->close();

        return $response;
    }
}
