<?php
    define('ROOT_URL', 'http://98.71.184.22/');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '12345');
    define('DB_NAME', 'phplogin');


    //Logging
    function ConsoleLog($output) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        $js_code = '<script>' . $js_code . '</script>';
        echo $js_code;
    }
?>
