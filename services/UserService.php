<?php

namespace services;

include_once("helper/Helper.php");
include_once("services/service.php");
include_once("services/contracts/UserServiceInterface.php");
include_once("services/support/user/Login.php");
include_once("services/support/user/Register.php");
include_once("services/support/user/Update.php");

use helper\Helper;
use services\contracts\UserServiceInterface;
use services\service;
use services\support\user\Login;
use services\support\user\Register;
use services\support\user\Update;

class UserService extends service implements UserServiceInterface
{
    use Helper,
        Login,
        Register,
        Update;

    public $firstNameError = "";
    public $lastNameError = "";
    public $emailError = "";
    public $usernameError = "";
    public $passwordError = "";
    public $passwordConfirmationError = "";
    public $fileError = "";
    public $hasError = false;

    /**
     * Logout user and destroy session.
     */
    public function logout()
    {
        session_destroy();

        $this->redirect("home.php");
    }

    /**
     * Check if username is already exists
     * 
     * @param string $username
     * @return void
     */
    protected function validateUsername($username)
    {
        $this->database->connect();

        $sql = "
            SELECT * FROM users WHERE username = '$username'
        ";

        $result = $this->database->conn->query($sql);

        if ($result->num_rows) {
            $this->usernameError = "Username is already exists";
            $this->hasError = true;
        }

        $this->database->close();

        return $this;
    }

    /**
     * Check if email is already exists
     * 
     * @param string $email
     * @return void
     */
    protected function validateEmail($email)
    {
        $this->database->connect();

        $sql = "
            SELECT * FROM users WHERE email = '$email'
        ";

        $result = $this->database->conn->query($sql);

        if ($result->num_rows) {
            $this->emailError = "Email already exists";
            $this->hasError = true;
        }

        $this->database->close();

        return $this;
    }
}
