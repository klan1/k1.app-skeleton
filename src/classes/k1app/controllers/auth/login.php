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

namespace k1app\controllers\auth;

use k1app\template\mazer\layouts\blank;
use k1lib\app\controller;
use k1lib\html\script;
use const k1app\template\mazer\TPL_URL;

class login extends controller {

    static function run() {
//        parent::run();
        $tpl = new blank();
        $tpl->head()->link_css(TPL_URL . '/assets/compiled/css/auth.css');
        $tpl->body()->load_file(__DIR__ . '/login.tpl.php');
        $tpl->body()->append_child_head(new script(TPL_URL . "assets/extensions/jquery/jquery.min.js"));
        $tpl->body()->append_child_head(new script(TPL_URL . "assets/extensions/parsleyjs/parsley.min.js"));
        $tpl->body()->append_child_head(new script(TPL_URL . "assets/static/js/pages/parsley.js"));

        echo $tpl->generate();

        $controller = new controller();
        $controller->use_template($tpl);
    }
}
