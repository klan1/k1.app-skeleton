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

use k1app\core\template\my_template;
use k1lib\html\p;

$tpl = new my_template();

$tpl->content()->set_title("Standar layout");
$tpl->content()->set_subtitle("For standard pages.");
$tpl->content()->set_content_title("Section title");
$tpl->content()->set_content('Section content');

$tpl->menu()->q('#nav-layout-standard')->nav_is_active();

echo $tpl->generate();