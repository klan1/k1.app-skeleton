<?php

namespace k1app;

// This might be different on your proyect

use k1lib\html\template as template;
use \k1lib\urlrewrite\url as url;
use k1app\k1app_template as DOM;
use k1lib\session\session_db as session_db;

\k1lib\session\session_db::is_logged(TRUE, APP_URL . 'app/log/form/');

k1app_template::start_template();
$body = DOM::html_document()->body();

template::load_template('header');
template::load_template('app-header');
template::load_template('app-footer');

DOM::menu_left()->set_active('nav-utils-usuarios');

$db_table_to_use = "k1app_users";
$controller_name = "Usarios del APP";

/**
 * ONE LINE config: less codign, more party time!
 */
$controller_object = new \k1lib\crudlexs\controller_base(APP_BASE_URL, $db, $db_table_to_use, $controller_name, 'k1lib-title-3');
$controller_object->set_config_from_class('\k1app\users_config');

//$controller_object->db_table->set_field_constants(['user_login' => session_db::get_user_login()]);

/**
 * ALL READY, let's do it :)
 */
$div = $controller_object->init_board();

//$controller_object->read_url_keys_text_for_list('referrer_table_caller');
//$controller_object->read_url_keys_text_for_create('referrer_table_caller');

if (!session_db::check_user_level(['god', 'admin'])) {
//    DOM_notifications::queue_mesasage("Solo puedes ver los listados digitados por tu estructura");
    $controller_object->db_table->set_field_constants(['coordinador_id' => (session_db::get_user_data())['coordinador_id']], TRUE);
}

if ($controller_object->on_board_list()) {
//    $controller_object->board_list_object->set_create_enable(FALSE);
}

$controller_object->start_board();
if ($controller_object->on_object_read()) {
    if (isset($_GET['reset-password'])) {
        if ($_GET['reset-password'] == 1) {
            $user_login = $controller_object->board_read()->read_object->get_db_table_data()[1]['user_login'];
            $new_password = substr($user_login, 0, 2) . substr($user_login, -2);
            $controller_object->object_read()->db_table->update_data(['user_password' => md5($new_password)], $controller_object->board_read()->read_object->get_row_keys_array());
            d("Nueva contraseña: $new_password");
            \k1lib\html\html_header_go(url::do_url('./', [], TRUE, ['auth-code']));
        }
    }
}
// LIST
if ($controller_object->on_object_list()) {
    $read_url = url::do_url($controller_object->get_controller_root_dir() . "{$controller_object->get_board_read_url_name()}/--rowkeys--/", ["auth-code" => "--authcode--"]);
    $controller_object->board_list_object->list_object->apply_link_on_field_filter($read_url, \k1lib\crudlexs\crudlexs_base::USE_LABEL_FIELDS);
}
//if ($controller_object->on_object_read()) {
//    /**
//     * Custom Links
//     */
//    $get_params = [
//        'auth-code' => '--fieldauthcode--',
//        'back-url' => $_SERVER['REQUEST_URI']
//    ];
//    // Layout Horizontal LINK
//    $horizontal_layout_url = url::do_url(APP_BASE_URL . table_config_class::ROOT_URL . '/' . table_config_class::BOARD_UPDATE_URL . '/--customfieldvalue--/', $get_params);
//    $controller_object->object_read()->apply_link_on_field_filter($horizontal_layout_url, ['ecard_layout_h_id'], ['ecard_layout_h_id']);
//}

$controller_object->exec_board();

$controller_object->finish_board();

if ($controller_object->on_board_read()) {
    if (session_db::check_user_level(['god'])) {
        $related_div = $div->append_div("row k1lib-crudlexs-related-data");
        $related_div->append_a(url::do_url('./', ['reset-password' => 1]), ' Restaurar contraseña', '_self', 'button warning fi-key')
                ->set_attrib('onclick', "javascript:return confirm('Estas seguro?')");
    }
}

$body->content()->append_child($div);
