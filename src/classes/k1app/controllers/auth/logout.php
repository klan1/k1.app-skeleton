<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * MAIN INDEX CONTROLLER BOOTSTRAP
 *
 * PHP version 8.2
 *
 * @author          Alejandro Trujillo J. <alejo@klan1.com> <https://github.com/j0hnd03>
 * @copyright       2013-2024 Alejandro Trujillo J.
 * @license         Apache 2.0
 * @version         2.0
 * @since           File available since Release 0.1
 */

namespace k1app\controllers\auth;

use k1lib\app\controller;
use k1lib\urlrewrite\url;
use const k1app\K1APP_URL;
use function k1lib\html\html_header_go;

class logout extends controller {

    public static function start() {
        parent::start();
        // DOM_notifications::
    }

    public static function run() {
        parent::run();
        self::app()->end_app_session();
        html_header_go(url::do_url(K1APP_URL));
    }
}
