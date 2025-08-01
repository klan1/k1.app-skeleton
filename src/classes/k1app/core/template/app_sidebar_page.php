<?php

namespace k1app\core\template;

use const k1app\K1APP_ASSETS_IMAGES_URL;
use k1app\template\mazer\layouts\sidebar_page;

class app_sidebar_page
        extends sidebar_page
{

    use header_common;

    public function __construct($lang = 'en', $use_card_as_content = true)
    {

        /**
         * PAGE CONTENT
         */
//        $page_content = new \k1app\template\mazer\pages\standard();
        parent::__construct($lang, $use_card_as_content);

        $this->append_header_common($this->head());
        /**
         * SIDE MENU ASSIGNATION
         */
        $app_menu = new app_menu();
        $this->set_menu($app_menu);

        $this->sidebar_logo_img()->set_src(K1APP_ASSETS_IMAGES_URL . 'klan1.png')->set_style('height:3.2rem');
        /**
         * FOOTER TEXTS
         */
        $this->set_footer(
                $this->app_settings->get_option('app_copyright'), $this->app_settings->get_option('app_version')
        );
    }
}
