<?php
namespace k1app;

include 'bootstrap.php';

use k1app\core\config\general;
use k1lib\app;

$config = new general();
$app = new app($config, __FILE__);
$app->start_session();
$app->start_controllers();
