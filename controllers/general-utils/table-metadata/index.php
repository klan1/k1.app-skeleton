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

use \k1lib\urlrewrite\url as url;

$default_url = APP_URL . "form/";

$controller_to_load = url::set_next_url_level(APP_CONTROLLERS_PATH, FALSE);

if (!$controller_to_load) {
    \k1lib\html\html_header_go(url::do_url($default_url));
} else {
    require $controller_to_load;
}

