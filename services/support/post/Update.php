<?php

namespace services\support\post;

trait Update
{
    /**
     * Update a specific resource.
     */
    public function update()
    {
        $id = $_POST["id"];
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

        $filename = null;

        if (file_exists($file["tmp_name"])) {
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
        }

        if ($this->hasError) return $this;

        $title = $this->filter($title);
        $body = $this->filter($body);

        $this->database->connect();

        $sql = sprintf(
            "
                UPDATE posts
                SET
                    %s%s
                WHERE
                    id = '$id'
            ",
            "
                title = '$title',
                body = '$body'
            ",
            ($filename) ? ",file = '$filename'" : ""
        );

        $this->database->conn->query($sql);

        $this->database->close();

        $this->redirect("view-post.php?id=$id");
    }
}
