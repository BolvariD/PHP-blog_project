<?php
    @session_start();
    $title = "Write posts";
    $addPostActive = true;
    
    require("./config/config.php");
    require("./config/db.php");

    // Csak bejelentkezéssel lehet az oldalt megtekinteni
    if(!isset($_SESSION['username'])) {
        header("Location:".ROOT_URL. "login.php");
    }

    // Poszt hozzáadása, nem módosítás
    if(isset($_POST["submit"]) && !isset($_SESSION["editPost"])) {
      $title = mysqli_real_escape_string($conn, $_POST["title"]);
      $body = mysqli_real_escape_string($conn, $_POST["body"]);
      $author = $_SESSION['username'];
      $created_at = date("Y-m-d H:i:s");

      $query = "INSERT INTO post(title, body, author, created_at) VALUES ('$title', '$body', '$author', '$created_at')";
      
      if(mysqli_query($conn, $query)) {
        header("Location: ".ROOT_URL."index.php");
      }
      else {
        echo mysqli_error($conn);
      }
    }

    // Módosításkor átállítja a mezők értékét az eredeti poszt értékeire
    if(isset($_SESSION["editPost"])) {
      $postID = $_SESSION["editPostID"];

      $query = "SELECT * FROM post WHERE id = ". $postID;
      $result = mysqli_query($conn, $query);
      $editPost = mysqli_fetch_all($result, MYSQLI_ASSOC);

      $title = $editPost[0]["title"];
      $body = $editPost[0]["body"];

      // Módosítás végrehajtása
      if(isset($_SESSION["editPost"]) && isset($_POST["submit"])) {
        $newTitle = mysqli_real_escape_string($conn, $_POST["title"]);
        $newBody = mysqli_real_escape_string($conn, $_POST["body"]);

        $query = "UPDATE post SET title='$newTitle', body='$newBody', edited=1 WHERE id = {$postID}";
        if(mysqli_query($conn, $query)) {
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