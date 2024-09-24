<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * MAIN CRUD CONTROLLER BOOTSTRAP
 *
 * PHP version 8.2
 *
 * @author          Alejandro Trujillo J. <alejo@klan1.com> <https://github.com/j0hnd03>
 * @copyright       2013-2024 Alejandro Trujillo J.
 * @license         Apache 2.0
 * @version         2.0
 * @since           File available since Release 2.0
 */

namespace k1app\controllers\crud;

use k1app\core\template\my_sidebar_page;
use k1lib\app\controller_crud;

class table_related extends controller_crud {

    public static function start() {

        parent::start();
        parent::start_crud('Related Table controller example', 'table_example');
    }

    public static function run() {
        parent::run();
        $tpl = new my_sidebar_page();
        parent::run_crud(__CLASS__, $tpl, '#nav-related-crud');
    }

    public static function finish_board() {
        parent::finish_board();
        self::add_related_table('table_uploads', '/crud/table_uploads/', 'Uploads of table');
    }
}
