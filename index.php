<?php
    @session_start();
    $sessionStatus = session_status();

    $title = "Blog";
    $homeActive = true;

    require("./config/config.php");
    require("./config/db.php");

    ConsoleLog("Session status: {$sessionStatus}");

    // Check if the user is logged in
    if(!isset($_SESSION['username'])){
	    ConsoleLog("Session variable 'username': not set");
        header("Location:".ROOT_URL. "login.php");
    }

    // Changing page from editing post: input characters disappear
    if(isset($_SESSION["editPost"])) {
        unset($_SESSION["editPost"]);
	    ConsoleLog("Session vaiable 'editPost': unset");
    }

    // Print posts from database
    $query = "SELECT * FROM post ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Post button variables
    $deleteButton = '<button name="deletePost" type="submit" class="btn btn-outline-danger float-end rounded">Delete</button>';
    $editButton = '<button name="editPost" type="submit" class="btn btn-outline-primary float-end me-3 rounded-pill">Edit</button>';

    // Edit button:
    if(isset($_POST["editPost"])) {
        // Set Session variables: addblog.php will edit the post, instead of adding one more
        $_SESSION["editPost"] = true;
        $_SESSION["editPostID"] = $_POST["post_id"];
        ConsoleLog("Editing post: {$_POST["post_id"]} id");
        header('Location: '. ROOT_URL .'/addblog.php');
    }

    // Delete button:
    if(isset($_POST["deletePost"])) {
        $postID = mysqli_real_escape_string($conn, $_POST["post_id"]);
        $deleteQuery = 'DELETE FROM post WHERE id = '. $postID;

        if(mysqli_query($conn, $deleteQuery)) {
            ConsoleLog("Deleting post successful: {$_POST["post_id"]} id");
            header('Location: ' .ROOT_URL. 'index.php');
        }
        else {
            ConsoleLog("Deleting post failed: {$_POST["post_id"]} id");
            echo mysqli_error($conn);
        }
    }
?>

<?php require("./inc/head.php"); ?>

<body>
    <div class="container w-50">
        <?php require("./inc/navbar.php"); ?>
        <?php foreach($posts as $post) : ?>
            <div class="card mt-2 rounded">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $post["title"]; ?></h4>
                    <p class="card-text"><?php echo $post["body"]; ?></p>
                    <label class="card-link"><?php echo explode(" ", $post["created_at"])[0]; ?></label>
                    <span class="card-link"><?php echo $post["author"]; ?></span>
                    <?php
                        if($post["edited"] == 1) {
                            echo "<small>Edited</small>";
                        }
                    ?>
                    <form class="w-50 float-end" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">
                        <?php
                            if($_SESSION["username"] == $post["author"] || $_SESSION["permission"] == "moderator" || $_SESSION["permission"] == "admin") {
                                echo $deleteButton;
                            }
                            if($_SESSION["username"] == $post["author"] || $_SESSION["permission"] == "admin") {
                                echo $editButton;
                            }
                        ?>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
