<?php
include_once("middleware/Authentication.php");

use middleware\Authentication;

(new Authentication)->handle();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blog</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php
    include_once("services/UserService.php");

    use services\UserService;

    $userService = (new UserService);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST["action"]) {
            case 'users.update':
                $userService->update();

                break;

            case 'logout':
                $userService->logout();
                break;
        }
    }
    ?>

    <form id="navbar" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="action" value="logout">

        <div class="navbar">
            <a href="/">Home</a>
            <a href="create-post.php">Create Post</a>
            <a href="javascript:$('#navbar').submit()" class="right">Logout</a>
        </div>
    </form>

    <div class="row">
        <div class="side">
            <img src="<?php echo 'uploads/' . $userService->auth->profile_picture ?>" alt="" style="height:200px;">
            <h2>
                <?php echo $userService->auth->firstname . " " . $userService->auth->lastname ?>

                <a href="edit-profile.php" class="edit-profile-button">Edit Profile</a>
            </h2>
            <h5><?php echo $userService->auth->username ?></h5>
            <h5><?php echo $userService->auth->email ?></h5>
        </div>
        <div class="main">
            <h3>Edit Post</h3>

            <div class="container">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="users.update">

                    <label for="profile_picture"><b>Profile Picture</b></label>
                    <br>
                    <input type="file" name="profile_picture" id="profile_picture">
                    <p class="error"><?php echo $userService->fileError; ?></p>

                    <label for="firstname"><b>First Name</b></label>
                    <input type="text" value="<?php echo $userService->auth->firstname ?>" placeholder="Enter First Name" name="firstname" required>
                    <p class="error"><?php echo $userService->firstNameError; ?></p>

                    <label for="lastname"><b>Last Name</b></label>
                    <input type="text" value="<?php echo $userService->auth->lastname ?>" placeholder="Enter Last Name" name="lastname" required>
                    <p class="error"><?php echo $userService->lastNameError; ?></p>

                    <label for="email"><b>Email</b></label>
                    <input type="email" value="<?php echo $userService->auth->email ?>" placeholder="Enter Email" name="email" required>
                    <p class="error"><?php echo $userService->emailError; ?></p>

                    <label for="username"><b>Username</b></label>
                    <input type="text" value="<?php echo $userService->auth->username ?>" placeholder="Enter Username" name="username" required>
                    <p class="error"><?php echo $userService->usernameError; ?></p>

                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password">
                    <p class="error"><?php echo $userService->passwordError; ?></p>

                    <label for="password_confirmation"><b>Confirm Password</b></label>
                    <input type="password" placeholder="Enter Confirm Password" name="password_confirmation">
                    <p class="error"><?php echo $userService->passwordConfirmationError; ?></p>

                    <input type="submit" value="Save">
                </form>
            </div>
        </div>
    </div>

</body>

</html>