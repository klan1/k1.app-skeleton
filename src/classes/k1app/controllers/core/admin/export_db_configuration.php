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

use k1lib\app\controller;
use k1lib\crudlexs\db_table;
use k1lib\db\sql_defaults;
use k1lib\session\app_session;
use const k1app\K1APP_URL;
use function k1lib\common\clean_array_with_guide;
use function k1lib\html\html_header_go;

class export_db_configuration
        extends controller
{

    public static function start()
    {
        parent::start();
        app_session::is_logged(true, K1APP_URL);

        if (!app_session::check_user_level(['god']))
        {
            html_header_go(K1APP_URL);
        }
        \header("Content-Type: text/plain");
    }

    public static function run()
    {
        $db = self::app()->db();
        $db_tables = $db->sql_query("show tables", true);

        foreach ($db_tables as $row_value)
        {
            $db_table_to_use = $row_value["Tables_in_" . $db->get_db_name()];

            if (strstr($db_table_to_use, "view_"))
            {
                continue;
            }

            $db_table = new db_table($db, $db_table_to_use);

            if ($db_table->get_state())
            {

                $table_config_to_use = [];
                foreach ($db_table->get_db_table_config() as $field => $config)
                {
                    $options_values = [];
                    $data_to_show = [];

                    $table_config_to_use[$field] = clean_array_with_guide(
                            $config, sql_defaults::get_k1lib_field_config_options_defaults()
                    );
                    foreach ($table_config_to_use[$field] as $option_name => $option_value)
                    {
                        if ($option_value === TRUE)
                        {
                            $option_value = "yes";
                        } elseif (($option_value === FALSE) || (empty($option_value) && is_bool(sql_defaults::get_k1lib_field_config_options_defaults()[$option_name])))
                        {
                            $option_value = "no";
                        }
                        $options_values[] = "$option_name:$option_value";
                    }
                    $data_to_show[$field] = implode(",", $options_values);
                    if ($data_to_show)
                    {
                        $table_definitions = $db->get_table_definition_as_array($db_table_to_use);
                        foreach ($data_to_show as $field => $comment_to_update)
                        {
                            if (isset($table_definitions[$field]) && !empty($data_to_show[$field]))
                            {
                                $sql_tu_update_comment = "{$db_table_to_use}\t{$field}\t{$data_to_show[$field]}";
                                echo $sql_tu_update_comment . PHP_EOL;
                            } else
                            {
                                if (!isset($table_definitions[$field]))
                                {
                                    trigger_error("FIELD definition of $field did not found to update", E_USER_WARNING);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

/**
 * TODO: GET table comments
 * 
    SELECT table_comment 
    FROM INFORMATION_SCHEMA.TABLES 
    WHERE table_schema='my_cool_database' 
        AND table_name='user_skill';
 */
