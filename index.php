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
    $editButton = '<button name="editPost" type="submit" class="btn btn-outline-primary float-end me-2 rounded-pill">Edit</button>';

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

    // Like button:
    if (isset($_POST['likePost'])) {
        $queryLikePost = "INSERT INTO likes(post_id, user_id) VALUES('{$_POST['post_id']}', '{$_SESSION['userid']}')";
        mysqli_query($conn, $queryLikePost);
        ConsoleLog("Post: {$_POST['post_id']} liked: {$_SESSION['username']}");
    }
    // Unlike:
    if(isset($_POST['likePost']) && isset($_POST['likeActive']) && $_POST['likeActive']) {
        $queryUnlikePost = "DELETE FROM likes WHERE post_id = {$_POST['post_id']} AND user_id = {$_SESSION['userid']}";
        mysqli_query($conn, $queryUnlikePost);
        ConsoleLog("Post: {$_POST['post_id']} unliked: {$_SESSION['username']}");
    }

?>

<?php require("./inc/head.php"); ?>

<body>
    <div class="container w-50">
        <?php require("./inc/navbar.php"); ?>
        <?php foreach($posts as $post) : ?>
            <div class="card mt-2 rounded">
                <div class="card-body">
                    <!-- Card info -->
                    <h4 class="card-title"><?php echo $post["title"]; ?></h4>
                    <p class="card-text"><?php echo $post["body"]; ?></p>
                    <label class="card-link"><?php echo explode(" ", $post["created_at"])[0]; ?></label>
                    <span class="card-link"><?php echo $post["author"]; ?></span>
                    <?php
                        if($post["edited"] == 1) {
                            echo "<small>Edited</small>";
                        }
                    ?>
                    <!-- Action buttons -->
                    <form class="d-flex float-end align-items-center" method="post" style="width: 60%;">
                        <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">
                        <!-- Like counter -->
                        <span class="text-muted float-start me-3 ms-1"><?php 
                            // Display like numbers if there is at least 1
                            $queryLikes = "SELECT COUNT(*) AS like_number FROM likes WHERE post_id = {$post['id']}";
                            $resultLikes = mysqli_query($conn, $queryLikes);
                            $rowLikes = mysqli_fetch_all($resultLikes, MYSQLI_ASSOC);
                            if(isset($rowLikes[0]['like_number']) && intval($rowLikes[0]['like_number']) > 0) {
                                echo $rowLikes[0]['like_number'];
                            }
                            // Make like button active if the user liked it
                            $queryLiked = "SELECT * FROM likes WHERE user_id = {$_SESSION['userid']} AND post_id = {$post['id']}";
                            $resultLiked = mysqli_query($conn, $queryLiked);
                            $rowLiked = mysqli_fetch_all($resultLiked, MYSQLI_ASSOC);
                            $likeActive = false;
                            if(!empty($rowLiked)) {
                                $likeActive = true;
                            }
                        ?></span>
                        <!-- Like button -->
                        <input type="hidden" name="likeActive" value="<?php echo $likeActive; ?>">
                        <button class="btn btn-outline-primary me-auto float-start rounded-pill <?php if(isset($likeActive) && $likeActive) {echo "active";} ?>" name="likePost" type="submit">🦆</button>
                        <!-- Edit and delete buttons -->
                        <?php
                            if($_SESSION["username"] == $post["author"] || $_SESSION["permission"] == "admin") {
                                echo $editButton;
                            }
                            if($_SESSION["username"] == $post["author"] || $_SESSION["permission"] == "moderator" || $_SESSION["permission"] == "admin") {
                                echo $deleteButton;
                            }
                        ?>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
