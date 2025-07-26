<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * MAIN CRUD CONTROLLER BOOTSTRAP
 *
 * PHP version 8.2
 *
 * @author          Alejandro Trujillo J. <alejo@klan1.com> <https://github.com/j0hnd03>
 * @copyright       2013-2025 Alejandro Trujillo J.
 * @license         Apache 2.0
 * @version         2.0
 * @since           File available since Release 2.0
 */

namespace k1app\controllers\app;

use k1app\core\template\my_sidebar_page;
use k1lib\app\controller_crud;
use k1lib\session\app_session;
use const k1lib\K1LIB_LANG;

class users extends controller_crud {

    public static function start() {
        parent::start();
        parent::start_crud('System users', 'k1app_users');
    }

    public static function run() {
        parent::run();
        $tpl = new my_sidebar_page(K1LIB_LANG);
        self::run_crud(__CLASS__, $tpl);

        /**
         * HACK to change the menu item if the page loaded is the 
         * actual logged user
         */
        if (!app_session::is_logged() || app_session::check_user_level(['guest', 'user'])) {
            self::set_nav_active('#nav-my-profile');
        } else {
            $user_data = app_session::get_user_data();
            if (isset($user_data['user_login'])) {
                if (self::$co->object_read()) {
                    $keys = self::$co->board_read()->read_object->get_row_keys_array();
                } else if (self::$co->object_update()) {
                    $keys = self::$co->board_update()->update_object->get_row_keys_array();
                } else {
                    $keys['user_login'] = null;
                }
            }
            if ($user_data['user_login'] != $keys['user_login']) {
                self::set_nav_active('#nav-admin-users');
            } else {
                self::set_nav_active('#nav-my-profile');
            }
        }
        /**
         * end hack user/menu
         */
    }

    public static function init_board(): void {
        parent::init_board();
        if (self::$co->board_list()) {
            self::tpl()->q("#k1lib-page-content")->set_class('no-card');
            self::$co->board_list()->set_data_row_template('data-row-card.tpl');
        }
    }
}
