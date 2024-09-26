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

namespace k1app\controllers\crud;

use k1app\core\template\my_sidebar_page;
use k1lib\app\controller_crud;

class table_uploads extends controller_crud {

    public static function start(): void {
//        \k1lib\session\app_session::is_logged(TRUE, '/auth/login/');
        
        parent::start();
        parent::start_crud('Simple Table controller example with FK', 'table_uploads');
    }

    public static function run(): void {
        parent::run();
        $tpl = new my_sidebar_page();
        parent::run_crud(__CLASS__, $tpl, '#nav-uploads-crud');
    }

    public static function init_board(): void {
        parent::init_board();
        self::$co->read_url_keys_text_for_list('table_example', FALSE);
        self::$co->read_url_keys_text_for_create('table_example');
    }
}
