<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * MAIN INDEX CONTROLLER BOOTSTRAP
 *
 * PHP version 7.4
 *
 * @author          Alejandro Trujillo J. <alejo@klan1.com> <https://github.com/j0hnd03>
 * @copyright       2013-2023 Alejandro Trujillo J. 
 * @license         Apache 2.0
 * @version         1.0
 * @since           File available since Release 0.1
 */

namespace k1app;

use k1lib\urlrewrite\url as url;
use k1lib\session\session_db as session_db;
use k1lib\html\template as template;

/**
 * $db @var Description \k1lib\db\PDO_k1 
 */
include 'db-connection-1.php';
include 'db-tables-aliases.php';
include 'app-controllers-def.php';

/*
 * APP START
 */
session_db::set_session_name(K1APP_SESSION_NAME);
$app_session = new session_db($db);
$app_session->start_session();
$app_session->load_logged_session_db();

// Template init
template::load_template('scripts/init');

//k1app_template::start_template();

$controller_to_load = url::set_next_url_level(APP_CONTROLLERS_PATH, FALSE, 'controller_to_include');
if ($controller_to_load) {
    require $controller_to_load;
} else {
    if (session_db::is_logged()) {
        if (!$controller_to_load) {
            if (session_db::check_user_level(['god', 'admin'])) {
                $go_url = url::do_url("dashboard/");
            } else {
                $go_url = url::do_url("dashboard/");
            }
            \k1lib\html\html_header_go($go_url);
        } else {
            require $controller_to_load;
        }
    } else {
        $get_params = ["back-url" => $_SERVER['REQUEST_URI']];
        \k1lib\html\html_header_go(url::do_url(APP_LOGIN_URL, $get_params));
    }
}
// APP Debug output
template::load_template('verbose-output');
// Template end
template::load_template('scripts/end');
