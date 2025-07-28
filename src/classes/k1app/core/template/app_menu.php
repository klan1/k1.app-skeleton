<?php

namespace k1app\core\template;

use k1app\template\mazer\components\app\sidebar\wrapper\sidebar_menu\menu;
use k1lib\app\controller;
use k1lib\session\app_session;
use const k1app\K1APP_BASE_URL;
use const k1app\K1APP_URL;

class app_menu
        extends menu
{

    public function __construct($menu_title = null)
    {
        if (isset(app_session::get_user_data()['user_login']))
        {
            $db = controller::app()->db();
            $user_login = app_session::get_user_data()['user_login'];
            $user_auth_code = $db->generate_auth_code($user_login);
            $person_profile_url = K1APP_URL . 'public/user/profile/' . $user_login . '/?auth-code=' . $user_auth_code;
            $user_profile_url = K1APP_URL . 'app/users/perfil/' . $user_login . '/?auth-code=' . $user_auth_code;
        }
        parent::__construct($menu_title);
        $this->add_item('Inicio', K1APP_URL, 'bi bi-file-earmark-bar-graph', 'nav-index');
        if (!app_session::is_logged())
        {
            $this->add_item('Iniciar sesión', K1APP_URL . 'auth/login/', 'bi bi-person-badge-fill', 'nav-login');
            $this->add_item(
                    'Registro', K1APP_URL . 'app/public/personas/registro/', 'bi bi-person-badge-fill', 'nav-my-profile'
            );
        } elseif (app_session::check_user_level(['guest']))
        {
            $this->add_item('Mi perfil', $person_profile_url, 'bi bi-person-badge-fill', 'nav-my-profile');
            $this->add_item('Cerrar sesión', K1APP_URL . 'auth/logout/', 'bi bi-door-open', 'nav-login');
        } else
        {
            if (app_session::is_logged())
            {
                $submenu_profile = $this->add_item('Mi perfil', '#', 'bi bi-person-badge-fill', 'nav-user-profile')->nav_is_sub();
                $submenu_profile->add_subitem('Ver perfíl', $user_profile_url, 'nav-my-profile');
                $submenu_profile->add_subitem('Cerrar sesión', K1APP_URL . 'auth/logout/');
            } else
            {
                $this->add_item('Iniciar sesión', K1APP_URL . 'auth/login/', 'bi bi-person-badge-fill', 'nav-login');
            }
        }

        /**
         * MENU TITLE
         */
        $this->add_menu_title('PHP MAZER EXAMPLES');

        /**
         * MENU SECTION - LAYOUTS
         */
        $submenu_layouts = $this->add_item('Layouts', '#', 'bi bi-grid-1x2-fill')->nav_is_sub();
        $submenu_layouts->add_subitem('Blank page', K1APP_BASE_URL . 'app/examples/layout/blank/', 'nav-blank-page');
        $submenu_layouts->add_subitem(
                'Single page', K1APP_BASE_URL . 'app/examples/layout/single_page/', 'nav-single-page'
        );
        $submenu_layouts->add_subitem(
                'Sidebar and page', K1APP_BASE_URL . 'app/examples/layout/sidebar_page/', 'nav-sidebar-page'
        );

        /**
         * MENU SECTION - EXAMPLES
         */
        $submenu_exmaples = $this->add_item('Examples', '#', 'bi bi-file-earmark-medical-fill')->nav_is_sub();
        $submenu_exmaples->add_subitem('Profile', K1APP_BASE_URL . 'app/examples/profile/', 'nav-profile-page');

        /**
         * MENU SECTION - CRUD
         */
        $submenu_crud = $this->add_item('CRUD', '#', 'bi bi bi-table')->nav_is_sub();
        $submenu_crud->add_subitem('Simple Table', K1APP_BASE_URL . 'app/examples/crud/table_simple/', 'nav-simple-crud');
        $submenu_crud->add_subitem(
                'Related Table', K1APP_BASE_URL . 'app/examples/crud/table_related/', 'nav-related-crud'
        );
        $submenu_crud->add_subitem(
                'Uploads Table', K1APP_BASE_URL . 'app/examples/crud/table_uploads/', 'nav-uploads-crud'
        );

        /**
         * MENU SECTION - CONTROL PANEL
         */
        if (app_session::check_user_level(['god']))
        {
            $this->add_menu_title('CONTROL PANEL');

            $this->add_item('App Users', K1APP_URL . 'app/users/', 'bi bi-person-workspace', 'nav-admin-users');

            $submenu_config = $this->add_item('DB Configurator', '#', 'bi bi-database', 'nav-db-configurator')->nav_is_sub();
            $submenu_config->add_subitem(
                    'Config a table', K1APP_BASE_URL . 'core/admin/select_table/', 'nav-config-table'
            );
            $submenu_config->add_subitem(
                    'Export configuration', K1APP_BASE_URL . 'core/admin/export_db_configuration/',
                    'nav-export-configuration'
            );
            $submenu_config->q('#a-nav-export-configuration')->set_attrib('target', '_export');
            $submenu_config->add_subitem(
                    'Import configuration', K1APP_BASE_URL . 'core/admin/import_db_configuration/',
                    'nav-export-configuration'
            );
        }
    }
}
