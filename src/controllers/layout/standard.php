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

use k1app\template\mazer\layouts\standard as tpl;
use k1lib\html\p;

// $template = new document();

$tpl = new tpl();
$tpl->page()->set_title("Controller Page Standard");
$tpl->page()->set_subtitle("For standard pages.");
$tpl->page()->set_content_title("Section title");
$tpl->page()->set_content(new p("P from HTML"));
echo $tpl->generate();
