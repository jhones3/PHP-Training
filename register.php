<?php
include_once("middleware/Guest.php");

use middleware\guest;

(new guest)->handle();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blog</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/styles.css">

    <style>
        html,
        body {
            min-height: 100%;
            margin: auto;
            display: grid;
        }

        form {
            border: 3px solid #f1f1f1;
            max-width: 500px;
            margin: auto;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }

        .container {
            padding: 16px;
        }
    </style>
</head>

<body>

    <?php
    include_once("services/UserService.php");

    use services\UserService;

    $userService = new UserService;

    if ($_SERVER["REQUEST_METHOD"] == "POST") $userService->register();
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="container">
            <label for="profile_picture"><b>Profile Picture</b></label>
            <br>
            <input type="file" name="profile_picture" id="profile_picture">
            <p class="error"><?php echo $userService->fileError; ?></p>

            <label for="firstname"><b>First Name</b></label>
            <input type="text" placeholder="Enter First Name" name="firstname" required>
            <p class="error"><?php echo $userService->firstNameError; ?></p>

            <label for="lastname"><b>Last Name</b></label>
            <input type="text" placeholder="Enter Last Name" name="lastname" required>
            <p class="error"><?php echo $userService->lastNameError; ?></p>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" required>
            <p class="error"><?php echo $userService->emailError; ?></p>

            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>
            <p class="error"><?php echo $userService->usernameError; ?></p>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
            <p class="error"><?php echo $userService->passwordError; ?></p>

            <label for="password_confirmation"><b>Confirm Password</b></label>
            <input type="password" placeholder="Enter Confirm Password" name="password_confirmation" required>
            <p class="error"><?php echo $userService->passwordConfirmationError; ?></p>

            <button type="submit">Register</button>

            Already have an account? <a href="login.php">login here</a>
        </div>
    </form>

</body>

</html>