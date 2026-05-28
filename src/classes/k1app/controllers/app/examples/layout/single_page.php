<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * MAIN INDEX CONTROLLER BOOTSTRAP
 *
 * PHP version 8.2
 *
 * @author Alejandro Trujillo J. <https://github.com/j0hnd03>
 * @copyright       2013-2025 Alejandro Trujillo J.
 * @license         Apache 2.0
 * @version         2.0
 * @since           File available since Release 0.1
 */

namespace k1app\controllers\app\examples\layout;

use k1app\template\mazer\layouts\single_page as sp;
use k1lib\app\controller;

class single_page extends controller {

    public static function run(): void {
        parent::run();
        $tpl = new sp();
        self::use_tpl($tpl);
    }

    public static function end(): void {
        parent::end();
        echo self::$tpl->generate();
    }
}
