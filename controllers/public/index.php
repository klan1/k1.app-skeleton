<?php

namespace k1app;

use k1lib\urlrewrite\url as url;
use k1lib\html\template as template;

/*
 * APP START
 */
//\k1lib\session\session_db::is_logged(TRUE, APP_URL . 'roy-2019/log/form/');
// Template init
template::load_template('scripts/init');

//k1app_template::start_template();

$controller_to_include = url::set_next_url_level(APP_CONTROLLERS_PATH, FALSE, 'controller_to_include');
if ($controller_to_include) {
    require $controller_to_include;
} else {
    $go_url = url::do_url("dashboard/");
    \k1lib\html\html_header_go($go_url);
}

// APP Debug output
template::load_template('verbose-output');
// Template end
template::load_template('scripts/end');
