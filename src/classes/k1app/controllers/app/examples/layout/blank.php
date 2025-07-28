<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * MAIN INDEX CONTROLLER BOOTSTRAP
 *
 * PHP version 8.2
 *
 * @author          Alejandro Trujillo J. <alejo@klan1.com> <https://github.com/j0hnd03>
 * @copyright       2013-2025 Alejandro Trujillo J.
 * @license         Apache 2.0
 * @version         2.0
 * @since           File available since Release 0.1
 */

namespace k1app\controllers\app\examples\layout;

use k1app\core\template\base;
use k1lib\app\controller;

class blank extends controller {

    public static function run() {
        $tpl = new base();
        self::use_tpl($tpl);
    }

    public static function end() {
        parent::end();
        echo self::$tpl->generate();
    }
}
