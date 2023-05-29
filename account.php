<?php
    @session_start();
    $title = "Your account";
    $accountActive = true;
    $sessionStatus = session_status();

    require("./config/config.php");
    require("./config/db.php");
    require("./config/errormsg.php");
    require("./inc/inputfieldVar.php");

    ConsoleLog("Session status: {$sessionStatus}");

    // Check if the user is logged in
    if(!isset($_SESSION['username'])) {
        ConsoleLog("Failed to access account.php: you are not logged in");
        header("Location:".ROOT_URL. "login.php");
    }

    // Button variables
    $editProfile = false;
    $submitChangeButton = '<button name="submitChange" type="submit" class="btn btn-outline-primary rounded">Submit</button>';
    $deleteButton = '<button name="deleteProfile" type="submit" class="btn btn-outline-danger rounded">Delete</button>';
    $editButton = '<button name="editProfile" type="submit" class="btn btn-outline-primary ms-3 rounded-pill">Edit</button>';

    // Store users data from database
    $query = "SELECT * FROM user WHERE username = '{$_SESSION["username"]}'";
    $result = mysqli_query($conn, $query);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ConsoleLog("Fetching user data was successful: {$_SESSION["username"]}");

    // Delete profile
    if(isset($_POST["deleteProfile"])) {
        ConsoleLog("Deleting profile: {$_SESSION["username"]}");
        // Posts of the author are changed to deleted
        $query = "UPDATE post SET author = 'deleted' WHERE author = '{$_SESSION["username"]}'";
        if(mysqli_query($conn, $query)) {
            $queryDelete = "DELETE FROM user WHERE username = '{$_SESSION["username"]}'";
            if(mysqli_query($conn, $queryDelete)) {
                ConsoleLog("Deleting profile successful: {$_SESSION["username"]}");
                header("Location: ". ROOT_URL. "logout.php");
            }
            else {
                ConsoleLog("Deleting profile failed: {$_SESSION["username"]}. Could not delete profile");
                echo mysqli_error($conn);
            }
        }
        else {
            ConsoleLog("Deleting profile failed: {$_SESSION["username"]}. Could not update posts author");
            echo mysqli_error($conn);
        }
    }

    // Edit profile
    if(isset($_POST['editProfile'])) {
        ConsoleLog("Editing profile: {$_SESSION["username"]}");
        $editProfile = true;
        $inputName = mysqli_real_escape_string($conn, $_SESSION["username"]);
    }

    // Submit edit changes
    if(isset($_POST["submitChange"])) {
        ConsoleLog("Submitted profile editing: {$_SESSION["username"]}");
        $newUser = mysqli_real_escape_string($conn, $_POST["newUser"]);
        $newPass = mysqli_real_escape_string($conn, $_POST["newPassword"]);

        $upperCase = preg_match('@[A-Z]@', $newPass);
        $lowerCase = preg_match('@[a-z]@', $newPass);
        $number = preg_match('@[0-9]@', $newPass);

        $query = "SELECT COUNT(*) AS row_number FROM user WHERE username = '{$newUser}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        // Check if username exists, but it can be the same
        if($newUser != $_SESSION["username"] && $row["row_number"] > 0) {
            $userExists = true;
            ConsoleLog("Editing profile failed: {$_SESSION["username"]}. Username already exists");
        }
        else if((!$lowerCase || !$number || strlen($newPass)) < 3 && !empty($newPass)) {
            $passwordStrong = false;
            ConsoleLog("Editing profile failed: {$_SESSION["username"]}. Your password is not strong enough");
        }
        else if($newUser == "") {
            $inputFailed = true;
            ConsoleLog("Editing profile failed: {$_SESSION["username"]}. Input field cannot be empty");
        }
        else {
            // Edit username only
            if(empty($newPass)) {
                ConsoleLog("Editing profile successful: {$_SESSION["username"]} -> {$_SESSION["newUser"]}. Username changed");
                $query = "UPDATE user SET username = '{$newUser}' WHERE id = ". $_POST["userID"];
                mysqli_query($conn, $query);
                $_SESSION["username"] = $newUser;
                header('Location: '.ROOT_URL.'/index.php');
            }
            // Edit password (and username)
            else {
                $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
                $query = "UPDATE user SET username = '{$newUser}', password = '{$hashedPass}' WHERE id = ". $_POST["userID"];
                mysqli_query($conn, $query);
                $_SESSION["username"] = $newUser;
                ConsoleLog("Editing profile successful: {$_SESSION["username"]}");
                header('Location: '.ROOT_URL.'/index.php');
            }
        }
    }

    // Cancel profile editing
    if(isset($_POST["cancelChange"])) {
        ConsoleLog("Cancelled profile editing: {$_SESSION["username"]}");
        header("Location: ". ROOT_URL. "account.php");
    }
?>

<?php require("./inc/head.php") ?>

<body>
    <div class="<?php echo "$container $containerWidth"; ?>"><?php require("./inc/navbar.php") ?></div>
    <div class="<?php echo "$container $containerWidth $margin"; ?>">
    <?php 
        // Error messages
        if(isset($_POST["submitChange"])) {
            if($inputFailed) {
                echo $inputFailed_msg;
            }
            else if(!$passwordStrong) {
                echo $passwordStrong_msg;
            }
            else if ($userExists) {
                echo $userExists_msg;
            }
        }
    ?>
        <div class="card mb-3">
            <form method="post">
            <h3 class="card-header">Profile</h3>
            <!-- Display input fields or user data -->
            <?php foreach($posts as $post) : ?>
                <div class="card-body">
                    <!-- Print username if not editing -->
                    <?php if(!$editProfile)  :?>
                        <h5 class="card-title">Username: <?php echo $_SESSION["username"]; ?></h5>
                    <!-- Print username input field if editing -->
                    <?php else :?>
                        <input type="text" class="form-control" placeholder="Username" name="newUser" value="<?php echo $_SESSION["username"]; ?>">
                        <input type="hidden" name="userID" value="<?php echo $post["id"]; ?>">
                    <?php endif; ?>
                </div>
                <ul class="list-group list-group-flush">
                    <!-- Print user privilege if not editing -->
                    <?php if(!$editProfile)  :?>
                        <li class="list-group-item p-3">User level: <?php echo $_SESSION["permission"]; ?></li>
                    <!-- Print password input field if editing -->
                    <?php else :?>
                        <li class="list-group-item p-3"><input type="password" class="form-control" placeholder="Password" name="newPassword"></li>
                    <?php endif; ?>
                </ul>
            <?php endforeach; ?>
            <div class="card-body">
                    <!-- Buttons -->
                    <?php if(!$editProfile)  :?>
                        <button name="deleteProfile" type="submit" class="btn btn-outline-danger rounded">Delete</button>
                        <button name="editProfile" type="submit" class="btn btn-outline-primary ms-3 rounded-pill">Edit</button>
                    <?php else : ?>
                        <button name="submitChange" type="submit" class="btn btn-outline-primary rounded">Submit</button>
                        <button name="cancelChange" type="submit" class="btn btn-outline-danger ms-3 rounded-pill">Cancel</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</body>
</html>