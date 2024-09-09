<?php

namespace k1app;

$error = new \k1lib\api\base();
$error->send_response(400, ['message' => 'Not found']);
