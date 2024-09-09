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
use k1app\core\template\my_menu;
use k1lib\html\p;
use k1lib\html\strong;

// $template = new document();

$tpl = new tpl();
$tpl->page()->set_title("Controller Page Standard");
$tpl->page()->set_subtitle("For standard pages.");
$tpl->page()->set_content_title("Section title");
$tpl->page()->set_content(new p("P from HTML"));
$tpl->page()->set_footer('Footer left', new strong('Footer right'));


$my_menu = new my_menu('App Menu');
$tpl->sidebar_menu()->menu($my_menu);
// $my_menu->add_item('App Home');

echo $tpl->generate();
