<?php

namespace k1app\api\utils;

use k1lib\api\base;

class ping_api extends api {

    function get() {
        parent::get();
        $this->send_response(200, 'hello');
    }

}