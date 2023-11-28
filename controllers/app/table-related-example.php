<?php

namespace k1app;

// This might be different on your proyect

use k1lib\html\template as template;
use \k1lib\urlrewrite\url as url;
use k1app\k1app_template as DOM;
use k1lib\session\session_db as session_db;

\k1lib\session\session_db::is_logged(TRUE, APP_URL . 'app/log/form/');

k1app_template::start_template();

$body = DOM::html()->body();

template::load_template('header');
template::load_template('app-header');
template::load_template('app-footer');

DOM::menu_left()->set_active('nav-table-related-example');

$db_table_to_use = "table_example";
$controller_name = "Table with related table controller example";

/**
 * ONE LINE config: less codign, more party time!
 * $co = controller_object
 */
$co = new \k1lib\crudlexs\controller_base(APP_BASE_URL, $db, $db_table_to_use, $controller_name, 'k1lib-title-3');
$co->set_config_from_class('\k1app\table_config_admin_default_class');

$co->db_table->set_field_constants(['user_login' => session_db::get_user_login()]);

/**
 * ALL READY, let's do it :)
 */
$div = $co->init_board();

//$co->read_url_keys_text_for_list('referrer_table_caller');
//$co->read_url_keys_text_for_create('referrer_table_caller');

if ($co->on_board_list()) {
    $co->board_list_object->set_create_enable(TRUE);
}

$co->start_board();

// LIST
if ($co->on_object_list()) {
    $read_url = url::do_url($co->get_controller_root_dir() . "{$co->get_board_read_url_name()}/--rowkeys--/", ["auth-code" => "--authcode--"]);
    $co->board_list()->list_object->apply_link_on_field_filter($read_url, \k1lib\crudlexs\crudlexs_base::USE_LABEL_FIELDS);
}

$co->exec_board();

if ($co->on_object_list()) {
    $co->board_list()->list_object->html_table->set_max_text_length_on_cell(100);
}

$co->finish_board();

if ($co->on_board_read()) {
    $related_div = $div->append_div("row k1lib-crudlexs-related-data");
    /**
     * Related list
     */
    $related_db_table = new \k1lib\crudlexs\class_db_table($db, "table_uploads");
    $co->board_read_object->set_related_show_all_data(TRUE);
    $co->board_read_object->set_related_show_new(TRUE);
    $related_list = $co->board_read_object->create_related_list($related_db_table, NULL, "Related title to show",
            file_uploads_class::ROOT_URL,
            file_uploads_class::BOARD_CREATE_URL,
            file_uploads_class::BOARD_READ_URL,
            file_uploads_class::BOARD_LIST_URL,
            FALSE
    );
    $related_list->append_to($related_div);
}

$body->content()->append_child($div);
