<?php
    if(session_status() == 2) {
        @session_unset();
    }
    @session_start();
    $title = 'Sign Up';

    require("./config/config.php");
    require("./config/db.php");
    require("./config/errormsg.php");
    require("./inc/inputfieldVar.php");

    ConsoleLog("Session started");

    if(isset($_POST['signup'])) {
        ConsoleLog("Post variable 'signup' submitted");
        $inputName = mysqli_real_escape_string($conn, $_POST['name']);
        $inputPass = mysqli_real_escape_string($conn, $_POST['password']);
        $inputPass2 = mysqli_real_escape_string($conn, $_POST['password2']);

        // Variables to check password strength
        $upperCase = preg_match('@[A-Z]@', $inputPass);
        $lowerCase = preg_match('@[a-z]@', $inputPass);
        $number = preg_match('@[0-9]@', $inputPass);

        // Variables to check if user exists
        $query = "SELECT COUNT(*) AS 'row_number' FROM user WHERE username = '{$inputName}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        // Check if username exists
        if($row["row_number"] > 0) {
            $userExists = true;
            ConsoleLog("Register failed: User exists");
        }
        // Check if password is strong enough
        else if(!$lowerCase || !$number || strlen($inputPass) < 3) {
            $passwordStrong = false;
            ConsoleLog("Register failed: Password is not strong enough");
        }
        // Check if input fields have values
        else if($inputPass !== $inputPass2 || $inputPass == "" || $inputName == "") {
            $inputFailed = true;
            ConsoleLog("Register failed: Wrong inputs");
        }
        //Login successful
        else {
            $hashed_pass = password_hash($inputPass, PASSWORD_DEFAULT);
            $query = "INSERT INTO user(username, password) VALUES('$inputName', '$hashed_pass')";
            
            if(mysqli_query($conn, $query)) {
                $_SESSION['signupSuccessful_msg'] = $signupSuccessful_msg;
                $_SESSION['registeredNow'] = true;
                ConsoleLog("Registration success");
                header('Location: '.ROOT_URL.'/login.php');
            }
            else {
                echo 'Error: '.mysqli_error($conn);
            }
        }
    }
?>

<?php require("./inc/head.php") ?>

<body>
<div class="<?php echo "$container $containerWidth $margin $padding $edge $opacity"; ?>" <?php echo $backgroundColorStlye;?>>
    <?php
        // Registration failed messages
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
                <input type="text" class="form-control" placeholder="Username" name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="password">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Password again</label>
                <input type="password" class="form-control" placeholder="Repeat password" name="password2">
            </div>
            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary rounded" name="signup">Sing Up</button>
                <a style="float:right;" href="<?php echo ROOT_URL; ?>login.php">Log In</a>
            </div>
        </fieldset>
    </form>
</div>
</body>
</html>
