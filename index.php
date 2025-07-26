<?php

namespace k1app;

include 'bootstrap.php';

use k1app\core\config\general;
use k1lib\app;

// Include the configuration settings for the application.
$config = new general();

// Initialize the main application object with the current file path and configuration settings.
$app = new app($config, __FILE__);

// Start the session used by the application.
$app->start_app_session();

// Run the controllers defined in the application.
$app->run_controllers();