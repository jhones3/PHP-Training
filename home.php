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
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>

<body>
    <?php
    include_once("services/UserService.php");
    include_once("services/PostService.php");

    use services\UserService;
    use services\PostService;

    $userService = (new UserService);
    $postService = (new PostService);

    $posts = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST["action"]) {
            case 'logout':
                $userService->logout();
                break;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $posts = $postService->getPosts();
    }
    ?>

    <form id="navbar" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="action" value="logout">

        <div class="navbar">
            <a href="/" class="active">Home</a>
            <a href="create-post.php">Create Post</a>
            <a href="javascript:$('#navbar').submit()" class="right">Logout</a>
        </div>
    </form>

    <div class="row">
        <div class="side">
            <img src="<?php echo 'uploads/' . $userService->auth->profile_picture ?>" alt="">
            <h2>
                <?php echo $userService->auth->firstname . " " . $userService->auth->lastname ?>

                <a href="edit-profile.php" class="edit-profile-button">Edit Profile</a>
            </h2>
            <h5><?php echo $userService->auth->username ?></h5>
            <h5><?php echo $userService->auth->email ?></h5>
        </div>
        <div class="main">
            <?php foreach ($posts as $key => $value) : ?>
                <div onclick="location.href = 'view-post.php?id=' + <?php echo $value->id; ?>;" class="post">
                    <div class="author">
                        <img src="<?php echo 'uploads/' . $value->profile_picture; ?>">
                        <p>
                            <strong>
                                <?php echo $value->firstname . ' ' . $value->lastname; ?>
                            </strong>
                            <br>
                            <small>@<?php echo $value->username; ?></small>
                        </p>
                    </div>

                    <h2><?php echo $value->title; ?></h2>
                    <h5>
                        <?php
                        echo $value->created_at ?
                            (new DateTime($value->created_at))->format("M d, Y h:i a") :
                            "";
                        ?>
                    </h5>
                    <img src="<?php echo 'uploads/' . $value->file ?>" alt="" style="height:200px">
                    <p><?php echo $value->body; ?></p>
                </div>
                <br>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>