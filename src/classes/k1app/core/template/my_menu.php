<?php

namespace k1app\core\template;

use const k1app\K1APP_BASE_URL;
use k1app\template\mazer\components\app\sidebar\wrapper\sidebar_menu\menu;
use k1lib\session\app_session;

class my_menu
        extends menu
{

    public function __construct($menu_title = null)
    {
        parent::__construct($menu_title);

        $this->add_menu_title('PHP MAZER EXAMPLES');
        $this->add_item('App home', K1APP_BASE_URL, 'bi bi-house', 'nav-index');

        $item = $this->add_item('Layouts', '#', 'bi bi-grid-1x2-fill')->nav_is_sub();
        $sub_menu = new menu(null, true);
        $sub_menu->append_to($item);
        $sub_menu->add_subitem('Blank page', K1APP_BASE_URL . 'layout/blank/', 'nav-blank-page');
        $sub_menu->add_subitem('Single page', K1APP_BASE_URL . 'layout/single_page/', 'nav-sidebar-page');
        $sub_menu->add_subitem('Sidebar and page', K1APP_BASE_URL . 'layout/sidebar_page/', 'nav-sidebar-page');

        $item = $this->add_item('Examples', '#', 'bi bi-file-earmark-medical-fill')->nav_is_sub();
        $sub_menu = new menu(null, true);
        $sub_menu->append_to($item);
        $sub_menu->add_subitem('Profile', K1APP_BASE_URL . 'profile/', 'nav-profile-page');

        $this->add_menu_title('K1 APP DEMO');

        if (app_session::is_logged())
        {
            $this->add_item('Logout', K1APP_BASE_URL . 'auth/logout/', 'bi bi-door-open', 'nav-login');
        } else
        {
            $this->add_item('Login', K1APP_BASE_URL . 'auth/login/', 'bi bi-person-badge-fill', 'nav-login');
        }
        $item = $this->add_item('CRUD', '#', 'bi bi bi-table')->nav_is_sub();
        $sub_menu = new menu(null, true);
        $sub_menu->append_to($item);
        $sub_menu->add_subitem('Simple Table', K1APP_BASE_URL . 'crud/table_simple/', 'nav-simple-crud');
        $sub_menu->add_subitem('Related Table', K1APP_BASE_URL . 'crud/table_related/', 'nav-related-crud');
        $sub_menu->add_subitem('Uploads Table', K1APP_BASE_URL . 'crud/table_uploads/', 'nav-uploads-crud');
        // $sub_menu->add_subitem('Blank page', K1APP_BASE_URL . 'layout/blank/', 'nav-blank-page');

        if (app_session::check_user_level(['god']))
        {
            $this->add_menu_title('CONTROL PANEL');

            $item = $this->add_item('DB Configurator', '#', 'bi bi-database', 'nav-db-configurator')->nav_is_sub();
            $sub_menu = new menu(null, true);
            $sub_menu->append_to($item);
            $sub_menu->add_subitem('Config a table', K1APP_BASE_URL . 'core/admin/select_table/', 'nav-config-table');
            $sub_menu->add_subitem(
                    'Export configuration', K1APP_BASE_URL . 'core/admin/export_db_configuration/',
                    'nav-export-configuration'
            );
            $sub_menu->q('#a-nav-export-configuration')->set_attrib('target', '_export');
            $sub_menu->add_subitem(
                    'Import configuration', K1APP_BASE_URL . 'core/admin/import_db_configuration/',
                    'nav-export-configuration'
            );
        }
    }
}
