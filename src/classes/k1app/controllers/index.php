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

namespace k1app\controllers;

use k1app\core\config\general;
use k1app\core\template\my_sidebar_page;
use k1app\template\mazer\layouts\blank;
use k1lib\app\controller;
use k1lib\html\pre;
use k1lib\html\tag_log;

class index extends controller
{

    public static function run()
    {

        $tpl = new my_sidebar_page();
        self::use_tpl($tpl);

        $tpl->page_content()->set_title("K1.APP Skeleton");
        $tpl->page_content()->set_subtitle("Fast and easy web development.");
        $tpl->page_content()->set_content_title("APP Defined constants");
        $tpl->page_content()->set_content(
            new pre(
                print_r(get_defined_constants(true)['user'], true) .
                print_r(new general(), true) .
                print_r(tag_log::get_log(), true)
            ));

        $tpl->menu()->q('#nav-index')->nav_is_active();

    }
    public static function end()
    {
        parent::end();
        echo self::$tpl->generate();
    }
}
