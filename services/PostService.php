<?php

namespace services;

include_once("helper/Helper.php");
include_once("middleware/Authorization.php");
include_once("services/service.php");
include_once("services/contracts/PostServiceInterface.php");
include_once("services/support/post/Store.php");
include_once("services/support/post/GetPosts.php");
include_once("services/support/post/Show.php");
include_once("services/support/post/Update.php");

use helper\Helper;
use middleware\Authorization;
use services\contracts\PostServiceInterface;
use services\service;
use services\support\post\Store;
use services\support\post\GetPosts;
use services\support\post\Show;
use services\support\post\Update;

class PostService extends service implements PostServiceInterface
{
    use Helper,
        Store,
        GetPosts,
        Show,
        Update;

    public $titleError = "";
    public $bodyError = "";
    public $fileError = "";
    public $hasError = false;

    /**
     * Delete a specific resource.
     */
    public function delete()
    {
        $id = $_POST["id"];

        (new Authorization)->handle($id);

        $this->database->connect();

        $sql = "
            DELETE FROM posts WHERE id = $id
        ";

        $this->database->conn->query($sql);

        $this->database->close();

        $this->redirect("home.php");
    }
}
