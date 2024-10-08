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
use k1lib\crudlexs\db_table;
use k1lib\db\PDO_k1;
use k1lib\db\security\db_table_aliases;
use k1lib\db\sql_defaults;
use k1lib\html\button;
use k1lib\html\div;
use k1lib\html\form;
use k1lib\html\input;
use k1lib\html\label;
use k1lib\html\textarea;
use k1lib\urlrewrite\url;
use function k1lib\common\clean_array_with_guide;
use function k1lib\html\generate_row_2columns_layout;
use function k1lib\html\get_link_button;

class fields_of
        extends controller
{

    static protected db_table $db_table;
    static protected PDO_k1 $db;
    static protected string $db_table_to_use;

    public static function start()
    {
        parent::start();

        self::$db = self::app()->db();

        $table_alias = url::set_url_rewrite_var(
                url::get_url_level_count(), "row_key_text", false
        );
        self::$db_table_to_use = db_table_aliases::decode($table_alias);
        self::$db_table = new db_table(self::$db, self::$db_table_to_use);

        $tpl = new my_sidebar_page();
        self::use_tpl($tpl);

        self::$tpl->page_content()->set_subtitle(null);
        self::$tpl->page_content()->set_content_title("Config table");
        self::$tpl->page_content()->set_content('');

        self::$tpl->menu()->q('#nav-config-table')->nav_is_active();

        $title = "Fields of: " . self::$db_table_to_use . ' [' . self::$db->get_db_name() . ']';
        self::$tpl->head()->set_title(self::$tpl->head()->get_title() . ' | ' . $title);
        self::$tpl->page_content()->set_title($title);
    }

    public static function run()
    {



        /**
         * MAIN CONTROLLER CODE
         */
        if (self::$db_table->get_state())
        {

            $div_container = new div("container");
            $form = (new form());
            $form->append_to($div_container);

            $div_row_buttons = new div('mb-3');
            $div_row_buttons->append_child(
                    get_link_button(
                            K1APP_URL . "core/admin/select_table/", "Back", 'btn-sm'
                    )
            );
            $div_row_buttons->append_child(
                    get_link_button(
                            "./", "Cancel", 'btn-sm'
                    )
            );
            $div_row_buttons->append_child(
                    $form->append_submit_button(
                            "Save changes", 'submit-it', TRUE
                    )
            );

            $form->append_child($div_row_buttons);
            $form->append_child(new div("row clearfix"));
//    $div_row_fieldset = new \k1lib\html\div("row");

            $accordion_div = new div("accordion", 'accordion-configurator');

            $table_config_to_use = [];
            $post_data_to_change = [];
            $table_config_for_fields = self::$db_table->get_db_table_config(TRUE);
            $accordion_row = 0;
            foreach ($table_config_for_fields as $field => $config)
            {


                $table_config_to_use[$field] = clean_array_with_guide(
                        $config, sql_defaults::get_k1lib_field_config_options_defaults()
                );

                foreach ($table_config_to_use[$field] as $option_name => $option_value)
                {

//            \k1lib\common\bolean_to_string($bolean)
                    $make_radio = FALSE;
                    if ($option_value === TRUE)
                    {
                        $option_value = "yes";
                        $make_radio = TRUE;
                    } elseif ($option_value === FALSE)
                    {
                        $option_value = "no";
                        $make_radio = TRUE;
                    }
                    if ($make_radio)
                    {
                        $input_yes = new input("radio", "{$field}[{$option_name}]", "yes", 'form-check-input');
                        $label_yes = new label("yes", "{$field}[{$option_name}]", 'form-check-label');
                        $input_yes->post_code($label_yes->generate());

                        $input_no = new input("radio", "{$field}[{$option_name}]", "no", 'form-check-input');
                        $label_no = new label("no", "{$field}[{$option_name}]", 'form-check-label');
                        $input_no->post_code($label_no->generate());

                        if ($option_value == "yes")
                        {
                            $input_yes->set_attrib("checked", TRUE);
                        }
                        if ($option_value == "no")
                        {
                            $input_no->set_attrib("checked", TRUE);
                        }
                        $table_config_to_use[$field][$option_name] = "{$input_yes} {$input_no}";
                    } else
                    {
                        if ($option_name != 'sql')
                        {
                            $input = new input("text", "{$field}[{$option_name}]", $option_value, 'form-control');
                        } else
                        {
                            $input = new textarea("{$field}[{$option_name}]", 'form-control');
                            $input->set_value($option_value);
                        }
//                        $input_generated = $input->generate();
                        $table_config_to_use[$field][$option_name] = $input;
                    }
                }
                if (isset($_POST[$field]))
                {
                    $post_data_to_change[$field] = implode(",", $_POST[$field]);
                }

                $accordion_item = $accordion_div->append_div('accordion-item');
                $accordion_header = $accordion_item->append_h2(null, 'accordion-header');
                $accordion_header->append_child(
                        (new button($field, 'accordion-button collapsed'))
                                ->set_attrib('data-bs-toggle', 'collapse')
                                ->set_attrib('data-bs-target', '#collapse' . $accordion_row)
                                ->set_attrib('aria-expanded', 'true')
                                ->set_attrib('aria-controls', '#collapse' . $accordion_row)
                );
                $accordion_content = new div('accordion-collapse collapse', 'collapse' . $accordion_row);
                $accordion_content
                        ->set_attrib('data-bs-parent', 'accordion-configurator')
                        ->append_to($accordion_item);
                $accordion_body = $accordion_content->append_div('accordion-body');
                generate_row_2columns_layout(
                        $accordion_body, $table_config_to_use[$field]
                );
                $labels = $accordion_body->q('.k1lib-label-object');
                /**
                 * CAPITALIZE LABELS
                 */
                foreach ($labels as $value)
                {
                    $value->set_class('text-uppercase', TRUE);
                }
                $accordion_row++;
            }

            $form->append_child($accordion_div);

            self::$tpl->page_content()->set_content($div_container);
        }
        /**
         *
         */
        // $db_tables = self::$db->sql_query("show tables", true);
        // foreach ($db_tables as $row_field => $row_value) {
        //     $table_to_link = $row_value["Tables_in_" . self::$db->get_db_name()];
        //     $table_alias = db_table_aliases::encode($table_to_link);
        //     if (strstr($table_to_link, "view_")) {
        //         continue;
        //     }
        //     $p = new \k1lib\html\p();
        //     $get_params = ['back-url' => $_SERVER['REQUEST_URI']];
        //     $a_manage = new a(url::do_url("../fields-of/{$table_alias}/", $get_params), "Configure");
        //     $p->set_value($table_to_link . " : " . $a_manage->generate());
        //     self::$tpl->page_content()->content()->append_child($p);
        // }
    }

    public static function pre_post()
    {
        parent::pre_post();
        self::start();
    }

    public static function on_post()
    {
        parent::on_post();

        $div_result = new div();
        $div_row_buttons = $div_result->append_div('mb-3');

        $div_row_buttons->append_child(
                get_link_button(
                        "./", "Back", 'btn-sm'
                )
        );

        $div_ok = $div_result->append_div();
        $p_fail = $div_result->append_p();
        $p_unchanged = $div_result->append_p();

        if (isset($_POST["submit-it"]))
        {
            unset($_POST["submit-it"]);
            $table_config = self::$db_table->get_db_table_config();
            $table_config_to_use = [];
            foreach ($_POST as $field => $config)
            {
                $options_values = [];
                $comment_values = [];
                $table_config_to_use[$field] = clean_array_with_guide(
                        $config, $table_config[$field]
                );
                foreach ($table_config_to_use[$field] as $option_name => $option_value)
                {
                    if ($option_value === TRUE)
                    {
                        $option_value = "yes";
                    } elseif ($option_value === FALSE)
                    {
                        $option_value = "no";
                    }
                    $options_values[] = "$option_name:$option_value";
                }
                $comment_values[$field] = implode(",", $options_values);
                if ($comment_values)
                {
                    $table_definitions = self::$db->get_table_definition_as_array(self::$db_table->get_db_table_name());
                    foreach ($comment_values as $field => $comment_to_update)
                    {
                        if (isset($table_definitions[$field]))
                        {
                            $sql_update_comment = "ALTER TABLE `" . self::$db_table->get_db_table_name() . "` CHANGE `$field` `$field` {$table_definitions[$field]} COMMENT '{$comment_values[$field]}'";
                            if (!empty($comment_values[$field]))
                            {
                                if (self::$db->sql_query($sql_update_comment) !== FALSE)
                                {
                                    $div_ok->append_p(
                                            "$sql_update_comment (ok) ", TRUE
                                    );
                                } else
                                {
                                    $p_fail->set_value("$field (fail)", TRUE);
                                }
                            } else
                            {
                                $p_unchanged->set_value(
                                        "$field (unchached)", TRUE
                                );
                            }
                        } else
                        {
                            trigger_error(
                                    "FIELD definition of $field did not found to update", E_USER_WARNING
                            );
                        }
                    }
                }
            }
//            self::run();
            self::$tpl->page_content()->set_content($div_result);
            self::end();
        }
    }

    public static function end()
    {
        parent::end();
        echo self::$tpl->generate();
    }
}
