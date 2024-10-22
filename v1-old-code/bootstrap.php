<?php

/*
 * Autor: Alejandro Trujillo J.
 * Copyright: Klan1 Network - 2010-2011
 *
 * TODO: Implement the file storage engine
 * TODO: Make a session manager to know is some one has return from some time
 *
 */

namespace k1app;

use k1lib\urlrewrite\url;

// header('Content-Type: text/html; charset=utf-8');

/*
 * INCLUDING ALL THE NECESSARY FILES
 */

require_once 'settings/app-constants.php';
require_once 'settings/app-paths-auto-def.php';

// Composer lines
require __DIR__ . '/vendor/autoload.php';
\k1lib\PROFILER::start();

require_once 'settings/app-config.php';

/**
 * AUTOLOAD FOR APP CLASES
 */
spl_autoload_register(function ($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $file_to_load = K1APP_CLASSES_PATH . $className . '.php';
    if (file_exists($file_to_load)) {
        include_once $file_to_load;
    } else {
        error_reporting(E_ALL);
        trigger_error($className . ' do not fount to autoload at path ' . $file_to_load, E_USER_NOTICE);
        exit;
    }
});

if (K1APP_MODE == K1APP_MODE_WEB || K1APP_MODE == K1APP_MODE_API) {

    /*
     * MANAGE THE URL REWRITING
     */
    require url::get_controller_path_from_url(K1APP_CONTROLLERS_PATH);
}
