<?php

namespace services\support\post;

trait Store
{
    /**
     * Store new post.
     */
    public function store()
    {
        $title = $_POST["title"];
        $body = $_POST["body"];
        $file = $_FILES["file"];

        if (empty($title)) {
            $this->titleError = "Title is required";
            $this->hasError = true;
        }

        if (empty($body)) {
            $this->bodyError = "Body is required";
            $this->hasError = true;
        }

        if (!file_exists($file["tmp_name"])) {
            $this->fileError = "Please upload profile picture";
            $this->hasError = true;
        }

        $dir = "uploads/";

        // Rename file name to timestamp
        $filename = strtotime("today") . "_" . time() . "." . explode('.', $file["name"])[1];
        $filePath = $dir . $filename;

        $imageFileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Allow certain file formats
        if (
            $imageFileType != "jpg" &&
            $imageFileType != "png" &&
            $imageFileType != "jpeg" &&
            $imageFileType != "gif"
        ) {
            $this->fileError = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $this->hasError = true;
        } else {
            move_uploaded_file($file["tmp_name"], $filePath);
        }

        if ($this->hasError) return $this;

        $userId = $this->auth->id;
        $title = $this->filter($title);
        $body = $this->filter($body);

        $this->database->connect();

        $sql = "
            INSERT INTO posts (
                user_id,
                title,
                body,
                file,
                created_at,
                updated_at
            )
            VALUES (
                '$userId', 
                '$title', 
                '$body',
                '$filename',
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP
            )
        ";

        $this->database->conn->query($sql);

        $this->database->close();

        $this->redirect("home.php");
    }
}
