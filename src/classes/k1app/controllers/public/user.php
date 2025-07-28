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

namespace k1app\controllers\public;

use k1app\core\config\general;
use k1app\core\template\app_sidebar_page;
use k1lib\app\controller_crud;

class user extends controller_crud {

    public static function start() {
//        parent::start();
        $app_options = new general();
        parent::start_crud($app_options->get_option('app_name'), 'k1app_users');
    }

    public static function run() {
        parent::run();
        $tpl = new app_sidebar_page();
        parent::run_crud(__CLASS__, $tpl, '#nav-registro', TRUE);
        $tpl->page_content()->set_subtitle('Aquí crearás un usuario de tipo invitado sin privilegios del sistema. Un administrador debe promover tu cuenta.');
        self::set_nav_active('#nav-my-profile');
    }

    public static function init_board(): void {
        parent::init_board();

        $table = self::$co->db_table;

        $user_constants = [
            'user_level' => 'guest',
        ];
        $table->set_field_constants($user_constants);
    }
}
