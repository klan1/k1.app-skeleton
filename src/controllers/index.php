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

namespace k1app;

use k1app\core\config\general;
use k1app\core\template\my_template;
use k1lib\html\html_document;
use k1lib\html\pre;
use k1lib\html\tag_catalog;
use k1lib\html\tag_log;

$tpl = new my_template();

$tpl->content()->set_title("K1.APP Skeleton");
$tpl->content()->set_subtitle("Fast and easy web development.");
$tpl->content()->set_content_title("APP Defined constants");
$tpl->content()->set_content(
    new pre(
        print_r(get_defined_constants(true)['user'], true) .
        print_r(new general(), true) .
        print_r(tag_log::get_log(), true)
    ));

$tpl->menu()->q('#nav-index')->nav_is_active();

echo $tpl->generate();
