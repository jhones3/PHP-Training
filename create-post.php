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
    include_once("services/PostService.php");
    include_once("services/UserService.php");

    use services\PostService;
    use services\UserService;

    $postService = new PostService;
    $userService = (new UserService);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST["action"]) {
            case 'posts.store':
                $postService->store();
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
            <a href="create-post.php" class="active">Create Post</a>
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
            <h3>Create Post</h3>

            <div class="container">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="posts.store">

                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="Your title.." required>
                    <p class="error"><?php echo $postService->titleError; ?></p>

                    <input type="file" name="file" id="file">
                    <p class="error"><?php echo $postService->fileError; ?></p>

                    <label for="body">Body</label>
                    <textarea id="body" name="body" placeholder="Write something.." style="height:200px" required></textarea>
                    <p class="error"><?php echo $postService->bodyError; ?></p>

                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

</body>

</html>