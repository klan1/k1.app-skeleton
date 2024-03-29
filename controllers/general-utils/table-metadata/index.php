<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * SUB INDEX CONTROLLER BOOTSTRAP
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

use \k1lib\urlrewrite\url;
use k1lib\session\session_db;

$default_url = APP_URL . "general-utils/table-metada/show-tables/";

if (session_db::check_user_level(['god', 'admin'])) {

    $controller_to_load = url::set_next_url_level(APP_CONTROLLERS_PATH, FALSE);

    if (!$controller_to_load) {

        \k1lib\html\html_header_go(url::do_url($default_url));
    } else {
        $k1lib_field_config_options_defaults = [
            'label' => null,
            'alias' => null,
            'validation' => null,
            'placeholder' => null,
            'show-create' => TRUE,
            'show-read' => TRUE,
            'show-update' => TRUE,
            'show-list' => TRUE,
            'show-related' => TRUE,
            'show-search' => TRUE,
            'show-export' => TRUE,
            'label-field' => null,
            'file-max-size' => null,
            'file-type' => null,
            'min' => 1,
            'sql' => null,
        ];
        require $controller_to_load;
    }
} else {
    \k1lib\html\html_header_go(url::do_url($default_url));
}    



