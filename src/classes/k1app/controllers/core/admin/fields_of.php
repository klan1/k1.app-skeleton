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

namespace k1app\controllers\core\admin;

use k1app\core\template\my_sidebar_page;
use k1lib\app\controller;
use k1lib\db\security\db_table_aliases;
use k1lib\html\a;
use k1lib\urlrewrite\url;

class fields_of extends controller
{

    public static function run()
    {
        $tpl = new my_sidebar_page();
        self::use_tpl($tpl);

        $tpl->page_content()->set_subtitle(null);
        $tpl->page_content()->set_content_title("Select a table");
        $tpl->page_content()->set_content('');

        $tpl->menu()->q('#nav-config-table')->nav_is_active();

        $db = self::app()->db();

        $table_alias = url::set_url_rewrite_var(url::get_url_level_count(), "row_key_text", false);
        $db_table_to_use = db_table_aliases::decode($table_alias);

        $title = "Fields of: " . $db_table_to_use . ' [' . $db->get_db_name() . ']';
        $tpl->head()->set_title($tpl->head()->get_title() . ' | ' . $title);
        $tpl->page_content()->set_title($title);

        /**
         *
         */
        // $db_tables = $db->sql_query("show tables", true);

        // foreach ($db_tables as $row_field => $row_value) {
        //     $table_to_link = $row_value["Tables_in_" . $db->get_db_name()];
        //     $table_alias = db_table_aliases::encode($table_to_link);

        //     if (strstr($table_to_link, "view_")) {
        //         continue;
        //     }
        //     $p = new \k1lib\html\p();

        //     $get_params = ['back-url' => $_SERVER['REQUEST_URI']];

        //     $a_manage = new a(url::do_url("../fields-of/{$table_alias}/", $get_params), "Configure");
        //     $p->set_value($table_to_link . " : " . $a_manage->generate());
        //     $tpl->page_content()->content()->append_child($p);
        // }

    }

    public static function end()
    {
        parent::end();
        echo self::$tpl->generate();
    }

}
