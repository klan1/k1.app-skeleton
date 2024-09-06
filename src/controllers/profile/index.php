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

use k1app\template\mazer\examples\profile as tpl;

// $template = new document();

$tpl = new tpl();
echo $tpl->generate();