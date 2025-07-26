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

namespace k1app\controllers\layout;

use k1app\core\template\my_sidebar_page;
use k1lib\app\controller;

class sidebar_page extends controller {

    public static function run() {
        $tpl = new my_sidebar_page();
        self::use_tpl($tpl);

        $tpl->page_content()->set_title("Standar layout");
        $tpl->page_content()->set_subtitle("For standard pages.");
        $tpl->page_content()->set_content_title("Section title");
        $tpl->page_content()->set_content('Section content');

        $tpl->menu()->q('#nav-sidebar-page')->nav_is_active();
    }

    public static function end() {
        parent::end();
        echo self::$tpl->generate();
    }
}
