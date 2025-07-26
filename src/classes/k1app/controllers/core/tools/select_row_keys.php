<?php

/**
 * CONTROLLER WITH DETAIL LIST
 * FOR FK SELECTION
 * Ver: 2.0
 * Since: 1.0
 * Autor: J0hnD03
 * Date: 2016-02-03
 *
 */

namespace k1app\controllers\core\tools;

use k1app\template\mazer\layouts\single_page as sp;
use k1lib\app\controller;
use k1lib\common_strings;
use k1lib\crudlexs\board\board_list;
use k1lib\crudlexs\board\board_list_strings;
use k1lib\crudlexs\controller\base as cb;
use k1lib\crudlexs\db_table;
use k1lib\crudlexs\object\base as ob;
use k1lib\crudlexs\object\creating;
use k1lib\db\security\db_table_aliases;
use k1lib\html\div;
use k1lib\html\DOM;
use k1lib\urlrewrite\url as url;
use const k1app\K1APP_BASE_URL;
use const k1lib\URL_REWRITE_VAR_NAME;
use function k1lib\common\serialize_var;
use function k1lib\common\unserialize_var;
use function k1lib\forms\check_all_incomming_vars;
use function k1lib\html\get_link_button;

class select_row_keys extends controller {

    protected static div $crud_container;
    protected static cb $co;

    public static function on_post(): void {
        self::launch();
    }

    public static function run() {
        parent::run();
        $tpl = new sp();
        self::use_tpl($tpl);
        /**
         *  LEGACY machete
         */
        DOM::start(self::$tpl);

        $tpl->page()->set_title("Select the Key");

        $static_vars_from_get = check_all_incomming_vars($_GET);
        unset($static_vars_from_get[URL_REWRITE_VAR_NAME]);

        /**
         * ONE LINE config: less codign, more party time!
         */
        $table_to_use = url::set_url_rewrite_var(url::get_url_level_count(), "table_to_use", false);
        $table_to_use_real = db_table_aliases::decode($table_to_use);

        self::$co = new cb(K1APP_BASE_URL, __CLASS__, $table_to_use_real, board_list_strings::$select_fk_tool_title);

        /**
         * CONTROLLER SUB TITLE AND REMOVE
         * MAIN CARD TITLE
         */
        self::$co->set_title_tag_id('#k1app-page-title');
        $tpl->q('#k1app-page-subtitle')->set_value(board_list_strings::$select_fk_tool_subtitle);
        $tpl->q('.card-header')->decatalog();

        if (self::$co->db_table->get_state() === false) {
            die('DB table did not found: ' . __CLASS__);
        } else {
            
        }

        if (self::$co->get_state()) {
            /**
             * POST data catch
             */
            if (isset($_POST) && !empty($_POST) && !isset($_POST['k1send'])) {
                $post_data = check_all_incomming_vars($_POST, "post-data");
                $back_url = $_GET['back-url'];
                serialize_var($back_url, "back-url");
            }
            /**
             * URL and ENABLE config from the simple config class on ../index.php
             */
            self::$co->set_board_create_enabled(false);
            self::$co->set_board_read_enabled(false);
            self::$co->set_board_update_enabled(false);
            self::$co->set_board_delete_enabled(false);
            self::$co->set_board_list_url_name("list");

            self::$co->set_board_list_name(board_list_strings::$select_fk_tool_title);

            self::$crud_container = self::$co->init_board();

            if (self::$co->on_board_list()) {
                self::$co->board_list_object->set_back_enable(false);

                $reference_table_to_use = url::set_url_rewrite_var(url::get_url_level_count(), "reference_table_to_use", false);
                $reference_table_to_use_real = db_table_aliases::decode($reference_table_to_use);
                $reference_db_table = new db_table(self::app()->db(), $reference_table_to_use_real);

                $creating_obj = new creating($reference_db_table, false);

                $static_vars_from_get_decoded = $creating_obj->decrypt_field_names($static_vars_from_get);
//                d($static_vars_from_get_decoded);
                /**
                 * SET THE FK TOOL FILTER FOR FILTER DATA TO SHOW
                 */
                $fk_tool_constants = unserialize_var('fk-filter-for-' . $table_to_use_real . '-from-' . $reference_table_to_use_real);
                if (!empty($fk_tool_constants)) {
                    self::$co->db_table->set_query_filter($fk_tool_constants, TRUE);
                }
                /**
                 * CUSTOM FIELD TO LINK ON FK
                 */
                if (isset($static_vars_from_get_decoded['caller-field'])) {
                    $custom_field_for_fk = $creating_obj->decrypt_field_name($static_vars_from_get_decoded['caller-field']);
                } else {
                    $custom_field_for_fk = null;
                }

                /**
                 * end
                 */
                self::$co->db_table->set_query_filter($static_vars_from_get_decoded, true, true);

                self::$co->board_list_object->set_search_enable(true);

                self::$co->board_list_object->set_where_to_show_stats(board_list::SHOW_BEFORE_TABLE);

                if (isset($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], self::$co->get_controller_root_dir()) === false) {
                    self::$co->board_list_object->set_search_catch_post_enable(false);
                }
            }
            self::$co->start_board();

            // LIST
            if (self::$co->on_board_list()) {
                if (self::$co->on_object_list()) {
                    self::$co->board_list_object->list_object->apply_link_on_field_filter(
                            K1APP_BASE_URL . "core/tools/send_row_keys/{$table_to_use}/"
                            . (empty($custom_field_for_fk) ? '--rowkeys--' : '--customfieldvalue--')
                            . "/{$reference_table_to_use}/"
                            , ob::USE_LABEL_FIELDS
                            , [$custom_field_for_fk]
                            , '_self'
                    );
                }
                if (isset($_GET['back-url'])) {
                    $close_search_buttom = get_link_button(
                            K1APP_BASE_URL . "core/tools/send_row_keys/{$table_to_use}/null/{$reference_table_to_use}/"
                            , common_strings::$button_cancel, 'btn-sm');
//                    $close_search_buttom->set_attrib("onClick", "parent.close_fk_iframe();");
                    self::$co->board_list_object->button_div_tag()->append_child_head($close_search_buttom);
                }
            }

            self::$co->exec_board();

            if (self::$co->on_object_list()) {
                if (self::$co->board_list()->list_object->html_table) {
                    self::$co->board_list()->list_object->html_table->set_max_text_length_on_cell(100);
                }
            }

            self::$co->finish_board();
        }
        $tpl->page()->set_content(self::$crud_container);
    }

    public static function end(): void {
        parent::end();

        if (method_exists(self::$tpl, 'page')) {
            self::$tpl->page()->set_content(self::$crud_container);
        } else {
            self::$tpl->body()->set_value(self::$crud_container);
        }

        echo self::$tpl->generate();
    }
}
