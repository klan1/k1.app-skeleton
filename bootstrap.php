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

// Composer lines
require __DIR__ . '/vendor/autoload.php';
// \k1lib\PROFILER::start();

/**
 * AUTOLOAD FOR APP CLASES
 */

spl_autoload_register(function ($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $file_to_load = __DIR__ . '/src/classes/' . $className . '.php';
    if (file_exists($file_to_load)) {
        include_once $file_to_load;
    } else {
        error_reporting(E_ALL);
        trigger_error($className . ' do not fount to autoload at path ' . $file_to_load, E_USER_NOTICE);
        exit;
    }
});
