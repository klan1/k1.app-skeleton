<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * MAIN INDEX CONTROLLER BOOTSTRAP
 *
 * PHP version 8.2
 *
 * @author          Alejandro Trujillo J. <alejo@klan1.com> <https://github.com/j0hnd03>
 * @copyright       2013-2024 Alejandro Trujillo J.
 * @license         Apache 2.0
 * @version         2.0
 * @since           File available since Release 0.1
 */

namespace k1app\controllers\profile;

use k1app\core\template\my_menu;
use k1app\core\template\my_sidebar_page;
use k1app\template\mazer\examples\profile;
use k1app\template\mazer\layouts\blank;
use k1lib\app\controller;
use const k1app\K1APP_ASSETS_IMAGES_URL;

class index extends controller {

    /**
     * @var my_sidebar_page
     */
    static protected blank $tpl;

    static function run() {

        $tpl = new profile();

        $my_menu = new my_menu('Sidebar Menu');
        $tpl->set_menu($my_menu);

        $tpl->sidebar_logo_img()->set_src(K1APP_ASSETS_IMAGES_URL . 'klan1.png')->set_style('height:3.2rem');

        $tpl->menu()->q('#nav-profile-page')->nav_is_active();

        echo $tpl->generate();
    }
}
