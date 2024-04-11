<?php

namespace services\support\user;

trait Update
{
    /**
     * Update a specific resource.
     */
    public function update()
    {
        $this->updateValidate();

        $file = $_FILES["profile_picture"];
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

        $id = $this->auth->id;
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $username = $_POST["username"];

        $data = (object)[
            "firstname" => $this->filter($firstname),
            "lastname" => $this->filter($lastname),
            "email" => $this->filter($email),
            "username" => $this->filter($username)
        ];

        if ($filename) $data->profile_picture = $filename;

        $user = $this->updateUserData($id, $data);

        unset($user->password);

        $_SESSION['auth'] = $user;

        $this->redirect("home.php");
    }

    /**
     * Validate input fields.
     */
    protected function updateValidate()
    {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $passwordConfirmation = $_POST["password_confirmation"];

        if (empty($firstname)) {
            $this->firstNameError = "First Name is required";
            $this->hasError = true;
        }

        if (empty($lastname)) {
            $this->lastNameError = "Last Name is required";
            $this->hasError = true;
        }

        if (empty($email)) {
            $this->emailError = "Email is required";
            $this->hasError = true;
        }

        if (empty($username)) {
            $this->usernameError = "Username is required";
            $this->hasError = true;
        }

        if (!empty($password)) {
            if (empty($passwordConfirmation)) {
                $this->passwordConfirmationError = "Confirm Password is required";
                $this->hasError = true;
            }

            if ($password !== $passwordConfirmation) {
                $this->passwordError = "Password confirmation does not match";
                $this->hasError = true;
            }
        }

        if ($username !== $this->auth->username) $this->validateUsername($username);

        if ($email !== $this->auth->email) $this->validateEmail($email);

        return $this;
    }

    /**
     * Save user data.
     * 
     * @param int|string $id
     * @param object $data
     * @return object
     */
    protected function updateUserData($id, $data)
    {
        $response = (object) [];

        $password = $_POST["password"];

        $this->database->connect();

        if (!empty($password)) {
            $password = password_hash($this->filter($password), PASSWORD_ARGON2I);
        }

        $sql = sprintf(
            "
                UPDATE users
                    SET
                        %s%s%s
                    WHERE
                        id = '$id'
            ",
            "
                firstname = '$data->firstname',
                lastname = '$data->lastname',
                email = '$data->email',
                username = '$data->username'
            ",
            (!empty($password)) ? ",password = '$password'" : "",
            ($data->profile_picture) ? ",profile_picture = '$data->profile_picture'" : ""
        );

        $this->database->conn->query($sql);

        $sql = "
            SELECT * FROM users where id = '$id'
        ";

        $result = $this->database->conn->query($sql);

        if ($result->num_rows) {
            $response = (object) $result->fetch_assoc();
        }

        $this->database->close();

        return $response;
    }
}
