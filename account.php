<?php
    @session_start();
    $title = "Your account";
    $accountActive = true;

    require("./config/config.php");
    require("./config/db.php");
    require("./config/errormsg.php");
    require("./inc/inputfieldVar.php");

    if(!isset($_SESSION['username'])) {
        header("Location:".ROOT_URL. "login.php");
    }

    $editProfile = false;
    $submitChangeButton = '<button name="submitChange" type="submit" class="btn btn-outline-primary rounded">Submit</button>';
    $deleteButton = '<button name="deleteProfile" type="submit" class="btn btn-outline-danger rounded">Delete</button>';
    $editButton = '<button name="editProfile" type="submit" class="btn btn-outline-primary ms-3 rounded-pill">Edit</button>';

    $query = "SELECT * FROM user WHERE username = '{$_SESSION["username"]}'";
    $result = mysqli_query($conn, $query);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(isset($_POST["deleteProfile"])) {
        //A felhasználó posztjainál az author -> deleted; Így ha ugyan azt a felhasználót létrehozzák, nem lehet a régi posztot módosítani
        $query = "UPDATE post SET author = 'deleted' WHERE author = '{$_SESSION["username"]}'";
        if(mysqli_query($conn, $query)) {
            $queryDelete = "DELETE FROM user WHERE username = '{$_SESSION["username"]}'";
            if(mysqli_query($conn, $queryDelete)) {
                header("Location: ". ROOT_URL. "logout.php");
            }
            else {
                echo mysqli_error($conn);
            }
        }
        else {
            echo mysqli_error($conn);
        }
    }

    if(isset($_POST['editProfile'])) {
        $editProfile = true;
        $inputName = mysqli_real_escape_string($conn, $_SESSION["username"]);
    }

    if(isset($_POST["submitChange"])) {
        $newUser = mysqli_real_escape_string($conn, $_POST["newUser"]);
        $newPass = mysqli_real_escape_string($conn, $_POST["newPassword"]);

        $upperCase = preg_match('@[A-Z]@', $newPass);
        $lowerCase = preg_match('@[a-z]@', $newPass);
        $number = preg_match('@[0-9]@', $newPass);

        $query = "SELECT COUNT(*) AS row_number FROM user WHERE username = '{$newUser}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        if($newUser != $_SESSION["username"] && $row["row_number"] > 0) {
            $userExists = true;
        }
        else if((!$lowerCase || !$number || strlen($newPass)) < 3 && !empty($newPass)) {
            $passwordStrong = false;
        }
        else if($newUser == "") {
            $inputFailed = true;
        }
        else {
            if(empty($newPass)) {
                $query = "UPDATE user SET username = '{$newUser}' WHERE id = ". $_POST["userID"];
                mysqli_query($conn, $query);
                $_SESSION["username"] = $newUser;
                header('Location: '.ROOT_URL.'/index.php');
            }
            else {
                $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
                $query = "UPDATE user SET username = '{$newUser}', password = '{$hashedPass}' WHERE id = ". $_POST["userID"];
                mysqli_query($conn, $query);
                $_SESSION["username"] = $newUser;
                header('Location: '.ROOT_URL.'/index.php');
            }
            if(mysqli_query($conn, $query)) {
                $_SESSION["username"] = $newUser;
                header('Location: '.ROOT_URL.'/index.php');
            }
            else {
                echo 'Error: '.mysqli_error($conn);
            }
        }
    }

    if(isset($_POST["cancelChange"])) {
        header("Location: ". ROOT_URL. "account.php");
    }
?>

<?php require("./inc/head.php") ?>

<body>
    <div class="<?php echo "$container $containerWidth"; ?>"><?php require("./inc/navbar.php") ?></div>
    <div class="<?php echo "$container $containerWidth $margin"; ?>">
        <div class="card mb-3">
            <form method="post">
            <h3 class="card-header">Profile</h3>
            <?php foreach($posts as $post) : ?>
                <div class="card-body">
                    <?php if(!$editProfile)  :?>
                        <h5 class="card-title">Username: <?php echo $_SESSION["username"]; ?></h5>
                    <?php else :?>
                        <input type="text" class="form-control" placeholder="Username" name="newUser" value="<?php echo $_SESSION["username"]; ?>">
                        <input type="hidden" name="userID" value="<?php echo $post["id"]; ?>">
                    <?php endif; ?>
                </div>
                <ul class="list-group list-group-flush">
                    <?php if(!$editProfile)  :?>
                        <li class="list-group-item p-3">User level: <?php echo $_SESSION["permission"]; ?></li>
                    <?php else :?>
                        <li class="list-group-item p-3"><input type="password" class="form-control" placeholder="Password" name="newPassword"></li>
                    <?php endif; ?>
                </ul>
            <?php endforeach; ?>
            <div class="card-body">
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


<!-- <div class="<?php echo "$container $containerWidth $margin $padding $edge $opacity"; ?>" <?php echo $backgroundColorStlye;?>>
    <?php 
        if(isset($_POST["signup"])) {
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
    <h1>Sing Up</h1>
    <form method="post">
        <fieldset>
            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label mt-4">Username</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username" name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Password again</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Repeat password" name="password2">
            </div>
            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary rounded" name="signup">Sing Up</button>
                <a style="float:right;" href="<?php echo ROOT_URL; ?>login.php">Log In</a>
            </div>
        </fieldset>
    </form>
</div> -->
</body>
</html>