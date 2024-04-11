<?php

namespace services\support\user;

trait Register
{
    /**
     * Store new user.
     */
    public function register()
    {
        $this->storeValidate();

        if ($this->hasError) return $this;

        $file = $_FILES["profile_picture"];
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

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $data = (object)[
            "firstname" => $this->filter($firstname),
            "lastname" => $this->filter($lastname),
            "email" => $this->filter($email),
            "username" => $this->filter($username),
            "password" => password_hash($this->filter($password), PASSWORD_ARGON2I),
            "profile_picture" => $filename
        ];

        $user = $this->saveUserToDatabase($data);

        unset($user->password);

        $_SESSION['auth'] = $user;

        $this->redirect("home.php");
    }

    /**
     * Validate input fields.
     */
    protected function storeValidate()
    {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $passwordConfirmation = $_POST["password_confirmation"];
        $file = $_FILES["profile_picture"];

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

        if (empty($password)) {
            $this->passwordError = "Password is required";
            $this->hasError = true;
        }

        if (empty($passwordConfirmation)) {
            $this->passwordConfirmationError = "Confirm Password is required";
            $this->hasError = true;
        }

        if ($password !== $passwordConfirmation) {
            $this->passwordError = "Password confirmation does not match";
            $this->hasError = true;
        }

        if (!file_exists($file["tmp_name"])) {
            $this->fileError = "Please upload profile picture";
            $this->hasError = true;
        }

        $this->validateUsername($username);
        $this->validateEmail($email);

        return $this;
    }

    /**
     * Save user data to database.
     * 
     * @param object $data
     */
    protected function saveUserToDatabase($data)
    {
        $response = (object) [];

        $this->database->connect();

        $sql = "
            INSERT INTO users (
                firstname, 
                lastname, 
                email, 
                username, 
                password,
                profile_picture,
                created_at,
                updated_at
            )
            VALUES (
                '$data->firstname', 
                '$data->lastname', 
                '$data->email', 
                '$data->username', 
                '$data->password',
                '$data->profile_picture',
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP
            )
        ";

        if ($this->database->conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->database->conn->error;

            return (object) [];
        }

        $sql = "
            SELECT * FROM users WHERE email = '$data->email'
        ";

        $result = $this->database->conn->query($sql);

        if ($result->num_rows) {
            $response = (object) $result->fetch_assoc();
        }

        $this->database->close();

        return $response;
    }
}
