<?php 
    if($_SESSION["permission"] == "admin") {
        $adminButton = true;
    }
?>

<nav class="navbar navbar-default sticky-top bg-white">
    <ul class="nav nav-pills navbar-left">
        <li class="nav-item">
            <a class="nav-link rounded <?php if(isset($homeActive)) {echo "active";} ?>" href="<?php echo ROOT_URL;?>index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded <?php if(isset($addPostActive)) {echo "active";} ?>" href="<?php echo ROOT_URL;?>addblog.php">Write a post</a>
        </li>
    </ul>
    <ul class="nav nav-pills navbar-right">
        <li class="nav-item">
            <?php 
            if(isset($adminButton)) {
                echo "<a class='nav-link rounded "; if(isset($adminActive)) {echo "active";}; echo "' href='admin.php'>Admin</a>";
            } ?>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded <?php if(isset($accountActive)) {echo "active";} ?>" href="account.php">Account</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo ROOT_URL;?>logout.php">Log out</a>
        </li>
    </ul>
</nav>