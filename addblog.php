<?php
    @session_start();
    $sessionStatus = session_status();

    $title = "Write posts";
    $addPostActive = true;
    
    require("./config/config.php");
    require("./config/db.php");

    ConsoleLog("Session status: {$sessionStatus}");

    // Check if the user is logged in
    if(!isset($_SESSION['username'])) {
      ConsoleLog("Session variable 'username': not set");
      header("Location:".ROOT_URL. "login.php");
    }

    // Add post
    if(isset($_POST["submit"]) && !isset($_SESSION["editPost"])) {
      ConsoleLog("Adding post: {$_SESSION["username"]}");
      // Set post variables
      $title = mysqli_real_escape_string($conn, $_POST["title"]);
      $body = mysqli_real_escape_string($conn, $_POST["body"]);
      $author = $_SESSION['username'];
      $created_at = date("Y-m-d H:i:s");

      // Insert post into database
      $query = "INSERT INTO post(title, body, author, created_at) VALUES ('$title', '$body', '$author', '$created_at')";
      
      if(mysqli_query($conn, $query)) {
        ConsoleLog("Adding post successful: {$_SESSION["username"]}");
        header("Location: ".ROOT_URL."index.php");
      }
      else {
        ConsoleLog("Adding post failed: {$_SESSION["username"]}");
        echo mysqli_error($conn);
      }
    }

    // On post editing, input fields are filled with the posts data
    if(isset($_SESSION["editPost"])) {
      ConsoleLog("Editing post: {$_SESSION["username"]}");
      $postID = $_SESSION["editPostID"];

      $query = "SELECT * FROM post WHERE id = ". $postID;
      $result = mysqli_query($conn, $query);
      $editPost = mysqli_fetch_all($result, MYSQLI_ASSOC);

      $title = $editPost[0]["title"];
      $body = $editPost[0]["body"];

      // Edit post
      if(isset($_SESSION["editPost"]) && isset($_POST["submit"])) {
        $newTitle = mysqli_real_escape_string($conn, $_POST["title"]);
        $newBody = mysqli_real_escape_string($conn, $_POST["body"]);

        $query = "UPDATE post SET title='$newTitle', body='$newBody', edited=1 WHERE id = {$postID}";
        if(mysqli_query($conn, $query)) {
          ConsoleLog("Editing post successful: {$_SESSION["username"]}, {$postID} id");
          unset($_SESSION["editPost"]);
          header("Location: ". ROOT_URL. "index.php");
        }
      }
    }
?>

<?php require("./inc/head.php"); ?>

<body>
<div class="container w-50">
  <?php require("./inc/navbar.php"); ?>
  <form method="post">
    <div class="form-group">
        <label class="col-form-label col-form-label-lg mt-4" for="inputLarge">Title</label>
        <input name="title" class="form-control form-control-lg" type="text" id="inputLarge" value="<?php if(isset($_SESSION["editPost"])) {echo $title; } ?>">
    </div>
        <fieldset>
            <div class="form-group">
                <label for="exampleTextarea" class="form-label mt-4">Body</label>
                <textarea name="body" class="form-control" id="exampleTextarea" rows="3"><?php if(isset($_SESSION["editPost"])) {echo $body; } ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-4 rounded" name="submit">Submit</button>
        </fieldset>
  </form>
</div>
</body>
</html>