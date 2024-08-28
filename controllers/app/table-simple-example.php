<?php

namespace k1app;

// This might be different on your proyect

use \k1lib\html\template as template;
use \k1lib\urlrewrite\url as url;
use \k1lib\session\session_db as session_db;
use \k1lib\crudlexs\controller\base as cb;

use \k1app\k1app_template as DOM;

DOM::start_template();

$body = DOM::html()->body();

template::load_template('header');
template::load_template('app-header');
template::load_template('app-footer');

DOM::menu_left()->set_active('nav-table-simple-example');

$db_table_to_use = "k1app_users";
$controller_name = "Simple Table controller example";

/**
 * ONE LINE config: less codign, more party time!
 * $co = controller_object
 */
$co = new cb(APP_BASE_URL, $db, $db_table_to_use, $controller_name, 'k1lib-title-3');
if ($co->db_table->get_state() === FALSE) {
    die('DB table did not found.');
}
$co->set_config_from_class('\k1app\table_config_admin_default_class');

/**
 * USE THIS IF THE TABLE NEED THE LOGIN_ID ON EVERY ROW FOR TRACKING
 */
$co->db_table->set_field_constants(['user_login' => session_db::get_user_login()]);

/**
 * ALL READY, let's do it :)
 */
$board_div = $co->init_board();

if ($co->on_board_list()) {
    $co->board_list_object->set_create_enable(TRUE);
}

$co->start_board();

// LIST
if ($co->on_object_list()) {
    $read_url = url::do_url($co->get_controller_root_dir() . "{$co->get_board_read_url_name()}/--rowkeys--/", ["auth-code" => "--authcode--"]);
    $co->board_list()->list_object->apply_link_on_field_filter($read_url, \k1lib\crudlexs\object\base::USE_LABEL_FIELDS);
}

$co->exec_board();

if ($co->on_object_list()) {
    $co->board_list()->list_object->html_table->set_max_text_length_on_cell(100);
}

$co->finish_board();

$body->content()->append_child($board_div);
