<?php

$full_script_name = strtok(__DIR__ . $_SERVER['REQUEST_URI'], '?');
if (is_file($full_script_name) && (strstr($_SERVER['SCRIPT_NAME'], 'index.php') === FALSE)) {
    return false;
} elseif (
        (strstr($_SERVER['REQUEST_URI'], 'time=') !== FALSE) ||
        preg_match('/\.(?:js|xml|htm|html|css|jpg|png|svg|gif|htc|ico|zip|rar|pdf|mp3|swf|map|php|woff|ttf)$/', $_SERVER["REQUEST_URI"])
) {
    return false;
} else {
    $_GET['K1LIB_URL'] = strtok(substr($_SERVER['REQUEST_URI'], 1), '?');
    include __DIR__ . '/index.php';
}