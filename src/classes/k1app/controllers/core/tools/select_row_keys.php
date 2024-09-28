<?php

namespace k1app\controllers\core\tools;

use k1app\template\mazer\layouts\single_page as sp;
use k1lib\app\controller;

class select_row_keys extends controller {

    static function on_post(): void {
        self::launch();
    }

    public static function run() {
        parent::run();
        $tpl = new sp();
        self::use_tpl($tpl);

        $tpl->page()->set_title("Select the key for insert");
    }

    static function end(): void {
        parent::end();
        echo self::$tpl->generate();
    }
}
