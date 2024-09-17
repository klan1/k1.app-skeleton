<?php

namespace k1app;

use k1lib\session\session_plain;
use \k1lib\urlrewrite\url as url;
use k1app\k1app_template as DOM;

$body = DOM::html_document()->body();

if (DOM::off_canvas()) {
//    DOM::off_canvas()->left()->set_class('reveal-for-large', TRUE);
//    DOM::off_canvas()->left()->set_attrib('data-options', 'inCanvasFor:large;');
}

if (!isset($_GET['just-controller'])) {

    DOM::set_title(1, K1APP_TITLE);
    DOM::set_title(2, ' :: ');
    DOM::set_title(3, '');

    $menu_left = DOM::menu_left();
    $menu_left_tail = DOM::menu_left_tail();
    if (!empty(DOM::off_canvas())) {

        /**
         * MENU ITEMS
         */
        if (session_plain::check_user_level(['god', 'admin'])) {
            $menu_left->add_menu_item(\k1app\K1APP_URL . 'app/dashboard/', 'Private Dashboard', 'nav-dashboard');
            $menu_left->add_menu_item(\k1app\K1APP_URL . 'app/table-simple-example/', 'Simple Table', 'nav-table-simple-example');
            $menu_left->add_menu_item(\k1app\K1APP_URL . 'app/table-related-example/', 'Related Table', 'nav-table-related-example');
            $menu_left->add_menu_item(\k1app\K1APP_URL . 'app/table-fk-example/', 'FK Table', 'nav-table-fk-example');
        } elseif (session_plain::check_user_level(['user'])) {
            $menu_left->add_menu_item(\k1app\K1APP_URL . 'app/dashboard/', 'Private Dashboard', 'nav-dashboard');
        } elseif (session_plain::check_user_level(['guest'])) {
            $menu_left->add_menu_item(\k1app\K1APP_URL . 'public/dashboard/', 'Public Dashboard', 'nav-dashboard');
        }
        if (session_plain::is_logged()) {
            /**
             * APP Preferences
             */
            if (\k1lib\session\session_plain::check_user_level(['god'])) {

                $admin_menu = $menu_left_tail->add_sub_menu('#', 'App preferences', 'nav-app-preferences');

                $admin_menu->add_menu_item(\k1app\K1APP_URL . 'app/system-users', 'App Users', 'nav-system-users');
                $admin_menu->add_menu_item(\k1app\K1APP_URL . 'general-utils/table-explorer/show-tables/', 'Table Explorer', 'nav-general-utils/table-explorer');
                $admin_menu->add_menu_item(\k1app\K1APP_URL . 'general-utils/table-metadata/show-tables/', 'Manage tables', 'nav-manage-tables');
                $admin_menu->add_menu_item(\k1app\K1APP_URL . 'general-utils/table-metadata/load-field-comments/', 'Load fields metadata', 'nav-fields-metadata');
                $admin_menu->add_menu_item(\k1app\K1APP_URL . 'general-utils/table-metadata/export-field-comments/', 'Export field metadata', 'nav-export-fields-meta')->set_attrib('target', '_blank');
            }

            $menu_left_tail->add_menu_item(url::do_url(\k1app\K1APP_URL . 'app/log/out/'), 'Logout', 'nav-logout');
        } else {
            $menu_left_tail->add_menu_item(url::do_url(APP_LOGIN_URL), 'Login', 'nav-login');
        }
    }
}
$body->header()->append_div(null, 'k1app-output');
