<?php
    // Connect to database
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(mysqli_connect_errno()) {
        echo 'Failed to connect: '. mysqli_connect_errno();
    }
?>