<?php
    // Database connection variables
    define('ROOT_URL', 'http://localhost/project/PHP-blog_project/');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '12345');
    define('DB_NAME', 'phplogin');

    //Logging function with javascript
    function ConsoleLog($output) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        $js_code = '<script>' . $js_code . '</script>';
        echo $js_code;
    }
?>
