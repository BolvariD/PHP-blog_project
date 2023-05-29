<?php
    @session_start();
    $title = "Admin page";
    $adminActive = true;

    require("./config/config.php");
    require("./config/db.php");






?>

<?php require("./inc/head.php"); ?>

<body>
    <div class="container w-50">
        <?php require("./inc/navbar.php"); ?>

    </div>
</body>
</html>