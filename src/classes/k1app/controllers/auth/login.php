<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * MAIN INDEX CONTROLLER BOOTSTRAP
 *
 * PHP version 8.2
 *
 * @author Alejandro Trujillo J. <https://github.com/j0hnd03>
 * @copyright       2013-2025 Alejandro Trujillo J.
 * @license         Apache 2.0
 * @version         2.0
 * @since           File available since Release 0.1
 */

namespace k1app\controllers\auth;

use const k1app\K1APP_ASSETS_CSS_URL;
use const k1app\K1APP_ASSETS_TEMPLATES_PATH;
use const k1app\K1APP_BASE_URL;
use const k1app\K1APP_HOME_URL;
use const k1app\template\mazer\TPL_URL;
use function k1lib\html\html_header_go;
use function k1lib\urlrewrite\get_back_url;
use k1app\template\mazer\layouts\blank as blank_layout;
use k1lib\app\controller;
use k1lib\notifications\on_DOM as DOM_notifications;
use k1lib\html\script;
use k1lib\session\app_session;
use k1lib\session\session_db;
use k1lib\urlrewrite\url;

class login extends controller {

    public static function start(): void {
        /**
         * DISABLE THE SESSION CHECK ON THE PARENT
         * IF WAS SET ON THE GENERAL CONFIG
         */
//        parent::start();
    }

    public static function run(): void {
        parent::run();
        $tpl = new blank_layout();
        self::use_tpl($tpl, 'login-alerts');

        // [Klan1-Developer IA] Replaced manual asset calls with asset_manager
        \k1lib\html\asset_manager::enqueue('mazer', 'compiled/css/auth.css', 'head');
        \k1lib\html\asset_manager::enqueue('app', 'css/mazer-hacks.css', 'head');
        \k1lib\html\asset_manager::enqueue('mazer', 'extensions/jquery/jquery.min.js', 'body');
        \k1lib\html\asset_manager::enqueue('mazer', 'extensions/parsleyjs/parsley.min.js', 'body');
        \k1lib\html\asset_manager::enqueue('mazer', 'static/js/pages/parsley.js', 'body');

        $tpl->body()->load_file(K1APP_ASSETS_TEMPLATES_PATH . '/login.tpl.php');
    }

    public static function end(): void {
        parent::end();
        echo self::$tpl->generate();
    }

    public static function on_post(): void {
        parent::on_post();

        $db = self::app()->db();

        $login_user_input = "login";
        $login_password_input = "pass";
        $login_remember_me = "remember-me";

        $user_data = [];
        $login_table = "k1app_users";
        $login_user_field = "user_login";
        $login_password_field = "user_password";
        $login_level_field = "user_level";

        session_db::init($db);
        session_db::set_config($login_table, $login_user_field, $login_password_field, $login_level_field);
        session_db::set_inputs($login_user_input, $login_password_input, $login_remember_me);

// chekc the magic value
        $post_data = session_db::catch_post();
        if ($post_data) {
            $app_session_check = session_db::check_login('text_plain');
            if ($app_session_check) {
                $user_data = array_merge($user_data, $app_session_check);
                // unset($user_data[$login_password_field]);
                // CLEAR ALL
                // session_db::unset_coockie(K1APP_BASE_URL);
//                app_session::end_session();
                app_session::regenerate_id();
                // BEGIN ALL AGAIN
//                app_session::start_session();
                // SET THE LOGGED SESSION
                session_db::save_data_to_coockie(K1APP_BASE_URL, $user_data);
                if (session_db::load_data_from_coockie()) {
                    DOM_notifications::queue_mesasage("Bienvenido!", "success");
                    if (get_back_url(true)) {
                        html_header_go(url::do_url(get_back_url(true)));
                    } else {
                        /**
                         * SUCCESS LOGIN URL DESTINATION HERE
                         */
                        html_header_go(url::do_url(K1APP_HOME_URL));
                    }
                } else {
                    trigger_error("Login with coockie not possible", E_USER_ERROR);
                }
            } elseif ($app_session_check === null) {
                DOM_notifications::queue_mesasage("No se han recibido datos", "warning", 'login-alerts');
            } elseif ($app_session_check === array()) {
                DOM_notifications::queue_mesasage("Usuario o contraseña incorrectos", "danger", 'login-alerts');
            }
        } elseif ($post_data === false) {
            DOM_notifications::queue_mesasage("BAD, BAD Magic!!", "warning", 'login-alerts');
        } elseif ($post_data === null) {
            DOM_notifications::queue_mesasage("No se han recibido datos", "warning", 'login-alerts');
        }
        html_header_go(url::do_url(K1APP_HOME_URL . 'auth/login/'));
    }
}
