<?php

/**
 * CONTROLLER WITH DETAIL LIST
 * Ver: 1.0
 * Autor: J0hnD03
 * Date: 2016-02-03
 *
 */

namespace k1app\controllers\core\tools;

use k1lib\app\controller;
use k1lib\crudlexs\controller\base as cb;
use k1lib\crudlexs\db_table;
use k1lib\crudlexs\object\creating;
use k1lib\db\security\db_table_aliases;
use k1lib\html\div;
use k1lib\urlrewrite\url as url;
use const k1lib\URL_REWRITE_VAR_NAME;
use function k1lib\common\serialize_var;
use function k1lib\common\unserialize_var;
use function k1lib\common\unset_serialize_var;
use function k1lib\forms\check_all_incomming_vars;
use function k1lib\html\html_header_go;

class send_row_keys extends controller {

    protected static div $crud_container;
    protected static cb $co;

    public static function on_post(): void {
        self::launch();
    }

    public static function run() {
        $db = self::app()->db();

        /**
         * ONE LINE config: less codign, more party time!
         */
        $table_to_use = url::set_url_rewrite_var(url::get_url_level_count(), "table_to_use", false);
        $table_to_use_real = db_table_aliases::decode($table_to_use);

        $row_keys_text = url::set_url_rewrite_var(url::get_url_level_count(), "row_key_text", false);

        $reference_table_to_use = url::set_url_rewrite_var(url::get_url_level_count(), "reference_table_to_use", false);
        $reference_table_to_use_real = db_table_aliases::decode($reference_table_to_use);

        $to_use_db_table = new db_table($db, $table_to_use_real);

        $reference_db_table = new db_table($db, $reference_table_to_use_real);

        $create_obj = new creating($reference_db_table, false);
        $create_obj->set_do_table_field_name_encrypt();

        $to_merge_array = [];
        if ($row_keys_text != 'null') {
            /**
             * CUSTOM FIELD TO LINK ON FK
             */
            $creating_obj = new creating($reference_db_table, false);
            $static_vars_from_get = check_all_incomming_vars($_GET);
            unset($static_vars_from_get[URL_REWRITE_VAR_NAME]);
            $static_vars_from_get_decoded = $creating_obj->decrypt_field_names($static_vars_from_get);

            if (isset($static_vars_from_get_decoded['caller-field'])) {
                $row_keys_array = [
                    $creating_obj->decrypt_field_name($static_vars_from_get_decoded['caller-field']) => $row_keys_text
                ];
            } else {
                $row_keys_array = $db->table_url_text_to_keys($row_keys_text, $to_use_db_table->get_db_table_config());
            }
            /**
             * end
             */
            foreach ($row_keys_array as $field => $value) {
                $to_merge_array[$create_obj->encrypt_field_name($field)] = $value;
            }
        }

        $post_data_saved = unserialize_var("post-data");
        //\k1lib\common\unset_serialize_var("post-data");

        $back_url_saved = unserialize_var("back-url");
        //\k1lib\common\unset_serialize_var("back-url");

        $array_to_send = array_merge($post_data_saved, $to_merge_array);
        serialize_var($array_to_send, "post-data-to-use");
        serialize_var($reference_db_table->get_db_table_config(), "post-data-table-config");
        /**
         * FIELDS FILTER FOR select_row_keys.php
         */
        unset_serialize_var('fk-filter-for-' . $table_to_use_real);

        html_header_go($back_url_saved);
    }

    public static function end(): void {
        parent::end();
//
//        if (method_exists(self::$tpl, 'page')) {
//            d("tpl a");
//            self::$tpl->page()->set_content(self::$crud_container);
//        } else {
//            d("tpl b");
//            self::$tpl->body()->set_value(self::$crud_container);
//        }
//
//        echo self::$tpl->generate();
    }
}
