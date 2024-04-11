<?php

namespace services\support\user;

trait Login
{
    /**
     * Authenticate user.
     */
    public function login()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (empty($username)) {
            $this->usernameError = "Username is required";
            $this->hasError = true;
        }

        if (empty($password)) {
            $this->passwordError = "Password is required";
            $this->hasError = true;
        }

        $user = $this->authenticate();

        if ($this->hasError) return $this;

        unset($user->password);

        $_SESSION['auth'] = $user;

        $this->redirect("home.php");
    }

    /**
     * Verify user credentials.
     * 
     * @return object
     */
    protected function authenticate()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $response = (object) [];

        $this->database->connect();

        $sql = "
            SELECT * FROM users where username = '$username'
        ";

        $result = $this->database->conn->query($sql);

        if ($result->num_rows) {
            $response = (object) $result->fetch_assoc();

            if (!password_verify($password, $response->password)) {
                $this->usernameError = "Invalid credentials";
                $this->hasError = true;
            }
        } else {
            $this->usernameError = "Invalid credentials";
            $this->hasError = true;
        }

        $this->database->close();

        return $response;
    }
}
