<?php
namespace k1app;

include 'bootstrap.php';

use k1app\core\config\general;
use k1lib\app;

$config = new general();
$app = new app($config, __FILE__);
$app->start_controllers();

print_r(get_defined_constants(true)['user']);

// /*
//  * Easy and clean start, not bad, learned from WordPress :D
//  */
// namespace k1lib;

// const K1LIB_LANG = 'en';

// namespace k1app;

// /**
//  *  k1.app start
//  */
// // MODES: web, api, shell
// const K1APP_MODE = "web";
// include_once "./bootstrap.php";
