<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * MAIN INDEX CONTROLLER BOOTSTRAP
 *
 * PHP version 8.2
 *
 * @author          Alejandro Trujillo J. <alejo@klan1.com> <https://github.com/j0hnd03>
 * @copyright       2013-2025 Alejandro Trujillo J.
 * @license         Apache 2.0
 * @version         2.0
 * @since           File available since Release 0.1
 */

namespace k1app\controllers\app\examples;

use k1app\core\template\app_sidebar_page;
use k1lib\app\controller;
use const k1app\K1APP_ASSETS_TEMPLATES_PATH;

class profile
        extends controller
{

    /**
     * @var app_sidebar_page
     */
    static function run()
    {

        $tpl = new app_sidebar_page('EN', FALSE);

        $tpl->page_content()->set_title(null);
        $tpl->page_content()->set_subtitle(null);
        $tpl->page_content()->content()->load_file(
                K1APP_ASSETS_TEMPLATES_PATH . '/mazer-example-profile.tpl.php', 1, FALSE, TRUE
        );

        echo $tpl->generate();
    }
}
