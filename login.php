<?php
    @session_start();
    $title = 'Log In';

    require("./config/config.php");
    require("./config/db.php");
    require("./config/errormsg.php");
    require("./inc/inputfieldVar.php");

    ConsoleLog("Session started");

    if(isset($_POST["login"])) {
        ConsoleLog("Input successful");
        $inputName = mysqli_real_escape_string($conn, $_POST["name"]);
        $inputPass = mysqli_real_escape_string($conn, $_POST["password"]);

        $query = "SELECT * FROM user WHERE username = '{$inputName}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        if(!empty($row)) {
            $databaseUser = $row["username"];
            $databasePass = $row["password"];
            $permission = $row["permission"];
            if(password_verify($inputPass, $databasePass) && $inputName == $databaseUser) {
                ConsoleLog("Login sucessful");
                $_SESSION["username"] = $inputName;
                $_SESSION["permission"] = $permission;
                ConsoleLog("Session variables set: username, permission");
                header('Location: '.ROOT_URL.'/index.php');
            }
            else {
                $loginFailed = true;
                ConsoleLog("Login failed: wrong password");
            }
        }
        else {
            $loginFailed = true;
            ConsoleLog("Login failed: username does not exist");
        }
    }
?>

<?php require("./inc/head.php") ?>

<body>
<div class="<?php echo "$container $containerWidth $margin $padding $edge $opacity"; ?>" <?php echo $backgroundColorStlye;?>>
    <?php
        if(session_status() == 2) {
            if(isset($_SESSION['registeredNow'])) {
                ConsoleLog("Registered");
                echo $_SESSION['signupSuccessful_msg'];
                unset($_SESSION['registeredNow']);
                ConsoleLog("registeredNow variable: unset");
            }
        }
        if(isset($_POST["login"])) {
            if($loginFailed) {
                ConsoleLog("Login failed: loginFailed_msg");
                echo $loginFailed_msg;
            }
        }
    ?>
    <h1>Log In</h1>
    <form method="post">
        <fieldset>
            <div class="form-group">
                <label class="form-label mt-4">Username</label>
                <input type="text" class="form-control" placeholder="Username" name="name">
            </div>
            <div class="form-group">
                <label class="form-label mt-4">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="password">
            </div>
            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary rounded" name="login">Log In</button>
                <a style="float:right;" href="<?php echo ROOT_URL; ?>register.php">Sign Up</a>
            </div>
        </fieldset>
    </form>
</div>
</body>
</html>
