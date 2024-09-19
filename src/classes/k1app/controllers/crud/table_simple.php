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
use k1lib\app\controller;
use k1lib\crudlexs\controller\base as cb;
use k1lib\crudlexs\object\base;
use k1lib\html\DOM;
use k1lib\session\session_db;
use k1lib\urlrewrite\url;
use const k1app\K1APP_BASE_URL;

class table_simple extends controller {
    
    public static function start() {
        parent::start();
        self::app()->start_session_db(1);
    }

    public static function run() {
        $tpl = new my_sidebar_page();
        self::use_tpl($tpl);

        DOM::start($tpl);

        $tpl->page_content()->set_title("CRUDLExS");
        $tpl->page_content()->set_subtitle("DB Table example");
        $tpl->page_content()->set_content_title(null);
        $tpl->page_content()->set_content(null);

        $tpl->menu()->q('#nav-sidebar-page')->nav_is_active();

        /**
         * CRUD START
         */
        $db_table_to_use = "table_example";
        $controller_name = "Simple Table controller example";

        /**
         * ONE LINE config: less codign, more party time!
         * $co = controller_object
         */
        $db = self::app()->db();
        $co = new cb($tpl, K1APP_BASE_URL, $db, $db_table_to_use, $controller_name, 'k1lib-title-3');
        if ($co->db_table->get_state() === false) {
            die('DB table did not found.');
        }
        $co->set_config_from_class('\k1app\table_config\table_example');

        /**
         * USE THIS IF THE TABLE NEED THE LOGIN_ID ON EVERY ROW FOR TRACKING
         */
        $co->db_table->set_field_constants(['user_login' => session_db::get_user_login()]);

        /**
         * ALL READY, let's do it :)
         */
        $board_div = $co->init_board();

        if ($co->on_board_list()) {
            $co->board_list_object->set_create_enable(true);
        }

        $co->start_board();

        // LIST
        if ($co->on_object_list()) {
            $read_url = url::do_url($co->get_controller_root_dir() . "{$co->get_board_read_url_name()}/--rowkeys--/", ["auth-code" => "--authcode--"]);
            $co->board_list()->list_object->apply_link_on_field_filter($read_url, base::USE_LABEL_FIELDS);
        }

        $co->exec_board();

        if ($co->on_object_list()) {
            $co->board_list()->list_object->html_table->set_max_text_length_on_cell(100);
        }

        $co->finish_board();

        $tpl->page_content()->set_content($board_div);
    }

    public static function end() {
        parent::end();
        echo self::$tpl->generate();
    }
}
