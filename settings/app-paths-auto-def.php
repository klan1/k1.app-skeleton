<?php

namespace k1app;

// MAIN PATH
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

// AUTO CONFIGURATED PATHS
define('k1app\K1APP_ROOT', str_replace('\\', '/', dirname(dirname(__FILE__))));
define('k1app\K1APP_DIR', basename(K1APP_ROOT) . '/');
define('k1app\K1APP_DOMAIN', $_SERVER['HTTP_HOST']);

define('k1app\K1APP_CONTROLLERS_PATH', K1APP_ROOT . '/src/app/');
define('k1app\K1APP_CLASSES_PATH', K1APP_ROOT . '/src/classes/');

define('k1app\K1APP_VIEWS_PATH', K1APP_ROOT . '/views/');

define('k1app\K1APP_VIEWS_CRUD_PATH', K1APP_VIEWS_PATH . '/k1lib.crud/');
define('k1app\K1APP_RESOURCES_PATH', K1APP_ROOT . '/resources/');
define('k1app\K1APP_SETTINGS_PATH', K1APP_ROOT . '/settings/');
define('k1app\K1APP_UPLOADS_PATH', K1APP_RESOURCES_PATH . 'uploads/');
define('k1app\K1APP_SHELL_SCRIPTS_PATH', K1APP_RESOURCES_PATH . '/shell-scripts/');
define('k1app\K1APP_TEMPLATES_PATH', K1APP_RESOURCES_PATH . '/templates/');
define('k1app\K1APP_FONTS_PATH', K1APP_RESOURCES_PATH . 'fonts/');

/**
 * COMPOSER
 */
define('k1app\COMPOSER_PACKAGES_PATH', K1APP_ROOT . 'vendor/');
/**
 * BOWER
 */
define('k1app\BOWER_PACKAGES_PATH', K1APP_ROOT . 'bower_components/');

// INCLUDES PATH ADDITION
set_include_path(K1APP_SETTINGS_PATH . PATH_SEPARATOR . K1APP_RESOURCES_PATH . '/includes' . PATH_SEPARATOR . get_include_path());

// AUTO CONFIGURATED URLS 
if (K1APP_MODE != 'shell') {

    /**
     * If this error is trigger you should set by hand the CONST: K1APP_BASE_URL
     * with your personal configuration.
     */
    $app_base_url = dirname(substr($_SERVER['SCRIPT_FILENAME'], strlen(\DOCUMENT_ROOT))) . '/';
    if ($app_base_url == '//' || $app_base_url == '\/') {
        $app_base_url = '/';
    }
    define('k1app\K1APP_BASE_URL', $app_base_url);

    //    define('k1app\K1APP_DOMAIN_URL', (\k1lib\common\get_http_protocol() . '://') . \K1APP_DOMAIN);
    define('k1app\K1APP_DOMAIN_URL', '//' . K1APP_DOMAIN);

    define('k1app\K1APP_URL', K1APP_DOMAIN_URL . K1APP_BASE_URL);
    define('k1app\K1APP_LOGIN_URL', K1APP_URL . 'K1APP/log/form/');
    define('k1app\K1APP_HOME_URL', K1APP_URL);
    define('k1app\K1APP_CONTROLLERS_URL', K1APP_URL . 'controllers/');
    define('k1app\K1APP_VIEWS_URL', K1APP_URL . 'views/');
    define('k1app\K1APP_RESOURCES_URL', K1APP_URL . 'resources/');
    define('k1app\K1APP_UPLOADS_URL', K1APP_RESOURCES_URL . 'uploads/');
    define('k1app\K1APP_TEMPLATES_URL', K1APP_RESOURCES_URL . 'templates/');
    //    define('k1app\K1APP_TEMPLATE_IMAGES_URL', K1APP_TEMPLATE_URL . 'img/');

    /**
     * BOWER
     */
    /**
     * BOWER - FOUNDATION 6.X
     */
    define('k1app\BOWER_PACKAGES_URL', K1APP_URL . 'bower_components/');

    /**
     * COMPOSER
     */
    define('k1app\COMPOSER_PACKAGES_URL', K1APP_URL . 'vendor/');
}
