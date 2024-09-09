<?php

namespace k1app\core\template;

use k1app\template\mazer\layouts\standard;
use k1lib\html\strong;

use const k1app\K1APP_IMAGES_URL;

class my_template extends standard
{
    function __construct($lang = 'en')
    {
        $page_content = new \k1app\template\mazer\pages\standard();
        parent::__construct($lang, $page_content);
        $this->sidebar_logo_img()->set_src(K1APP_IMAGES_URL . 'klan1.png')->set_style('height:3.2rem');


        $this->content()->set_footer('© 2013-2024 By <a href="https://github.com/j0hnd03" class="klan1-site-link" target="_blank">@J0hnD03</a>', 'Open Source');

        $my_menu = new my_menu('Sidebar Menu');
        // $my_menu->id('nav-layout-standard')->is_active();

        $this->set_menu($my_menu);
    }
}
