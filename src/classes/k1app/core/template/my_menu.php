<?php

namespace k1app\core\template;

use k1app\template\mazer\components\app\sidebar\wrapper\sidebar_menu\menu;
use const k1app\K1APP_BASE_URL;

class my_menu extends menu {

    function __construct($menu_title = NULL) {
        parent::__construct($menu_title);

        $this->add_item('App home', K1APP_BASE_URL, 'bi bi-house', 'nav-index');
        $this->add_item('Login', K1APP_BASE_URL . 'auth/login/', 'bi bi-person-badge-fill', 'nav-login');

        $item = $this->add_item('CRUD', '#', 'bi bi bi-table')->nav_is_sub();
        $sub_menu = new menu(null, true);
        $sub_menu->append_to($item);
        $sub_menu->add_subitem('Simple Table', K1APP_BASE_URL . 'crud/table_simple/', 'nav-sidebar-page');
        // $sub_menu->add_subitem('Blank page', K1APP_BASE_URL . 'layout/blank/', 'nav-blank-page');

        $item = $this->add_item('Layouts', '#', 'bi bi-grid-1x2-fill')->nav_is_sub();
        $sub_menu = new menu(null, true);
        $sub_menu->append_to($item);
        $sub_menu->add_subitem('Sidebar and page', K1APP_BASE_URL . 'layout/standard/', 'nav-sidebar-page');
        $sub_menu->add_subitem('Blank page', K1APP_BASE_URL . 'layout/blank/', 'nav-blank-page');

        $item = $this->add_item('Examples', '#', 'bi bi-file-earmark-medical-fill')->nav_is_sub();
        $sub_menu = new menu(null, true);
        $sub_menu->append_to($item);
        $sub_menu->add_subitem('Profile', K1APP_BASE_URL . 'profile/', 'nav-profile-page');
    }
}
