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

namespace k1app\controllers\core\admin;

use k1app\core\template\my_sidebar_page;
use k1lib\app\controller;
use k1lib\crudlexs\db_table;
use k1lib\db\PDO_k1;
use k1lib\html\div;
use k1lib\html\form;
use k1lib\html\input;
use k1lib\html\textarea;
use k1lib\session\app_session;
use const k1app\K1APP_URL;
use function k1lib\forms\check_single_incomming_var;
use function k1lib\html\html_header_go;

class import_db_configuration extends controller {

    static protected db_table $db_table;
    static protected PDO_k1 $db;
    static protected form $form_create;
    static protected input $submit_button;
    static protected textarea $textarea;

    public static function start() {
        parent::start();

        app_session::is_logged(true, K1APP_URL);

        if (!app_session::check_user_level(['god'])) {
            html_header_go(K1APP_URL);
        }

        self::$db = self::app()->db();

        $tpl = new my_sidebar_page();
        self::use_tpl($tpl);

        self::$tpl->page_content()->set_subtitle(null);
        self::$tpl->page_content()->set_content_title("Load configuration text");
        self::$tpl->page_content()->set_content('');

        self::$tpl->menu()->q('#nav-config-table')->nav_is_active();

        $title = "Load DB configuration: " . self::$db->get_db_name();
        self::$tpl->head()->set_title(self::$tpl->head()->get_title() . ' | ' . $title);
        self::$tpl->page_content()->set_title($title);
    }

    public static function run() {

        $div_container = new div("row");

        self::$form_create = $form_create = (new form());
        $form_create->append_to($div_container);

        $div_row_buttons = $form_create->append_div('mb-3');

        self::$submit_button = $submit_button = $form_create->append_submit_button("Make SQL", 'submit-it', TRUE);
        $submit_button->append_to($div_row_buttons);

        $form_create->append_div("row clearfix");
        /**
         * @var textarea
         */
        self::$textarea = $textarea = new textarea("load-info", 'form-control');
        $textarea->set_attrib("rows", 10)->append_to($form_create);

        self::$tpl->page_content()->set_content($div_container);
    }

    public static function pre_post() {
        parent::pre_post();
        self::start();
    }

    public static function on_post() {
        parent::on_post();
        self::run();

        $sql_field_update_comments = "";
        $sql_update_comment = "";
        if (isset($_POST['load-info']) && !empty($_POST['load-info'])) {

            $load_info = check_single_incomming_var($_POST['load-info']);
            self::$textarea->set_value($load_info);

            $load_info_by_lines = explode("\n\r", $load_info);
            $last_db_table_to_use = null;
            foreach ($load_info_by_lines as $line => $field_comment_line) {
                list($db_table_to_use, $field, $comment) = explode("\t", $field_comment_line);
                $db_table_to_use = trim($db_table_to_use);
                $comment = str_replace("\n", "", $comment);
                $comment = str_replace("\r", "", $comment);
                if ($last_db_table_to_use != $db_table_to_use) {
                    self::$db_table = new db_table(self::$db, $db_table_to_use);
                    $table_definitions = self::$db->get_table_definition_as_array($db_table_to_use);
                }

                if (isset($table_definitions[$field])) {
                    $sql_update_comment = "ALTER TABLE `{$db_table_to_use}` CHANGE `{$field}` `{$field}` {$table_definitions[$field]} COMMENT '{$comment}';\n";
                    $sql_field_update_comments .= $sql_update_comment;
                } else {
                    trigger_error("FIELD definition of $field did not found to update", E_USER_WARNING);
                }
                $last_db_table_to_use = $db_table_to_use;
            }

            self::$submit_button->set_value("Exectute SQL", FALSE);

            $textarea_result = new textarea("result-sql", 'form-control mb-3');
            self::$form_create->append_child_head($textarea_result->set_attrib("rows", 10));
            $textarea_result->set_value($sql_field_update_comments);

            if (isset($_POST['result-sql']) && !empty($_POST['result-sql'])) {
                self::$submit_button->decatalog();
                self::$textarea->decatalog();
                $textarea_result->decatalog();

                $result_sql = check_single_incomming_var($_POST['result-sql']);

                $textarea_result->set_value($result_sql);

                $result_sql_by_lines = explode(PHP_EOL, $result_sql);
                $result_sql_by_lines = str_replace("\'", "'", $result_sql_by_lines);
                $result_sql_by_lines = str_replace("\n", "", $result_sql_by_lines);
                $result_sql_by_lines = str_replace("\r", "", $result_sql_by_lines);

                $div_result = new div('mb-3');
                self::$form_create->append_child_head($div_result);

                foreach ($result_sql_by_lines as $line => $field_comment_line) {
                    if (!empty($field_comment_line)) {
                        if (self::$db->sql_query($field_comment_line) !== FALSE) {
                            $p = $div_result->append_p("OK - $field_comment_line");
                        } else {
                            $p = $div_result->append_p("FAIL - $field_comment_line");
                        }
                    }
                }
            }
        }

        self::end();
    }

    public static function end() {
        parent::end();
        echo self::$tpl->generate();
    }
}
