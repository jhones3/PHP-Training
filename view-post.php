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

    $post = (object)[];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST["action"]) {
            case 'posts.delete':
                $postService->delete();
                break;

            case 'logout':
                $userService->logout();
                break;
        }
    } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (!isset($_GET['id'])) {
            header("location: /");
            die();
        }

        $post = $postService->show($_GET['id']);
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
            <img src="<?php echo 'uploads/' . $userService->auth->profile_picture ?>" alt="">
            <h2>
                <?php echo $userService->auth->firstname . " " . $userService->auth->lastname ?>

                <a href="edit-profile.php" class="edit-profile-button">Edit Profile</a>
            </h2>
            <h5><?php echo $userService->auth->username ?></h5>
            <h5><?php echo $userService->auth->email ?></h5>
        </div>
        <div class="main">
            <div class="author">
                <img src="<?php echo 'uploads/' . $post->profile_picture; ?>">
                <p>
                    <strong>
                        <?php echo $post->firstname . ' ' . $post->lastname; ?>
                    </strong>
                    <br>
                    <small>@<?php echo $post->username; ?></small>
                </p>
            </div>

            <form id="post-action" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" value="posts.delete" name="action">
                <input type="hidden" value="<?php echo $post->id; ?>" name="id">

                <?php if ($post->user_id === $userService->auth->id) : ?>
                    <a href="<?php echo 'edit-post.php?id=' . $post->id ?>" class="edit-button">Edit Post</a>
                    <a href="javascript:$('#post-action').submit()" class="delete-button">Delete Post</a>
                <?php endif; ?>
            </form>

            <h2>
                <?php echo $post->title ?>
            </h2>
            <h5>
                <?php
                echo $post->created_at ?
                    (new DateTime($post->created_at))->format("M d, Y h:i a") :
                    "";
                ?>
            </h5>
            <img src="<?php echo 'uploads/' . $post->file ?>" alt="" style="height:200px">
            <p><?php echo $post->body ?></p>
        </div>
    </div>

</body>

</html>