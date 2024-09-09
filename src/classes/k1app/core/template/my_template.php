<?php

namespace k1app\core\template;

use const k1app\K1APP_IMAGES_URL;
use k1app\core\config\general;
use k1app\template\mazer\layouts\standard;

class my_template extends standard
{
    public function __construct($lang = 'en')
    {
        $page_content = new \k1app\template\mazer\pages\standard();
        parent::__construct($lang, $page_content);
        $this->sidebar_logo_img()->set_src(K1APP_IMAGES_URL . 'klan1.png')->set_style('height:3.2rem');

        $settings = new general();
        $this->content()->set_footer(
            $settings->get_option('app_copyright'),
            $settings->get_option('app_version')
        );

        $this->head()->set_title($settings->get_option('app_name'));
        $this->head()->append_meta("description", $settings->get_option('app_description'));
        $this->head()->append_meta("keywords", $settings->get_option('app_keywords'));

        $my_menu = new my_menu('Sidebar Menu');

        $this->set_menu($my_menu);
    }
}
