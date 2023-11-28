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

DOM::menu_left()->set_active('nav-table-fk-example');

$db_table_to_use = "table_uploads";
$controller_name = "FK Table controller example";

/**
 * ONE LINE config: less codign, more party time!
 * $co = controller_object
 */
$co = new \k1lib\crudlexs\controller_base(APP_BASE_URL, $db, $db_table_to_use, $controller_name, 'k1lib-title-3');
$co->set_config_from_class('\k1app\file_uploads_class');

$co->db_table->set_field_constants(['user_login' => session_db::get_user_login()]);

/**
 * ALL READY, let's do it :)
 */
$div = $co->init_board();

d($co->read_url_keys_text_for_list('table_example',true));
$co->read_url_keys_text_for_create('table_example');

if ($co->on_board_list()) {
    $co->board_list_object->set_create_enable(TRUE);
}

$co->start_board();

// LIST
if ($co->on_object_list()) {
//    $read_url = url::do_url($co->get_controller_root_dir() . "{$co->get_board_read_url_name()}/--rowkeys--/", ["auth-code" => "--authcode--"]);
//    $co->board_list()->list_object->apply_link_on_field_filter($read_url, \k1lib\crudlexs\crudlexs_base::USE_LABEL_FIELDS);
}

if ($co->on_object_read()) {
    /**
     * Custom Links
     */
    $get_params = ['auth-code' => '--fieldauthcode--'];
    $listado_url = url::do_url(APP_BASE_URL . table_example_class::ROOT_URL . '/' . table_example_class::BOARD_READ_URL . '/--customfieldvalue--/', $get_params);
    $co->object_read()->apply_link_on_field_filter($listado_url, ['id'], ['id', 'user_login']);
}

$co->exec_board();

if ($co->on_object_list()) {
//    $co->board_list()->list_object->html_table->set_max_text_length_on_cell(100);
}

$co->finish_board();

$body->content()->append_child($div);
