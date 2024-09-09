<?php

namespace k1app\core\template;

use k1app\template\mazer\components\app\sidebar\wrapper\sidebar_menu\menu;

class my_menu extends menu
{
    function __construct($menu_title = NULL)
    {
        parent::__construct($menu_title);

        $this->add_item('App home', '/', 'bi bi-house');
        $item = $this->add_item('Layouts', '/', 'bi bi-grid-1x2-fill')->is_sub();
        $sub_menu = new menu(null, true);
        $sub_menu->append_to($item);

        $sub_menu->add_subitem('Standard', '/layout/standard/','nav-layout-standard')->is_active();
        $sub_menu->add_subitem('1 Column', '#','nav-layout-1column');
        $sub_menu->add_subitem('Vertical Navbar', '#','nav-layout-vertical-navbar');
        $sub_menu->add_subitem('Horizontal Menu', '#','nav-layout-horizontal-menu');
    }
}
