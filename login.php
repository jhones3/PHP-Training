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

    if ($_SERVER["REQUEST_METHOD"] == "POST") $userService->login();
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="container">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>
            <p class="error"><?php echo $userService->usernameError; ?></p>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
            <p class="error"><?php echo $userService->passwordError; ?></p>

            <button type="submit">Login</button>

            Need an account? <a href="register.php">register here</a>
        </div>
    </form>

</body>

</html>