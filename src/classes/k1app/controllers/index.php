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

use k1app\core\template\app_sidebar_page;
use k1lib\app\controller;
use k1lib\html\pre;
use k1lib\html\tag_log;
use k1lib\session\app_session;

class index extends controller {

    public static function run() {

//        app_session::start_session();

        $tpl = new app_sidebar_page();
        self::use_tpl($tpl);

        $tpl->page_content()->set_title("K1.APP Skeleton");
        $tpl->page_content()->set_subtitle("Fast and easy web development.");
        $tpl->page_content()->set_content_title("APP Internal Debug");
        $tpl->page_content()->set_content(
                new pre(
                        'session_status() : ' . (string) session_status() . PHP_EOL .
                        'session_id() : ' . (string) session_id() . PHP_EOL .
                        'session_name() : ' . (string) session_name() . PHP_EOL .
                        'on_session() : ' . (string) app_session::on_session() . PHP_EOL .
                        'is_logged() : ' . (string) app_session::is_logged() . PHP_EOL .
                        'get_user_hash() : ' . (string) app_session::get_user_hash() . PHP_EOL .
                        'get_user_login() : ' . (string) app_session::get_user_login() . PHP_EOL .
                        print_r($_SESSION, true) .
                        print_r(app_session::get_user_data(), TRUE) .
                        print_r($_COOKIE, true) .
                        print_r($_SERVER, true) .
                        'get_terminal_info_array() : ' . print_r(app_session::get_terminal_info_array(), true) . PHP_EOL .
                        'get_browser_fp() : ' . (string) app_session::get_browser_fp(self::app()->config()->get_option('magic_value')) . PHP_EOL .
                        'get_browser_fp() : ' . (string) print_r(app_session::get_browser_fp(self::app()->config()->get_option('magic_value'),true),true) . PHP_EOL .
                        print_r(get_defined_constants(true)['user'], true) .
                        print_r(tag_log::get_log(), true)
        ));

        $tpl->menu()->q('#nav-index')->nav_is_active();
    }

    public static function end() {
        parent::end();
        echo self::$tpl->generate();
    }
}
